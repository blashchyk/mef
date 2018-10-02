<?php

namespace modules\snippet\models;

use Yii;
use yii\db\ActiveRecord;
use modules\page\models\Page;

/**
 * This is the model class for table "{{%snippet_page}}".
 *
 * @property integer $id
 * @property integer $snippet_id
 * @property integer $page_id
 *
 * @property Snippet $snippet
 * @property Page $page
 */
class SnippetPage extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%snippet_page}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['snippet_id', 'page_id'], 'required'],
            [['snippet_id', 'page_id'], 'integer'],
            [['snippet_id'], 'exist', 'skipOnError' => true, 'targetClass' => Snippet::className(), 'targetAttribute' => ['snippet_id' => 'id']],
            [['page_id'], 'exist', 'skipOnError' => true, 'targetClass' => Page::className(), 'targetAttribute' => ['page_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'snippet_id' => Yii::t('app', 'Snippet'),
            'page_id' => Yii::t('app', 'Page'),
        ];
    }

    /**
     * @return array
     */
    public static function getPageList($snippetId)
    {
        return self::find()->select(['page_id'])
            ->indexBy('id')
            ->andWhere(['snippet_id' => $snippetId])
            ->column();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSnippet()
    {
        return $this->hasOne(Snippet::className(), ['id' => 'snippet_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPage()
    {
        return $this->hasOne(Page::className(), ['id' => 'page_id']);
    }

    /**
     * @param $snippetId
     * @param $newAssignments
     * @return bool
     */
    public static function updateAssignments($snippetId, $newAssignments)
    {
        $pages = Page::find()->all();
        $oldAssignments = Snippet::getAssignments($snippetId);
        $newAssignments = !empty($newAssignments) ? $newAssignments : [];

        foreach ($pages as $page) {
            if (in_array($page->id, $oldAssignments)) {
                if (!in_array($page->id, $newAssignments)) {
                    SnippetPage::deleteAll([
                        'snippet_id' => $snippetId,
                        'page_id' => $page->id
                    ]);
                }
            } else {
                if (in_array($page->id, $newAssignments)) {
                    $assignments = new SnippetPage();
                    $assignments->snippet_id = $snippetId;
                    $assignments->page_id = $page->id;
                    $assignments->save();
                }
            }
        }

        return true;
    }
}
