<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;
use kartik\dialog\Dialog;
use app\models\Unit;
use yii\jui\DatePicker;
use kartik\time\TimePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Ot */
/* @var $form yii\widgets\ActiveForm */
?>

<?php

Modal::begin([
    'header' => '<h3 id="modal-header">Senarai Unjuran</h3>',
    'id' => 'modal',
    'clientOptions' => ['backdrop' => 'static'],
    'size' => 'modal-lg',
    'footer' => '<button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>',
]);

echo '<div id="modalContent"><div class="loader col-sm-4" style="margin: 40px 50%;"></div></div>';
Modal::end();

$id_pengguna = Yii::$app->user->identity->id;
$no_kp = Yii::$app->user->identity->no_kp;

echo Dialog::widget();

$currentYear = date("Y"); 
$yearList = [];
for($i = $currentYear - 1; $i < $currentYear + 2; $i++) {
    $yearList[$i] = $i; 
}

$months = [
            '01' => 'Jan', '02' => 'Feb', '03' => 'Mac', '04' => 'Apr', '05' => 'Mei', '06' => 'Jun',
            '07' => 'Jul', '08' => 'Ogos', '09' => 'Sep', '10' => 'Okt', '11' => 'Nov', '12' => 'Dis'
          ];
?>

<div class="form-group">
    <button id="pilih-unjuran" class="btn btn-primary">Pilih Unjuran</button>
</div>
<div id="unjuran_info" style="display: none;">
    <div class="form-group">
        <label>Kod Unjuran: <span id="kod-unjuran"></span></label>
    </div>
    <div class="form-group">
        <label>OS: <span id="os"></span></label>
    </div>
    <div class="form-group">
        <label>Butiran: <span id="butiran"></span></label>
    </div>
    <div class="form-group">
        <label>Jumlah Unjuran: <span id="jumlah-unjuran"></span></label>
    </div>
    <div class="form-group">
        <label>Baki: <span id="baki"></span></label>
    </div>
    <div class="form-group">
        <label>Unjuran Jabatan: <span id="jabatan"></span></label>
    </div>

</div>

<div class="ot-form">

    <?php $form = ActiveForm::begin(["id" => "ot-form"]); ?>
    <div class="first" style="display: none;">
        <div class="row">
            <div class="col-6 col-sm-6">
                <?= $form->field($model, 'bulan')->dropDownList($months, 
                        [
                            'prompt' => '- Sila Pilih -',
                            'options' => [date("m") => ['selected' => true]],
                        ]) ?>                
            </div>
            <div class="col-6 col-sm-6">
                <?= $form->field($model, 'tahun')->dropDownList($yearList, 
                        [
                            'prompt' => '- Sila Pilih -',
                            'options' => [date("Y") => ['selected' => true]],
                        ]) ?>               
            </div>
        </div>
        <?= $form->field($model, 'no_kp')->textInput(['maxlength' => true, 'value' => $no_kp])->label('No. KP tanpa (-)') ?>
        <div class="row row-loader form-group" style="display: none;">
            <div class="loader col-sm-4"></div>
            <div class="col-sm-8" style="height:60px; display:flex; align-items:center; font-weight: bold;">Carian data ....</div>
        </div>
         <div class="form-group">
            <?= Html::button(Yii::t('app', 'Periksa Data'), ['class' => 'btn btn-success', 'id' => 'periksa-data']) ?>
            <?= Html::button(Yii::t('app', 'Buat Tuntutan'), ['class' => 'btn btn-warning', 'id' => 'buat-tuntutan', 'style' => 'display: none;']) ?>
        </div>

    </div>
    <div class="second" style="display: none;">
        <?= $form->field($model, 'kod_unjuran')->hiddenInput(['maxlength' => true])->label(false) ?>

        <?php //= $form->field($model, 'kod_id')->textInput(['maxlength' => true]) ?>
        
        <?php //= $form->field($model, 'id')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'id_jabatan')->hiddenInput(['maxlength' => true])->label(false) ?>

        <?= $form->field($model, 'id_jabatan_asal')->hiddenInput(['maxlength' => true, 'value' => yii::$app->user->identity->id_jabatan])->label(false)?>

        <?= $form->field($model, 'id_unit')->hiddenInput(['maxlength' => true, 'value' => yii::$app->user->identity->id_unit ])->label(false) ?>

        <?= $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>

        <div class="row">
            <div class="col-6 col-sm-6">
                <?= $form->field($model, 'no_hp')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-6 col-sm-6">
                <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>  
            </div>
        </div>
        <div class="row">
            <div class="col-6 col-sm-6">
                <?= $form->field($model, 'gred_jawatan')->textInput(['maxlength' => true])->label('Gred Jawatan (Con: N17, DV41)') ?>
            </div>
            <div class="col-6 col-sm-6">
                <?= $form->field($model, 'jawatan')->textInput(['maxlength' => true])->label('Jawatan (Con: Pemandu, PLV)') ?>
            </div>
        </div>
        
        <?= $form->field($model, 'tanggung_kerja')->checkbox(['value' => 1]) ?>

        <div class="row">
            <div class="col-3 col-sm-3">
                <?= $form->field($model, 'no_gaji')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-3 col-sm-3">
                <?= $form->field($model, 'gaji_asas')->textInput(['type' => 'number', 'step' => '0.01']) ?>
            </div>
            <div class="col-3 col-sm-3">
                <label>1/3 Gaji</label>
                <?= Html::textInput('gaji13', 0, ['id' => 'gaji13', 'class' => 'form-control', 'readonly' => true]); ?>
            </div>
            <div class="col-3 col-sm-3">
                <?= $form->field($model, 'kadar_sejam')->textInput(['readonly' => true]) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-4 col-sm-4">
                <?= $form->field($model, 'bank')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-4 col-sm-4">
                <?= $form->field($model, 'cawangan_bank')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-4 col-sm-4">
                <?= $form->field($model, 'akaun_bank')->textInput(['maxlength' => true]) ?>
            </div>
        </div>

        <?= $form->field($model, 'jumlah_OT')->hiddenInput()->label(false) ?>

        <?= $form->field($model, 'jumlah_kew')->hiddenInput()->label(false) ?>

        <?= $form->field($model, 'status')->hiddenInput(['value' => 'A'])->label(false) ?>

        <?php //= $form->field($model, 'user')->textInput() ?>
        <div class="hidden">
        <?= DatePicker::widget(['options' => ['class' => 'hidden']]); ?>
            <?= TimePicker::widget([
                'name' => 'start_time', 
                'value' => '00:00 AM',
                'options' => ['class' => 'hidden'],
                'pluginOptions' => ['showInputs' => false]
            ]); ?>
        </div>
        <div class="form-group">
            <label>Kod Hari: A (Hari Bekerja), B (Hari Minggu), C (Hari Kelepasan AM)</label><br>
            <label>Kod Waktu: 1 (6:00 AM - 10:00 PM), 2 (10:00 PM - 6:00 AM)</label>
        </div>

        <table id="maklumat-ot" class="table table-condensed table-striped table-bordered table-hover table-responsive">
            <thead>
                <tr>
                    <th>No.</th><th>Tarikh</th><th>Hari</th><th>Kod Hari</th><th>Kod Waktu</th><th>Waktu Masuk Kerja</th><th>Waktu Pulang Kerja</th><th>Masa Mula OT</th><th>Masa Tamat OT</th><!-- <th>Jumlah Jam</th> --><th>Jam Layak</th><!-- <th>Lampiran Rujukan</th> --><th>Butiran Tugas</th><th>Padam</th>
                </tr>
            </thead>
            <tbody>
                <tr class="clone">
                    <td>1</td>
                    <td>
                        <?= Html::textInput('OtDetails[tarikh][1]', null, ['class' => 'form-control datepicker must', 'readonly' => true]) ?>
                    </td>
                    <td>
                        <?= Html::textInput('OtDetails[hari][1]', null, ['class' => 'form-control must', 'readonly' => true]) ?>
                    </td>
                    <td>
                        <?= Html::dropdownList('OtDetails[kod_hari][1]', null, ['A' => 'A', 'B' => 'B', 'C' => 'C'], ['class' => 'form-control kod-hari kod must', 'prompt' => 'Sila Pilih']); ?>
                    </td>
                    <td>
                        <?= Html::dropdownList('OtDetails[kod_waktu][1]', null, [1 => 1, 2 => 2], ['class' => 'form-control kod-waktu kod must', 'prompt' => 'Sila Pilih']); ?>
                    </td>
                    <td>
                        <?= Html::dropdownList('OtDetails[waktu_masuk][1]', null, [1 => '7:30 AM', '8:00 AM', '8:30 AM', '9:00 AM'], ['class' => 'form-control waktu-masuk kod must', 'prompt' => 'Sila Pilih']); ?>
                    </td>
                    <td>
                        <?= Html::dropdownList('OtDetails[waktu_pulang][1]', null, [1 => '2:30 PM', '3:00 PM', '3:30 PM', '4:00 PM', '4:30 PM', '5:00 PM', '5:30 PM', '6:00 PM'], ['class' => 'form-control waktu-pulang kod must', 'prompt' => 'Sila Pilih']); ?>
                    </td>
                    <td>
                        <div class="bootstrap-timepicker input-group">
                            <input type="text" class="form-control time-picker time-picker-mula must start-ot" name="OtDetails[jam_mula][1]" placeholder="0:00 AM">
                            <span class="input-group-addon picker"><i class="glyphicon glyphicon-time"></i></span>
                        </div>
                    </td>
                    <td>
                        <div class="bootstrap-timepicker input-group">
                            <input type="text" class="form-control time-picker time-picker-akhir must end-ot" name="OtDetails[jam_akhir][1]" placeholder="0:00 AM">
                            <span class="input-group-addon picker"><i class="glyphicon glyphicon-time"></i></span>
                        </div>
                    </td>
                    <!-- <td>
                        <?= Html::textInput('OtDetails[jumlah_jam][1]', null, ['class' => 'form-control jumlah-jam', 'readonly' => true]) ?>
                    </td> -->
                    <td>
                        <?= Html::textInput('OtDetails[jam_layak][1]', null, ['class' => 'form-control jam-layak', 'readonly' => true, 'size' => '10']) ?>
                    </td>
                    <!-- <td>
                        &nbsp;
                    </td> -->
                    <td>
                        <?= Html::textarea('OtDetails[butiran][1]', null, ['class' => 'form-control must', 'cols' => 50]) ?>
                    </td>
                    <td class="remove">
                        
                    </td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="9" id="perkiraan">Jumlah</th>
                    <th id="jumlah-jam-ot"></th>
                    <th></th>
                    <th></th>
                </tr>
            </tfoot>
        </table>
        <div class="form-group">
            <button class="btn btn-primary" id="btn-ot" title="Tambah OT" type="button"><span class="glyphicon glyphicon-plus-sign icon-size"></span></button>
        </div>

        <div class="form-group">
            <?php //= Html::button("Kira", ['class' => 'btn btn-primary kira']) ?>
            <?= Html::submitButton(Yii::t('app', 'Hantar'), ['class' => 'btn btn-success']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>

<?php 

$this->registerJs('
    $("#pilih-unjuran").on("click", function(){
        $("#modal").modal("show").find("#modalContent").load("'.Url::to(['ot/unjuran-list']).'");
        return false;
    });

    $("#periksa-data").on("click", function(){
        if($("#ot-no_kp").val().length > 5) {
            $(".row-loader").show();
            var nokp = $("#ot-no_kp").val();
            var bulan = $("#ot-bulan").val();
            var tahun = $("#ot-tahun").val();
            var os = $("#os").text();
            var data = {no_kp: nokp, bulan: bulan, tahun: tahun, os: os, jenis: 1};
            $.post("'.Url::to(['ot/carian-ot']).'", data)
                .done(function(msg){
                    var x = msg;
                    //alert("a:"+x);
                    $(document).ajaxComplete(function(){
                        //alert("b:"+x);
                        if($.trim(msg)/1 < 1) {
                            //alert("c:"+x);
                            $(".loader").hide();
                            $(".col-sm-8").html(" <span class=\"glyphicon glyphicon-ok\"></span><h5> &nbsp;Tiada tuntutan dibuat pada bulan ini.</h5>");
                            $("#buat-tuntutan").show();
                        }
                        else {
                            $(".loader").hide();
                            $(".col-sm-8").html(" <span class=\"glyphicon glyphicon-remove\"></span> Anda sudah membuat tuntutan OT untuk bulan " + $("#ot-bulan option:selected").text() + " dan OS " + os);
                            $("#buat-tuntutan").hide();
                        }
                    });
                    return false;
                });
        }
        else
            $(".row-loader").hide(); 
    });

    $("#buat-tuntutan").click(function(){
         $(".second").show();
         $("#periksa-data").hide();
         $(this).hide();
         // $(".col-sm-8").hide();
    });

    $("#ot-gaji_asas").keyup(function(){
        $("#gaji13").val(($(this).val()/3).toFixed(2));
        $("#ot-kadar_sejam").val(($(this).val()*12/2504).toFixed(2));
    });

    $("#ot-gaji_asas").change(function(){
        $(".time-picker").trigger("blur");
    });

    // $( ".datepicker" ).datepicker({
    //       numberOfMonths: 2,
    //       minDate: "-2M",
    //       maxDate: new Date(),
    //       dateFormat: "dd-mm-yy",
    //       showButtonPanel: true
    // });

    $(document).on("focus",".datepicker", function(){
        $(this).removeClass("hasDatepicker").datepicker({
            numberOfMonths: 2,
            minDate: "-2M",
            maxDate: new Date(),
            dateFormat: "dd-mm-yy",
            showButtonPanel: true,
            onSelect: function(dateText, inst) {
                var days = ["Isnin", "Selasa", "Rabu", "Khamis", "Jumaat", "Sabtu", "Ahad"];
                var date = $(this).datepicker("getDate");
                var dayOfWeek = date.getUTCDay();
                $(this).parent().next().children().val(days[dayOfWeek]);
            }
        });
    });
    
    $(".time-picker").timepicker({
        defaultTime: false,
        minuteStep: 5,
        // template: true,
        // showInputs: false,
        // minuteStep: 5
    });
    
    var time_picker_mula = false;
    var time_picker_akhir = false;

    $(document).on("blur", ".time-picker", function(e){
        // $(this).timepicker({ defaultTime: false, minuteStep: 5});
        if($(this).attr("name").indexOf("jam_mula") > -1) {
            jam_mula = time_dec24($(this).val());
            time_index = $(this).index(".time-picker-mula");
            jam_akhir = time_dec24($(".time-picker-akhir").eq(time_index).val());
            time_picker_mula = true;
            time_picker_akhir = false;
        }

        if($(this).attr("name").indexOf("jam_akhir") > -1) {
            jam_akhir = time_dec24($(this).val());
            time_index = $(this).index(".time-picker-akhir");
            jam_mula = time_dec24($(".time-picker-mula").eq(time_index).val());
            time_picker_mula = false;
            time_picker_akhir = true;
        }
        
        kod_hari = $(".kod-hari").eq(time_index).val();
        kod_waktu = $(".kod-waktu").eq(time_index).val()/1;
        waktu_masuk = time_dec24($(".waktu-masuk option:selected").eq(time_index).text());
        waktu_pulang = time_dec24($(".waktu-pulang option:selected").eq(time_index).text());

        if(kod_hari == "A" && kod_waktu == 1) {            
            if(waktu_pulang > jam_mula && jam_mula >= waktu_masuk) {
                alert("Waktu mula OT mestilah sama atau lebih daripada waktu pulang pejabat");
                $(".time-picker-mula").eq(time_index).val("");
                return false;
            }
            if(jam_akhir > 22) {
                alert("Waktu berakhir OT untuk kod 1 adalah jam 10:00 PM");
                $(".time-picker-akhir").eq(time_index).val("");
                return false;
            }
            if(jam_mula != -1 && jam_mula < 6) {
                alert("Waktu mula OT untuk kod 1 adalah jam 6:00 AM");
                $(".time-picker-mula").eq(time_index).val("");
                return false;
            }
        }
        if(kod_hari == "A" && kod_waktu == 2) {   
            if(jam_mula >= 6 && jam_mula <= 22) {
                alert("Waktu OT untuk kod waktu 2 adalah antara 10:00 PM sehingga 6:00 AM");
                $(".time-picker-mula").eq(time_index).val("");
            }
            if(jam_akhir >= 6 && jam_akhir <= 22) {
                alert("Waktu OT untuk kod waktu 2 adalah antara 10:00 PM sehingga 6:00 AM");
                $(".time-picker-akhir").eq(time_index).val("");
            }
        }
        if(kod_hari != "A" && kod_waktu == 1) {
            if(jam_mula != -1 && jam_akhir != -1)
                if(!(jam_mula >= 6 && jam_mula <= 22 && jam_akhir >= 6 && jam_akhir <= 22)) {
                    alert("Kod waktu 1 mestilah bermula daripada 6:00 AM sehingga 10:00 PM");
                    return false;
                }
        }
        if(kod_hari != "A" && kod_waktu == 2) {
            if(jam_mula >= 6 && jam_mula < 22 && time_picker_mula == true ) {
                alert("Kod waktu 2 mestilah bermula antara jam 10:00 PM dan 5:00 AM");
                $(".time-picker-mula").eq(time_index).val("");
                $(".time-picker-akhir").eq(time_index).val("");
            }
            if(jam_akhir >= 6 && jam_akhir <= 22 && time_picker_akhir == true) {
                alert("Kod waktu 2 mestilah berakhir selepas jam 10:00 PM dan sebelum 6:00 AM");
                $(".time-picker-mula").eq(time_index).val("");
                $(".time-picker-akhir").eq(time_index).val("");
            }
        }
        if(jam_mula != -1 && jam_akhir != -1) {
            var tambah_jam = 0;
            if(kod_waktu == 1 && jam_mula > jam_akhir)
                alert("Untuk kod waktu 1, jam tamat mestilah lebih lewat dari jam mula")
            if(kod_waktu == 2 && jam_mula > jam_akhir)
                jam_akhir += 24;
            if(kod_hari == "A" && kod_waktu == 1 && jam_mula < waktu_masuk)
                tambah_jam = (waktu_pulang - waktu_masuk) * -1;
            $(".jumlah-jam").eq(time_index).val(jam_layak((jam_akhir - jam_mula + tambah_jam).toFixed(2)));
            // $(".jam-layak").eq(time_index).val(ot_layak((jam_akhir - jam_mula + tambah_jam).toFixed(2), time_index));
            var jam = jam_layak((jam_akhir - jam_mula + tambah_jam).toFixed(2));
            $(".jam-layak").eq(time_index).val(ot_layak(jam, time_index).toFixed(2));
            
            var jumlah_jam_ot = 0;
            for(var j = 0; j < $(".jam-layak").length; j++) {
                temp_jam = $(".jam-layak").eq(j).val() * getRateDay($(".kod-hari").eq(j).val(), $(".kod-waktu").eq(j).val());
                //console.log(j+"# jam-layak:" + $(".jam-layak").eq(j).val() + ", rate:" + getRateDay($(".kod-hari").eq(j).val(), $(".kod-waktu").eq(j).val()));
                temp_jam = temp_jam.toFixed(3);
                if(temp_jam/1 > 0)
                    jumlah_jam_ot += temp_jam/1;
            }
            console.log("J:" + jumlah_jam_ot);
            var jumlah_tuntutan_ot = $("#ot-kadar_sejam").val() * jumlah_jam_ot;
            $("#perkiraan").html("Jumlah: RM" + $("#ot-kadar_sejam").val() + " X " + jumlah_jam_ot + " = RM" + jumlah_tuntutan_ot.toFixed(2));
            
            $("#ot-jumlah_kew, #ot-jumlah_ot").val(jumlah_tuntutan_ot.toFixed(2));
        }
        
    });


    //TIME PICKER CLICK
    $(document).on("click", ".time-picker", function(){
        if($(this).attr("name").indexOf("jam_mula") > -1) {
            time_index = $(this).index(".time-picker-mula");
        }

        if($(this).attr("name").indexOf("jam_akhir") > -1) {
            time_index = $(this).index(".time-picker-akhir");
        }
        if($(".kod-waktu").eq(time_index).val()/1 > 0) {
            $(this).prop("disabled", false);
        }
        else {
            $(this).prop("disabled", true);
            alert("Sila pilih kod waktu dahulu");
        }

        // console.log($(".kod-waktu").eq(time_index).val()/1);
    });

    $(document).on("change", ".kod-waktu", function(){
         time_index = $(this).index(".kod-waktu");
         $(".time-picker-mula, .time-picker-akhir").prop("disabled", false);
    });
    
    var nth_row = 1;
    $("#btn-ot").on("click", function(){
        
        nth_row++;
        var btn_minus = "<button class=\"btn btn-warning btn-ot-minus\" type=\"button\"><span class=\"glyphicon glyphicon-minus-sign icon-size\"></span></button>";
        $("tr.clone:first").clone().insertAfter("table#maklumat-ot > tbody > tr:last");
        $(".remove:last").html(btn_minus);
        $("tr.clone:last").html($("tr.clone:last").html().replace("<td>1</td>", "<td>" + nth_row + "</td>"));
        $("tr.clone:last").html($("tr.clone:last").html().replace(/\[.1?\]/g, "[" + nth_row + "]"));
        //$("tr.clone:last").html($("tr.clone:last").html().replace(/id/g, "src"));
        $("tr.clone:last").html($("tr.clone:last").html().replace(/id\=\"\w*\d*\"/g, ""));
        $(".time-picker").timepicker({
            defaultTime: false,
            minuteStep: 5
        });
    });

    $(document).on("click", ".btn-ot-minus", function(){
        $(this).parent().parent().remove();
    });

    $(document).on("change", ".kod", function(){
        if($(this).prop("class").indexOf("kod-waktu") > -1) {
            var index = $(this).index(".kod-waktu");
        }
        if($(this).prop("class").indexOf("waktu-pulang") > -1) {
            var index = $(this).index(".waktu-pulang");
            var time_out = time24($("option:selected", this).text());
            console.log("out: " + time_out);
        } 
        $(".time-picker").trigger("blur"); 
        // console.log($(this).prop("class") + ":" + index);

    });

    $("#ot-tanggung_kerja").click(function(){
        $(".time-picker").trigger("blur");
    });


    $("form#ot-form").on("beforeValidate", function(){
        if(!checkMust())
            return false;
        if(confirm("Hantar tuntutan ini?"))
            return true;
        return false;
    });

    //console.log(time_dec24(""));
');

// FUNCTIONS
$this->registerJs('
    function time24(amPmString) { 
        var d = new Date("1/1/2013 " + amPmString); 
        return d.getHours() + ":" + d.getMinutes(); 
    }

    function time_dec(time) {
        var t = time.split(":");
        h = t[0];
        m = t[1]/60;

        return Number((h/1 + m/1).toFixed(2));
    }

    function time_dec24(time) {
        if(time == "")
            return -1;
        if(time.indexOf(":") < 0){
            time = time.replace("PM", "");
            time = time.replace("AM", "");
            time = time.replace(" ", "");
            return Number(time);
        }
        var t = time24(time).split(":");
        h = t[0];
        m = t[1]/60;

        return Number((h/1 + m/1).toFixed(2));
    }

    function diff_hours(dt2, dt1) 
    {
        var diff =(dt2.getTime() - dt1.getTime()) / 1000;
        diff /= (60 * 60);
        return /*Math.abs*/(diff.toFixed(2));
    }

    function jam_layak(time)
    {
        var t = time.split(".");
        var h = t[0]/1;
        var m = t[1]/1;

        if(m < 25)
            aqm = 0; //actual qualified minit
        else if(m < 50)
            aqm = 0.25;
        else if(m < 75)
            aqm = 0.5;
        else
            aqm = 0.75;

        return (h/1 + aqm/1);

    }

    function ot_layak(jam, index)
    {
        if(jam > 8)
            jam -= 1;

        if($("#ot-tanggung_kerja").prop("checked")) {
            if($(".datepicker").eq(index).val() != $(".datepicker").eq(index-1).val())
                jam -= 2.25;
            if(index == 0)
                jam -= 2.25;
        }
        return jam;
    }

    function checkMust() {
        for(var i = 0; i < $(".must").length; i++) {
            $(".must").eq(i).css("background-color", "");
            if($(".must").eq(i).val() == "") {
                $(".must").eq(i).css("background-color", "red");    
                alert("Sila lengkapkan ruangan berwarna merah ");
                $(".must").eq(i).focus();
                return false;
            }
        }
        return true;    
    }

    function getRateDay(day, time){
        if(day == "A" && time == "1")
            return 1.125;
        if(day == "A" && time == "2")
            return 1.25;
        if(day == "B" && time == "1")
            return 1.25;
        if(day == "B" && time == "2")
            return 1.5;
        if(day == "C" && time == "1")
            return 1.75;    
        if(day == "C" && time == "2")
            return 2;
        return -1;
    }

', \yii\web\View::POS_HEAD);

?>

<?php

//TESTING SCRIPT

$this->registerJs('

$("#ot-nama").val(Math.random().toString(36).substr(2, 5) + " " + Math.random().toString(36).substr(2, 5));
    $("#ot-no_hp").val((Math.random() * 40000000).toFixed(0));
    $("#ot-email").val(Math.random().toString(36).substr(2, 5) + "@" + Math.random().toString(36).substr(2, 5) + ".com");
    $("#ot-gred_jawatan").val(Math.random().toString(36).substr(2, 5));
    $("#ot-jawatan").val(Math.random().toString(36).substr(2, 5));
    $("#ot-no_gaji").val(Math.random().toString(36).substr(2, 5));
    $("#ot-gaji_asas").val((Math.random()* 10000).toFixed(2));
    $("#ot-gaji_asas").blur(function(){
        $(this).trigger("keyup");
    });
    $("#ot-bank").val(Math.random().toString(36).substr(2, 5));
    $("#ot-cawangan_bank").val(Math.random().toString(36).substr(2, 5));
    $("#ot-akaun_bank").val((Math.random() * 100000000000).toFixed(0));

');

?>
