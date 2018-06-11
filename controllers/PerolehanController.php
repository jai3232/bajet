<?php

namespace app\controllers;

use Yii;
use app\models\Perolehan;
use app\models\PerolehanSearch;
use app\models\PerolehanAllSearch;
use app\models\Barangan;
use app\models\Pembekal;
use app\models\Panjar;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use kartik\mpdf\Pdf;

/**
 * PerolehanController implements the CRUD actions for Perolehan model.
 */
class PerolehanController extends Controller
{
    /**
     * @inheritdoc
     */

    private $status = ['A', 'B', 'B+', 'C'];

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

    public function actionIndexAll()
    {
        if(!Yii::$app->user->identity->accessLevel([0, 2, 3, 4]))
            return $this->redirect(['perolehan/index']);
        $searchModel = new PerolehanAllSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index-all', [
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
// if ($model->load(Yii::$app->request->post()))
//     $barangans = Yii::$app->request->post('Barangan');
//         print_r(empty($barangans['justifikasi'][1]));
//         return print_r(Yii::$app->request->post());

        if ($model->load(Yii::$app->request->post())) {
            $perolehan = Yii::$app->request->post('Perolehan');
            $barangans = Yii::$app->request->post('Barangan');
            $pembekals = Yii::$app->request->post('Pembekal');
            $panjar = Yii::$app->request->post('Panjar');
            $harga_utama = 0;
            //return print_r($barangans['justifikasi']);
            //return print_r($pembekals);
            $model->kod_id = self::generateCodeReset('P'.substr($year,2,2), 
                                empty(Perolehan::find()->where(['LIKE', 'kod_id', 'P'.date('y').'%', false])->max('kod_id')) ? 
                                    'P'.date('y').'0000000' 
                                : 
                                Perolehan::find()->where(['LIKE', 'kod_id', 'P'.date('y').'%', false])->max('kod_id'));
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
                $id_perolehan = $model->id;
                if(!empty($barangans['justifikasi'][1]))
                    for($i = 1; $i <= count($barangans['justifikasi']); $i++) 
                    {
                        $model_barangan = new Barangan();
                        $model_barangan->id_perolehan = $id_perolehan;
                        $model_barangan->justifikasi = $barangans['justifikasi'][$i];
                        $model_barangan->kuantiti = $barangans['kuantiti'][$i]; 
                        if(!$model_barangan->save()) {
                            return print_r($model_barangan->getErrors());
                        }
                        
                    }
                if(!empty($pembekals['pembekal'][1]))
                    for($i = 1; $i <= count($pembekals['pembekal']); $i++) {
                        $model_pembekal = new Pembekal();
                        $model_pembekal->id_perolehan = $id_perolehan;
                        $model_pembekal->pembekal = $pembekals['pembekal'][$i];
                        $model_pembekal->nama_pembekal = $pembekals['nama_pembekal'][$i];
                        $model_pembekal->no_telefon = $pembekals['telefon'][$i];
                        $model_pembekal->email = $pembekals['emel'][$i];
                        $model_pembekal->harga = $pembekals['harga'][$i];

                        if($i == $pembekals['keutamaan']) {
                            $model_pembekal->utama = 1;
                            $harga_utama = $pembekals['harga'][$i];
                        }
                        if($model_pembekal->save()) {
                            $model = $this->findModel($id_perolehan);
                            $model->nilai_permohonan = $harga_utama;
                            $model->nilai_perolehan = $harga_utama;
                            if(!$model->save())
                                return print_r($model->getErrors());
                        }
                        else
                            return print_r($model_pembekal->getErrors());
                    }
                if($perolehan['kaedah_pembayaran'] == 3) {     
                    $model_panjar = new Panjar();
                    $model_panjar->id_perolehan = $id_perolehan;
                    $model_panjar->sambungan = $panjar['sambungan'];
                    $model_panjar->jumlah_panjar = $panjar['jumlah_panjar'];
                    $model_panjar->tujuan = $panjar['tujuan'];
                    $model_panjar->jawatan = $panjar['jawatan'];
                    if($model_panjar->save()) {
                        $model = $this->findModel($id_perolehan);
                        $model->nilai_permohonan = $panjar['jumlah_panjar'];
                        $model->nilai_perolehan = $panjar['jumlah_panjar'];
                        if(!$model->save())
                            return print_r($model->getErrors());
                    }
                    else
                        return print_r($model_panjar->getErrors());
                    return $this->redirect(['/perolehan/panjar', 'id' => $id_perolehan]);
                }

                return $this->redirect(['/perolehan/form', 'id' => $id_perolehan]);
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
        Pembekal::deleteAll(['id_perolehan' => $id]);
        Barangan::deleteAll(['id_perolehan' => $id]);
        Panjar::deleteAll(['id_perolehan' => $id]);
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionUnjuranList()
    {
        return $this->renderAjax('unjuran');
    }

    public function actionForm($id = 0)
    {
        $model = Perolehan::findOne($id);
        $model_barangan = Barangan::find()->where(['id_perolehan' => $id])->all();
        $model_pembekal = Pembekal::find()->where(['id_perolehan' => $id])->all();

        // Yii::$app->response->format = 'pdf';
        // Yii::$container->set(Yii::$app->response->formatters['pdf']['class'], [
        //     'format' => [216, 356], // Legal page size in mm
        //      'orientation' => 'Landscape', // This value will be used when 'format' is an array only. Skipped when 'format' is empty or is a string
        //     // 'beforeRender' => function($mpdf, $data) {},
        // ]);

        return $this->render('perolehan-form', [
            'model' => $model,
            'model_barangan' => $model_barangan,
            'model_pembekal' => $model_pembekal
        ]);
    }

    public function actionFormPdf($id = 0)
    {
        $model = Perolehan::findOne($id);
        $model_barangan = Barangan::find()->where(['id_perolehan' => $id])->all();
        $model_pembekal = Pembekal::find()->where(['id_perolehan' => $id])->all();

        $content = $this->renderPartial('perolehan-form',[
            'model' => $model,
            'model_barangan' => $model_barangan,
            'model_pembekal' => $model_pembekal
        ]);

        $css = '
            #rujukan {
                position: relative;
                border: 3px solid red;
                width: 200px;
                padding: 1px 3px;
                text-align: center;
                font-weight: bold;
                color: red;

            }
            .btn {
                display: none;
            }
            .glyphicon {
                position: relative;
                top: 1px;
                display: inline-block;
                font-family: \'Glyphicons Halflings\';
                font-style: normal;
                font-weight: normal;
                line-height: 1;

                -webkit-font-smoothing: antialiased;
                -moz-osx-font-smoothing: grayscale;
            }
            .glyphicon-phone-alt:before {
                content: "\e183";
            }
        ';
        
        
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_CORE, 
            // A4 paper format
            'format' => Pdf::FORMAT_A4, 
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT, 
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER, 
            // your html content input
            'content' => $content,  
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting 
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
            // any css to be embedded if required
            'cssInline' => '.kv-heading-1{font-size:18px} .bordered {border: 1px solid black;}'.$css, 
             // set mPDF properties on the fly
            'options' => ['title' => 'Borang Perolehan'],
             // call mPDF methods on the fly
            'methods' => [ 
                'SetHeader'=>['Borang Perolehan'], 
                'SetFooter'=>['{PAGENO}'],
            ]
        ]);
    
        // return the pdf output as per the destination setting
        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        //Yii::$app->response->headers->add('Content-Type', 'application/pdf');
        return $pdf->render(); 
    }

    public function actionPanjar($id)
    {
        $model = Perolehan::findOne($id);
        $model_panjar = Panjar::find()->where(['id_perolehan' => $id])->one();

        return $this->render('panjar', [
            'model' => $model,
            'model_panjar' => $model_panjar
        ]);
    }

    public function actionPanjarPdf($id = 0)
    {
        $model = Perolehan::findOne($id);
        $model_panjar = Panjar::find()->where(['id_perolehan' => $id])->one();        

        $content = $this->renderPartial('panjar',[
            'model' => $model,
            'model_panjar' => $model_panjar,
        ]);

        $css = '
            #rujukan {
                position: relative;
                border: 3px solid red;
                width: 200px;
                padding: 1px 3px;
                text-align: center;
                font-weight: bold;
                color: red;

            }
            .btn {
                display: none;
            }
            .glyphicon {
                position: relative;
                top: 1px;
                display: inline-block;
                font-family: \'Glyphicons Halflings\';
                font-style: normal;
                font-weight: normal;
                line-height: 1;

                -webkit-font-smoothing: antialiased;
                -moz-osx-font-smoothing: grayscale;
            }
        ';
        
        $pdf = new Pdf([
            // set to use core fonts only
            'mode' => Pdf::MODE_CORE, 
            // A4 paper format
            'format' => Pdf::FORMAT_A4, 
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT, 
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER, 
            // your html content input
            'content' => $content,  
            // format content from your own css file if needed or use the
            // enhanced bootstrap css built by Krajee for mPDF formatting 
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/assets/kv-mpdf-bootstrap.min.css',
            // any css to be embedded if required
            'cssInline' => '.kv-heading-1{font-size:18px} .bordered {border: 1px solid black;}'.$css, 
             // set mPDF properties on the fly
            'options' => ['title' => 'Borang Panjar Runcit'],
             // call mPDF methods on the fly
            'methods' => [ 
                'SetHeader'=>['Borang Panjar Runcit'], 
                'SetFooter'=>['{PAGENO}'],
            ]
        ]);
    
        // return the pdf output as per the destination setting
        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        //Yii::$app->response->headers->add('Content-Type', 'application/pdf');
        return $pdf->render(); 
    }

    public function actionFinance()
    {
        if(!Yii::$app->user->identity->accessLevel([0, 2, 3]))
            return $this->redirect(['perolehan/index']);
        $searchModel = new PerolehanAllSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('finance', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionFormLo($id)
    {
        $model = $this->findModel($id);
        return $this->renderAjax('_form-lo', [
            'model' => $model,
        ]);
    }

    public function actionUpdateLo()
    {
        $perolehan = yii::$app->request->post('Perolehan');
        $model = $this->findModel($perolehan['id']);
        if($perolehan['lulus_lo'] != 'C') {
            $model->nilai_perolehan = $perolehan['nilai_perolehan'];
            $model->nolo = $perolehan['nolo'];
            $model->tarikhlo = Yii::$app->formatter->asDate($perolehan['tarikhlo'], 'yyyy-MM-dd');
            $model->catatan2 = $perolehan['catatan2'];
            $model->status_kewangan = array_search($perolehan['lulus_lo'], $this->status);
            //return print_r(yii::$app->request->post('Perolehan'));
            //return Yii::$app->formatter->asDate($perolehan['tarikhlo'], 'yyyy-MM-dd');
        }
        else {
            $model->nilai_perolehan = 0;
            $model->catatan2 = $perolehan['catatan2'];
            $model->status_kewangan = array_search($perolehan['lulus_lo'], $this->status);  
        }
        if(!$model->save())
            return print_r($model->getErrors());
        else
            return true;
    }    

    public function actionFormVo($id)
    {
        $model = $this->findModel($id);
        return $this->renderAjax('_form-vo', [
            'model' => $model,
        ]);
    }

    public function actionUpdateVo()
    {
        $perolehan = yii::$app->request->post('Perolehan');
        $model = $this->findModel($perolehan['id']);
        if($perolehan['lulus_vo'] != 'C') {
            $model->nilai_perolehan = $perolehan['nilai_perolehan'];
            $model->novoucher = $perolehan['novoucher'];
            $model->tarikh_voucher = Yii::$app->formatter->asDate($perolehan['tarikh_voucher'], 'yyyy-MM-dd');
            $model->status_kewangan = array_search($perolehan['lulus_vo'], $this->status);
        }
        else {
            $model->nilai_perolehan = 0;
            $model->status_kewangan = array_search($perolehan['lulus_vo'], $this->status);  
        }
        if(!$model->save())
            return print_r($model->getErrors());
        else
            return true;
    }

    public function actionTest()
    {
        //print_r(substr(Perolehan::find()->where(['LIKE', 'kod_id', 'P'.date('y').'%', false])->max('kod_id'), 3)/1);
        Perolehan::find()->where(['LIKE', 'kod_id', 'P'.date('y').'%', false])->max('kod_id');
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

    static function generateCodeReset($c, $data) {
        $data = substr($data, 3) / 1;
        $data++;
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
