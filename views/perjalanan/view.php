<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Perjalanan */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Perjalanans'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="perjalanan-view">

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
            'jawatan',
            'no_gaji',
            'gaji_asas',
            'elaun',
            'elaun_mangku',
            'bank',
            'cawangan_bank',
            'akaun_bank',
            'model_kereta',
            'no_plate',
            'cc',
            'kelas_tuntutan',
            'alamat_pejabat',
            'alamat_rumah',
            'jumlah_jarak',
            'jarak_telah_dituntut',
            'kali_makan',
            'kali_makan_sabah',
            'kali_harian',
            'kali_harian_sabah',
            'kali_elaun_luar',
            'elaun_makan',
            'elaun_makan_sabah',
            'elaun_harian',
            'elaun_harian_sabah',
            'elaun_luar',
            'peratus_elaun_makan',
            'peratus_elaun_makan_sabah',
            'peratus_elaun_harian',
            'peratus_elaun_harian_sabah',
            'peratus_elaun_luar',
            'kali_hotel',
            'kali_hotel2',
            'kali_hotel3',
            'kali_hotel4',
            'kali_hotel5',
            'kali_hotel6',
            'kali_lojing',
            'hotel',
            'hotel2',
            'hotel3',
            'hotel4',
            'hotel5',
            'hotel6',
            'cukai',
            'lojing',
            'teksi',
            'resit_teksi',
            'bas',
            'resit_bas',
            'keretapi',
            'resit_keretapi',
            'terbang',
            'resit_terbang',
            'feri',
            'resit_feri',
            'lain',
            'resit_lain',
            'tol',
            'resit_tol',
            'no_tg',
            'pakir',
            'resit_pakir',
            'dobi',
            'resit_dobi',
            'pos',
            'resit_pos',
            'telefon',
            'resit_telefon',
            'tukaran',
            'resit_tukaran',
            'pendahuluan',
            'tuntutan_lain',
            'jumlah_tuntutan',
            'jumlah_kew',
            'status',
            'cetak',
            'catatan:ntext',
            'user',
            'tarikh_jadi',
            'tarikh_kemaskini',
        ],
    ]) ?>

</div>
