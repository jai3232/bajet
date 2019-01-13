<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <div class="header-login"><div id="logo"></div></div>
    <?php
    NavBar::begin([
        'brandLabel' => false,//Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-left'],
        'encodeLabels' => false,
        'items' => [
            ['label' => '<span class="glyphicon glyphicon-home" title="Laman Utama"></span>', 'url' => ['/site/index'], 'visible' => !Yii::$app->user->isGuest ],
            ['label' => 'Admin', 'items' => [
                    ['label' => 'Pengguna', 'url' => ['/pengguna/index']],
                    ['label' => 'Bahagian', 'url' => ['/jabatan/index']],
                    ['label' => 'OS (Objek Sebagai)', 'url' => ['/os/index']],
                    ['label' => 'Konfigurasi', 'url' => ['/site/configuration']],
                ],
                'visible' => !Yii::$app->user->isGuest ? Yii::$app->user->identity->accessLevel([0]) : false,
            ],
            // ['label' => 'Daftar', 'url' => ['/site/register'], 'visible' => Yii::$app->user->isGuest],
            ['label' => 'Unjuran', 'items' => [
                    [
                        'label' => 'Masukan Unjuran',
                        'url' => ['/unjuran/create'],
                    ],
                    [
                        'label' => 'Unjuran Bahagian',
                        'url' => ['/unjuran/index', 'id' => Yii::$app->user->isGuest ? '' : Yii::$app->user->identity->id_jabatan]
                    ],
                    [
                        'label' => 'Unjuran Semua', 
                        'url' => ['/unjuran/index-all'],
                        'visible' => !Yii::$app->user->isGuest ? Yii::$app->user->identity->accessLevel([0, 2, 3, 4]) : false,
                    ],
                    [
                        'label' => 'Laporan Unjuran Bahagian/OS',
                        'url' => ['/unjuran/report'],   
                    ],
                    [
                        'label' => 'Laporan Unjuran OS/Kod',
                        'url' => ['/unjuran/report-os-kod'],   
                    ],
                ], 
                'visible' => !Yii::$app->user->isGuest ? Yii::$app->user->identity->accessLevel([0, 2, 3, 4, 5, 6, 7]) : false,
            ],
            ['label' => 'Waran', 'items' => [
                    ['label' => 'Senarai Waran', 'url' => ['/waran/index']],
                    [
                        'label' => 'Tambah Waran', 
                        'url' => ['/waran/create'],
                        'visible' => !Yii::$app->user->isGuest ? Yii::$app->user->identity->accessLevel([0, 2, 3]) : false,

                    ],
                    ['label' => 'Agihan Waran', 'url' => ['/waran/agihan']]
                ],
                'visible' => !Yii::$app->user->isGuest ? Yii::$app->user->identity->accessLevel([0, 2, 3, 4, 5, 6, 7]) : false,
            ],
            ['label' => 'Perolehan', 'items' => [
                    ['label' => 'Borang Perolehan', 'url' => ['/perolehan/create']],
                    ['label' => 'Senarai Perolehan Bahagian', 'url' => ['/perolehan/index']],
                    [
                        'label' => 'Senarai Perolehan Semua', 
                        'url' => ['/perolehan/index-all'], 
                        'visible' => !Yii::$app->user->isGuest ? Yii::$app->user->identity->accessLevel([0, 2, 3, 4]) : false,
                    ],
                    ['label' => 'Kelulusan Kewangan', 'url' => ['/perolehan/finance']],
                    ['label' => 'Perbelanjaan Lain', 'url' => ['/perbelanjaan/index']]
                ],
                'visible' => !Yii::$app->user->isGuest ? Yii::$app->user->identity->accessLevel([0, 2, 3, 4, 5, 6, 7]) : false,
            ],
            ['label' => 'Tuntutan', 'items' => [
                    ['label' => 'Perjalanan Dalam Negeri', 'url' => ['/perjalanan/create']],
                    ['label' => 'Perjalanan Luar Negeri', 'url' => ['/perjalanan/create-over']],
                    ['label' => 'Perjalanan Lain', 'url' => ['/perjalanan/create-other']],
                    ['label' => 'Lebih Masa (OT)', 'url' => ['/ot/create']],
                    ['label' => 'Penceramah', 'url' => ['/penceramah/create']],
                    ['label' => 'Senarai Tuntutan Perjalanan', 'url' => ['/perjalanan/index']],
                    ['label' => 'Senarai Tuntutan Lebih Masa (OT)', 'url' => ['/ot/index']],
                    ['label' => 'Senarai Tuntutan Penceramah', 'url' => ['/penceramah/index']],
                    
                ],
                'visible' => !Yii::$app->user->isGuest,
            ],
            [
                'label' => 'Syarikat', 
                'items' => [
                    ['label' => 'Daftar Syarikat', 'url' => ['/syarikat/create']],
                    ['label' => 'Senarai Syarikat', 'url' => ['/syarikat/index']],
                    ['label' => 'Kajian Pasaran', 'url' => ['/syarikat/survey']],
                    ['label' => 'Prestasi Pembekal', 'url' => ['/syarikat/performance']],
                ],
                'visible' => !Yii::$app->user->isGuest ? Yii::$app->user->identity->accessLevel([0, 6]) : false,
            ],
            ['label' => 'Laporan', 'items' => [
                    ['label' => 'Dashboard Unjuran', 'url' => ['/laporan/dashboard-unjuran']],
                    ['label' => 'Dashboard Agihan', 'url' => ['/laporan/dashboard-agihan']],
                    ['label' => 'Dashboard Perbelanjaan', 'url' => ['/laporan/dashboard-belanja']],
                    ['label' => 'Dashboard Prestasi OS', 'url' => ['/laporan/dashboard-prestasi-os']],
                    ['label' => 'Perbelanjaan', 'url' => ['/laporan/belanja']],
                    ['label' => 'Prestasi Perbelanjaan', 'url' => ['/laporan/belanja-jabatan']],
                    ['label' => 'Baki Perbelanjaan', 'url' => ['/laporan/baki-belanja']]
                ],
                 'visible' => !Yii::$app->user->isGuest ? Yii::$app->user->identity->accessLevel([0, 2, 3, 4, 5, 6, 7]) : false,
            ],
            ['label' => 'Bantuan', 'items' => [
                    ['label' => 'Profail', 'url' => ['/pengguna/profile', 'id' => Yii::$app->user->isGuest ? 0 : yii::$app->user->identity->id], 'visible' => !Yii::$app->user->isGuest],
                    ['label' => 'Tukar Katalaluan', 'url' => ['/pengguna/password', 'id' => Yii::$app->user->isGuest ? 0 : yii::$app->user->identity->id], 'visible' => !Yii::$app->user->isGuest],
                    // ['label' => 'About', 'url' => ['/site/about']],
                    // [
                    //     'label' => 'Bantuan2', 'items' => [
                    //         ['label' => 'Sub Bantuan', 'options' => ['class' => 'dropdown-submenu end'], 'url' => ['site']],
                    //     ]
                    // ]
                ],
                'visible' => !Yii::$app->user->isGuest,
            ],
            //['label' => 'Contact', 'url' => ['/site/contact']],
            Yii::$app->user->isGuest ? (''
                // ['label' => 'Login', 'url' => ['/site/login']]
            ) : (
                '<li>'
                . Html::beginForm(['/site/logout'], 'post')
                // . Html::submitButton(
                //     'Logout (' . Yii::$app->user->identity->no_kp . ')',
                //     ['class' => 'btn btn-link logout']
                // )
                . Html::submitButton(
                    '<span class="glyphicon glyphicon-log-out" title="Keluar"></span>',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'
            )
        ],
    ]);
    NavBar::end();
    ?>
    <?php
        // if(Yii::$app->controller->action->id == 'login') {
    ?>
    
    <?php 
        // }
    ?>
    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            'homeLink' => ['label' => 'Laman Utama', 'url' => Yii::$app->homeUrl],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>
<footer class="footer" style="background: #222; color: white; font-weight: bold;">
    <div class="container">
        <p class="pull-left">&copy; IntraBajet 2.0 <?= date('Y') ?></p>
        <p class="pull-right"><label style="font-size: 1.1em; color: red">Powered by:</label> <img src="images/stellaris4-footer.png" width="200" height="30"></p>
    </div>    
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

