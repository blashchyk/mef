<?php

namespace common\helpers;

use Yii;
use yii\helpers\Html;

class Toolbar
{
    /**
     * @param $dataProvider
     * @return null|string
     */
    public static function toggleButton($dataProvider)
    {
        $multiPageView = $dataProvider->totalCount > $dataProvider->pagination->pageSize;
        return $multiPageView ? '{toggleData}' : null;
    }

    /**
     * @param string $caption
     * @return string
     */
    public static function refreshButton($caption = '')
    {
        return Html::a('<i class="glyphicon glyphicon-repeat"></i> ' . $caption, '', [
            'class' => 'btn btn-primary refresh-link',
            'title' => Yii::t('app', 'Refresh Data'),
            'aria-label' => Yii::t('app', 'Refresh Data'),
        ]) . ' ';
    }

    /**
     * @param string $caption
     * @return null|string
     */
    public static function createButton($caption = '')
    {
        if (!Yii::$app->user->can('create')) {
            return null;
        }

        return Html::a('<i class="glyphicon glyphicon-plus"></i> ' . $caption, ['create'], [
            'class' => 'btn btn-success',
            'title' => Yii::t('app', 'Add New Record'),
            'aria-label' => Yii::t('app', 'Add New Record'),
        ]) . ' ';
    }

    /**
     * @return string
     */
    public static function exportButton()
    {
        return '{export}';
    }

    /**
     * @return string
     */
    public static function enableButton()
    {
        return Html::a(Yii::t('app', 'Enable Selected'), ['show-list'], ['class' => 'action-list-link']);
    }

    /**
     * @return string
     */
    public static function disableButton()
    {
        return Html::a(Yii::t('app', 'Disable Selected'), ['show-list', 'visible' => false], ['class' => 'action-list-link']);
    }

    /**
     * @return string
     */
    public static function blockButton()
    {
        return Html::a(Yii::t('app', 'Block Selected'), ['activate-list', 'active' => false], ['class' => 'action-list-link']);
    }

    /**
     * @return string
     */
    public static function unblockButton()
    {
        return Html::a(Yii::t('app', 'Unblock Selected'), ['activate-list'], ['class' => 'action-list-link']);
    }

    /**
     * @return string
     */
    public static function markOpenedButton()
    {
        return Html::a(Yii::t('app', 'Mark Selected as Read'), ['open-list'], ['class' => 'action-list-link']);
    }

    /**
     * @return string
     */
    public static function markNewButton()
    {
        return Html::a(Yii::t('app', 'Mark Selected as Unread'), ['open-list', 'opened' => false], ['class' => 'action-list-link']);
    }

    /**
     * @param string $caption
     * @return null|string
     */
    public static function deleteButton($caption = '')
    {
        if (!Yii::$app->user->can('delete')) {
            return null;
        }

        return Html::a('<i class="glyphicon glyphicon-trash"></i> ' . $caption, ['delete-list'], [
            'class' => 'btn btn-danger action-list-link',
            'title' => Yii::t('app', 'Delete Selected'),
            'aria-label' => Yii::t('app', 'Delete Selected'),
            'data-confirm' => Yii::t('app', 'Are you sure you want to delete the selected items?'),
        ]) . ' ';
    }

    /**
     * @return string
     */
    public static function activateSelect()
    {
        return self::operationSelect([self::blockButton(), self::unblockButton()]);
    }

    /**
     * @return null|string
     */
    public static function showSelect()
    {
        if (!Yii::$app->user->can('update')) {
            return null;
        }

        return self::operationSelect([self::enableButton(), self::disableButton()]);
    }

    /**
     * @return string
     */
    public static function openSelect()
    {
        return self::operationSelect([self::markOpenedButton(), self::markNewButton()]);
    }

    /**
     * @param $items
     * @return string
     */
    public static function operationSelect($items)
    {
        return '<div class="btn-group">
            <button type="button" class="btn btn-default">' . Yii::t('app', 'More') . '</button>
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="caret"></span>
            </button>'
            . Html::ul($items, [
                'item' => function($item, $index) { return Html::tag('li', $item); },
                'class' => 'dropdown-menu'
            ])
        . '</div>';
    }

    /**
     * @param $dataProvider
     * @return string
     */
    public static function paginationSelect($dataProvider)
    {
        $pageSize = $dataProvider->pagination->pageSize;
        $paginationOptions = Yii::$app->params['paginationOptions'];
        $dropDownElement = Html::dropDownList('pageSize', $pageSize, $paginationOptions, ['id' => 'page-size', 'class' => 'form-control']);
        return Html::tag('form', '&nbsp; ' . Yii::t('app', 'Per page') . ' ' . $dropDownElement, ['class' => 'form-inline pull-left']);
    }
}
