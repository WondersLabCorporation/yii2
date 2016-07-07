<?php
namespace common\overrides\grid;

use common\overrides\db\ActiveRecord;
use Yii;
use yii\helpers\Html;

class ActionColumn extends \yii\grid\ActionColumn
{
    /**
     * @inheritdoc
     * Do not adding disable and activate buttons by default since not always needed.
     * // TODO: Might be better to have a flag to choose type instead of overriding template once those buttons are needed
     */
    public $template = "{view}\n\r{update}\n\r{delete}";
    
    /**
     * @inheritdoc
     */
    public $contentOptions = ['width' => 85];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->initDefaultVisibleButtons();
    }
        

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
                return Html::tag('div', $link, ['class' => 'view-action-wrapper']);
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
                return Html::tag('div', $link, ['class' => 'update-action-wrapper']);
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
                return Html::tag('div', $link, ['class' => 'delete-action-wrapper']);
            };
        }
        if (!isset($this->buttons['disable'])) {
            $this->buttons['disable'] = function ($url, $model, $key) {
                $options = array_merge([
                    'title' => Yii::t('yii', 'Disable'),
                    'aria-label' => Yii::t('yii', 'Disable'),
                    'data-method' => 'post',
                    'data-pjax' => '0',
                ], $this->buttonOptions);
                $link = Html::a(Yii::t('yii', '{disableIcon} Disable', ['disableIcon' => '<span class="glyphicon glyphicon-unchecked"></span>']), $url, $options);
                return Html::tag('div', $link, ['class' => 'disable-action-wrapper']);
            };
        }
        if (!isset($this->buttons['activate'])) {
            $this->buttons['activate'] = function ($url, $model, $key) {
                $options = array_merge([
                    'title' => Yii::t('yii', 'Activate'),
                    'aria-label' => Yii::t('yii', 'Activate'),
                    'data-method' => 'post',
                    'data-pjax' => '0',
                ], $this->buttonOptions);
                $link = Html::a(Yii::t('yii', '{activateIcon} Activate', ['activateIcon' => '<span class="glyphicon glyphicon-check"></span>']), $url, $options);
                return Html::tag('div', $link, ['class' => 'activate-action-wrapper']);
            };
        }
    }

    /**
     * Init default visible buttons
     * Adding disable and activate callable-s when none set by the user
     */
    protected function initDefaultVisibleButtons()
    {
        if (!isset($this->visibleButtons['disable'])) {
            $this->visibleButtons['disable'] = function ($model) {
                return ActionColumn::checkStatusHelper($model, true);
            };
        }
        if (!isset($this->visibleButtons['activate'])) {
            $this->visibleButtons['activate'] = function ($model) {
                return ActionColumn::checkStatusHelper($model, false);

            };
        }
    }

    public static function checkStatusHelper($model, $isActive = true)
    {
        // Run isActive method if any
        if ($model->hasMethod('isActive')) {
            // Return result of isActive when checking for active-ness. Return ! otherwise
            return ($isActive) ? $model->isActive() : !$model->isActive();
        }
        // Check Status field in case it exists
        if (isset($model->attributes['status'])) {
            // Compare with Active status when checking for active-ness. Compare with ! Active otherwise
            return ($isActive) ? $model->status === ActiveRecord::STATUS_ACTIVE : $model->status !== ActiveRecord::STATUS_ACTIVE;
        }
        // Do not show button in case we do not know the status of the model (e.g. there is no status for the model at all)
        return false;
    }
}
