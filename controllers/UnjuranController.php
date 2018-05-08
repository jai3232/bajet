<?php

namespace app\controllers;

use Yii;
use app\models\Unjuran;
use app\models\UnjuranSearch;
use app\models\Jabatan;
use app\models\Waran;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * UnjuranController implements the CRUD actions for Unjuran model.
 */
class UnjuranController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                    [
                        'actions' => ['index'],
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
     * Lists all Unjuran models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UnjuranSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        // if(!isset($_GET['id']))
        //     return $this->redirect(['site/unauthorized']);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionIndexAll()
    {
        if(!Yii::$app->user->identity->accessLevel([1, 3, 4, 5]))
            return $this->redirect(['site/unauthorized']);
        $searchModel = new UnjuranSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('indexAll', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'all' => true,
        ]);
    }

    /**
     * Displays a single Unjuran model.
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
     * Creates a new Unjuran model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Unjuran();

        if ($model->load(Yii::$app->request->post())) {
            $year = Yii::$app->request->post('Unjuran')['tahun']; 
            $model->kod_id = self::generateCode('U'.substr($year,2,2), empty(Unjuran::find()->max('id')) ? 1 : Unjuran::find()->max('id') + 1);
            $model->user = Yii::$app->user->identity->id;
            if($year == date("Y"))
                $model->status = 1;
            if($model->save())
                return $this->redirect(['index', 'UnjuranSearch[tahun]' => $model->tahun]);
            else
                return print_r($model->getErrors());
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Unjuran model.
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
     * Deletes an existing Unjuran model.
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

    public function actionA($id)
    {
        if(Yii::$app->request->post()) {
            $unjuran_post = Yii::$app->request->post('Unjuran')['jumlah_unjuran'];
            $model = $this->findModel($id);
            if($model->jumlah_unjuran > $unjuran_post) {
                $new_model = new Unjuran();
                $year = $model->tahun;
                $new_model->kod_id = self::generateCode('U'.substr($year,2,2), empty(Unjuran::find()->max('id')) ? 1 : Unjuran::find()->max('id') + 1);
                $new_model->os = $model->os;
                $new_model->id_jabatan = $model->id_jabatan;
                $new_model->id_unit = $model->id_unit;
                $new_model->butiran = $model->butiran;
                $new_model->kuantiti = $model->kuantiti;
                $new_model->kod = $model->kod;
                $new_model->jumlah_unjuran = ($model->jumlah_unjuran - $unjuran_post);
                $new_model->tahun = $model->tahun;
                $new_model->catatan = '@ Unjuran dari '.$model->kod_id;
                $new_model->status = $model->status;
                $new_model->user = Yii::$app->user->identity->id;
                if(!$new_model->save())
                    return print_r($new_model->getErrors());
            }
            $model->kod = 'A';
            $model->jumlah_unjuran = $unjuran_post;

    
            if($model->save()) {
                return true;
            }
            return print_r($model->getErrors());
        }
        return $this->renderAjax('a', ['model' => $this->findModel($id)]);
    }

    public function actionShare($id)
    {
        if(Yii::$app->request->post()) {
            return print_r(Yii::$app->request->post('Unjuran')['kongsi']);

        }
        return $this->renderAjax('share', ['model' => $this->findModel($id)]);   
    }

    public function actionReport()
    {
        $jabatan = Jabatan::find();
        $waran = Waran::find();
        $unjuran = Unjuran::find();

        return $this->render('report', [
            'unjuran' => $unjuran,
            'jabatan' => $jabatan,
            'waran' => $waran,
        ]);
   }

    public function actionReportOsKod()
    {
        $jabatan = Jabatan::find();
        $waran = Waran::find();
        $unjuran = Unjuran::find();

        return $this->render('reportOsKod', [
            'unjuran' => $unjuran,
            'jabatan' => $jabatan,
            'waran' => $waran,
        ]);
    }

    static function generateCode($c, $data) {
        $dLength = strlen($data);
        $str = $c;
        $sLength = strlen($c);
        for($i = 0; $i < (10 - $dLength - $sLength); $i++)
            $str .= "0";
        return ($str.$data);
    }

    /**
     * Finds the Unjuran model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Unjuran the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Unjuran::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
