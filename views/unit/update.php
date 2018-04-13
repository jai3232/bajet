<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Unit */

$this->title = Yii::t('app', 'Kemaskini Unit: {nameAttribute}', [
    'nameAttribute' => $model->unit,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Unit'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Yii::t('app', 'Kemaskini');
?>
<div class="unit-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
