<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Penceramah */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Penceramahs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="penceramah-view">

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
            'jenis_penceramah',
            'nilai_kumpulan',
            'tugas',
            'nama',
            'bahagian',
            'bahagian_asal',
            'unit',
            'no_kp',
            'jawatan',
            'gred_jawatan',
            'taraf_jawatan',
            'kelayakan',
            'no_gaji',
            'gaji',
            'jabatan',
            'alamat_jabatan',
            'no_hp',
            'email:email',
            'bulan',
            'tahun',
            'bank',
            'akaun_bank',
            'jumlah_tuntutan',
            'jumlah_kew',
            'status',
            'catatan:ntext',
            'user',
            'tarikh_jadi',
            'tarikh_kemaskini',
        ],
    ]) ?>

</div>
