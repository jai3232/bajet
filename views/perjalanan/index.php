<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use app\models\Jabatan;
use app\models\Unit;
/* @var $this yii\web\View */
/* @var $searchModel app\models\PerjalananSearch */
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
if(!isset($_GET['PerjalananSearch']['tahun']))
    $selectedYear = $currentYear;
else
    $selectedYear = $_GET['PerjalananSearch']['tahun'];

if(!isset($_GET['PerjalananSearch']['bulan']))
    $selectedMonth = $currentMonth;
else
    $selectedMonth =  $_GET['PerjalananSearch']['bulan'];

$this->title = Yii::t('app', 'Senarai Perjalanan');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="perjalanan-index">

    <h2><?= Html::encode($this->title) ?></h2>
    <div class="alert alert-info">
        <h5>Petunjuk: A: Sedang diproses, B: Lulus, C: Tolak, X: Tidak Lengkap (belum dihantar)</h5>
    </div>
    <?php Pjax::begin(); ?>
    <div class="form-group">
        <div class="row">
        <?php echo $this->render('_search', [
                'model' => $searchModel, 
                'yearList' => $yearList, 
                'selectedYear' => $selectedYear,
                'months' => $months,
                'selectedMonth' => $selectedMonth,
            ]
        ); ?>
        </div>
    </div>
    <p>
        <?php // Html::a(Yii::t('app', 'Create Perjalanan'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'id' => 'perjalanan-grid',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'kod_unjuran',
            'kod_id',
            // 'kodUnjuran.os',
            [
                'attribute' => 'os',
                'label' => 'OS',
                'value' => function($model) {
                    return $model->kodUnjuran->os;
                },
            ],
            'nama',
            'no_kp',
            [
                'attribute' => 'jenis',
                'value' => function($model) {
                    return $model->jenis == 0 ? 'Dalam':'Luar';
                },
                'filter' => ['Dalam', 'Luar', 'Lain'],
            ],
            [
                'attribute' => 'id_jabatan',
                'label' => 'Jabatan',
                'value' => function($model) {
                    return Jabatan::findOne($model->id_jabatan)->jabatan;
                },
                'filter' => ArrayHelper::map(Jabatan::find()->all(), 'id', 'jabatan'),
            ],
            // [
            //     // 'attribute' => 'id_jabatan_asal',
            //     'label' => 'Unjuran Jabatan ',
            //     'value' => function($model) {
            //         return \app\models\Jabatan::findOne($model->id_jabatan_asal)->jabatan;
            //     }
            // ],
            [
                'attribute' => 'id_unit',
                'label' => 'Unit',
                'value' => function($model) {
                    return Unit::findOne($model->id_unit)->unit;
                },
                'filter' => ArrayHelper::map(Unit::findAll(['id_jabatan' => isset($_GET['PerjalananSearch']['id_jabatan']) ? $_GET['PerjalananSearch']['id_jabatan'] : '']), 'id', 'unit'),
            ],
            [
                'label' => 'Bulan',
                'attribute' => 'bulan',
                'value' => function($model) {
                    return $model->bulan.'/'.$model->tahun;
                }
            ],
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
            //'kali_lojing',
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
            [  
                'attribute' => 'jumlah_tuntutan',
                'contentOptions' => ['class' => 'text-right'],
                'value' => function($model) {
                    return number_format($model->jumlah_tuntutan, 2);
                }
            ],
            [  
                'label' => 'Lulus Kewangan',
                'attribute' => 'jumlah_kew',
                'contentOptions' => ['class' => 'text-right'],
                'value' => function($model) {
                    if($model->status == 'B')
                        return number_format($model->jumlah_kew, 2);
                    return '0.00';
                }
            ],
            [
                'attribute' => 'status',
                'contentOptions' => ['class' => 'text-center'],
                'filter' => ['A', 'B', 'C', 'X'],
            ],
            //'cetak',
            //'catatan:ntext',
            //'user',
            //'tarikh_jadi',
            //'tarikh_kemaskini',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}{update}{delete}{finance}',
                'visibleButtons' => [
                    'update' => function($model) {
                        // if($model->status == 'X')
                        //     return true;
                        // return false;
                        return ($model->status == 'X' && $model->user == Yii::$app->user->identity->id);
                    },
                    'delete' => function($model) {
                        // if($model->status == 'X' )
                        // return true;
                        // return false;
                        return (($model->status == 'X' || $model->status == 'A') && $model->user == Yii::$app->user->identity->id);
                    }

                ],
                'buttons' => [
                    'view' => function($url, $model) {
                        if($model->jenis == 1) {
                            return Html::a('<span class="glyphicon glyphicon-print"></span>', ['perjalanan/form-over', 'id' => $model->id], [
                                    'title' => Yii::t('app', 'Cetak'),
                                ]);
                        }
                        return Html::a('<span class="glyphicon glyphicon-print"></span>', ['perjalanan/form', 'id' => $model->id], [
                                    'title' => Yii::t('app', 'Cetak'),
                                ]);
                    },
                    'update' => function($url, $model) {
                        if($model->jenis == 1) {
                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['perjalanan/update-over', 'id' => $model->id], [
                                'title' => Yii::t('app', 'Kemaskini'),
                            ]);
                        }
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                'title' => Yii::t('app', 'Kemaskini'),
                            ]);


                    },
                    'finance' => function($url, $model) {
                        if($model->status == 'A') {
                            return Html::a('<span class="glyphicon glyphicon-usd finance"></span>', ['perjalanan/finance', 'id' => $model->id], ['title' => Yii::t('app', 'Tindakan Kewangan')]);
                        }
                    }
                ],
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
<?php
Modal::begin([
    'header' => '<h3 id="modal-header">Kelulusan Kewangan</h3>',
    'id' => 'modal',
    //'clientOptions' => ['backdrop' => 'static'],
    'footer' => '<button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>',
]);

echo '<div id="modalContent"></div>';
Modal::end();

?>

<?php
    $this->registerJs('

        $("input[name=\'PerjalananSearch[bulan]\'").hide();

        $("select option[value=\"\"]").append("Semua");
        $("select[name*=tahun] > option:first").hide();

        $(document).on("pjax:success", function() {
            $("select option[value=\"\"]").append("Semua");
            $("select[name*=tahun] > option:first").hide();
            $("input[name=\'PerjalananSearch[bulan]\'").hide();
        });

        $(".finance").on("click", function(){
            $("#modal").modal("show").find("#modalContent").load($(this).parent().attr("href"));
            return false;
        });
    ');

?>
