<?php

namespace app\controllers;

use Yii;
use app\models\Pengguna;
use app\models\PenggunaSearch;
use app\models\Unit;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * PenggunaController implements the CRUD actions for Pengguna model.
 */
class PenggunaController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'activate', 'set-level'],
                'rules' => [
                    [
                        'actions' => ['index', 'activate', 'set-level'],
                        'allow' => Yii::$app->user->isGuest ? false : Yii::$app->user->identity->accessLevel([0]),
                        'roles' => ['@'],
                    ],
                ],
                'denyCallback' => function() {
                    return $this->redirect(['site/unauthorized']);
                }
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                //'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Lists all Pengguna models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PenggunaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Pengguna model.
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
     * Creates a new Pengguna model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Pengguna();

        // if ($model->load(Yii::$app->request->post()) && $model->save()) {
        //     return $this->redirect(['view', 'id' => $model->id]);
        // }

        if ($model->load(Yii::$app->request->post())) {
            $model->photo_file = UploadedFile::getInstance($model, 'photo_file');
            // return print_r($model->photo_file);
            if($model->photo_file != null || $model->photo_file != '') {
                $model->photo = $model->photo_file->baseName . '.' . $model->photo_file->extension;
            }
            $model->password = md5(Yii::$app->request->post('Pengguna')['password']);
            $model->password_ulang = $model->password;
            if(!$model->save())
                return print_r($model->getErrors());
            if ($model->photo_file && $model->validate()) {                
                $model->photo_file->saveAs('uploads/pengguna/' . $model->photo_file->baseName . '.' . $model->photo_file->extension);
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Pengguna model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->photo_file = UploadedFile::getInstance($model, 'photo_file');
            if($model->photo_file != null || $model->photo_file != '') {
                $model->photo = $model->photo_file->baseName . '.' . $model->photo_file->extension;
                $model->save();
            }
            if ($model->photo_file && $model->validate()) {                
                $model->photo_file->saveAs('uploads/pengguna/' . $model->photo_file->baseName . '.' . $model->photo_file->extension);
            }
            if(yii::$app->user->identity->level != 0)
                return $this->redirect(['profile', 'id' => $model->id]);
            return $this->redirect(['view', 'id' => $model->id]);
        }
        if(count($model->getErrors()))
            return print_r($model->getErrors());

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionProfile($id)
    {
        if($id != yii::$app->user->identity->id) {
            return $this->redirect(['site/unauthorized']);
        }
        return $this->render('profile', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionPassword($id)
    {
        if($id != yii::$app->user->identity->id) {
            return $this->redirect(['site/unauthorized']);
        }
        //return yii::$app->user->identity->id;

        $msg = '';
        if(Yii::$app->request->post('katalaluan_baru')) {

            $model = new Pengguna();
            $old_password = Yii::$app->request->post('katalaluan_lama');
            $old_hash = md5($old_password);
            $id = Yii::$app->request->post('id');
            
            if($id) {
                $pengguna = $model->findOne(['id' => $id]);
                $new_password = Yii::$app->request->post('katalaluan_baru');
                $repeat_password = Yii::$app->request->post('katalaluan_baru_ulang');
                //if(password_verify($old_password, $personal->katalaluan)) { // PHP 5.5 >=
                if(md5($old_password) == $pengguna->password) {
                    //return $this->redirect(['personal/info', 'tab' => 5]);
                    //return $this->render('info', ['tab' => 5]);
                    if($new_password == $repeat_password) {
                        $pengguna->password = md5($new_password);
                        if(!$pengguna->save())
                            return print_r($pengguna->getErrors());
                        $msg = 'OK';
                    }
                    else
                        $msg = 'MatchError';
                }
                else
                    $msg = 'PassError';
            }
                //return $this->actionInfo(5);
        }

        return $this->render('password', [
            'model' => $this->findModel($id),
            'msg' => $msg,
        ]);
    }

    public function actionUnitList($id) 
    {
        $units = Unit::find()->where(['id_jabatan' => $id])->all();

        $list = '<option value>- Sila Pilih -</option>';
        foreach ($units as $key => $value) {
            $list .= '<option value="'.$value['id'].'">'.$value['unit'].'</option>';
        }
        return $list;
    }

    public function actionActivate($id)
    {

        $model = $this->findModel($id);
        $model->aktif = !$model->aktif ? 1: 0;
        if(!$model->save(false))
            return print_r($model->getErrors);
        return true;
    }

    public function actionSetLevel() 
    {
        $id = $_POST['id'];
        $val = $_POST['val'];
        $model = $this->findModel($id);
        $model->level = $val;
        if(!$model->save(false))
            return print_r($model->getErrors);
        return true;
    }

    /**
     * Deletes an existing Pengguna model.
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

    /**
     * Finds the Pengguna model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Pengguna the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Pengguna::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
