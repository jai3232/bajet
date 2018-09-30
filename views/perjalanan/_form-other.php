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

echo '<div id="modalContent"><div class="loader col-sm-4" style="margin: 40px 50%;"></div></div>';
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


<div class="perjalanan-form">
    <?php $form = ActiveForm::begin(["id" => "perjalanan-form"]); ?>
    <div class="first" style="display: none;">

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

        <?= $form->field($model, 'nama')->textInput(['maxlength' => true, 'value' => $latest_model->nama]) ?>

        <div class="row">
            <div class="col-6 col-sm-6">
            <?= $form->field($model, 'no_hp')->textInput(['maxlength' => true, 'value' => $latest_model->no_hp])->label('No Telefon/Hp') ?>
            </div>
            <div class="col-6 col-sm-6">
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-6 col-sm-6">
            <?= $form->field($model, 'jawatan')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-6 col-sm-6">
            <?= $form->field($model, 'no_gaji')->hiddenInput(['maxlength' => true, 'value' => 0])->label(false) ?>
            </div>
            <div class="col-6 col-sm-6">
            <?= $form->field($model, 'gaji_asas')->hiddenInput(['value' => 0])->label(false) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-6 col-sm-6">
            <?= $form->field($model, 'elaun')->hiddenInput(['value' => 0])->label('Jumlah Elaun')->label(false) ?>
            </div>
            <div class="col-6 col-sm-6">
            <?= $form->field($model, 'elaun_mangku')->hiddenInput()->label('Jumlah Elaun Memangku')->label(false) ?>
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
            <?= $form->field($model, 'model_kereta')->hiddenInput(['maxlength' => true, 'value' => '-'])->label(false) ?>
            </div>
            <div class="col-6 col-sm-4">
            <?= $form->field($model, 'no_plate')->hiddenInput(['maxlength' => true, 'value' => 0])->label(false) ?>
            </div>
            <div class="col-6 col-sm-4">
            <?= $form->field($model, 'cc')->hiddenInput(['step' => '1', 'value' => 0])->label(false) ?>
            </div>
        </div>

        <?= $form->field($model, 'kelas_tuntutan')->radioList(['A' => 'A', 'B' => 'B', 'C' => 'C', 'D' => 'D', 'E' => 'E'], ['class' => 'kelas', 'value' => 'E', 'class' => 'hidden'])->label(false) ?>

        <?= $form->field($model, 'alamat_pejabat')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'alamat_rumah')->textInput(['maxlength' => true]) ?>
        </fieldset>

        <?= $form->field($model, 'pendahuluan')->hiddenInput()->label(false) ?>

        <?= $form->field($model, 'tuntutan_lain')->hiddenInput(['value' => 0])->label(false) ?>

        <?= $form->field($model, 'jumlah_tuntutan')->textInput(['type' => 'number', 'step' => '1']) ?>

        <?= $form->field($model, 'jumlah_kew')->hiddenInput()->label(false) ?>

        <?= $form->field($model, 'id')->hiddenInput()->label(false) ?>

        <?= $form->field($model, 'jenis')->hiddenInput(['value' => 2])->label(false) ?>

        <?php //= $form->field($model, 'status')->textInput() ?>

        <?php //= $form->field($model, 'cetak')->textInput() ?>

        <?php //= $form->field($model, 'catatan')->textarea(['rows' => 6]) ?>

        <?php //= $form->field($model, 'user')->textInput() ?>

        <?php //= $form->field($model, 'tarikh_jadi')->textInput() ?>

        <?php //= $form->field($model, 'tarikh_kemaskini')->textInput() ?>

        <fieldset>
            <legend>H. Pengakuan</legend>
            <div class="form-group">
                <?= Html::checkbox('Perjalanan[akuan]', false, ['id' => 'akuan']) ?> Saya mengaku bahawa (tik untuk simpan dan cetak)
                
            </div>
            <div class="form-group">
                <ol type="alpha">
                    <li>Perjalanan pada tarikh-tarikh tersebut adalah benar dan telah dibuat atas urusan rasmi;</li>
                    <li>Tuntutan ini dibuat mengikut kadar dan syarat seperti yang dinyatakan di bawah peraturan- 
peraturan bagi pegawai bertugas rasmi dan/atau pegawai berkursus yang berkuatkuasa 
semasa;</li>
                    <li>Butir-butir seperti yang dinyatakan di atas adalah benar dan saya bertanggungjawab terhadapnya. 
</li>
                </ol>
                Tarikh: <?= date('d-m-Y') ?>
            </div>
        </fieldset>        
            <?= Html::submitButton(Yii::t('app', 'Hantar & Cetak'), ['class' => 'btn btn-warning', 'id' => 'cetak-perjalanan', 'disabled' => true]) ?>
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

    $("#periksa-data").on("click", function(){
        if($("#perjalanan-no_kp").val().length > 5) {
            $(".row-loader").show();
            var nokp = $("#perjalanan-no_kp").val();
            var bulan = $("#perjalanan-bulan").val();
            var tahun = $("#perjalanan-tahun").val();
            var os = $("#os").text();
            var data = {no_kp: nokp, bulan: bulan, tahun: tahun, os: os, jenis: 0};
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
                        }
                        else {
                            $(".loader").hide();
                            $(".col-sm-8").html(" <span class=\"glyphicon glyphicon-remove\"></span> Anda sudah membuat tuntutan perjalanan untuk bulan " + $("#perjalanan-bulan option:selected").text() + " dan OS " + os);
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
         $(".second").show();
         $("#periksa-data").hide();
         $(this).hide();
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

    
    $("#akuan").on("click", function(){
        if($(this).is(":checked")) {
            $("#cetak-perjalanan").prop("disabled", false);
        }
        else {
            $("#cetak-perjalanan").prop("disabled", true);
        }

    });

    $("#perjalanan-jumlah_tuntutan").keyup(function(){
        $("#perjalanan-jumlah_kew").val($(this).val());
    });
');

// FUNCTIONS
$this->registerJs('


function setTotal() {
    $("#jumlah_tuntutan").text(($("#jumlah_kadar_jarak2").text()/1 + $("#jumlah_elaun_makan").text()/1 + $("#jumlah_elaun_penginapan").text()/1 + $("#jumlah_tambang").text()/1 + $("#jumlah_pelbagai").text()/1).toFixed(2));
    $("#perjalanan-jumlah_tuntutan, #perjalanan-jumlah_kew").val($("#jumlah_tuntutan").text());
    $("#pendahuluan").html(($("#jumlah_tambang").text()/1 + $("#jumlah_pelbagai").text()/1 + $("#jumlah_elaun_penginapan").text()/1 - $("#jumlah_lojing").text()/1 - $("#perjalanan-telefon").val()/1).toFixed(2));
    $("#perjalanan-pendahuluan").val($("#pendahuluan").html());
    $("#telefon2").html(($("#perjalanan-telefon").val()/1).toFixed(2));
        
}

function testNumeric(x) {
    var str = "0123456789.";
    var k = 0;
    var p = 0;
    var temp = "";
    for(var i = 0; i < x.length; i++)
    {
        for(var j = 0; j < str.length; j++) {
            if(str.substr(j,1) == x.substr(i,1))
            {
                k++;
            }
        }
        if(x.substr(i,1) == ".") {
            p++;
        }
        if(k == 0 || p > 1) {
            temp = x.substr(0, i)+x.substr(i+1, x.length-i);
            return temp;
        }
        k = 0
    }
    return x;
    
}


function setPenginapan() {
    var tempVal = 0;
    for(var i = 0; i < $(".penginapan").length; i++) {
            tempVal += $(".penginapan").eq(i).text()/1;
    }
    tempVal = tempVal.toFixed(2);
    $("#jumlah_elaun_penginapan").text(tempVal);
}

function setPelbagai(){
    var tempVal = 0;
    for(var i = 0; i < $(".pelbagai").length; i++) {
        tempVal += $(".pelbagai").eq(i).val()/1;
    }
    $("#jumlah_pelbagai").text(tempVal.toFixed(2));
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

function checkBaki() {
    var balance = $("#baki").text().replace(/,/g, "")/1;
    var spend = $("#perjalanan-jumlah_kew").val()/1;
    console.log(balance+":"+spend);
    if(balance >= spend)
        return true;
    return false;

}



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


//TEST SCRIPT 
$this->registerJs('
    //$("#perjalanan-nama").val(Math.random().toString(36).substr(2, 5) + " " + Math.random().toString(36).substr(2, 5));
    //$("#perjalanan-no_hp").val((Math.random() * 40000000).toFixed(0));
    $("#perjalanan-email").val(Math.random().toString(36).substr(2, 5) + "@" + Math.random().toString(36).substr(2, 5) + ".com");
    $("#perjalanan-jawatan").val(Math.random().toString(36).substr(2, 5));
    // $("#perjalanan-no_gaji").val(Math.random().toString(36).substr(2, 5));
    // $("#perjalanan-gaji_asas").val((Math.random()* 10000).toFixed(2));
    // $("#perjalanan-elaun").val((Math.random() * 10000).toFixed(2));
    $("#perjalanan-bank").val(Math.random().toString(36).substr(2, 5));
    $("#perjalanan-cawangan_bank").val(Math.random().toString(36).substr(2, 5));
    $("#perjalanan-akaun_bank").val((Math.random() * 100000000000).toFixed(0));
    // $("#perjalanan-model_kereta").val("Citroen " + Math.random().toString(36).substr(2, 5));
    // $("#perjalanan-no_plate").val("TL " + Math.random().toString(36).substr(2, 5));
    // $("#perjalanan-cc").val((Math.random() * 3000).toFixed(0));
    $("#perjalanan-alamat_pejabat").val(Math.random().toString(36).substr(2, 5) + " " + Math.random().toString(36).substr(2, 5));
    $("#perjalanan-alamat_rumah").val(Math.random() * 10 + Math.random().toString(36).substr(2, 5) + " " + Math.random().toString(36).substr(2, 5));
    $("#perjalanan-cc").trigger("keyup");
    $("#perjalanan-cc").trigger("blur");

');
?>



