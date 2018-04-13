<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Os */

$this->title = 'Tambah OS';
$this->params['breadcrumbs'][] = ['label' => 'OS', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="os-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
