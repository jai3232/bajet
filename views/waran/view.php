<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Waran */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Waran', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$status_waran = [0 => 'Asal' , 1 => 'Tambah', 2 => 'Tarik'];
?>
<div class="waran-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Kemaskini', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Padam', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'no_waran',
            'tarikh_waran',
            [
                'attribute' => 'status_waran',
                'value' => $status_waran[$model->status_waran],
            ],
            'tahun',
            'os',
            [
                'attribute' => 'jumlah_waran',
                'value' => number_format($model->jumlah_waran),
            ],
            'catatan:ntext',
        ],
    ]) ?>

</div>
