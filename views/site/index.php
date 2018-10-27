<?php
use yii\helpers\Url;
/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Selamat Datang ke IntraBudget!</h1>

        <p class="lead">Memperkasakan belanjawan</p>

        <p><a class="btn btn-lg btn-success" href="<?= isset(Yii::$app->user->identity->id) ? Url::to(['logout2']) : Url::to(['site/register']) ?>"><?= isset(Yii::$app->user->identity->id) ? 'Keluar' : 'Daftar' ?></a></p>
    </div>

    </div>
</div>
