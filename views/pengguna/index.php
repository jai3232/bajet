<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\models\KumpulanPengguna;
use app\models\Jabatan;
/* @var $this yii\web\View */
/* @var $searchModel app\models\PenggunaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Pengguna');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pengguna-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Tambah Pengguna'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'nama',
            'no_kp',
            //'password',
            [
                'label' => 'Jabatan',
                'attribute' => 'id_jabatan',
                'value' => 'jabatan.jabatan',
                //'filter' => ArrayHelper::map(Jabatan::find()->all(), 'id', 'jabatan'),
                'filter' => Html::textInput('PenggunaSearch[jabatan]', $searchModel->jabatan, ['class' => 'form-control']),
            ],
            [
                'label' => 'Unit',
                'attribute' => 'id_unit',
                'value' => 'unit.unit',
                'filter' => Html::textInput('PenggunaSearch[unit]', $searchModel->unit, ['class' => 'form-control']),
            ],
            'emel',
            [
                'label' => 'Level',
                'attribute' => 'level',
                'format' => 'raw',
                'value' => function($model) {
                        return Html::dropDownList('level', 
                                                    $model->level, 
                                                    ArrayHelper::map(KumpulanPengguna::find()->all(), 'id', 'nama'), 
                                                    [
                                                        'class' => 'form-control level-control',
                                                        'dir' => Url::to(['pengguna/set-level']),
                                                        'id' => $model->id,
                                                    ]
                                                 );
                },
                'filter' => ArrayHelper::map(KumpulanPengguna::find()->all(), 'id', 'nama'),
            ],
            //'jenis',
            [
                'label' => 'Aktif',
                'attribute' => 'aktif',
                'contentOptions' => ['class' => 'text-center'],
                'format' => 'raw',
                'value' => function($model) {
                    return Html::checkbox('aktif'.$model->id, 
                                          !$model->aktif ? false : true, 
                                          ['class' => 'activate-user', 
                                          'id' => 'aktif'.$model->id, 
                                          'dir' => Url::to(['pengguna/activate', 'id' => $model->id])]);
                },
                'filter' => ['Tidak', 'Aktif']
            ],
            //'date',

            //['class' => 'yii\grid\ActionColumn'],
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Tindakan',
                'contentOptions' => ['class' => 'text-center'],
                'template' => '{view} {update} {delete}',
                'buttons' => [
                    'delete' => function($url, $model){
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete', 'id' => $model->id], [
                            'class' => '',
                            'data' => [
                                'confirm' => 'Padam rekod ini?',
                                'method' => 'post',
                            ],
                        ]);
                    }
                ]
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>

<?php
    
$this->registerJs('

    var selectVal = 0;

    $(document).on("pjax:success", function() {
        $(".activate-user").on("click", function(){
            if(confirm("Set pengguna ini?")) {
                $.get($(this).attr("dir"), function(data){});
            }
            else
                 $(this).prop("checked", !$(this).prop("checked"));

        });

        $(".level-control").click(function(){
            selectVal = $(this).val();
        });    

        $(".level-control").change(function(){
            if(confirm("Set pengguna ini?")) {
                $.post($(this).attr("dir"), {id: $(this).attr("id"), val: $(this).val()}, function(data) {
                })
            }
            else
                $(this).val(selectVal);
        });
    });

    $(".activate-user").on("click", function(){
        if(confirm("Set pengguna ini?")) {
            $.get($(this).attr("dir"), function(data){});
        }
        else
             $(this).prop("checked", !$(this).prop("checked")); 
    });

    $(".level-control").click(function(){
        selectVal = $(this).val();
    });    

    $(".level-control").change(function(){
        if(confirm("Set pengguna ini?")) {
            $.post($(this).attr("dir"), {id: $(this).attr("id"), val: $(this).val()}, function(data) {
            })
        }
        else
            $(this).val(selectVal);
    });
');
?>
