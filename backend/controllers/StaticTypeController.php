<?php

namespace backend\controllers;

use Yii;
use backend\models\StaticType;
use backend\models\StaticTypeSearch;
use backend\components\BaseController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * StaticTypeController implements the CRUD actions for StaticType model.
 */
class StaticTypeController extends BaseController
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
     * Lists all StaticType models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new StaticTypeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        Yii::$app->user->setReturnUrl(Yii::$app->request->url);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single StaticType model.
     * @param integer $id
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
     * Creates a new StaticType model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new StaticType([
            // Setting items amount to Unlimited by default
            'items_amount' => StaticType::AMOUNT_UNLIMITED,
        ]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->addFlash('success', Yii::t('backend', 'Static Type created successfully.'));
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing StaticType model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->addFlash('success', Yii::t('backend', 'Static Type updated successfully.'));
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing StaticType model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->addFlash('success', Yii::t('backend', 'Static Type deleted successfully.'));
        return $this->redirect(['index']);
    }

    /**
     * Disabled an existing StaticType model.
     * If disable is successful, the browser will be redirected back
     * @param integer $id
     * @return mixed
     */
    public function actionDisable($id)
    {
        $model = $this->findModel($id);
        $model->status = StaticType::STATUS_DELETED;
        if ($model->save()) {
            Yii::$app->session->addFlash('success', Yii::t('backend', 'Item disabled successfully.'));
        } else {
            Yii::error('Failed to disable StaticType. Errors: ' . json_encode($model), 'static_content');
            Yii::$app->session->addFlash('error', Yii::t('backend', 'Failed to disable item.'));
        }
        return $this->goBack(Yii::$app->urlManager->createUrl(['view', 'id' => $model->id]));
    }

    /**
     * Activating an existing StaticType model.
     * If activate is successful, the browser will be redirected back
     * @param integer $id
     * @return mixed
     */
    public function actionActivate($id)
    {
        $model = $this->findModel($id);
        $model->status = StaticType::STATUS_ACTIVE;
        if ($model->save()) {
            Yii::$app->session->addFlash('success', Yii::t('backend', 'Item activated successfully.'));
        } else {
            Yii::error('Failed to activate StaticType. Errors: ' . json_encode($model), 'static_content');
            Yii::$app->session->addFlash('error', Yii::t('backend', 'Failed to activate item.'));
        }
        return $this->goBack(Yii::$app->urlManager->createUrl(['view', 'id' => $model->id]));
    }

    /**
     * Finds the StaticType model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return StaticType the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = StaticType::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
