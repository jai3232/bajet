<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\PerolehanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Perolehan');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="perolehan-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Perolehan'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'kod_id',
            'kod_unjuran',
            'jabatan',
            'jabatan_asal',
            //'unit',
            //'jenis_perolehan',
            //'kaedah_pembayaran',
            //'kontrak_pusat',
            //'id_syarikat',
            //'status',
            //'tarikh_lulus1',
            //'catatan1:ntext',
            //'lulus_perolehan',
            //'status_kewangan',
            //'tarikh_lulus2',
            //'nolo',
            //'tarikhlo',
            //'novoucher',
            //'tarikh_voucher',
            //'nilai_perolehan',
            //'catatan2:ntext',
            //'tahun',
            //'tarikh_jadi',
            //'tarikh_kemaskini',
            //'user',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
