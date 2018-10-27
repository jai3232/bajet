<?php

namespace app\controllers;

use Yii;
use app\models\Penceramah;
use app\models\PenceramahSearch;
use app\models\PenceramahDetails;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PenceramahController implements the CRUD actions for Penceramah model.
 */
class PenceramahController extends Controller
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
     * Lists all Penceramah models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PenceramahSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Penceramah model.
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
     * Creates a new Penceramah model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Penceramah();
        $id_pengguna = Yii::$app->user->identity->id;
        $latest_model = Penceramah::find()->where(['user' => $id_pengguna])
                                          ->andWhere(['<>', 'status', 'X'])
                                          ->orderBy(['id' => SORT_DESC])->one();

        $post = Yii::$app->request->post();
        if ($model->load($post)) {
            $details = $post['PenceramahDetails'];

            $model->user = $id_pengguna;
            $model->kod_id = self::generateCodeReset('C', $model);
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
                $details_model = new PenceramahDetails();
                $details_model->id_penceramah = $model_id;
                $details_model->tarikh = Yii::$app->formatter->asDate($value['tarikh'], 'yyyy-MM-dd');
                $details_model->nama_ceramah= $value['nama_ceramah'];
                $details_model->tempoh = $value['tempoh'];
                $details_model->jumlah = $value['jumlah'];
                if(!$details_model->save())
                    return print_r($details_model->getErrors());
            }
            return $this->redirect(['form', 'id' => $model->id]);

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Penceramah model.
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
     * Deletes an existing Penceramah model.
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

    public function actionCarianPenceramah()
    {
        $post = yii::$app->request->post();
        $no_kp = $post['no_kp'];
        $bulan = $post['bulan'];
        $tahun = $post['tahun'];
        $os = $post['os'];

        return Penceramah::find()->joinWith('kodUnjuran')->where(['no_kp' => $no_kp, 'bulan' => $bulan, 'penceramah.tahun' => $tahun, 'unjuran.os' => $os])->andWhere(['!=', 'penceramah.status', 'C'])->count();
    }

    public function actionFinance($id)
    {
        $post = yii::$app->request->post('Penceramah');
        $model = $this->findModel($id);
        if($post) {
            // return print_r($post);
            $model->jumlah_kew = $post['jumlah_tuntutan'];
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

    public function actionForm($id = 0)
    {
        $model = Penceramah::findOne($id);
        if(count($model) == 0)
            return $this->render('penceramah-form', ['error' => 404]);
        $model_details = PenceramahDetails::find()->where(['id_penceramah' => $id])->all();

        return $this->render('penceramah-form', [
            'model' => $model,
            'model_details' => $model_details,
        ]);
    }

    /**
     * Finds the Penceramah model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Penceramah the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Penceramah::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
