<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PenceramahSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Penceramahs');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="penceramah-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Penceramah'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'kod_unjuran',
            'kod_id',
            'jenis_penceramah',
            'nilai_kumpulan',
            //'tugas',
            //'nama',
            //'bahagian',
            //'bahagian_asal',
            //'unit',
            //'no_kp',
            //'jawatan',
            //'gred_jawatan',
            //'taraf_jawatan',
            //'kelayakan',
            //'no_gaji',
            //'gaji',
            //'jabatan',
            //'alamat_jabatan',
            //'no_hp',
            //'email:email',
            //'bulan',
            //'tahun',
            //'bank',
            //'akaun_bank',
            //'jumlah_tuntutan',
            //'jumlah_kew',
            //'status',
            //'catatan:ntext',
            //'user',
            //'tarikh_jadi',
            //'tarikh_kemaskini',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
