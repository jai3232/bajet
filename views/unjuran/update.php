<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Unjuran */

$this->title = 'Kemaskini Unjuran: '.$model->kod_id;
$this->params['breadcrumbs'][] = ['label' => 'Unjuran', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Kemaskini';
?>
<div class="unjuran-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
