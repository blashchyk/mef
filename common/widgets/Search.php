<?php

namespace common\widgets;

use yii\base\Widget;

class Search extends Widget
{
    public $model;
    public $selectedCategory;

    public $submitButtonClass = null;

    /**
     * @return null
     */
    public function init()
    {
        parent::init();
    }

    /**
     * @return string
     */
    public function run()
    {
        return $this->render('search_form', [
            'model' => $this->model,
            'selectedCategory' => $this->selectedCategory,
            'submitButtonClass' => $this->submitButtonClass,
        ]);
    }
}
