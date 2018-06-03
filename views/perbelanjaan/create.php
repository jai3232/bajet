<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Perbelanjaan */

$this->title = Yii::t('app', 'Create Perbelanjaan');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Perbelanjaans'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="perbelanjaan-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
