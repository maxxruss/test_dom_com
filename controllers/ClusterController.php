<?php

namespace app\controllers;

use Yii;
use app\models\Cluster;
use app\models\search\ClusterSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ClusterController implements the CRUD actions for Cluster model.
 */
class ClusterController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'], // авторизованные пользователи
                    ],
                ],
            ]
        ];
    }

    /**
     * Lists all Cluster models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ClusterSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Cluster model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if (\Yii::$app->user->can('view')) {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
        }

        throw new ForbiddenHttpException('Недостаточно прав для данного действия');
    }

    /**
     * Creates a new Cluster model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Cluster();

        if (\Yii::$app->user->can('create')) {

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }

            return $this->render('create', [
                'model' => $model,
            ]);

        }

        throw new ForbiddenHttpException('Недостаточно прав для данного действия');
    }

    /**
     * Updates an existing Cluster model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (\Yii::$app->user->can('update')) {

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
        }

        throw new ForbiddenHttpException('Недостаточно прав для данного действия');
    }

    /**
     * Deletes an existing Cluster model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        if (\Yii::$app->user->can('delete')) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
        }

        throw new ForbiddenHttpException('Недостаточно прав для данного действия');
    }

    /**
     * Finds the Cluster model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Cluster the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Cluster::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
