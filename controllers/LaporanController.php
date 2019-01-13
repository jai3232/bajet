<?php

namespace app\controllers;

use yii\filters\AccessControl;
use yii\filters\VerbFilter;

class LaporanController extends \yii\web\Controller
{
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
                    'logout' => ['post'],
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
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionDashboardUnjuran()
    {
        return $this->render('dashboard-unjuran');
    }

    public function actionDashboardAgihan()
    {
        return $this->render('dashboard-agihan');
    }

    public function actionDashboardBelanja()
    {
        return $this->render('dashboard-belanja');
    }

    public function actionDashboardPrestasiOs()
    {
        return $this->render('dashboard-prestasi-os');
    }

    public function actionBelanja()
    {
        return $this->render('belanja');
    }

    public function actionBelanjaJabatan()
    {
        return $this->render('belanja-jabatan');
    } 

    public function actionBakiBelanja()
    {
        return $this->render('baki-belanja');
    }   

    public function actionTest()
    {
    	$email = 'jai3232@gmail.com';
    	$fec = substr($email, 0, 1);
    	$lowerArr = range('a', 'z') ;
    	$position = array_search($fec, $lowerArr);
    	echo $position;
    	echo $fec;
    	$encrypt_date = self::ecrypt('2018-12-31');
    	$encrypt_date1 = substr($encrypt_date, 0, $position);
    	$encrypt_date2 = substr($encrypt_date, $position);
    	$encrypt_email = self::ecrypt($email);
    	echo '<br>Enc:'.$encrypt_date;
    	echo '<br>Enc1:'.$encrypt_date1.', Enc2:'.$encrypt_date2;
    	echo '<br>Enc Email:'.$encrypt_email;
    	echo '<br>Lisence: '.$encrypt_date1.$encrypt_email.$encrypt_date2;
    }
    public static function ecrypt( $string, $action = 'e' ) 
    {
	    // you may change these values to your own
	    $secret_key = 'my_simple_secret_key';
	    $secret_iv = 'my_simple_secret_iv';
	 
	    $output = false;
	    $encrypt_method = "AES-256-CBC";
	    $key = hash( 'sha256', $secret_key );
	    $iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );
	 
	    if( $action == 'e' ) {
	        $output = base64_encode( openssl_encrypt( $string, $encrypt_method, $key, 0, $iv ) );
	    }
	    else if( $action == 'd' ){
	        $output = openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );
	    }
	 
	    return $output;
	}

}
