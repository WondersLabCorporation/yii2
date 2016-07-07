<?php

/* @var $model StaticType */

use backend\models\StaticType;
use yii\helpers\Html;

?>
<?php if ($model->status == StaticType::STATUS_DELETED) : ?>
    <div class="alert alert-warning">
        <?= Yii::t(
            'backend',
            'This content type is <strong>disabled!</strong> That means you will not see the content you are editing on the frontend. You can enable it {hereLink}.',
            [
                'hereLink' => Html::a('here', ['/static-type/update', 'id' => $model->id]),
            ]
        ); ?>
    </div>
<?php endif; ?>
