<?php

namespace app\controllers;

use Yii;
use app\models\Perjalanan;
use app\models\PerjalananSearch;
use app\models\PerjalananHotel;
use app\models\PerjalananDetails;
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

            $model->user = yii::$app->user->identity->id;
            $model->kod_id = self::generateCodeReset('J', $model);

            if(!$model->save())
                return print_r($model->getErrors());
            $model_id = $model->id;

            $nth_perjalanans = [];
            foreach ($details['tarikh'] as $key => $value) {
                $nth_perjalanans [] = $key;
            }
            $data_perjalanans = [];
            foreach ($details as $key => $value) {
                $data_perjalanans[] = $value;
            }
            
            foreach ($nth_perjalanans as $key1 => $value1) {
                $model_details = new PerjalananDetails();
                $model_details->id_perjalanan = $model_id;
                $model_details->tarikh =  Yii::$app->formatter->asDate($data_perjalanans[0][$value1], 'yyyy-MM-dd');
                $model_details->bertolak = date('H:i', strtotime($data_perjalanans[1][$value1]));
                $model_details->sampai = date('H:i', strtotime($data_perjalanans[2][$value1]));
                $model_details->tujuan = $data_perjalanans[3][$value1];
                $model_details->jarak = $data_perjalanans[4][$value1];
                $model_details->kos = $data_perjalanans[5][$value1];
                if(!$model_details->save())
                    return print_r($model_details->getErrors());
            }

            $nth_hotels = [];
            foreach ($hotels['kali_hotel'] as $key => $value) {
                $nth_hotels[] = $key;
            }
            $data_hotels = [];
            foreach ($hotels as $key => $value) {
                $data_hotels[] = $value;
            }

            foreach ($nth_hotels as $key => $value) {
                $model_hotel = new PerjalananHotel();
                $model_hotel->id_perjalanan = $model_id;
                $model_hotel->kali_hotel = $data_hotels[0][$value];
                $model_hotel->kos_hotel = $data_hotels[1][$value];
                if(!$model_hotel->save())
                    return print_r($model_details->getErrors());
            }

            return true;
            //return $this->redirect(['view', 'id' => $model->id]);
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

    static function generateCodeReset($c, $model) {
        
        $c = $c.date('y');
        $data = empty($model->find()->where(['LIKE', 'kod_id', $c.'%', false])->max('kod_id')) ? 
                    '0000000' : $model->find()->where(['LIKE', 'kod_id', $c.'%', false])->max('kod_id');
        $data = substr($data, 3) / 1;
        $data++;
        $dLength = strlen($data);
        $str = $c;
        $sLength = strlen($c);
        for($i = 0; $i < (10 - $dLength - $sLength); $i++)
            $str .= "0";
        return ($str.$data);
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
