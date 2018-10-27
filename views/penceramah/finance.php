<?php
use yii\widgets\ActiveForm;	
use yii\helpers\Html;
use app\models\Agihan;
use app\models\Unjuran;
use app\models\Jabatan;
use app\models\Unit;
?>
<div class="finance-form">
    <?php $form = ActiveForm::begin(['id' => 'finance']); ?>
    <table id="kodA" class="table table-striped table-bordered table-hover table-responsive list-view">
    	<tbody>
            <tr><th>Kod ID</th><td><?= $model->kod_id ?></td></tr>
            <tr><th>OS</th><td><?= $model->kodUnjuran->os ?></td></tr>
            <tr><th>Nama</th><td><?= $model->nama ?></td></tr>
            <tr><th>No. KP</th><td><?= $model->no_kp ?></td></tr>
            <tr><th>Jabatan / Unit</th><td><?= Jabatan::findOne($model->id_jabatan_asal)->jabatan.' / '.Unit::findOne($model->id_unit)->unit ?></td></tr>
            <tr><th>Tarikh Tuntutan</th><td><?= $model->bulan.'/'.$model->tahun ?></td></tr>
            <tr><th>Jumlah Tuntutan</th><td>RM <span id="jumlah_tuntutan"><?= number_format($model->jumlah_tuntutan, 2) ?></span></td></tr>

            <tr><th>Kelulusan </th><td>
                                    <input name="Penceramah[lulus]" type="radio" value="0" id="lulus"> Lulus tuntutan dengan jumlah yang sama. <br>
                                    <input name="Penceramah[lulus]" type="radio" value="1" id="tukar"> Lulus dengan perubahan jumlah. <br>
                                    <input name="Penceramah[lulus]" type="radio" value="2" id="tolak"> Tolak. <br>
                                   </td>
            </tr>
            
    	</tbody>
    </table>



    
    <?= $form->field($model, 'jumlah_tuntutan', ['inputOptions' => ['value' => Yii::$app->formatter->asDecimal($model->jumlah_tuntutan), 'class' => 'form-control']])->textInput(['readonly' => true, 'type' => 'number'])->label('Jumlah Tuntutan (RM)') ?>
    <?= $form->field($model, 'status')->hiddenInput()->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Hantar'), ['class' => 'btn btn-primary hidden', 'id' => 'hantar', 'data-confirm' => 'Hantar data ini?']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>



<?php

$this->registerJs('

    // $("form#finance").on("befreSubmit", function() {
    //     alert("X");
    //     $.post(form.attr("action"), form.serialize())
    //         .done(function(data){
    //             //alert(data);
    //             form.trigger("reset");
    //             $.pjax.reload({container: "#penceramah-grid"});
    //             $("#modalContent").html("<h4>Berjaya</h4>");
    //         })
    //         .fail();

    //     return false;  
    // });
');

?>

<?php $script = <<< JS

$(":radio").click(function(){
    if($(this).val()/1 == 0) {
        $("#penceramah-status").val('B');
        $("#penceramah-jumlah_tuntutan").prop("readonly", true);
        $("#penceramah-jumlah_tuntutan").val($("#jumlah_tuntutan").text().replace(/,/g, ""));

    }
    if($(this).val()/1 == 1){
        $("#penceramah-jumlah_tuntutan").prop("readonly", false);
        $("#penceramah-status").val('B');
    }

    if($(this).val()/1 == 2) {
        $("#penceramah-status").val('C');
        $("#penceramah-jumlah_tuntutan").val("0");
        $("#penceramah-jumlah_tuntutan").prop("readonly", true);
    }

    $("#hantar").removeClass("hidden");

});

$('form#finance').on('beforeSubmit', function(){
    //return false;
    var form = $(this);
    $.post(
        form.attr('action'),
        form.serialize()
    )
        .done(function(data){
            if($.trim(data) == 1) { // if create success
                form.trigger('reset');
                $('#modalContent').html('<h4>Berjaya</h4>');
                $.pjax.reload({container: '#penceramah-grid'});
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