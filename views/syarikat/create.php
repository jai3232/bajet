<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Syarikat */

$this->title = Yii::t('app', 'Tambah Syarikat');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Syarikat'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="syarikat-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
