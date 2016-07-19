<?php

namespace backend\controllers;

use Yii;
use backend\models\StaticContent;
use backend\models\StaticContentSearch;
use backend\components\BaseController;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * StaticContentController implements the CRUD actions for StaticContent model.
 */
class StaticContentController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'delete' => ['post'],
                'disable' => ['post'],
                'activate' => ['post'],
            ],
        ];
        return $behaviors;
    }

    /**
     * Lists all StaticContent models.
     * @param $type_id integer Content Type ID
     * @throws NotFoundHttpException when no such Content type found
     * @return mixed
     */
    public function actionIndex($type_id)
    {
        $searchModel = new StaticContentSearch(['type_id' => $type_id]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if (!$searchModel->type) {
            throw new NotFoundHttpException('No such content type');
        }

        if ($searchModel->type->items_amount == 1) {
            if ($contentItem = $searchModel->type->getContentItems()->one()) {
                return $this->redirect(['view', 'id' => $contentItem->id, 'type_id' => $contentItem->type_id]);
            }
            Yii::$app->session->addFlash(
                'warning',
                Yii::t(
                    'backend',
                    'You do not have a {type} content yet. Please create it first',
                    [
                        'type' => $searchModel->type->name
                    ]
                )
            );
            return $this->redirect(['create', 'type_id' => $searchModel->type_id]);
        }

        Yii::$app->user->setReturnUrl(Yii::$app->request->url);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single StaticContent model.
     * @param integer $id integer
     * @return mixed
     */
    public function actionView($id)
    {
        Yii::$app->user->setReturnUrl(Yii::$app->request->url);
        
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new StaticContent model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @param $type_id integer ID of the content type to be created
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionCreate($type_id)
    {
        $model = new StaticContent(['type_id' => $type_id]);

        if (!$model->validate(['type_id'])) {
            Yii::error('Attempt to create content with type ID:' . $type_id, 'static_content');
            throw new BadRequestHttpException($model->getFirstError('type_id'));
        }

        if ($model->type->items_amount == 1 && $contentItem = $model->type->getContentItems()->one()) {
            Yii::$app->session->addFlash(
                'warning',
                Yii::t(
                    'backend',
                    'You can have one only one item of {type} content.',
                    [
                        'type' => $model->type->name
                    ]
                )
            );
            return $this->redirect(['update', 'id' => $contentItem->id, 'type_id' => $contentItem->type_id]);
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->addFlash('success', Yii::t('backend', '{type} Static Content created successfully.', ['type' => $model->type->name]));
            return $this->redirect(['view', 'id' => $model->id, 'type_id' => $model->type_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing StaticContent model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->addFlash('success', Yii::t('backend', '{type} Static Content updated successfully.', ['type' => $model->type->name]));
            return $this->redirect(['view', 'id' => $model->id, 'type_id' => $model->type_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing StaticContent model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $contentItem = $this->findModel($id);
        $type = $contentItem->type;
        $contentItem->delete();
        Yii::$app->session->addFlash('success', Yii::t('backend', '{type} Static Content deleted successfully.', ['type' => $type->name]));
        return $this->redirect(['index', 'type_id' => $type->id]);
    }

    /**
     * Disabled an existing StaticContent model.
     * If disable is successful, the browser will be redirected back
     * @param integer $id
     * @return mixed
     */
    public function actionDisable($id)
    {
        $model = $this->findModel($id);
        $model->status = StaticContent::STATUS_DELETED;
        if ($model->save()) {
            Yii::$app->session->addFlash('success', Yii::t('backend', 'Item disabled successfully.'));
        } else {
            Yii::error('Failed to disable StaticContent. Errors: ' . json_encode($model), 'static_content');
            Yii::$app->session->addFlash('error', Yii::t('backend', 'Failed to disable item.'));
        }
        return $this->goBack(Yii::$app->urlManager->createUrl(['view', 'id' => $model->id, 'type_id' => $model->type_id]));
    }

    /**
     * Activating an existing StaticContent model.
     * If activate is successful, the browser will be redirected back
     * @param integer $id
     * @return mixed
     */
    public function actionActivate($id)
    {
        $model = $this->findModel($id);
        $model->status = StaticContent::STATUS_ACTIVE;
        if ($model->save()) {
            Yii::$app->session->addFlash('success', Yii::t('backend', 'Item activated successfully.'));
        } else {
            Yii::error('Failed to activate StaticContent. Errors: ' . json_encode($model), 'static_content');
            Yii::$app->session->addFlash('error', Yii::t('backend', 'Failed to activate item.'));
        }
        return $this->goBack(Yii::$app->urlManager->createUrl(['view', 'id' => $model->id, 'type_id' => $model->type_id]));
    }

    /**
     * Finds the StaticContent model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return StaticContent the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = StaticContent::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
