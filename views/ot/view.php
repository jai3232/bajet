<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Ot */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ots'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ot-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'kod_unjuran',
            'kod_id',
            'os',
            'bahagian',
            'bahagian_asal',
            'unit',
            'nama',
            'no_kp',
            'no_hp',
            'email:email',
            'bulan',
            'tahun',
            'gred_jawatan',
            'tanggung_kerja',
            'jawatan',
            'no_gaji',
            'gaji_asas',
            'kadar_sejam',
            'bank',
            'akaun_bank',
            'jumlah_OT',
            'jumlah_kew',
            'status',
            'catatan:ntext',
            'user',
            'tarikh_jadi',
            'tarikh_kemaskini',
        ],
    ]) ?>

</div>
