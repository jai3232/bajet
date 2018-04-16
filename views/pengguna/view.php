<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Pengguna */

$this->title = $model->no_kp;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pengguna'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pengguna-view">

    <h1><?php //= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Pengguna'), ['index', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php /*= Html::a(Yii::t('app', 'Padam'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ])*/ ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'nama',
            'no_kp',
            //'password',
            'jabatan.jabatan',
            'unit.unit',
            'emel',
            [
                'label' => 'Level',
                'attribute' => 'level0.nama',
                'value' => $model->level0['nama'].': '.$model->level0['butiran'],
            ],
            [
                'attribute' => 'aktif',
                'value' => !$model->aktif ? 'Tidak' : 'Ya',
            ],
            //'date',
        ],
    ]) ?>

</div>
