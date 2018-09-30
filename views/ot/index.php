<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\OtSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Ots');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ot-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Ot'), ['create'], ['class' => 'btn btn-success']) ?>
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
            //'gred_jawatan',
            //'tanggung_kerja',
            //'jawatan',
            //'no_gaji',
            //'gaji_asas',
            //'kadar_sejam',
            //'bank',
            //'akaun_bank',
            //'jumlah_OT',
            //'jumlah_kew',
            //'status',
            //'catatan:ntext',
            //'user',
            //'tarikh_jadi',
            //'tarikh_kemaskini',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
