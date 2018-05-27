<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Perolehan */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Perolehans'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="perolehan-view">

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
            'kod_id',
            'kod_unjuran',
            'id_jabatan',
            'id_jabatan_asal',
            'id_unit',
            'jenis_perolehan',
            'kaedah_pembayaran',
            'kontrak_pusat',
            'id_syarikat',
            'status',
            'tarikh_lulus1',
            'catatan1:ntext',
            'lulus_perolehan',
            'status_kewangan',
            'tarikh_lulus2',
            'nolo',
            'tarikhlo',
            'novoucher',
            'tarikh_voucher',
            'nilai_perolehan',
            'catatan2:ntext',
            'tahun',
            'tarikh_jadi',
            'tarikh_kemaskini',
            'user',
        ],
    ]) ?>

</div>
