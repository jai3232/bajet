<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Pengguna */

$this->title = $model->no_kp;
//$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pengguna'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pengguna-view">

    <h1><?php //= Html::encode($this->title) ?></h1>

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
                'value' => $model->level0['butiran'],
            ],
            [
                'attribute' => 'aktif',
                'value' => !$model->aktif ? 'Tidak' : 'Ya',
            ],
            //'date',
        ],
    ]) ?>
    <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
</div>
