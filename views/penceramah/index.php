<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;
use app\models\Jabatan;
use app\models\Unit;
/* @var $this yii\web\View */
/* @var $searchModel app\models\PenceramahSearch */
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
if(!isset($_GET['PenceramahSearch']['tahun']))
    $selectedYear = $currentYear;
else
    $selectedYear = $_GET['PenceramahSearch']['tahun'];

if(!isset($_GET['PenceramahSearch']['bulan']))
    $selectedMonth = $currentMonth;
else
    $selectedMonth =  $_GET['PenceramahSearch']['bulan'];

$this->title = Yii::t('app', 'Senarai Tuntutan Penceramah');
$this->params['breadcrumbs'][] = $this->title;
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
<div class="penceramah-index">

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
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Buat Tuntutan Penceramah'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'id' => 'penceramah-grid',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'kod_unjuran',
            'kod_id',
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
                'attribute' => 'id_jabatan',
                'label' => 'Jabatan',
                'value' => function($model) {
                    return Jabatan::findOne($model->id_jabatan)->jabatan;
                },
                'filter' => ArrayHelper::map(Jabatan::find()->all(), 'id', 'jabatan'),
            ],
            [
                'attribute' => 'id_unit',
                'label' => 'Unit',
                'value' => function($model) {
                    return Unit::findOne($model->id_unit)->unit;
                },
                'filter' => ArrayHelper::map(Unit::findAll(['id_jabatan' => isset($_GET['PenceramahSearch']['id_jabatan']) ? $_GET['PenceramahSearch']['id_jabatan'] : '']), 'id', 'unit'),
            ],
            [
                'label' => 'Bulan',
                'attribute' => 'bulan',
                'value' => function($model) {
                    return $model->bulan.'/'.$model->tahun;
                },
                // 'filter' => $months,
            ],
            [  
                'label' => 'Tuntutan',
                'attribute' => 'jumlah_tuntutan',
                'contentOptions' => ['class' => 'text-right'],
                'value' => function($model) {
                    return number_format($model->jumlah_tuntutan, 2);
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
                        return Html::a('<span class="glyphicon glyphicon-print"></span>', ['penceramah/form', 'id' => $model->id], [
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
                            return Html::a('<span class="glyphicon glyphicon-usd finance"></span>', ['penceramah/finance', 'id' => $model->id], ['title' => Yii::t('app', 'Tindakan Kewangan')]);
                        }
                    }
                ],
            ],
            // 'jenis_penceramah',
            // 'nilai_kumpulan', 
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

            // ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
<?php

$this->registerJs('
    $("input[name=\'PenceramahSearch[bulan]\'").hide();

    $("select option[value=\"\"]").append("Semua");
    $("select[name*=tahun] > option:first").hide();

    $(document).on("pjax:success", function() {
        $("select option[value=\"\"]").append("Semua");
        $("select[name*=tahun] > option:first").hide();
        $("input[name=\'PenceramahSearch[bulan]\'").hide();
    });

    $(".finance").on("click", function(){
        $("#modal").modal("show").find("#modalContent").load($(this).parent().attr("href"));
        return false;
    });
    ');

?>
