<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use app\models\Jabatan;
use app\models\Unit;
/* @var $this yii\web\View */
/* @var $searchModel app\models\OtSearch */
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
if(!isset($_GET['OtSearch']['tahun']))
    $selectedYear = $currentYear;
else
    $selectedYear = $_GET['OtSearch']['tahun'];

if(!isset($_GET['OtSearch']['bulan']))
    $selectedMonth = $currentMonth;
else
    $selectedMonth =  $_GET['OtSearch']['bulan'];

$this->title = Yii::t('app', 'Senarai Tuntutan OT');
$this->params['breadcrumbs'][] = $this->title;

// $months = [1 => 'Jan', 2 => 'Feb', 3 => 'Mac', 4 => 'Apr', 5 => 'May', 6 => 'Jun', 7 => 'Jul', 
//            8 => 'Ogos', 9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Dis'];
?>
<?php
Modal::begin([
    'header' => '<h3 id="modal-header">Kelulusan Kewangan</h3>',
    'id' => 'modal',
    'clientOptions' => ['backdrop' => 'static'],
    'footer' => '<button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>',
]);

echo '<div id="modalContent"></div>';
Modal::end();

?>
<div class="ot-index">

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
    <?php //Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Buat Tuntutan OT'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'id' => 'ot-grid',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            // 'id',
            'kod_unjuran',
            'kod_id',
            [
                'attribute' => 'os',
                'value' => function($model) {
                    return $model->kodUnjuran->os;
                },
            ],
            'nama',
            'no_kp',            
            [
                'attribute' => 'id_jabatan',
                'label' => 'Jabatan',
                'value' => function($model) {
                    return Jabatan::findOne($model->id_jabatan)->jabatan;
                },
                'filter' => ArrayHelper::map(Jabatan::find()->all(), 'id', 'jabatan'),
            ],
            // [
            //     'attribute' => 'id_jabatan_asal',
            //     'header' => 'Unjuran<br>Jabatan ',
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
                'filter' => ArrayHelper::map(Unit::findAll(['id_jabatan' => isset($_GET['OtSearch']['id_jabatan']) ? $_GET['OtSearch']['id_jabatan'] : '']), 'id', 'unit'),
            ],
            //'no_hp',
            //'email:email',
            [
                'label' => 'Bulan',
                'attribute' => 'bulan',
                'value' => function($model) {
                    return $model->bulan.'/'.$model->tahun;
                },
                // 'filter' => $months,
            ],
            //'tahun',
            //'gred_jawatan',
            //'tanggung_kerja',
            //'jawatan',
            //'no_gaji',
            //'gaji_asas',
            //'kadar_sejam',
            //'bank',
            //'akaun_bank',
            [  
                'label' => 'Jumlah OT',
                'attribute' => 'jumlah_OT',
                'contentOptions' => ['class' => 'text-right'],
                'value' => function($model) {
                    return number_format($model->jumlah_OT, 2);
                }
            ],
            [  
                'label' => 'Kewangan',
                'attribute' => 'jumlah_kew',
                'contentOptions' => ['class' => 'text-right'],
                // 'headerOptions' => ['style' => ['max-width' => '30px', 'word-wrap' => 'break-word']],
                'value' => function($model) {
                    if($model->status == 'B')
                        return number_format($model->jumlah_kew, 2);
                    return '0.00';
                }
            ],
            [
                'attribute' => 'status',
                'contentOptions' => ['class' => 'text-center'],
                'filter' => ['A', 'B', 'C'],
            ],
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
                        return Html::a('<span class="glyphicon glyphicon-print"></span>', ['ot/form', 'id' => $model->id], [
                                    'title' => Yii::t('app', 'Cetak'),
                                ]);
                    },
                    'update' => function($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                'title' => Yii::t('app', 'Kemaskini'),
                            ]);


                    },
                    'finance' => function($url, $model) {
                        if($model->status == 'A') {
                            return Html::a('<span class="glyphicon glyphicon-usd finance"></span>', ['ot/finance', 'id' => $model->id], ['title' => Yii::t('app', 'Tindakan Kewangan')]);
                        }
                    }
                ],
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>

<?php

$this->registerJs('
    $("input[name=\'OtSearch[bulan]\'").hide();

    $("select option[value=\"\"]").append("Semua");
    $("select[name*=tahun] > option:first").hide();

    $(document).on("pjax:success", function() {
        $("select option[value=\"\"]").append("Semua");
        $("select[name*=tahun] > option:first").hide();
        $("input[name=\'OtSearch[bulan]\'").hide();
    });

    $(".finance").on("click", function(){
        $("#modal").modal("show").find("#modalContent").load($(this).parent().attr("href"));
        return false;
    });
    ');

?>
