<?php

namespace modules\menu\models\frontend;

use modules\menu\models\Menu as BaseMenu;

class Menu extends BaseMenu
{
    /**
     * @return MenuItem[]
     */
    public function getRootItems()
    {
        return MenuItem::find()
            ->where(['menu_id' => $this->id, 'parent_id' => null])
            ->orderBy('sorting')
            ->all();
    }
}
