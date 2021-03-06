<?php

namespace app\controllers;

use Yii;
use app\models\Waran;
use app\models\WaranSearch;
use app\models\Jabatan;
use app\models\Agihan;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\base\DynamicModel;

/**
 * WaranController implements the CRUD actions for Waran model.
 */
class WaranController extends Controller
{
    /**
     * @inheritdoc
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
     * Lists all Waran models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new WaranSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $field = [
            'fileImport' => 'File Import',
        ];
        $modelImport = DynamicModel::validateData($field, [
            [['fileImport'], 'required'],
            [['fileImport'], 'file', 'extensions'=>'xls,xlsx','maxSize'=>1024*1024],
        ]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'modelImport' => $modelImport,
        ]);
    }

    /**
     * Displays a single Waran model.
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
     * Creates a new Waran model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if(!Yii::$app->user->identity->accessLevel([0, 2, 3]))
            throw new NotFoundHttpException('Laman ini tidak wujud untuk akses anda.');

        $model = new Waran();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        $model->status_waran = 0;

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Waran model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        if(!Yii::$app->user->identity->accessLevel([0, 2, 3]))
            throw new NotFoundHttpException('Laman ini tidak wujud untuk akses anda.');
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Waran model.
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


    public function actionAgihan()
    {
        $jabatan = Jabatan::find();
        $waran = Waran::find();
        $agihan = Agihan::find();

        return $this->render('distribution', [
            'jabatan' => $jabatan,
            'waran' => $waran,
            'agihan' => $agihan,
        ]);
    }

    public function actionUpdateAgihan()
    {
        $os = $_POST['os'];
        $id_jabatan = $_POST['jabatan'];
        $tahun = $_POST['tahun'];
        $value = $_POST['value'];

        $model = Agihan::findOne([
            'id_jabatan' => $id_jabatan,
            'os' => $os,
            'tahun' => $tahun,
        ]);
        //return $value;
        $model->agihan_jabatan = $value;
        if(!$model->save())
            return json_encode($model->getErrors());
        return true;

    }    

    /**
     * Finds the Waran model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Waran the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Waran::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
