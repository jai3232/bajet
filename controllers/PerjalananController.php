<?php

namespace app\controllers;

use Yii;
use app\models\Perjalanan;
use app\models\PerjalananSearch;
use app\models\PerjalananHotel;
use app\models\PerjalananDetails;
use app\models\PerjalananLuarDetails;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use kartik\mpdf\Pdf;

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
        $id_pengguna = Yii::$app->user->identity->id;
        $latest_model = Perjalanan::find()->where(['user' => $id_pengguna])
                                          ->andWhere(['<>', 'status', 'X'])
                                          ->orderBy(['id' => SORT_DESC])->one();
        $post = Yii::$app->request->post();

        if($post && $post['Perjalanan']['id'] != '') { // save only
            $model_id = $post['Perjalanan']['id'];
            $model = Perjalanan::findONe($model_id);
            $model->load($post);
            if(isset($post['Perjalanan']['akuan']))
                $model->status = 'A';
            else
                $model->jumlah_kew = 0;

            if(!$model->save())
                return print_r($model->getErrors());
            
            PerjalananDetails::deleteAll(['id_perjalanan' => $model_id]);
            $details = $post['PerjalananDetails'];
            $nth_perjalanans = [];
            foreach ($details['tarikh'] as $key => $value) {
                $nth_perjalanans [] = $key;
            }
            $data_perjalanans = [];
            foreach ($details as $key => $value) {
                $data_perjalanans[] = $value;
            }
            foreach ($nth_perjalanans as $key => $value1) {
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

            PerjalananHotel::deleteAll(['id_perjalanan' => $model_id]);
            $hotels = $post['PerjalananHotel'];
            $nth_hotels = [];
            foreach ($hotels['kali_hotel'] as $key => $value) {
                $nth_hotels[] = $key;
            }
            $data_hotels = [];
            foreach ($hotels as $key => $value) {
                $data_hotels[] = $value;
            }
            foreach ($nth_hotels as $key => $value) {
                if($data_hotels[0][$value] == 0 || $data_hotels[1][$value] == '')
                    continue;
                $model_hotel = new PerjalananHotel();
                $model_hotel->id_perjalanan = $model_id;
                $model_hotel->kali_hotel = $data_hotels[0][$value];
                $model_hotel->kos_hotel = $data_hotels[1][$value];
                if(!$model_hotel->save())
                    return print_r($model_details->getErrors());
            }

            if(isset($post['Perjalanan']['akuan']))
                return $this->redirect(['form', 'id' => $model_id]);

            return $model_id;
        }
        
        if ($model->load($post)) {
            //return print_r($post['Perjalanan']['id']/1 + 31);
            $perjalanan = Yii::$app->request->post('Perjalanan');
            $details = Yii::$app->request->post('PerjalananDetails');
            $hotels = Yii::$app->request->post('PerjalananHotel');

            $model->user = yii::$app->user->identity->id;
            $model->kod_id = self::generateCodeReset('J', $model);
            if(isset($post['Perjalanan']['akuan']) && $post['Perjalanan']['akuan']/1 == 1)
                $model->status = 'A';
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
            
            foreach ($nth_perjalanans as $key => $value1) {
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
                if($data_hotels[0][$value] == 0 || $data_hotels[1][$value] == '')
                    continue;
                $model_hotel = new PerjalananHotel();
                $model_hotel->id_perjalanan = $model_id;
                $model_hotel->kali_hotel = $data_hotels[0][$value];
                $model_hotel->kos_hotel = $data_hotels[1][$value];
                if(!$model_hotel->save())
                    return print_r($model_details->getErrors());
            }

            if(isset($post['Perjalanan']['akuan']) && $post['Perjalanan']['akuan']/1 == 1)
                return $this->redirect(['form', 'id' => $model_id]);

            return $model_id;
            
        }

        return $this->render('create', [
            'model' => $model,
            'latest_model' => $latest_model,
        ]);
    }

    public function actionCreateOver()
    {
        $model = new Perjalanan();

        $post = Yii::$app->request->post(); 
        if($post && $post['Perjalanan']['id'] != '') { // save only
            $model_id = $post['Perjalanan']['id'];
            $model = Perjalanan::findONe($model_id);
            $model->load($post);
            //$model->jumlah_kew = 0;
            if(isset($post['Perjalanan']['akuan']) && $post['Perjalanan']['akuan']/1 == 1)
                $model->status = 'A';
            else
                $model->jumlah_kew = 0;
            if(!$model->save())
                return print_r($model->getErrors());
            
            PerjalananDetails::deleteAll(['id_perjalanan' => $model_id]);
            if(isset($post['PerjalananDetails'])) {
                $details = $post['PerjalananDetails'];
                $nth_perjalanans = [];
                foreach ($details['tarikh'] as $key => $value) {
                    $nth_perjalanans [] = $key;
                }
                $data_perjalanans = [];
                foreach ($details as $key => $value) {
                    $data_perjalanans[] = $value;
                }
                foreach ($nth_perjalanans as $key => $value1) {
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
            }

            PerjalananHotel::deleteAll(['id_perjalanan' => $model_id]);
            $hotels = $post['PerjalananHotel'];
            $nth_hotels = [];
            foreach ($hotels['kali_hotel'] as $key => $value) {
                $nth_hotels[] = $key;
            }
            $data_hotels = [];
            foreach ($hotels as $key => $value) {
                $data_hotels[] = $value;
            }
            foreach ($nth_hotels as $key => $value) {
                if($data_hotels[0][$value] == 0 || $data_hotels[1][$value] == '')
                    continue;
                $model_hotel = new PerjalananHotel();
                $model_hotel->id_perjalanan = $model_id;
                $model_hotel->kali_hotel = $data_hotels[0][$value];
                $model_hotel->kos_hotel = $data_hotels[1][$value];
                if(!$model_hotel->save())
                    return print_r($model_details->getErrors());
            }

            PerjalananLuarDetails::deleteAll(['id_perjalanan' => $model_id]);
            $luar = $post['PerjalananLuarDetails'];
            $luar_record = count($post['PerjalananLuarDetails']['dari']);
            for($c = 1; $c <= $luar_record; $c++) {
                foreach ($luar as $key => $value) {
                    $luar_details[$c]['PerjalananLuarDetails'][$key] = $value[$c];
                }
            }
            foreach ($luar_details as $key => $value) {
                $model_luar_details = new PerjalananLuarDetails();
                $model_luar_details->load($value);
                $model_luar_details->id_perjalanan = $model_id;
                $model_luar_details->dari = $value['PerjalananLuarDetails']['dari'];
                $model_luar_details->tarikh_bertolak = Yii::$app->formatter->asDate($value['PerjalananLuarDetails']['tarikh_bertolak'], 'yyyy-MM-dd');
                $model_luar_details->waktu_bertolak = date('H:i', strtotime($value['PerjalananLuarDetails']['waktu_bertolak']));
                $model_luar_details->destinasi = $value['PerjalananLuarDetails']['destinasi'];
                $model_luar_details->tarikh_sampai = Yii::$app->formatter->asDate($value['PerjalananLuarDetails']['tarikh_sampai'], 'yyyy-MM-dd');
                $model_luar_details->waktu_sampai = date('H:i', strtotime($value['PerjalananLuarDetails']['waktu_sampai']));
                $model_luar_details->tujuan_lawatan = $value['PerjalananLuarDetails']['tujuan_lawatan'];
                if(!$model_luar_details->save())
                    return print_r($model_luar_details->getErrors());
            }

            if(isset($post['Perjalanan']['akuan']) && $post['Perjalanan']['akuan']/1 == 1)
                return $this->redirect(['form-over', 'id' => $model_id]);

            return $model_id;
        }

        if ($model->load($post)) { // save, submit and print

            $model->user = yii::$app->user->identity->id;
            $model->kod_id = self::generateCodeReset('J', $model);
            if(isset($post['Perjalanan']['akuan']) && $post['Perjalanan']['akuan']/1 == 1)
                $model->status = 'A';
            // $model->kod_unjuran = $post['Perjalanan']['kod_unjuran'];
            // $model->id_jabatan = $post['Perjalanan']['id_jabatan'];
            // $model->id_unit = $post['Perjalanan']['id_unit'];
            // $model->nama = $post['Perjalanan']['nama'];
            // $model->no_kp = $post['Perjalanan']['no_kp'];
            // $model->no_hp = $post['Perjalanan']['no_hp'];
            // $model->bulan = $post['Perjalanan']['bulan'];
            // $model->tahun = $post['Perjalanan']['tahun'];
            // $model->jawatan = $post['Perjalanan']['jawatan'];
            // $model->no_gaji = $post['Perjalanan']['no_gaji'];
            // $model->gaji_asas = $post['Perjalanan']['gaji_asas'];
            // $model->elaun = $post['Perjalanan']['elaun'];
            // $model->bank = $post['Perjalanan']['bank'];
            // $model->cawangan_bank = $post['Perjalanan']['cawangan_bank'];
            // $model->akaun_bank = $post['Perjalanan']['akaun_bank'];
            // $model->model_kereta = $post['Perjalanan']['model_kereta'];
            // $model->no_plate = $post['Perjalanan']['no_plate'];
            // $model->cc = $post['Perjalanan']['cc'];
            // $model->kelas_tuntutan = $post['Perjalanan']['kelas_tuntutan'];
            // $model->alamat_rumah = $post['Perjalanan']['alamat_rumah'];
            // $model->alamat_pejabat = $post['Perjalanan']['alamat_pejabat'];
            // $model->jumlah_tuntutan = $post['Perjalanan']['jumlah_tuntutan'];
            // $model->jenis = $post['Perjalanan']['jenis'];

            if(!$model->save())
                return print_r($model->getErrors());
            $model_id = $model->id;
            //return isset($model_id) ? $model_id : 'xxx';
            $perjalanan = Yii::$app->request->post('Perjalanan');
            $details = Yii::$app->request->post('PerjalananDetails');
            $hotels = Yii::$app->request->post('PerjalananHotel');

            $nth_perjalanans = [];
            foreach ($details['tarikh'] as $key => $value) {
                $nth_perjalanans [] = $key;
            }
            $data_perjalanans = [];
            foreach ($details as $key => $value) {
                $data_perjalanans[] = $value;
            }
            
            foreach ($nth_perjalanans as $key => $value1) {
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
                if($data_hotels[0][$value] == 0 || $data_hotels[1][$value] == '')
                    continue;
                $model_hotel = new PerjalananHotel();
                $model_hotel->id_perjalanan = $model_id;
                $model_hotel->kali_hotel = $data_hotels[0][$value];
                $model_hotel->kos_hotel = $data_hotels[1][$value];
                if(!$model_hotel->save())
                    return print_r($model_details->getErrors());
            }

            $luar = Yii::$app->request->post('PerjalananLuarDetails');
            $luar_record = count(Yii::$app->request->post('PerjalananLuarDetails')['dari']);
            for($c = 1; $c <= $luar_record; $c++) {
                foreach ($luar as $key => $value) {
                    $luar_details[$c]['PerjalananLuarDetails'][$key] = $value[$c];
                }
            }
            foreach ($luar_details as $key => $value) {
                $model_luar_details = new PerjalananLuarDetails();
                $model_luar_details->load($value);
                $model_luar_details->id_perjalanan = $model_id;
                $model_luar_details->dari = $value['PerjalananLuarDetails']['dari'];
                $model_luar_details->tarikh_bertolak = Yii::$app->formatter->asDate($value['PerjalananLuarDetails']['tarikh_bertolak'], 'yyyy-MM-dd');
                $model_luar_details->waktu_bertolak = date('H:i', strtotime($value['PerjalananLuarDetails']['waktu_bertolak']));
                $model_luar_details->destinasi = $value['PerjalananLuarDetails']['destinasi'];
                $model_luar_details->tarikh_sampai = Yii::$app->formatter->asDate($value['PerjalananLuarDetails']['tarikh_sampai'], 'yyyy-MM-dd');
                $model_luar_details->waktu_sampai = date('H:i', strtotime($value['PerjalananLuarDetails']['waktu_sampai']));
                $model_luar_details->tujuan_lawatan = $value['PerjalananLuarDetails']['tujuan_lawatan'];
                if(!$model_luar_details->save())
                    return print_r($model_luar_details->getErrors());
            }
            if(isset($post['Perjalanan']['akuan']) && $post['Perjalanan']['akuan']/1 == 1)
                return $this->redirect(['form-over', 'id' => $model_id]);

            return $model_id;
        }

        return $this->render('create-over', [
            'model' => $model,
            //'model_luar_details' => $model_luar_details,
        ]);
    }

    public function actionCreateOther()
    {
        $model = new Perjalanan();
        $id_pengguna = Yii::$app->user->identity->id;
        $latest_model = Perjalanan::find()->where(['user' => $id_pengguna])
                                          ->andWhere(['<>', 'status', 'X'])
                                          ->orderBy(['id' => SORT_DESC])->one();
        $post = Yii::$app->request->post();

        //return print_r($post);
        if ($model->load($post)) { // save, submit and print

            $model->user = $id_pengguna;
            $model->kod_id = self::generateCodeReset('J', $model);
            if(isset($post['Perjalanan']['akuan']) && $post['Perjalanan']['akuan']/1 == 1)
                $model->status = 'A';
            if(!$model->save())
                return print_r($model->getErrors());
            if(isset($post['Perjalanan']['akuan']) && $post['Perjalanan']['akuan']/1 == 1)
                return $this->redirect(['form-other', 'id' => $model->id]);

            return $model->id;
        }


        return $this->render('create-other', [
            'model' => $model,
            'latest_model' => $latest_model
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

        if($model->status != 'X')
            return $this->redirect(['perjalanan/index']);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['form', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'perjalanan_details' => PerjalananDetails::findAll(['id_perjalanan' => $id]),
            'perjalanan_hotel' =>PerjalananHotel::findAll(['id_perjalanan' => $id]),
        ]);
    }

    public function actionUpdateOver($id)
    {
        $model = $this->findModel($id);

        if($model->status != 'X')
            return $this->redirect(['perjalanan/index']);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['form-over', 'id' => $model->id]);
        }

        return $this->render('update-over', [
            'model' => $model,
            'perjalanan_details' => PerjalananDetails::findAll(['id_perjalanan' => $id]),
            'perjalanan_hotel' => PerjalananHotel::findAll(['id_perjalanan' => $id]),
            'perjalanan_luar_details' => PerjalananLuarDetails::findAll(['id_perjalanan' => $id]),
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
        PerjalananDetails::deleteAll(['id_perjalanan' => $id]);
        PerjalananHotel::deleteAll(['id_perjalanan' => $id]);
        PerjalananLuarDetails::deleteAll(['id_perjalanan' => $id]);
        $this->findModel($id)->delete();

        //return $this->redirect(['index']);
        return $this->redirect(Yii::$app->request->referrer ?: ['index']);
    }

    public function actionUnjuranList()
    {
         return $this->renderAjax('unjuran');
    }

    public function actionCarianPerjalanan()
    {
         //return print_r(yii::$app->request->post());
        $post = yii::$app->request->post();
        $no_kp = $post['no_kp'];
        $bulan = $post['bulan'];
        $tahun = $post['tahun'];
        $os = $post['os'];
        $jenis = $post['jenis'];

        return Perjalanan::find()->joinWith('kodUnjuran')->where(['no_kp' => $no_kp, 'bulan' => $bulan, 'perjalanan.tahun' => $tahun, 'unjuran.os' => $os, 'jenis' => $jenis])->count();
    }

    public function actionForm($id = 0)
    {
        $model = Perjalanan::findOne($id);
        if(count($model) == 0)
            return $this->render('perjalanan-form', ['error' => 404]);
        $model_details = PerjalananDetails::find()->where(['id_perjalanan' => $id])->all();
        $model_hotels = PerjalananHotel::find()->where(['id_perjalanan' => $id])->all();

        return $this->render('perjalanan-form', [
            'model' => $model,
            'model_details' => $model_details,
            'model_hotels' => $model_hotels
        ]);
    }

    public function actionFormOver($id = 0)
    {
        $model = Perjalanan::findOne($id);
        if(count($model) == 0)
            return $this->render('perjalanan-form', ['error' => 404]);
        $model_details = PerjalananDetails::find()->where(['id_perjalanan' => $id])->all();
        $model_hotels = PerjalananHotel::find()->where(['id_perjalanan' => $id])->all();
        $model_luar_details = PerjalananLuarDetails::find()->where(['id_perjalanan' => $id])->all();

        return $this->render('perjalanan-form-over', [
            'model' => $model,
            'model_details' => $model_details,
            'model_hotels' => $model_hotels,
            'model_luar_details' => $model_luar_details,
        ]);
    }

    public function actionFormOther($id = 0)
    {
        $model = Perjalanan::findOne($id);
        if(count($model) == 0)
            return $this->render('perjalanan-form', ['error' => 404]);

        return $this->render('perjalanan-form-other', [
            'model' => $model,
        ]);
    }

    public function actionFormPdf($id = 0)
    {
        $model = Perjalanan::findOne($id);
        if(count($model) == 0)
            return $this->render('perjalanan-form', ['error' => 404]);
        $model_details = PerjalananDetails::find()->where(['id_perjalanan' => $id])->all();
        $model_hotels = PerjalananHotel::find()->where(['id_perjalanan' => $id])->all();

        $content = $this->renderPartial('perjalanan-form-pdf',[
            'model' => $model,
            'model_details' => $model_details,
            'model_hotels' => $model_hotels
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
            .break {page-break-after: always;}

            .noborder tr td, .noborder tr th , table tr td, td th {border: none !important;}

            .noborder td, td , .noborder th { 
                border: none !important; 
                border-style: hidden !important;
                padding: 0; !important;
            }

            table {
              border-collapse: separate;
              border-spacing: 0px;
              font-size: 13px;
              /* Apply cell spacing */
            }

            .btn, footer {display: none !important;}

            table {
                border: solid white !important;
                border-width: 1px 0 0 1px !important;
                border-bottom-style: none;
                border: none;
            }

            th, td {
                border: solid white !important;
                border-width: 0 1px 1px 0 !important;
                border-bottom-style: none;
                border: none;
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
            //'options' => ['title' => 'Borang Perolehan'],
             // call mPDF methods on the fly
            'methods' => [ 
                //'SetHeader'=>['Borang Perolehan'], 
                'SetFooter'=>['{PAGENO}'],
            ]
        ]);

        $mpdf = $pdf->api;
        //$mpdf->keep_table_proportions = false;
        $mpdf->SetDefaultFontSize(8);
    
        // return the pdf output as per the destination setting
        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        //Yii::$app->response->headers->add('Content-Type', 'application/pdf');
        return $pdf->render(); 
    }

    public function actionFinance($id)
    {
        $post = yii::$app->request->post('Perjalanan');
        $model = $this->findModel($id);
        if($post) {
            $model->jumlah_kew = $post['jumlah_kew'];
            $model->status = $post['status'];
            if(!$model->save())
                return print_r($model->getErrors());
            return true;
        }
        return $this->renderAjax('finance', ['model' => $model]);
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
