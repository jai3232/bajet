<?php
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;	
use yii\helpers\Html;
use app\models\Agihan;
use app\models\Unjuran;
?>

<?php /*DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'kod_id',
            'os',
            'ol',
            //'id_jabatan',
            //'id_unit',
            'butiran:ntext',
            'kuantiti',
            'kod',
            'jumlah_unjuran',
            //'kongsi',
            //'public',
            //'tahun',
            'catatan:ntext',
            //'status',
            //'sah',
            //'tarikh_jadi',
            //'tarikh_kemaskini',
            //'user',
        ],
    ])*/ ?>



<?php
    //echo $model->tahun;
    //echo Yii::$app->user->identity->id_jabatan;
    $jumlah_agihan = Agihan::find()->where([
        'id_jabatan' => Yii::$app->user->identity->id_jabatan, 
        'tahun' => $model->tahun, 
        'os' => $model->os])
    ->sum('agihan_jabatan');
    $jumlah_ujuran_A = Unjuran::find()->where([
        'id_jabatan' => Yii::$app->user->identity->id_jabatan, 
        'tahun' => $model->tahun, 
        'os' => $model->os,
        'kod' => 'A'])
    ->sum('jumlah_unjuran');

?>

<table id="kodA" class="table table-striped table-bordered table-hover table-responsive list-view">
	<tbody>
		<tr><th>Kod ID</th><td><?= $model->kod_id ?></td></tr>
		<tr><th>OS</th><td><?= $model->os ?></td></tr>
		<tr><th>OL</th><td><?= $model->ol ?></td></tr>
		<tr><th>Butiran</th><td><?= $model->butiran ?></td></tr>
		<tr><th>Kuantiti</th><td><?= isset($model->kuantiti) ? $model->kuantiti : '-' ?></td></tr>
		<tr><th>Kod Unjuran</th><td><?= $model->kod ?></td></tr>
		<tr><th>Jumlah Unjuran</th><td><?= number_format($model->jumlah_unjuran, 2) ?></td></tr>
		<tr><th>Catatan</th><td><?= $model->catatan ?></td></tr>
        <tr><th>Jumlah Baki Unjuran yang ada </th><td><?= number_format($jumlah_agihan - $jumlah_ujuran_A, 2); ?></td></tr>
        <tr><th>Kelulusan </th><td>
                                <input name="lulus" type="radio" checked value="0"> Tukar kepada kod A seperti nilai unjuran. <br>
                                <input name="lulus" type="radio" value="1"> Tukar kepada kod A dengan perubahan.
                               </td>
        </tr>
        
	</tbody>
</table>

<div class="jabatan-form">

    <?php $form = ActiveForm::begin(['id' => 'kodA']); ?>

    <?= $form->field($model, 'jabatan')->hiddenInput(['maxlength' => true])->label(false) ?>

    <?= $form->field($model, 'jumlah_unjuran')->textInput(['maxlength' => true, 'readonly' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Simpan'), ['class' => 'btn btn-success', 'id' => 'simpanA', 'data-confirm' => 'Set?']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<?php

$this->registerJs('
    $("input[name=lulus]").click(function(){
        if($(this).val() == "1") {
            $("#unjuran-jumlah_unjuran").attr("readonly", false);
        }
        else
            $("#unjuran-jumlah_unjuran").attr("readonly", true);
    });

    $("form#kodA").on("submit", function() {
        var form = $(this);
        $.post(form.attr("action"), form.serialize())
            .done(function(data){
                alert(data);
            })
            .fail();

        return false;  
    });
');

?>

<?php $script = <<< JS

$('form#kodA').on('beforeSubmit', function(){
    alert("Y");
    return false;
    var form = $(this);
    //alert(form.attr('action'));
    //return false;
    $.post(
        form.attr('action'),
        form.serialize()
    )
        .done(function(data){
            if($.trim(data) == 1) { // if create success
                form.trigger('reset');
                $.pjax.reload({container: '#bidangGrid'});
            }
            else
            if($.trim(data) == 2) { // if uddate success
                $('#modalContent').html('<h4>Berjaya</h4>');
                $.pjax.reload({container: '#bidangGrid'});
            }
            else {
                alert('error:'+data);
            }
        })
        .fail();
    return false;
})


JS;
$this->registerJs($script);