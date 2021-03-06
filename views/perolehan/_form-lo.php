<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Perolehan */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="lulus_lo">

    <?= Html::beginForm('', 'post', ['id' => 'lulus_lo_form'])?>
        <div class="form-group">
            <label>Kod Perolehan: <span id="kod_perolehan"><?= $model->kod_id ?></span></label><br>
            <label>Nilai Permohonan: <span id="kod_perolehan">RM<?= number_format($model->nilai_permohonan, 2)  ?></span></label>
            <?= Html::hiddenInput('Perolehan[id]', $model->id) ?>
        </div>
        <div class="form-group">
            <label>Kelulusan</label>
            <?= Html::radioList('Perolehan[lulus_lo]', null, ['B' => 'Lulus', 'B+' => 'Lulus Dengan Perubahan Harga', 'C' => 'Ditolak']) ?>
        </div>
        <div class="form-group">
            <label>Nilai LO (RM)</label>
            <?= Html::textInput('Perolehan[nilai_perolehan]', number_format($model->nilai_permohonan, 2), ['class' => 'form-control must', 'readonly' => true, 'id' => 'nilai_lo']) ?>
        </div>
        <div class="form-group">
            <label>No LO</label>
            <?= Html::textInput('Perolehan[nolo]', null, ['class' => 'form-control must']) ?>
        </div>
        <div class="form-group">
            <label>Tarikh LO</label>
           <?= DatePicker::widget([
                    'name' => 'Perolehan[tarikhlo]', 
                    'dateFormat' => 'dd-MM-yyyy', 
                    'options' => ['class' => 'form-control must date', 'readonly' => true]
                ]) 
            ?>
        </div>
        <div class="form-group">
            <label>Catatan</label>
            <?= Html::textarea('Perolehan[catatan2]', null, ['class' => 'form-control']) ?>
        </div>

        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
    <?= Html::endForm() ?>
</div>

<?php
$this->registerJs('
    $("input[name=\"Perolehan[lulus_lo]\"]").on("click", function(){
        if($(this).val() == "B+") {
            $("#nilai_lo").attr("readonly", false);
        }
        else
            $("#nilai_lo").attr("readonly", true);
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

    $("form#lulus_lo_form").on("submit", function(){
        var form = $(this);
        if(!$("input[name=\"Perolehan[lulus_lo]\"]").is(":checked")) {
            alert("Sila pilih kelulusan perolehan");
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

        $.post("'.Url::to(['perolehan/update-lo']).'", $(this).serialize(), function(data) {
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
