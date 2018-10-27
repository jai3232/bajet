<?php

namespace app\controllers;

use Yii;
use app\models\Ot;
use app\models\OtDetails;
use app\models\OtSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * OtController implements the CRUD actions for Ot model.
 */
class OtController extends Controller
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
     * Lists all Ot models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OtSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Ot model.
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
     * Creates a new Ot model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Ot();
        $id_pengguna = Yii::$app->user->identity->id;
        $latest_model = Ot::find()->where(['user' => $id_pengguna])
                                          ->andWhere(['<>', 'status', 'X'])
                                          ->orderBy(['id' => SORT_DESC])->one();
        $post = Yii::$app->request->post();


        if(!$post /*&& $post['Ot']['id'] != ''*/) { // save only

        }

        if ($model->load($post)) {
            $Ot = $post['Ot'];
            $details = $post['OtDetails'];

            $model->user = $id_pengguna;
            $model->kod_id = self::generateCodeReset('T', $model);
            // if(isset($post['Perjalanan']['akuan']) && $post['Perjalanan']['akuan']/1 == 1)
            $model->status = 'A';
            if(!$model->save())
                return print_r($model->getErrors());
            $model_id = $model->id;

            $out = array();
            foreach($details as $key => $a){
                foreach($a as $k => $v){
                    $out[$k][$key] = $v;
                }
            }

            foreach ($out as $key => $value) {
                $details_model = new OtDetails();
                $details_model->id_ot = $model_id;
                $details_model->tarikh = Yii::$app->formatter->asDate($value['tarikh'], 'yyyy-MM-dd');
                $details_model->hari = $value['hari'];
                $details_model->kod_hari = $value['kod_hari'];
                $details_model->kod_waktu = $value['kod_waktu'];
                $details_model->waktu_masuk = $value['waktu_masuk'];
                $details_model->waktu_pulang = $value['waktu_pulang'];
                $details_model->ot_mula = date('H:i', strtotime($value['jam_mula']));
                $details_model->ot_akhir = date('H:i', strtotime($value['jam_akhir']));
                $details_model->jam_layak = $value['jam_layak'];
                $details_model->butiran = $value['butiran'];
                if(!$details_model->save())
                    return print_r($details_model->getErrors());
            }
            return $this->redirect(['form', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Ot model.
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
     * Deletes an existing Ot model.
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

    public function actionCarianOt()
    {
        $post = yii::$app->request->post();
        $no_kp = $post['no_kp'];
        $bulan = $post['bulan'];
        $tahun = $post['tahun'];
        $os = $post['os'];

        return Ot::find()->joinWith('kodUnjuran')->where(['no_kp' => $no_kp, 'bulan' => $bulan, 'ot.tahun' => $tahun, 'unjuran.os' => $os])->andWhere(['!=', 'ot.status', 'C'])->count();
    }

    public function actionForm($id = 0)
    {
        $model = Ot::findOne($id);
        if(count($model) == 0)
            return $this->render('ot-form', ['error' => 404]);
        $model_details = OtDetails::find()->where(['id_ot' => $id])->all();

        return $this->render('ot-form', [
            'model' => $model,
            'model_details' => $model_details,
        ]);
    }

    public function actionFinance($id)
    {
        $post = yii::$app->request->post('Ot');
        $model = $this->findModel($id);
        if($post) {
            // return print_r($post);
            $model->jumlah_kew = $post['jumlah_OT'];
            $model->status = $post['status'];//$post['lulus'] > 1 ? 'C' : 'B';
            if(!$model->save())
                return print_r($model->getErrors());
            return true;
        }
        return $this->renderAjax('finance', ['model' => $model]);
    }

    static function generateCodeReset($c, $model) 
    {
        
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

    public function getRateDay($day)
    {
        if($day == 'A1')
            return 1.125;
        if($day == 'A2')
            return 1.25;
        if($day == 'B1')
            return 1.25;
        if($day == 'B2')
            return 1.5;
        if($day == 'C1')
            return 1.75;    
        if($day == 'C2')
            return 2;
    }

    public function actionTest()
    {
        return $this->asJson(\app\models\Perjalanan::find()->where(['id' => 50])->asArray()->all());
        return json_encode(\app\models\Perjalanan::find()->where(['id' => 50])->asArray()->all());
    }

    /**
     * Finds the Ot model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Ot the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Ot::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
