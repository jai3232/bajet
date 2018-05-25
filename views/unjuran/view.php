<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Unjuran */

$this->title = $model->kod_id;
$this->params['breadcrumbs'][] = ['label' => 'Unjuran', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="unjuran-view">

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
            'kod_id',
            'os',
            'ol',
            'id_jabatan',
            'id_unit',
            'butiran:ntext',
            'kuantiti',
            'kod',
            'jumlah_unjuran',
            'kongsi',
            'public',
            'tahun',
            'catatan:ntext',
            'status',
            'sah',
            'tarikh_jadi',
            'tarikh_kemaskini',
            'user',
        ],
    ]) ?>

</div>
