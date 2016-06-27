<?php
namespace common\overrides\grid;

use Yii;
use yii\helpers\Html;

class ActionColumn extends \yii\grid\ActionColumn
{
    /**
     * @inheritdoc
     */
    public $template = '<div class="view-link">{view}</div><div class="update-link">{update}</div><div class="delete-link">{delete}</div>';
    
    /**
     * @inheritdoc
     */
    public $contentOptions = ['width' => 85];
        

    /**
     * @inheritdoc
     */
    protected function initDefaultButtons()
    {
        if (!isset($this->buttons['view'])) {
            $this->buttons['view'] = function ($url, $model, $key) {
                $options = array_merge([
                    'title' => Yii::t('yii', 'View'),
                    'aria-label' => Yii::t('yii', 'View'),
                    'data-pjax' => '0',
                ], $this->buttonOptions);
                $link = Html::a(Yii::t('yii', '{viewIcon} View', ['viewIcon' => '<span class="glyphicon glyphicon-eye-open"></span>']), $url, $options);
                return Html::tag('div', $link);
            };
        }
        if (!isset($this->buttons['update'])) {
            $this->buttons['update'] = function ($url, $model, $key) {
                $options = array_merge([
                    'title' => Yii::t('yii', 'Update'),
                    'aria-label' => Yii::t('yii', 'Update'),
                    'data-pjax' => '0',
                ], $this->buttonOptions);
                $link = Html::a(Yii::t('yii', '{updateIcon} Update', ['updateIcon' => '<span class="glyphicon glyphicon-pencil"></span>']), $url, $options);
                return Html::tag('div', $link);
            };
        }
        if (!isset($this->buttons['delete'])) {
            $this->buttons['delete'] = function ($url, $model, $key) {
                $options = array_merge([
                    'title' => Yii::t('yii', 'Delete'),
                    'aria-label' => Yii::t('yii', 'Delete'),
                    'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                    'data-method' => 'post',
                    'data-pjax' => '0',
                ], $this->buttonOptions);
                $link = Html::a(Yii::t('yii', '{deleteIcon} Delete', ['deleteIcon' => '<span class="glyphicon glyphicon-trash"></span>']), $url, $options);
                return Html::tag('div', $link);
            };
        }
    }
}
