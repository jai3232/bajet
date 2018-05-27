<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use app\models\Jabatan;

/* @var $this yii\web\View */
/* @var $model app\models\Pengguna */

$this->title = Yii::t('app', 'Kemaskini Pengguna: {nameAttribute}', [
    'nameAttribute' => $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pengguna'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Kemaskini');
?>
<div class="pengguna-update">

    <h2><?= Html::encode($this->title) ?></h2>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>



</div>
