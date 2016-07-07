<?php
namespace backend\components;

use backend\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

/**
 * Site controller
 */
class BaseController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'ruleConfig' => [
                'class' => AccessRule::className(),
            ],
            'rules' => [
                [
                    'roles' => [User::ROLE_ADMIN],
                    'allow' => true,
                ],
                [
                    'actions' => ['error'],
                    'allow' => true,
                ],
            ],
        ];
        return $behaviors;
    }
    
    // TODO: CRUD and disable/activate actions might be copy-pasted a lot of times. Need to be moved to trait or separate Action classes probably
}
