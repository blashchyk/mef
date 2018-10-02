<?php

namespace modules\menu\models;

use Yii;
use yii\db\ActiveRecord;
use modules\i18n\models\Language;
use common\behaviors\I18nListBehavior;
use modules\page\models\Page;

/**
 * This is the model class for table "{{%menu_item}}".
 *
 * @property integer $id
 * @property integer $menu_id
 * @property integer $parent_id
 * @property integer $page_id
 * @property integer $type
 * @property string $link_name
 * @property string $url
 * @property string $sorting
 * @property integer $inherited
 *
 * @property Page $page
 * @property Menu $menu
 * @property MenuItem $parent
 * @property MenuItem[] $menuItems
 * @property MenuItemI18n[] $menuItemI18ns
 * @property Language[] $languages
 */
class MenuItem extends ActiveRecord
{
    const TYPE_PAGE = 0;
    const TYPE_LINK = 1;
    const TYPE_TEXT = 2;

    const INHERITED_NO = 0;
    const INHERITED_YES = 1;

    public static $types = [
        self::TYPE_PAGE => 'page',
        self::TYPE_LINK => 'link',
        self::TYPE_TEXT => 'text',
    ];

    const SCENARIO_ADD_PAGE = 'addPage';
    const SCENARIO_ADD_LINK = 'addLink';

    public static function getInheritedStatuses()
    {
        return [
            self::INHERITED_YES => Yii::t('app', 'Yes (use Link Caption of the selected page)'),
            self::INHERITED_NO => Yii::t('app', 'No (enter Link Caption and translations manually)'),
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%menu_item}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => I18nListBehavior::className(),
                'i18nModelClass' => MenuItemI18n::className(),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['menu_id', 'link_name'], 'required'],
            [['menu_id', 'parent_id', 'page_id', 'type', 'sorting'], 'integer'],
            [['link_name'], 'string', 'max' => 100],
            [['url'], 'string', 'max' => 255],
            [['url'], 'url', 'defaultScheme' => 'http'],
            [['url'], 'required', 'on' => [self::SCENARIO_ADD_LINK]],
            [['inherited'], 'boolean'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'menu_id' => Yii::t('app', 'Menu'),
            'parent_id' => Yii::t('app', 'Parent'),
            'page_id' => Yii::t('app', 'Page'),
            'type' => Yii::t('app', 'Type'),
            'link_name' => Yii::t('app', 'Link Caption'),
            'url' => Yii::t('app', 'Url'),
            'sorting' => Yii::t('app', 'Sorting'),
            'inherited' => Yii::t('app', 'Inherited'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPage()
    {
        return $this->hasOne(Page::className(), ['id' => 'page_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenu()
    {
        return $this->hasOne(Menu::className(), ['id' => 'menu_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(MenuItem::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenuItems()
    {
        return $this->hasMany(MenuItem::className(), ['parent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenuItemI18ns()
    {
        return $this->hasMany(MenuItemI18n::className(), ['id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLanguages()
    {
        return $this->hasMany(Language::className(), ['language' => 'language'])->viaTable('{{%menu_item_i18n}}', ['id' => 'id']);
    }

    /**
     * @return string
     */
    public function getLinkName()
    {
        $linkName = $this->link_name;
        if (!empty($this->page) && (empty($linkName) || $this->inherited)) {
            $linkName =$this->page->link_name;
        }

        return $linkName;
    }

    /**
     * @return string
     */
    public function getLinkUrl()
    {
        $linkUrl = $this->url;
        if ($this->type == self::TYPE_PAGE && !empty($this->page)) {
            $linkUrl = ['/' . $this->page->slug];
        }
        if ($this->type == self::TYPE_LINK && substr($linkUrl, 0, 4) != 'http') {
            $linkUrl = 'http://' . $this->url;
        }

        return $linkUrl;
    }

    /**
     * @return string
     */
    public function getLinkType()
    {
        if (!empty(self::$types[(int) $this->type])) {
            return self::$types[(int) $this->type];
        }
        return null;
    }

    /**
     * @return boolean
     */
    public function getVisible()
    {
        $visible = true;
        if (!empty($this->page)) {
            $visible = $this->page->visible;
            if ($visible == Page::VISIBLE_LOGGED) {
                $visible = !Yii::$app->user->isGuest;
            } elseif ($visible == Page::VISIBLE_NOT_LOGGED) {
                $visible = Yii::$app->user->isGuest;
            }
        }
        return $visible;
    }

    /**
     * @return MenuItem[]
     */
    public function getItems()
    {
        return MenuItem::find()
            ->where(['menu_id' => $this->menu_id, 'parent_id' => $this->id])
            ->orderBy('sorting')
            ->all();
    }

    /**
     * @param integer $menuId
     * @return boolean
     */
    public static function updateItems($menuId)
    {
        $post = Yii::$app->request->post();

        $treeItems = !empty($post['TreeItems']) ? json_decode($post['TreeItems']) : [];
        $menuItems = !empty($post['MenuItem']) ? $post['MenuItem'] : [];
        $newItems = !empty($post['NewItem']) ? $post['NewItem'] : [];
        $newIds = [];
        $sortingIds = [];

        // This can not happen, but just in case, leave it here.
        if (empty($treeItems)) {
            return false;
        }

        $oldItems = static::findAll(['menu_id' => $menuId]);
        foreach ($oldItems as $oldItem) {
            if (empty($menuItems[$oldItem->id])) {
                $oldItem->delete();
            }
        }

        foreach ($treeItems as $treeItem) {
            // Skip unneeded extra root element
            if($treeItem->parent_id == 'none'){
                continue;
            }

            // Get database generated id for parent, that was stored in array previously
            $parentId = array_key_exists($treeItem->parent_id, $newIds) ? $newIds[$treeItem->parent_id] : null;

            // Calc sort index from direct parent
            $sortingIndex = $parentId ?: 'root';
            $sortingIds[$sortingIndex] = isset($sortingIds[$sortingIndex]) ? $sortingIds[$sortingIndex] + 1 : 1;

            // $treeItem->item_id can contain either string like 'new1', 'new2' etc or database id
            // In first case it is new record. In second case it is existing item with according id
            $is_new = !is_numeric($treeItem->item_id);
            $treeItemIdTrimmed = str_replace('new', '', $treeItem->item_id); // only for new records

            $item = $is_new ? new self() : static::findOne(['id' => $treeItem->item_id]);
            $item->menu_id = $menuId;
            $item->attributes = !$is_new ? $menuItems[$treeItem->item_id] : $newItems[$treeItemIdTrimmed];
            $item->parent_id = $parentId;
            $item->sorting = $sortingIds[$sortingIndex];

            // Multi language fix only for new records
            // Model's id should be defined and placed as key of $_POST['MenuItemI18n'] array for usage in I18nListBehavior::afterSave()
            if($is_new && array_key_exists($treeItemIdTrimmed, $post['NewItemI18n'])) {
                # Save model for initialize id because of autoincrement.
                $item->save(false);
                $_POST['MenuItemI18n'][$item->id] = $post['NewItemI18n'][$treeItemIdTrimmed];
            }

            // Actually trigger model validation and I18nListBehavior::afterSave()
            if(!$item->save()){
                return false;
            }

            $newIds[$treeItem->item_id] = $item->id;

        }

        return true;
    }
}
