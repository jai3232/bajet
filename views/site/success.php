<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$name = 'Status Pendaftaran';
$this->title = $name;
?>
<div class="site-error">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-success">
        Pendaftaran telah berjaya dilakukan. Akaun anda perlu diaktifkan oleh administrator untuk capaian ke sistem sebagai tujuan keselamatan.
    </div>

</div>
