<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Waran */

$this->title = 'Tambah Waran';
$this->params['breadcrumbs'][] = ['label' => 'Waran', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="waran-create">

    <h2><?= Html::encode($this->title) ?></h2>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
