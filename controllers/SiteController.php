<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;
use yii\web\UploadedFile;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Register;
use app\models\Konfigurasi;
use app\models\Pengguna;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout, configuration'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $model = Konfigurasi::findOne(1);
        if($model->lesen == null) {     
            return $this->render('init', [
                'model' => $model,
            ]);
        }
        if (!Yii::$app->user->isGuest) {
            return $this->render('welcome', []);
        }
        else
            return $this->redirect(['site/login']);
    }

    public function actionInit()
    {
        $post = Yii::$app->request->post('Konfigurasi');
        if($post) {
            $model = Konfigurasi::findOne(1);
            $model->emel = $post['emel'];
            $model->lesen = $post['lesen'];
            $model->sistem_ip = $post['sistem_ip'];
            $model->subnet_mask = $post['subnet_mask'];
            $model->gateway = $post['gateway'];
            if(!$model->save())
                return print_r($model->getErrors());
            return $this->goHome();
        }

    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            // return $this->goHome();
            return $this->render('welcome', []);
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            //return $this->goBack();
            return $this->redirect(['site/index']);
            //return $this->render('welcome', []);
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->redirect(['site/login']);
        return $this->goHome();
    }

    public function actionLogout2()
    {
        Yii::$app->user->logout();
        return $this->redirect(['site/login']);
        return $this->goHome(); 
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    public function actionRegister()
    {
        $model = new Register();

        if ($model->load(Yii::$app->request->post())) {
            $model->password = md5(Yii::$app->request->post('Register')['password']);
            $model->password_ulang = $model->password;

            if(!$model->save()) {
                $err = $model->getErrors();
                //print_r($model->getErrors());
                foreach ($err as $key => $value) {
                    if($key == 'emel')
                        return $this->render('error', ['message' => 'Emel telah wujud', 'name' => 'Error']);
                }
            }
            return $this->redirect(['site/success']);
        }

        return $this->render('register', [
            'model' => $model,
        ]);
    }

    public function actionSuccess()
    {
        return $this->render('success');
    }

    public function actionUnauthorized()
    {
        return $this->render('unauthorized');
    }

    public function actionConfiguration()
    {
        if(Yii::$app->user->isGuest)
            $this->redirect(['site/logout']);
        $model = Konfigurasi::findOne(1);
        $post = Yii::$app->request->post();
        if($post) {
            $model->load($post);
            $model->file = UploadedFile::getInstance($model, 'file');
            if($model->file != null || $model->file != '' || isset($model->file))
                $model->logo = $model->file->baseName . '.' . $model->file->extension;
            if(!$model->save())
                return print_r($model->getErrors());
            if ($model->file && $model->validate()) {                
                $model->file->saveAs('uploads/' . $model->file->baseName . '.' . $model->file->extension);
            }
            return $this->redirect(['site/configuration']);
        }
        return $this->render('konfigurasi', [
            'model' => $model,
        ]);
    }

    public function actionForget()
    {
        $model = new Pengguna();

        if(Yii::$app->request->post()) {
            $nokp = Yii::$app->request->post()['Pengguna']['no_kp'];
            $email = Yii::$app->request->post()['Pengguna']['emel'];
            $personal_found = Pengguna::findAll(['no_kp' => $nokp, 'emel' => $email]);
            $found = count($personal_found);
            // return print_r($personal_found);
            if($found) {
                $status_data = $personal_found[0]->aktif;
                if($status_data == 1) {
                    $config = Konfigurasi::findOne(1);
                    Yii::$app->set('mailer', [
                        'class' => 'yii\swiftmailer\Mailer',
                        'transport' => [
                            'class' => 'Swift_SmtpTransport',
                            // Values from db
                            'host' => $config->smtp,
                            'username' => $config->username,
                            'password' => $config->password,
                            'port' => $config->port,
                            'encryption' => $config->enkripsi,
                        ],
                    ]);
                    $password = substr(md5(time()), 26);
                    $body = '<h3>Set Semula Katalaluan</h3>';
                    $body .= '<p>Login: '.$nokp.'<br>Katalaluan: '.$password.'<p><br>'.md5($password);
                    $sent = Yii::$app->mailer->compose()
                        ->setFrom(['sistem@ciast.gov.my' => 'Sistem'])
                        ->setTo($email)
                        ->setSubject('Set Semula Katalaluan eProfiling')
                        ->setHTMLBody($body)
                        ->send();

                    if($sent) {
                        $pengguna = $model->findOne(['no_kp' => $nokp]);
                        $pengguna->password = md5($password);
                        if(!$pengguna->save())
                            return print_r($personal->getErrors());
                    }
                }
            }
        }

        return $this->render('forget',[
            'model' => $model,
            'found' => isset($found)? $found: 'x',
            'status' => isset($status_data)? $status_data: 'x',
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
