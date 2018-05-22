<?php

namespace app\controllers;

use Yii;
use app\models\Perolehan;
use app\models\PerolehanSearch;
use app\models\Barangan;
use app\models\Pembekal;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PerolehanController implements the CRUD actions for Perolehan model.
 */
class PerolehanController extends Controller
{
    /**
     * @inheritdoc
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
     * Lists all Perolehan models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PerolehanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Perolehan model.
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
     * Creates a new Perolehan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Perolehan();
        $year = date("Y");

        if ($model->load(Yii::$app->request->post())) {
            $perolehan = Yii::$app->request->post('Perolehan');
            $barangans = Yii::$app->request->post('Barangan');
            $pembekals = Yii::$app->request->post('Pembekal');
            return print_r($barangans['justifikasi']);
            return print_r($barangans);
            $model->kod_id = self::generateCode('P'.substr($year,2,2), empty(Perolehan::find()->max('id')) ? 1 : Perolehan::find()->max('id') + 1);
            $model->kod_unjuran = $perolehan['kod_unjuran'];
            $model->id_jabatan = $perolehan['id_jabatan'];
            $model->id_jabatan_asal = $perolehan['id_jabatan_asal'];
            $model->id_unit = $perolehan['id_unit'];
            $model->jenis_perolehan = $perolehan['jenis_perolehan'];
            $model->kaedah_pembayaran = $perolehan['kaedah_pembayaran'];
            $model->kontrak_pusat = $perolehan['kontrak_pusat'];
            $model->tahun = $year;
            $model->user = Yii::$app->user->identity->id;
            if($model->save()) {
                for($i = 0; $i < count($barangans['justifikasi']); $i++) 
                {
                    $model_barangan = new Barangan();
                    $model_barangan->id_perolehan = $model->id;
                    //$model_barangan->justifikasi = 'x';
                }
                return print_r($model->id);
            }
            else
                return print_r($model->getErrors());
            //$model->save()
            //return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Perolehan model.
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
     * Deletes an existing Perolehan model.
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

    /**
     * Finds the Perolehan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Perolehan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */

    static function generateCode($c, $data) {
        $dLength = strlen($data);
        $str = $c;
        $sLength = strlen($c);
        for($i = 0; $i < (10 - $dLength - $sLength); $i++)
            $str .= "0";
        return ($str.$data);
    }

    protected function findModel($id)
    {
        if (($model = Perolehan::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
