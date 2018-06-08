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
/* @var $model app\models\Perjalanan */
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

echo '<div id="modalContent"></div>';
Modal::end();
$id_pengguna = Yii::$app->user->identity->id;

echo Dialog::widget();

$currentYear = date("Y"); 
$yearList = [];
for($i = $currentYear - 1; $i < $currentYear + 2; $i++) {
    $yearList[$i] = $i; 
}

$months = [
            '01' => 'Jan', '02' => 'Feb', '03' => 'Mac', '04' => 'Apr', '05' => 'Mei', '06' => 'Jun',
            '07' => 'Jul', '08' => 'Ogo', '09' => 'Sep', '10' => 'Okt', '11' => 'Nov', '12' => 'Dis'
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


<div class="perjalanan-form">
    <?php $form = ActiveForm::begin(["id" => "perjalanan-form"]); ?>
    <div class="first">

        <?= $form->field($model, 'kod_unjuran')->hiddenInput(['maxlength' => true])->label(false) ?>

        <?php //= $form->field($model, 'kod_id')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'id_jabatan')->hiddenInput(['maxlength' => true])->label(false) ?>

        <?= $form->field($model, 'id_jabatan_asal')->hiddenInput(['maxlength' => true, 'value' => yii::$app->user->identity->id_jabatan])->label(false) ?>

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

        <?= $form->field($model, 'no_kp')->textInput(['maxlength' => true, 'value' => '777777777777'])->label('No. KP tanpa (-)') ?>
        <div class="row row-loader form-group" style="display: none;">
            <div class="loader col-sm-4"></div>
            <div class="col-sm-8" style="height:60px; display:flex; align-items:center; font-weight: bold;">Carian data ....</div>
        </div>
         <div class="form-group">
            <?= Html::button(Yii::t('app', 'Periksa Data'), ['class' => 'btn btn-success', 'id' => 'periksa-data']) ?>
            <?= Html::button(Yii::t('app', 'Buat Tuntutan'), ['class' => 'btn btn-warning', 'id' => 'buat-tuntutan', 'style' => 'display: none;']) ?>
        </div>

    </div>

    <div class="second" style="display: nonex;">
        <fieldset><legend>Maklumat Personal</legend>
        <?php //= $form->field($model, 'unit')->dropDownList(ArrayHelper::map(Unit::find()->where(['id_jabatan' => yii::$app->user->identity->id_jabatan])->all(), 'id', 'unit'),['prompt' => '- Sila Pilih -']) ?>

        <?= $form->field($model, 'id_unit')->hiddenInput(['maxlength' => true, 'value' => yii::$app->user->identity->id_unit])->label(false) ?>

        <?= $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>

        <div class="row">
            <div class="col-6 col-sm-6">
            <?= $form->field($model, 'no_hp')->textInput(['maxlength' => true]) ?>
            </div>

            <div class="col-6 col-sm-6">
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
       
        <?= $form->field($model, 'jawatan')->textInput(['maxlength' => true]) ?>
        
        <div class="row">
            <div class="col-6 col-sm-6">
            <?= $form->field($model, 'no_gaji')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-6 col-sm-6">
            <?= $form->field($model, 'gaji_asas')->textInput(['type' => 'number', 'step' => '0.01']) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-6 col-sm-6">
            <?= $form->field($model, 'elaun')->textInput(['type' => 'number', 'step' => '0.01'])->label('Jumlah Elaun') ?>
            </div>
            <div class="col-6 col-sm-6">
            <?= $form->field($model, 'elaun_mangku')->textInput(['type' => 'number', 'step' => '0.01'])->label('Jumlah Elaun Memangku') ?>
            </div>
        </div>
        <div class="row">
            <div class="col-6 col-sm-4">
            <?= $form->field($model, 'bank')->textInput(['maxlength' => true])->label('Nama Bank') ?>
            </div>
            <div class="col-6 col-sm-4">
            <?= $form->field($model, 'cawangan_bank')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-6 col-sm-4">
            <?= $form->field($model, 'akaun_bank')->textInput(['maxlength' => true])->label('Nombor Akaun Bank') ?>
            </div>
        </div>
        <div class="row">
            <div class="col-6 col-sm-4">
            <?= $form->field($model, 'model_kereta')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-6 col-sm-4">
            <?= $form->field($model, 'no_plate')->textInput(['maxlength' => true])->label('Nombor Pendaftaran Kenderaan') ?>
            </div>
            <div class="col-6 col-sm-4">
            <?= $form->field($model, 'cc')->textInput(['type' => 'number', 'step' => '1', 'onkeypress' => 'return event.charCode >= 48 && event.charCode <= 57'])->label('CC Kenderaan') ?>
            </div>
        </div>

        <?= $form->field($model, 'kelas_tuntutan')->radioList(['A' => 'A', 'B' => 'B', 'C' => 'C', 'D' => 'D', 'E' => 'E'], ['class' => 'kelas']) ?>

        <?= $form->field($model, 'alamat_pejabat')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'alamat_rumah')->textInput(['maxlength' => true]) ?>
        </fieldset>
        <fieldset>
            <legend>Maklumat Perjalanan</legend>
            <div class="form-group">
                <?= DatePicker::widget(['options' => ['class' => 'hidden']]); ?>
                <?= TimePicker::widget([
                        'name' => 'start_time', 
                        'value' => '11:24 AM',
                        'options' => ['class' => 'hidden'],
                        'pluginOptions' => []
                    ]); ?>
                <table id="maklumat-perjalanan" class="table table-condensed table-striped table-bordered table-hover table-responsive">
                    <thead bgcolor="#eee">
                        <tr>
                            <th rowspan="2" scope="col" class="text-center">No</th>
                            <th colspan="3" scope="col" class="text-center">Waktu</th>
                            <th rowspan="2" scope="col" class="text-center">Tujuan / Tempat</th>
                            <th rowspan="2" scope="col" class="text-center">Jarak (KM)</th>
                            <th rowspan="2" scope="col" class="text-center">Kos Tol (RM)</th>
                            <th rowspan="2" scope="col" class="text-center">Padam</th>
                        </tr>
                        <tr>
                            <th class="text-center">Tarikh</th>
                            <th class="text-center">Bertolak</th>
                            <th class="text-center">Sampai</th>
                        </tr>
                    </thead>
                    <tbody id="perjalanan-body">
                        <tr>
                            <td class="text-center">1</td>
                            <td class="text-center">
                                <?= Html::textInput('PerjalananDetails[tarikh][1]', null, ['class' => 'form-control datepicker']) ?>
                            </td>
                            <td class="text-center">
                                <div class="bootstrap-timepicker input-group">
                                    <input type="text" class="form-control time-picker" name="PerjalananDetails[bertolak][1]">
                                    <span class="input-group-addon picker"><i class="glyphicon glyphicon-time"></i></span>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="bootstrap-timepicker input-group">
                                    <input type="text" class="form-control time-picker" name="PerjalananDetails[sampai][1]">
                                    <span class="input-group-addon picker"><i class="glyphicon glyphicon-time"></i></span>
                                </div>
                            </td>
                            <td class="text-center"><?= Html::textarea('PerjalananDetails[tujuan][1]', null,['class' => 'form-control', 'cols' => 55]) ?></td>
                            <td class="text-center col-lg-1"><?= Html::textInput('PerjalananDetails[jarak][1]', null,['class' => 'form-control jarak', 'type' => 'number']) ?></td>
                            <td class="text-center col-lg-1"><?= Html::textInput('PerjalananDetails[kos][1]', null,['class' => 'form-control tol', 'type' => 'number', 'step' => 0.01]) ?></td>
                            <td class="text-center"></td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr><th colspan="5"></th><th id="jumlah-jarak" class="text-center">0</th><th id="jumlah-tol" class="text-right">0.00</th><th></th></tr>
                    </tfoot>
                </table>
                <div class="form-group">
                    <button class="btn btn-success" id="btn-perjalanan"><span class="glyphicon glyphicon-plus-sign icon-size"></span></button>
                </div>
            </div>
        </fieldset>

        <?php //= $form->field($model, 'jumlah_jarak')->textInput() ?>

        <?php //= $form->field($model, 'jarak_telah_dituntut')->textInput() ?>

        <?= $form->field($model, 'kali_makan')->textInput() ?>

        <?= $form->field($model, 'kali_makan_sabah')->textInput() ?>

        <?= $form->field($model, 'kali_harian')->textInput() ?>

        <?= $form->field($model, 'kali_harian_sabah')->textInput() ?>

        <?= $form->field($model, 'kali_elaun_luar')->textInput() ?>

        <?= $form->field($model, 'elaun_makan')->textInput() ?>

        <?= $form->field($model, 'elaun_makan_sabah')->textInput() ?>

        <?= $form->field($model, 'elaun_harian')->textInput() ?>

        <?= $form->field($model, 'elaun_harian_sabah')->textInput() ?>

        <?= $form->field($model, 'elaun_luar')->textInput() ?>

        <?= $form->field($model, 'peratus_elaun_makan')->textInput() ?>

        <?= $form->field($model, 'peratus_elaun_makan_sabah')->textInput() ?>

        <?= $form->field($model, 'peratus_elaun_harian')->textInput() ?>

        <?= $form->field($model, 'peratus_elaun_harian_sabah')->textInput() ?>

        <?= $form->field($model, 'peratus_elaun_luar')->textInput() ?>

        <?= $form->field($model, 'kali_hotel')->textInput() ?>

        <?= $form->field($model, 'kali_hotel2')->textInput() ?>

        <?= $form->field($model, 'kali_hotel3')->textInput() ?>

        <?= $form->field($model, 'kali_hotel4')->textInput() ?>

        <?= $form->field($model, 'kali_hotel5')->textInput() ?>

        <?= $form->field($model, 'kali_hotel6')->textInput() ?>

        <?= $form->field($model, 'kali_lojing')->textInput() ?>

        <?= $form->field($model, 'hotel')->textInput() ?>

        <?= $form->field($model, 'hotel2')->textInput() ?>

        <?= $form->field($model, 'hotel3')->textInput() ?>

        <?= $form->field($model, 'hotel4')->textInput() ?>

        <?= $form->field($model, 'hotel5')->textInput() ?>

        <?= $form->field($model, 'hotel6')->textInput() ?>

        <?= $form->field($model, 'cukai')->textInput() ?>

        <?= $form->field($model, 'lojing')->textInput() ?>

        <?= $form->field($model, 'teksi')->textInput() ?>

        <?= $form->field($model, 'resit_teksi')->textInput() ?>

        <?= $form->field($model, 'bas')->textInput() ?>

        <?= $form->field($model, 'resit_bas')->textInput() ?>

        <?= $form->field($model, 'keretapi')->textInput() ?>

        <?= $form->field($model, 'resit_keretapi')->textInput() ?>

        <?= $form->field($model, 'terbang')->textInput() ?>

        <?= $form->field($model, 'resit_terbang')->textInput() ?>

        <?= $form->field($model, 'feri')->textInput() ?>

        <?= $form->field($model, 'resit_feri')->textInput() ?>

        <?= $form->field($model, 'lain')->textInput() ?>

        <?= $form->field($model, 'resit_lain')->textInput() ?>

        <?= $form->field($model, 'tol')->textInput() ?>

        <?= $form->field($model, 'resit_tol')->textInput() ?>

        <?= $form->field($model, 'no_tg')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'pakir')->textInput() ?>

        <?= $form->field($model, 'resit_pakir')->textInput() ?>

        <?= $form->field($model, 'dobi')->textInput() ?>

        <?= $form->field($model, 'resit_dobi')->textInput() ?>

        <?= $form->field($model, 'pos')->textInput() ?>

        <?= $form->field($model, 'resit_pos')->textInput() ?>

        <?= $form->field($model, 'telefon')->textInput() ?>

        <?= $form->field($model, 'resit_telefon')->textInput() ?>

        <?= $form->field($model, 'tukaran')->textInput() ?>

        <?= $form->field($model, 'resit_tukaran')->textInput() ?>

        <?= $form->field($model, 'pendahuluan')->textInput() ?>

        <?= $form->field($model, 'tuntutan_lain')->textInput() ?>

        <?= $form->field($model, 'jumlah_tuntutan')->textInput() ?>

        <?= $form->field($model, 'jumlah_kew')->textInput() ?>

        <?php //= $form->field($model, 'status')->textInput() ?>

        <?php //= $form->field($model, 'cetak')->textInput() ?>

        <?php //= $form->field($model, 'catatan')->textarea(['rows' => 6]) ?>

        <?php //= $form->field($model, 'user')->textInput() ?>

        <?php //= $form->field($model, 'tarikh_jadi')->textInput() ?>

        <?php //= $form->field($model, 'tarikh_kemaskini')->textInput() ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success', 'id' => 'simpan-perjalanan']) ?>
        </div>

    </div>    
    <?php ActiveForm::end(); ?>

    

</div>

<?php

$this->registerJs('
    $("#pilih-unjuran").on("click", function(){
        $("#modal").modal("show").find("#modalContent").load("'.Url::to(['perjalanan/unjuran-list']).'");
        //$("#modal-header").html("Penukaran Kod A");
        return false;
    });

    $("#perjalanan-no_kp").keyup(function(){
          
    });

    $("#periksa-data").on("click", function(){
        if($("#perjalanan-no_kp").val().length > 5) {
            $(".row-loader").show();
            var nokp = $("#perjalanan-no_kp").val();
            var bulan = $("#perjalanan-bulan").val();
            var tahun = $("#perjalanan-tahun").val();
            var os = $("#os").text();
            var data = {no_kp: nokp, bulan: bulan, tahun: tahun, os: os};
            $.post("'.Url::to(['perjalanan/carian-perjalanan']).'", data)
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
                            $(".second").show();
                        }
                        else {
                            $(".loader").hide();
                            $(".col-sm-8").html(" <span class=\"glyphicon glyphicon-remove\"></span> Sudah Claim");
                            $("#buat-tuntutan").hide();
                        }
                    });
                    return false;
                });
        }
        else
            $(".row-loader").hide(); 
    });

    $("#perjalanan-no_kp, #perjalanan-bulan, #perjalanan-tahun").change(function(){
        $("#buat-tuntutan").hide();
    });

    $("#buat-tuntutan").click(function(){
         $("#perjalanan-no_kp, #perjalanan-bulan, #perjalanan-tahun").attr("readonly", true);
    });

    $("input[name=\"Perjalanan[kelas_tuntutan]\"]").addClass("kelass");

    $("#perjalanan-gaji_asas, #perjalanan-cc").blur(function(){
        k = setKelasTuntutan($("#perjalanan-gaji_asas").val()/1, $("#perjalanan-cc").val()/1);
        //alert(k);
        console.log(k);
        $(".kelass").prop("checked", false);
        if(k == "A")
            $(".kelass").eq(1).prop("checked", true);
        if(k == "B")
            $(".kelass").eq(2).prop("checked", true);
        if(k == "C")
            $(".kelass").eq(3).prop("checked", true);
        if(k == "D")
            $(".kelass").eq(4).prop("checked", true);
        if(k == "E")
            $(".kelass").eq(5).prop("checked", true);
        $(".kelass:checked").trigger("click");
    }); 

    function setKelasTuntutan(gaji, cc){
        if(gaji >= 2625.45)
            kelas1 = "A";
        if(gaji >= 2333 && gaji < 2625.45)
            kelas1 = "B";
        if(gaji >= 1820.75 && gaji < 2333)
            kelas1 = "C";
        if(gaji  < 1820.75)
            kelas1 = "D";    
        if(cc >= 1400) 
            kelas2 = "A";
        if(cc >= 1000 && cc < 1400)
            kelas2 = "B";
        if(cc >= 175 && cc < 1000)
            kelas2 = "C";
        if(cc < 175)
            kelas2 = "D";
        if(gaji < 1820.75 && cc < 175)
            return "E";
        if(kelas2.charCodeAt(0) > kelas1.charCodeAt(0))
            return kelas2;
        else
            return kelas1;  
    }

    $( ".datepicker" ).datepicker({
          numberOfMonths: 2,
          minDate: "-2M",
          maxDate: new Date(),
          dateFormat: "dd-mm-yy",
          showButtonPanel: true
    });

    // $("table").on("click", ".datepicker", function(){
    //     var $this = $(this);
    //     if(!$this.data("datepicker")) {
    //         $this.removeClass("hasDatepicker");
    //         // $this.datepicker();
    //         // $this.datepicker("show");
    //         $this.datepicker({    
    //             numberOfMonths: 2,
    //             minDate: "-2M",
    //             maxDate: new Date(),
    //             dateFormat: "dd-mm-yy",
    //             showButtonPanel: true
    //         }).datepicker("show");
    //     }    
    // });

    // Dynamic datepicker
    $(document).on("focus",".datepicker", function(){
        $(this).removeClass("hasDatepicker").datepicker({
            numberOfMonths: 2,
            minDate: "-2M",
            maxDate: new Date(),
            dateFormat: "dd-mm-yy",
            showButtonPanel: true
        });
    });

    $(".datepicker").css({
                        "position": "relative",
                        "z-index": 999999
                    } );
    
    $(document).on("focus", ".time-picker", function(){
        $(this).timepicker({});
    });

    // $( ".datepicker" ).on("click", function(){
    //     $(this).datepicker({    
    //         numberOfMonths: 2,
    //         minDate: "-2M",
    //         maxDate: new Date(),
    //         dateFormat: "dd-mm-yy",
    //         showButtonPanel: true
    //     }).datepicker("show");
    // });

    $(".time-picker").timepicker({
        // template: true,
        // showInputs: true,
        // minuteStep: 5
    });

    // $("button.tr_clone_add").on("click", function() {
    //     var $tr    = $(this).closest(".tr_clone");
    //     var $clone = $tr.clone();
    //     $clone.find(":text").val("");
    //     $tr.after($clone);
    //     return false;
    // });

    $("table").on("click", "button.tr_clone_add", function(){
         var $tr    = $(this).closest(".tr_clone");
        var $clone = $tr.clone();
        $clone.find(":text").val("");
        $tr.after($clone);
        return false;
    });

    var i = 1, j = 1;
    $("#btn-perjalanan").on("click", function(){
        
        i++;
        row = "<tr>" +
                "<td class=\"text-center\">" + i + "</td>" +
                "<td class=\"text-center\">" +
                    "<input type=\"text\" class=\"form-control datepicker\" name=\"PerjalananDetails[tarikh][" + i + "]\"></td>" +
                "<td class=\"text-center\">" +
                    "<div class=\"bootstrap-timepicker input-group\">" +
                        "<input type=\"text\" class=\"form-control time-picker\" name=\"PerjalananDetails[bertolak][" + i + "]\">" +
                        "<span class=\"input-group-addon picker\"><i class=\"glyphicon glyphicon-time\"></i></span>" +
                    "</div>" +
                "</td>" +
                "<td class=\"text-center\">" +
                    "<div class=\"bootstrap-timepicker input-group\">" +
                        "<input type=\"text\" class=\"form-control time-picker\" name=\"PerjalananDetails[sampai][" + i + "]\">" +
                        "<span class=\"input-group-addon picker\"><i class=\"glyphicon glyphicon-time\"></i></span>" +
                    "</div>" +
                "</td>" +
                "<td class=\"text-center\"><textarea class=\"form-control\" name=\"PerjalananDetails[tujuan][" + i + "]\" cols=\"55\"></textarea></td>" +
                "<td class=\"text-center col-lg-1\"><input type=\"number\" class=\"form-control jarak\" name=\"PerjalananDetails[jarak][" + i + "]\"></td>" +
                "<td class=\"text-center col-lg-1\"><input type=\"number\" class=\"form-control tol\" name=\"PerjalananDetails[kos][" + i + "]\" step=\"0.01\"></td>" +
                 "<td class=\"text-center\"><button class=\"btn btn-warning btn-minus\"><span class=\"glyphicon glyphicon-minus-sign icon-size\"></span></button></td>" +
            "</tr>";
        $("tbody#perjalanan-body").append(row);
        return false;
    });

    $(document).on("click", ".btn-minus", function(e){
        if(confirm("Padam maklumat ini?")) {
            $(this).parent().parent().remove();
        }
        e.stopPropagation();
        return false;
    });

    // $("form#perjalanan-form").on("beforeSubmit", function(){
    //     $.post("'.Url::to(['perjalanan/create']).'", $("#perjalanan-form").serialize(), function(data){
    //         //alert(data)
    //         console.log(data);
    //     })
    //     return false;
    // });

    $("#simpan-perjalanan").on("click", function(){
        $.post("'.Url::to(['perjalanan/create']).'", $("form#perjalanan-form").serialize(), function(data){
            //alert(data)
            console.log(data);
        });
        return false;
    });

    $("table").on("keyup", ".jarak", function(){
        var sum_jarak = 0;
        $(".jarak").each(function(){
            sum_jarak += $(this).val() / 1;
        });
        $("#jumlah-jarak").html(sum_jarak);
    });

    $("table").on("keyup", ".tol", function(){
        var sum_tol = 0;
        $(".tol").each(function(){
            sum_tol += $(this).val() / 1;
        });
        $("#jumlah-tol").html(sum_tol.toFixed(2));
    });
');

$this->registerCss('
    .loader {
        border: 10px solid #f3f3f3; /* Light grey */
        border-top: 10px solid #3498db; /* Blue */
        border-radius: 50%;
        width: 50px;
        height: 50px;
        animation: spin 2s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
');

?>