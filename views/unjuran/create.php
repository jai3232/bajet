<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Unjuran */

$this->title = 'Tambah Unjuran';
$this->params['breadcrumbs'][] = ['label' => 'Unjuran', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="unjuran-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
