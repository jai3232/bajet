<?php

namespace app\controllers;

use Yii;
use app\models\Syarikat;
use app\models\SyarikatSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SyarikatController implements the CRUD actions for Syarikat model.
 */
class SyarikatController extends Controller
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
        ];
    }

    /**
     * Lists all Syarikat models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SyarikatSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort->defaultOrder = ['id' => SORT_DESC];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Syarikat model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Syarikat model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Syarikat();

        if ($model->load(Yii::$app->request->post())) {
            if(!isset(Yii::$app->user->identity->id))
                $model->user = 0;
            else
                $model->user = Yii::$app->user->identity->id;
            if(!$model->save())
                return print_r($model->getErrors()  );
            
            return $this->redirect(['syarikat/index']);
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Syarikat model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Syarikat model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionSurvey()
    {
       // \VIPSoft\Unzip\Unzip;

        $unzipper  = new \VIPSoft\Unzip\Unzip();
        $filenames = $unzipper->extract('robots.zip', 'test/');
        return $this->render('survey');
    }

    public function actionPerformance()
    {
        return $this->render('performance');
    }

    public function actionSearch($term = '')
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        //$rs = Cure::find()->where(['like', 'name_uz', $term])->all();
        // if(strlen($term) < 3)
        //     return [];
        $data = Syarikat::find()
                        ->select(['syarikat.id', 'syarikat.nama_syarikat AS value', 'syarikat.nama_syarikat AS label', 'syarikat.id AS id'])
                        // ->joinWith('personalPerjawatans')
                        ->where(['LIKE', 'syarikat.nama_syarikat', $term])
                        // ->orWhere(['LIKE', 'personal.nama', $term])
                        // ->orWhere(['LIKE', 'personal.no_kp', $term])
                        ->orderBy('nama_syarikat')
                        ->asArray()
                        ->limit(100)
                        ->all();
        return $data;
    }

    /**
     * Finds the Syarikat model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Syarikat the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Syarikat::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
