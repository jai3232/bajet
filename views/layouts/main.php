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
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => 'Laman Utama', 'url' => ['/site/index']],
            ['label' => 'Admin', 'items' => [
                    ['label' => 'Pengguna', 'url' => ['/pengguna/index']],
                    ['label' => 'Jabatan', 'url' => ['/jabatan/index']],
                    ['label' => 'OS (Objek Sebagai)', 'url' => ['/os/index']],
                ],
                'visible' => !Yii::$app->user->isGuest ? Yii::$app->user->identity->accessLevel([0]) : false,
            ],
            ['label' => 'Daftar', 'url' => ['/site/register'], 'visible' => Yii::$app->user->isGuest],
            ['label' => 'Unjuran', 'items' => [
                    [
                        'label' => 'Masukan Unjuran',
                        'url' => ['/unjuran/create'],
                    ],
                    [
                        'label' => 'Unjuran Jabatan/Bahagian',
                        'url' => ['/unjuran/index', 'id' => Yii::$app->user->isGuest ? '' : Yii::$app->user->identity->id_jabatan]
                    ],
                    [
                        'label' => 'Unjuran Semua', 
                        'url' => ['/unjuran/index-all'],
                        'visible' => !Yii::$app->user->isGuest ? Yii::$app->user->identity->accessLevel([0, 2, 3, 4]) : false,
                    ],
                    [
                        'label' => 'Laporan Unjuran Jabatan/OS',
                        'url' => ['/unjuran/report'],   
                    ],
                    [
                        'label' => 'Laporan Unjuran OS/Kod',
                        'url' => ['/unjuran/report-os-kod'],   
                    ],
                ], 
                'visible' => !Yii::$app->user->isGuest
            ],
            ['label' => 'Waran', 'items' => [
                    ['label' => 'Senarai Waran', 'url' => ['/waran/index']],
                    ['label' => 'Tambah Waran', 'url' => ['/waran/create']],
                    ['label' => 'Agihan Waran', 'url' => ['/waran/agihan']]
                ],
                'visible' => !Yii::$app->user->isGuest,
            ],
            ['label' => 'Perolehan', 'items' => [
                    ['label' => 'Borang Perolehan', 'url' => ['/perolehan/create']],
                    ['label' => 'Senarai Perolehan Jabatan', 'url' => ['/perolehan/index']],
                    [
                        'label' => 'Senarai Perolehan Semua', 
                        'url' => ['/perolehan/index-all'], 
                        'visible' => !Yii::$app->user->isGuest ? Yii::$app->user->identity->accessLevel([0, 2, 3, 4]) : false,
                    ],
                    ['label' => 'Kelulusan Kewangan', 'url' => ['/perolehan/finance']]
                ],
                'visible' => !Yii::$app->user->isGuest,
            ],
            ['label' => 'Tuntutan', 'items' => [
                    ['label' => 'Senarai Waran', 'url' => ['/waran/index']],
                    ['label' => 'Tambah Waran', 'url' => ['/waran/create']],
                    ['label' => 'Agihan Waran', 'url' => ['/waran/agihan']]
                ],
                'visible' => !Yii::$app->user->isGuest,
            ],
            ['label' => 'Laporan', 'items' => [
                    ['label' => 'Senarai Waran', 'url' => ['/waran/index']],
                    ['label' => 'Tambah Waran', 'url' => ['/waran/create']],
                    ['label' => 'Agihan Waran', 'url' => ['/waran/agihan']]
                ],
                'visible' => !Yii::$app->user->isGuest, 
            ],
            ['label' => 'Bantuan', 'items' => [
                    ['label' => 'Profail', 'url' => ['/pengguna/profile', 'id' => Yii::$app->user->isGuest ? 0 : yii::$app->user->identity->id], 'visible' => !Yii::$app->user->isGuest],
                    ['label' => 'Tukar Katalaluan', 'url' => ['/pengguna/password', 'id' => Yii::$app->user->isGuest ? 0 : yii::$app->user->identity->id], 'visible' => !Yii::$app->user->isGuest],
                    ['label' => 'About', 'url' => ['/site/about']],
                ]
            ],
            //['label' => 'Contact', 'url' => ['/site/contact']],
            Yii::$app->user->isGuest ? (
                ['label' => 'Login', 'url' => ['/site/login']]
            ) : (
                '<li>'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    'Logout (' . Yii::$app->user->identity->no_kp . ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'
            )
        ],
    ]);
    NavBar::end();
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

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
