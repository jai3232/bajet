<?php

namespace app\controllers;

use Yii;
use app\models\Perjalanan;
use app\models\PerjalananSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * PerjalananController implements the CRUD actions for Perjalanan model.
 */
class PerjalananController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['*'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Perjalanan models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PerjalananSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Perjalanan model.
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
     * Creates a new Perjalanan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Perjalanan();

        if ($model->load(Yii::$app->request->post())) {
            //return print_r(Yii::$app->request->post());
            $perjalanan = Yii::$app->request->post('Perjalanan');
            $details = Yii::$app->request->post('PerjalananDetails');
            $hotels = Yii::$app->request->post('PerjalananHotel');
            print_r($perjalanan);
            echo "<br><br><br>";
            foreach ($details as $key => $value) {
                print_r($key);
                echo ":";
                print_r($value);
                echo "<br>";
            }
            return;
            // if($model->save()) {
            //     $id_perjalanan = $model->id;
            //     if(!empty($details['tarikh'][1])) {

            //     }
                
            // }
            // else
            //     return print_r($model->getErrors());
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Perjalanan model.
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
     * Deletes an existing Perjalanan model.
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

    public function actionUnjuranList()
    {
         return $this->renderAjax('unjuran');
    }

    public function actionCarianPerjalanan()
    {
         //return print_r(yii::$app->request->post());
        $no_kp = yii::$app->request->post('no_kp');
        $bulan = yii::$app->request->post('bulan');
        $tahun = yii::$app->request->post('tahun');
        $os = yii::$app->request->post('os');

        return Perjalanan::find()->joinWith('kodUnjuran')->where(['no_kp' => $no_kp, 'bulan' => $bulan, 'perjalanan.tahun' => $tahun, 'unjuran.os' => $os])->count();
    }    

    /**
     * Finds the Perjalanan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Perjalanan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Perjalanan::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}