<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
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
use app\models\Panjar;
use kartik\dialog\Dialog;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PerolehanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$currentYear = date("Y"); 
$currentMonth = date("m");
$yearList = ['' => ''];
for($i = $currentYear - 5; $i < $currentYear + 1; $i++) {
    $yearList[$i] = $i; 
}
$months = [
            '' => '',
            '01' => 'Jan', '02' => 'Feb', '03' => 'Mac', '04' => 'Apr', '05' => 'Mei', '06' => 'Jun',
            '07' => 'Jul', '08' => 'Ogos', '09' => 'Sep', '10' => 'Okt', '11' => 'Nov', '12' => 'Dis'
          ];
//$months = [0 => 'Semua', 'Jan', 'Feb', 'Mac', 'Apr', 'Mei', 'Jun', 'Jul','Ogo', 'Sep', 'Okt', 'Nov', 'Dis'];
if(!isset($_GET['PerolehanSearch']['tahun']))
    $selectedYear = $currentYear;
else
    $selectedYear = $_GET['PerolehanSearch']['tahun'];

if(!isset($_GET['PerolehanSearch']['bulan']))
    $selectedMonth = $currentMonth;
else
    $selectedMonth =  $_GET['PerolehanSearch']['bulan'];

Pjax::begin(); 
$this->title = Yii::t('app', 'Perolehan').' '.Jabatan::findOne(yii::$app->user->identity->id_jabatan)->jabatan.' '.$months[$selectedMonth].' '.$selectedYear;
$this->params['breadcrumbs'][] = $this->title;

echo Dialog::widget();
?>

<div class="perolehan-index">

    <h2><?= Html::encode($this->title) ?></h2>
    <div class="form-group">
        <?= Html::a(Yii::t('app', 'Create Perolehan'), ['create'], ['class' => 'btn btn-success']) ?>
    </div>
    <div class="alert alert-info">
        <strong>Petunjuk</strong> <p>A: Sedang diproses, B: Lulus, C: Tolak </p>
    </div>
    <div class="form-group">
        <div class="row">
        <?php echo $this->render('_search', [
                'model' => $searchModel, 
                'yearList' => $yearList, 
                'selectedYear' => $selectedYear,
                'months' => $months,
                'selectedMonth' => $selectedMonth,
                'all' => false,
            ]
        ); ?>
        </div>
    </div>
       
    <div class="output" style="overflow-x: auto">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}{delete}{file}',
                'visibleButtons' => [
                    'view' => true,
                    'delete' => function($model) {
                        return is_null($model->nolo) ? true : false;
                    },
                    'file' => true,
                ],
                'buttons' => [
                    'file' => function($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-file"></span>', 
                                [ $model->kaedah_pembayaran != 3 ? 'form' : 'panjar', 'id' => $model->id],
                                ['title' => 'Borang']);
                    }
                ]
            ],
            //'id',
            'kod_id',
            'kod_unjuran',
            //'id_jabatan',
            // [
            //     'label' => 'Jabatan',
            //     'attribute' => 'id_jabatan_asal',
            //     'value' => function($model) {
            //         return Jabatan::findOne($model->id_jabatan_asal)->jabatan;
            //     },
            //     'filter' => ArrayHelper::map(Jabatan::find()->all(), 'id', 'jabatan'),
            // ],
            // [
            //     'attribute' => 'tahun',
            //     'filter' => Html::dropDownList('PerolehanSearch[tahun]', $searchModel->tahun, $yearList, ['class' => 'form-control']),
            // ],
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
                },
                'filter' => ArrayHelper::map(Agihan::find()->where(['tahun' => date('Y')])->all(), 'os', 'os'),
            ],
            [
                'label' => 'Jenis',
                'attribute' => 'jenis_perolehan',
                'value' => function($model) {
                    return RefJenisPerolehan::findOne($model->jenis_perolehan)->jenis;
                },
                'filter' => [1 => 'Bekalan', 2 => 'Perkhidmatan', 3 => 'Kerja'],
            ],
            [
                'label' => 'Kaedah',
                'attribute' => 'kaedah_pembayaran',
                'value' => function($model) {
                    return RefKaedahPerolehan::findOne($model->kaedah_pembayaran)->kaedah;
                },
                'filter' => [1 => 'Pembelian Terus', 2 => 'Sebutharga', 3 => 'Panjar', 4 => 'Kontrak', 5 => 'Pukal', 6 => 'Lain-lain'],

            ],
            [
                'label' => 'Barangan <br>Perkhidmatan',
                'format' => 'raw',
                'encodeLabel' => false,
                'attribute' => 'barangan',
                'value' => function($model) {
                    $barangans = Barangan::findAll(['id_perolehan' => $model->id]);
                    $list = '<ol style="margin-left: 0; padding-left: 15px;">';
                    foreach ($barangans as $key => $value) {
                        $list .= '<li>'.$value->justifikasi.'</li>';
                    }
                    $list .= '</ol>';
                    if($model->kaedah_pembayaran == 3)
                        return isset(Panjar::findOne(['id_perolehan' => $model->id])->tujuan) ?
                            Panjar::findOne(['id_perolehan' => $model->id])->tujuan : '-';
                    return $list;
                }
            ],
            [
                'label' => 'Pembekal',
                'format' => 'raw',
                'attribute' => 'pembekal',
                'value' => function($model) {
                    $pembekals = Pembekal::findAll(['id_perolehan' => $model->id]);
                    $list = '<ol style="margin-left: 0; padding-left: 15px;">';
                    foreach ($pembekals as $key => $value) {
                        if($value->utama == 1)
                            $list .= '<li><strong>'.$value->pembekal.'</strong></li>';
                        else
                            $list .= '<li>'.$value->pembekal.'</li>';
                    }
                    $list .= '</ol>';
                    if(!count($pembekals))
                        return null;
                    return $list;
                }
            ],
            // [
            //     'label' => 'Kontrak Pusat',
            //     //'attribute' => 'kontrak_pusat',
            //     'value' => function($model) {
            //         return $model->kontrak_pusat == 1 ? 'Ya' : 'Tidak';
            //     }
            // ],
            //'id_syarikat',
            // [
            //     'attribute' => 'status',
            //     'value' => function($model) {
            //         $status = ['A', 'B', 'C'];
            //         return $status[$model->status];
            //     },
            //     'filter' => ['A', 'B', 'C'],
            // ],
            //'tarikh_lulus1',
            //'catatan1:ntext',
            //'lulus_perolehan',
            [
                'label' => 'Nilai <br>Permohonan',
                'attribute' => 'nilai_permohonan',
                'encodeLabel' => false,
                'contentOptions' => ['class' => 'text-right'],
                'value' => function($model) {
                    return number_format($model->nilai_permohonan, 2);
                    //return print_r(Pembekal::findOne(['id_perolehan' => $model->id, 'utama' => 1])['harga']);
                }
            ],
            [
                'label' => 'Status <br> Kewangan',
                'attribute' => 'status_kewangan',
                'encodeLabel' => false,
                'value' => function($model) {
                    $status = ['A', 'B', 'B+', 'C'];
                    return $status[$model->status_kewangan];
                },
                'contentOptions' => ['class' => 'text-center'],
                'filter' => ['A', 'B', 'B+', 'C'],
            ],
            //'tarikh_lulus2',
            [
                'label' => 'No LO',
                'attribute' => 'nolo',
            ],
            // [
            //     'attribute' => 'tarikhlo',
            //     'label' => 'Tarikh LO',
            // ],
            [
                'attribute' => 'novoucher',
                'label' => 'No Baucer',
            ],
            // [
            //     'attribute' => 'tarikh_voucher',
            //     'label' => 'Tarikh Baucer',
            // ],
            [
                'attribute' => 'nilai_perolehan',
                'label' => 'Nilai Perolehan',
                'value' => function($model) {
                    return is_null($model->novoucher) ? null : $model->nilai_perolehan;
                }
            ],
            [
                'label' => 'Catatan',
                'attribute' => 'catatan2',
            ],
            [
                'label' => 'Tarikh <br>(dd-mm-yyyy)',
                'attribute' => 'tarikh_jadi',
                'encodeLabel' => false,
                'value' => function($model) {
                    return Yii::$app->formatter->asDate($model->tarikh_jadi);
                },
                // 'filter' =>  DatePicker::widget([
                //                 'name' => 'PerolehanSearch[tarikh_jadi]',
                //                 'options' => ['class' => 'form-control'],
                //                 'dateFormat' => 'yyyy-MM-dd',
                //              ]),
            ],
            //'tarikh_kemaskini',
            //'user',
        ],
    ]); ?>
    </div>
    <?php Pjax::end(); ?>
</div>

<?php
    $this->registerJs('
        $("select option[value=\"\"]").append("Semua");
        $("select[name*=tahun] > option:first").hide();

        $(document).on("pjax:success", function() {
            $("select option[value=\"\"]").append("Semua");
            $("select[name*=tahun] > option:first").hide();
        });
    ');

?>
