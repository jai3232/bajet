<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Os */

$this->title = 'Kemaskini OS';
$this->params['breadcrumbs'][] = ['label' => 'OS', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Kemaskini';
?>
<div class="os-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
