<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\Jabatan;
use yii\bootstrap\Modal;
use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UnjuranSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$currentYear = date("Y"); 
$yearList = ['' => ''];
for($i = $currentYear - 5; $i < $currentYear + 5; $i++) {
    $yearList[$i] = $i; 
}
$kodList = ['' => 'ABCD', 'A' => 'A', 'B' => 'B', 'C' => 'C', 'D' => 'D'];

if(!isset($_GET['UnjuranSearch']['tahun']))
    $selectedYear = $currentYear;
else
    $selectedYear = $_GET['UnjuranSearch']['tahun'];

//print_r(Yii::$app->request->get('UnjuranSearch')['tahun']);

$this->title = 'Unjuran Jabatan/Bahagian '.Jabatan::findOne(Yii::$app->user->identity->id_jabatan)->jabatan.' '.$selectedYear;;
$this->params['breadcrumbs'][] = $this->title; echo Yii::t('app','Confirmation');
?>
<div class="unjuran-index">

    <h2><?= Html::encode($this->title) ?></h2>
    <?php //Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= isset($all) ? '' : Html::a('Tambah Unjuran', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <div class="alert alert-info">
        A: Diluluskan, B: Wajib, C: Keutamaan, D: Kurang Utama
    </div>

    <?php

        Modal::begin([
            'header' => '<h3 id="modal-header">Penukaran Kod A</h3>',
            'id' => 'modal',
            'clientOptions' => ['backdrop' => 'static'],
            'footer' => '<button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>',
        ]);

        echo '<div id="modalContent"></div>';
        Modal::end();
        $id_pengguna = Yii::$app->user->identity->id;

    ?>

    <?php
        $gridColumns = [
            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'os',
            'ol',
            [
                'label' => 'Unit',
                'attribute' => 'id_unit',
                'value' => 'unit.unit',
            ],
            'butiran:ntext',
            'kod',
            'jumlah_unjuran',
            'tahun',
            //'catatan:ntext',
            'sah',
            ['class' => 'yii\grid\ActionColumn'],
        ];

        echo ExportMenu::widget([
            'dataProvider' => $dataProvider,
            'columns' => $gridColumns,
            'showConfirmAlert' => false,
            'showColumnSelector' => false,
            'enableFormatter' => true,
            'filename' => 'Unjuran'.$selectedYear,
            'target' => ExportMenu::TARGET_SELF,
            'exportConfig' => [
                ExportMenu::FORMAT_PDF => false,
                ExportMenu::FORMAT_HTML => false,
                //ExportMenu::FORMAT_CSV => true,
                ExportMenu::FORMAT_TEXT => false,
                ExportMenu::FORMAT_EXCEL => false,
                ExportMenu::FORMAT_EXCEL_X => [
                    'label' => "Excel",
                    // 'icon' => true ? 'file-excel-o' : 'floppy-remove',
                    'iconOptions' => ['class' => 'text-success'],
                    // 'linkOptions' => [],
                    'options' => ['title' => "Microsoft Excel"],
                    //'message' => null,
                    'alertMsg' => "Fail Excel akan diproses untuk muatturun.",
                    'mime' => 'application/application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                    'extension' => 'xls',
                    'writer' => 'Excel2007',
                ],
            ],
        ]);
    ?>    

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'kod_id',
            [
                'label' => 'OS',
                'attribute' => 'os',
            ],
            [
                'label' => 'OL',
                'attribute' => 'ol',
            ],
            /*[
                'label' => 'Jabatan',
                'attribute' => 'id_jabatan',
                'value' => 'jabatan.jabatan',
                'filter' => Html::textInput('UnjuranSearch[jabatan]', $searchModel->jabatan, ['class' => 'form-control']),
            ],*/
            [
                'label' => 'Unit',
                'attribute' => 'id_unit',
                'value' => 'unit.unit',
                'filter' => Html::textInput('UnjuranSearch[unit]', $searchModel->unit, ['class' => 'form-control']),
            ],
            'butiran:ntext',
            //'kuantiti',
            [
                'attribute' => 'kod',
                'contentOptions' => ['class' => 'text-center'],
                'filter' => Html::dropDownList('UnjuranSearch[kod]', $searchModel->kod , $kodList, ['class' => 'form-control'])
            ],
            [
                'attribute' => 'jumlah_unjuran',
                'label' => 'Unjuran',
                // 'format' => 'raw',
                //'encodeLabel' => false,
                'contentOptions' => ['class' => 'text-right'],
                'value' => function($model) {
                    return number_format($model->jumlah_unjuran);  
                } 
            ],
            // //'kongsi',
            // 'public',
            [
                'attribute' => 'tahun',
                'filter' => Html::dropDownList('UnjuranSearch[tahun]', $searchModel->tahun, $yearList, ['class' => 'form-control'])
            ],
            'catatan:ntext',
            //'status',
            [
                'label' => 'Sah',
                'attribute' => 'sah',
                'contentOptions' => ['class' => 'text-center'],
                'format' => 'raw',
                'visible' => Yii::$app->user->identity->accessLevel([3, 5, 6]),
                'value' => function($model) {
                    return Html::checkbox('sah', !$model->sah ? false : true);
                }
            ],
            //'tarikh_jadi',
            //'tarikh_kemaskini',
            //'user',
            //['class' => 'yii\grid\ActionColumn'],
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Tindakan',
                'contentOptions' => ['class' => 'text-center'],
                'template' => '{update} {delete} {a} {share} {list}',
                'buttons' => [
                    'update' => function($url, $model) {
                        if(Yii::$app->user->identity->accessLevel([1, 2, 3, 4, 5, 6]) || Yii::$app->user->identity->id == $model->user ) //visible to kj only
                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['update', 'id' => $model->id], [
                        ]);
                    },
                    'delete' => function($url, $model){
                        if(Yii::$app->user->identity->accessLevel([1, 2, 3, 4, 5, 6]) || Yii::$app->user->identity->id == $model->user) //visible to kj only
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete', 'id' => $model->id], [
                                'class' => '',
                                'data' => [
                                    'confirm' => 'Padam rekod ini?',
                                    'method' => 'post',
                                ],
                            ]);
                    },
                    'a' => function($url, $model) {
                        if(Yii::$app->user->identity->accessLevel([6]) && $model->kod != 'A') //visible to kj only
                            return Html::a('<span class="glyphicon glyphicon-text-background" title="Tukar kod A"></span>', ['a', 'id' => $model->id]);
                    },
                    'share' => function($url, $model) {
                        if(Yii::$app->user->identity->accessLevel([6]))
                            return Html::a('<span class="glyphicon glyphicon glyphicon-share" title="Kongsi Unjuran"</span>', ['Kongsi', 'id' => $model->id]);
                    },
                    'list' => function($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-list"></span>', ['list', 'id' => $model->id]);
                    }
                ]
            ],
        ],
    ]); ?>
    <?php //Pjax::end(); ?>
</div>

<?php
$this->registerJs('
    $(".unjuran-index .glyphicon-text-background").click(function(){
        $("#modal").modal("show").find("#modalContent").load($(this).parent().attr("href"));
        $("#modal-header").html("Penukaran Kod A");
        return false;
    });
');

?>
