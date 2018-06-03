<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Perolehan */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="lulus_vo">

    <?= Html::beginForm('', 'post', ['id' => 'lulus_vo_form'])?>
        <div class="form-group">
            <label>Kod Perolehan: <span id="kod_perolehan"><?= $model->kod_id ?></span></label><br>
            <label>Nilai Permohonan: <span id="kod_perolehan">RM<?= number_format($model->nilai_permohonan, 2)  ?></span></label>
            <?= Html::hiddenInput('Perolehan[id]', $model->id) ?>
        </div>
        <div class="form-group">
            <label>Nilai Baucer</label>
            <?= Html::radioList('Perolehan[lulus_vo]', null, ['B' => 'Sama', 'B+' => 'Perubahan Nilai', 'C' => 'Ditolak']) ?>
        </div>
        <div class="form-group">
            <label>Nilai Baucer(RM)</label>
            <?= Html::textInput('Perolehan[nilai_perolehan]', number_format($model->nilai_permohonan, 2), ['class' => 'form-control must', 'readonly' => true, 'id' => 'nilai_vo']) ?>
        </div>
        <div class="form-group">
            <label>No Baucer</label>
            <?= Html::textInput('Perolehan[novoucher]', null, ['class' => 'form-control must']) ?>
        </div>
        <div class="form-group">
            <label>Tarikh Baucer</label>
           <?= DatePicker::widget([
                    'name' => 'Perolehan[tarikh_voucher]', 
                    'dateFormat' => 'dd-MM-yyyy', 
                    'options' => ['class' => 'form-control must date', 'readonly' => true]
                ]) 
            ?>
        </div>

        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
    <?= Html::endForm() ?>
</div>

<?php
$this->registerJs('
    $("input[name=\"Perolehan[lulus_vo]\"]").on("click", function(){
        if($(this).val() == "B+") {
            $("#nilai_vo").attr("readonly", false);
        }
        else
            $("#nilai_vo").attr("readonly", true);
    });

    $(".must").on("keyup", function(){
        if($(this).val().length > 0) {
            $(this).css("background", "");
            $(this).attr("placeholder", "");
        }
        else {
            $(this).css("background", "red");
            $(this).attr("placeholder", "Sila lengkapkan input ini");
        }
    });

    $(".date").on("change", function(){
        if($(this).val().length > 0) {
            $(this).css("background", "");
        }
        else {
            $(this).css("background", "red");
        }
    });

    $("form#lulus_vo_form").on("submit", function(){
        var form = $(this);
        if(!$("input[name=\"Perolehan[lulus_vo]\"]").is(":checked")) {
            alert("Sila pilih nilai baucer");
            return false;
        }
        
        if($("input:checked").val() != "C") {
            for(var i = 0; i < $(".must").length; i++) {
                if($(".must").eq(i).val() == "") {
                    $(".must").eq(i).css("background", "red");
                    $(".must").eq(i).attr("placeholder", "Sila lengkapkan input ini");
                    $(".must").eq(i).focus();
                    return false;
                }
            }
        }        

        $.post("'.Url::to(['perolehan/update-vo']).'", $(this).serialize(), function(data) {
            if(data) {
                form.trigger("reset");
                $("#modal").modal("hide");
                $.pjax.reload({container: "#finance-grid"});
            }
            else
                alert(data);
        });

        return false;
    });
');

?>
