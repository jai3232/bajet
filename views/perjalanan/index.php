<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\PerjalananSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Perjalanans');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="perjalanan-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Perjalanan'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'kod_unjuran',
            'kod_id',
            'os',
            'bahagian',
            //'bahagian_asal',
            //'unit',
            //'nama',
            //'no_kp',
            //'no_hp',
            //'email:email',
            //'bulan',
            //'tahun',
            //'jawatan',
            //'no_gaji',
            //'gaji_asas',
            //'elaun',
            //'elaun_mangku',
            //'bank',
            //'cawangan_bank',
            //'akaun_bank',
            //'model_kereta',
            //'no_plate',
            //'cc',
            //'kelas_tuntutan',
            //'alamat_pejabat',
            //'alamat_rumah',
            //'jumlah_jarak',
            //'jarak_telah_dituntut',
            //'kali_makan',
            //'kali_makan_sabah',
            //'kali_harian',
            //'kali_harian_sabah',
            //'kali_elaun_luar',
            //'elaun_makan',
            //'elaun_makan_sabah',
            //'elaun_harian',
            //'elaun_harian_sabah',
            //'elaun_luar',
            //'peratus_elaun_makan',
            //'peratus_elaun_makan_sabah',
            //'peratus_elaun_harian',
            //'peratus_elaun_harian_sabah',
            //'peratus_elaun_luar',
            //'kali_hotel',
            //'kali_hotel2',
            //'kali_hotel3',
            //'kali_hotel4',
            //'kali_hotel5',
            //'kali_hotel6',
            //'kali_lojing',
            //'hotel',
            //'hotel2',
            //'hotel3',
            //'hotel4',
            //'hotel5',
            //'hotel6',
            //'cukai',
            //'lojing',
            //'teksi',
            //'resit_teksi',
            //'bas',
            //'resit_bas',
            //'keretapi',
            //'resit_keretapi',
            //'terbang',
            //'resit_terbang',
            //'feri',
            //'resit_feri',
            //'lain',
            //'resit_lain',
            //'tol',
            //'resit_tol',
            //'no_tg',
            //'pakir',
            //'resit_pakir',
            //'dobi',
            //'resit_dobi',
            //'pos',
            //'resit_pos',
            //'telefon',
            //'resit_telefon',
            //'tukaran',
            //'resit_tukaran',
            //'pendahuluan',
            //'tuntutan_lain',
            //'jumlah_tuntutan',
            //'jumlah_kew',
            //'status',
            //'cetak',
            //'catatan:ntext',
            //'user',
            //'tarikh_jadi',
            //'tarikh_kemaskini',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
