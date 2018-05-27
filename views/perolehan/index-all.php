<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\Jabatan;
use app\models\Unit;
use app\models\RefJenisPerolehan;
use app\models\RefKaedahPerolehan;
use app\models\Barangan;
use app\models\Pembekal;
use app\models\Unjuran;
use app\models\Agihan;

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

            //'id',
            'kod_id',
            'kod_unjuran',
            //'id_jabatan',
            [
                'label' => 'Jabatan',
                'attribute' => 'id_jabatan_asal',
                'value' => function($model) {
                    return Jabatan::findOne($model->id_jabatan_asal)->jabatan;
                },
                'filter' => ArrayHelper::map(Jabatan::find()->all(), 'id', 'jabatan'),
            ],
            [
                'label' => 'Unit',
                'attribute' => 'id_unit',
                'value' => function($model) {
                    return Unit::findOne($model->id_unit)->unit;
                },
                'filter' => ArrayHelper::map(Unit::findAll(['id_jabatan' => yii::$app->user->identity->id_jabatan]), 'id', 'unit'),
            ],
            [
                'label' => 'OS',
                'format' => 'raw',
                'attribute' => 'os',
                'value' => function($model) {
                    return Unjuran::findOne(['kod_id' => $model->kod_unjuran])->os;
                }
            ],
            [
                'label' => 'Pembekal',
                'format' => 'raw',
                'attribute' => 'pembekal',
                'value' => function($model) {
                    $pembekals = Pembekal::findAll(['id_perolehan' => $model->id]);
                    $list = '<ol style="margin-left: 0; padding-left: 15px">';
                    foreach ($pembekals as $key => $value) {
                        if($value->utama == 1)
                            $list .= '<li><strong>'.$value->pembekal.'</strong></li>';
                        else
                            $list .= '<li>'.$value->pembekal.'</li>';
                    }
                    $list .= '</ol>';
                    return $list;
                }
            ],
            [
                'label' => 'Perolehan',
                //'attribute' => 'jenis_perolehan',
                'value' => function($model) {
                    return RefJenisPerolehan::findOne($model->jenis_perolehan)->jenis . '/' . RefKaedahPerolehan::findOne($model->kaedah_pembayaran)->kaedah;
                }
            ],
            // [
            //     'label' => 'Kaedah Pembayaran',
            //     'attribute' => 'kaedah_pembayaran',
            //     'value' => function($model) {
            //         return RefKaedahPerolehan::findOne($model->kaedah_pembayaran)->kaedah;
            //     }
            // ],
            // [
            //     'label' => 'Kontrak Pusat',
            //     //'attribute' => 'kontrak_pusat',
            //     'value' => function($model) {
            //         return $model->kontrak_pusat == 1 ? 'Ya' : 'Tidak';
            //     }
            // ],
            //'id_syarikat',
            'status',
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
            [
                'label' => 'Tarikh',
                'attribute' => 'tarikh_jadi',
                'value' => function($model) {
                    return Yii::$app->formatter->asDate($model->tarikh_jadi);
                }
            ],
            //'tarikh_kemaskini',
            //'user',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
