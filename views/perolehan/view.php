<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\RefJenisPerolehan;
use app\models\RefKaedahPerolehan;

/* @var $this yii\web\View */
/* @var $model app\models\Perolehan */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Perolehan'), 'url' => ['index']];
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
    <?php
        $status = ['A', 'B', 'B+', 'C'];
    ?>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'kod_id',
            'kod_unjuran',
            //'id_jabatan',
            'jabatan.jabatan',
            'unit.unit',
            [
                'attribute' => 'jenis_perolehan',
                'value' =>  RefJenisPerolehan::findOne($model->jenis_perolehan)->jenis,

            ],
            [
                'attribute' => 'kaedah_pembayaran',
                'value' =>  RefKaedahPerolehan::findOne($model->kaedah_pembayaran)->kaedah,
            ],
            [
                'attribute' => 'kontrak_pusat',
                'value' => $model->kontrak_pusat == 0 ? 'Tidak' : 'Ya',
            ],
            //'id_syarikat',
            //'status',
            //'tarikh_lulus1',
            //'catatan1:ntext',
            //'lulus_perolehan',
            [
                'attribute' => 'status_kewangan',
                'value' => $status[$model->status_kewangan],
            ],
            //'tarikh_lulus2:date',
            [
                'attribute' => 'tarikh_lulus2',
                'label' => 'Tarikh Lulus Kewangan',
                'value' => is_null($model->tarikh_lulus2) ? $model->tarikh_lulus2 : Yii::$app->formatter->asDate($model->tarikh_lulus2),
            ],
            [
                'attribute' => 'nolo',
                'label' => 'No. LO',
            ],
            [
                'attribute' => 'tarikhlo',
                'label' => 'Tarikh LO',
                'attribute' => 'tarikh_lulus2',
                'value' => is_null($model->tarikhlo) ? $model->tarikhlo : Yii::$app->formatter->asDate($model->tarikhlo),
            ],
            [
                'attribute' => 'novoucher',
                'label' => 'No Baucer',
            ],
            //'tarikh_voucher',
            [
                'attribute' => 'tarikh_voucher',
                'label' => 'Tarikh Baucer',
                'attribute' => 'tarikh_voucher',
                'value' => is_null($model->tarikh_voucher) ? $model->tarikh_voucher : Yii::$app->formatter->asDate($model->tarikh_voucher),
            ],
            'nilai_perolehan',
            [
                'attribute' => 'catatan2',
                'label' => 'Catatan',
            ],
            //'tahun',
            [
                'attribute' => 'tarikh_jadi',
                'label' => 'Tarikh Mohon',
                'value' => Yii::$app->formatter->asDate($model->tarikh_jadi),
            ],
            //'tarikh_kemaskini',
            [
                'label' => 'Pemohon', 
                'attribute' => 'pengguna.nama', 
            ],
        ],
    ]) ?>

</div>
