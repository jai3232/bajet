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
/* @var $model app\models\Penceramah */
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
<div class="penceramah-form">

    <?php $form = ActiveForm::begin(["id" => "penceramah-form"]); ?>

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

    <?= $form->field($model, 'kod_unjuran')->hiddenInput(['maxlength' => true])->label(false) ?>

    <?= $form->field($model, 'jenis_penceramah')->radioList([0 => 'Kerajaan', 1 => 'Swasta']); ?>

    <?= $form->field($model, 'tugas')->radioList([0 => 'Penceramah/Pensyarah', 1 => 'Fasilitator']); ?>

    <?= $form->field($model, 'nilai_kumpulan')->dropDownList(
            [
                300 => 'Pengurusan Tertinggi', 
                200 => 'Pengurusan & Profesional (53-54)',
                150 => 'Pengurusan  Profesional (45-52)',
                120 => 'Pengurusan & Profesional (41-44)',
                80 => 'Sokongan'
            ], 
            ['prompt' => '- Sila Pilih -']
        )->label('Kumpulan'); 
    ?>

    <?= $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'bahagian')->hiddenInput(['maxlength' => true])->label(false) ?>

    <?= $form->field($model, 'bahagian_asal')->hiddenInput(['maxlength' => true, 'value' => yii::$app->user->identity->id_jabatan])->label(false) ?>

    <?= $form->field($model, 'unit')->hiddenInput(['maxlength' => true, 'value' => yii::$app->user->identity->id_unit])->label(false) ?>

    <div class="row">

        <div class="col-4 col-sm-4">

            <?= $form->field($model, 'jawatan')->textInput(['maxlength' => true])->label('Nama Jawatan') ?>

        </div>

        <div class="col-4 col-sm-4">

            <?= $form->field($model, 'gred_jawatan')->textInput(['maxlength' => true]) ?>

        </div>

        <div class="col-4 col-sm-4">

            <?= $form->field($model, 'taraf_jawatan')->radioList([0 => 'Tetap', 1 => 'Sementara', 2 => 'Lain-lain']); ?>

        </div>

    </div>

    <div class="second" style="display: nonex;">

        <?= $form->field($model, 'kelayakan')->textInput() ?>

        <div class="row">
            <div class="col-6 col-sm-6">
                
                <?= $form->field($model, 'no_gaji')->textInput() ?>

            </div>
            <div class="col-6 col-sm-6">
                
                <?= $form->field($model, 'gaji')->textInput(['type' => 'number', 'step' => 0.01])->label('Gaji Asas') ?>

            </div>
        </div>

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
                <?= $form->field($model, 'bank')->textInput(['maxlength' => true])->label('Nama Bank') ?>
            </div>
            <div class="col-6 col-sm-6">
                <?= $form->field($model, 'akaun_bank')->textInput(['maxlength' => true])->label('No Akaun Bank') ?>
            </div>
        </div>

        <?= $form->field($model, 'jabatan')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'alamat_jabatan')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'jumlah_tuntutan')->textInput() ?>

        <?= $form->field($model, 'jumlah_kew')->textInput() ?>

        <?= $form->field($model, 'status')->textInput(['maxlength' => true, 'value' => 'A']) ?>

    </div>
    <div class="hidden">
        <?= DatePicker::widget(['options' => ['class' => 'hidden']]); ?>        
    </div>
    <table id="maklumat-ceramah" class="table table-condensed table-striped table-bordered table-hover table-responsive">
        <thead>
            <tr><th colspan="6" class="text-center">Maklumat Ceramah</th></tr>
            <tr>
                <th>No.</th>
                <th>Tarikh</th>
                <th>Nama Penganjur / Ceramah</th>
                <th>Tempoh (jam)</th>
                <th>Jumlah (RM)</th>
                <th>Padam</th>
            </tr>
        </thead>
        <tbody>
            <tr class="clone">
                <td>1</td>
                <td>
                    <?= Html::textInput('PenceramahDetails[tarikh][1]', null, ['class' => 'form-control datepicker must', 'readonly' => true]) ?>
                </td>
                <td>
                    <?= Html::textarea('PenceramahDetails[nama_ceramah][1]', null, ['class' => 'form-control must', 'cols' => 50, 'rows' => 1]); ?>
                </td>
                <td>
                    <?= Html::textInput('PenceramahDetails[tempoh][1]', null, ['class' => 'form-control must', 'type' => 'number', 'step' => 0.1]) ?>
                </td>
                <td>
                    <?= Html::textInput('PenceramahDetails[tuntutan][1]', null, ['class' => 'form-control', 'readonly' => true]) ?>
                </td>
                <td class="remove"></td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="6" class="text-center">Pengakuan</th>
            </tr>
            <tr>
                <td colspan="6">
                    <p>
                        <input type="checkbox" name="akuan" id="akuan">
                        Saya mengaku bahawa (sila tik di sini)<br>
                        <?= Html::checkbox('agree', true, ['label' => 'I agree']) ?>
                    </p>
                    <ol type="a">
                        <li> Perjalanan pada tarikh-tarikh tersebut adalah benar dan telah dibuat atas urusan rasmi; </li>
                        <li>Tuntutan ini dibuat mengikut kadar dan syarat seperti yang dinyatakan di bawah peraturan- 
                        peraturan bagi pegawai bertugas rasmi dan/atau pegawai berkursus yang berkuatkuasa 
                        semasa;</li>
                        <li>butir-butir seperti yang dinyatakan di atas adalah benar dan saya bertanggungjawab terhadapnya. 
                            <br>
                            <br>
                            Tarikh : ??? <br>
                        </li>
                    <p></p>
                    </ol>
                </td>
            </tr>
        </tfoot>
    </table>
    <div class="form-group">
            <button class="btn btn-primary" id="btn-ceramah" title="Tambah Ceramah" type="button"><span class="glyphicon glyphicon-plus-sign icon-size"></span></button>
        </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<?php 

$this->registerJs('
    $("#pilih-unjuran").on("click", function(){
        $("#modal").modal("show").find("#modalContent").load("'.Url::to(['penceramah/unjuran-list']).'");
        return false;
    });

    $("#periksa-data").on("click", function(){
        if($("#penceramah-no_kp").val().length > 5) {
            $(".row-loader").show();
            var nokp = $("#penceramah-no_kp").val();
            var bulan = $("#penceramah-bulan").val();
            var tahun = $("#penceramah-tahun").val();
            var os = $("#os").text();
            var data = {no_kp: nokp, bulan: bulan, tahun: tahun, os: os, jenis: 1};
            $.post("'.Url::to(['penceramah/carian-penceramah']).'", data)
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

    $(document).on("focus",".datepicker", function(){
        $(this).removeClass("hasDatepicker").datepicker({
            numberOfMonths: 2,
            minDate: "-2M",
            maxDate: new Date(),
            dateFormat: "dd-mm-yy",
            showButtonPanel: true
        });
    });

    var nth_row = 1;
    $("#btn-ceramah").on("click", function(){
        
        nth_row++;
        var btn_minus = "<button class=\"btn btn-warning btn-penceramah-minus\" type=\"button\"><span class=\"glyphicon glyphicon-minus-sign icon-size\"></span></button>";
        $("tr.clone:first").clone().insertAfter("table#maklumat-ceramah > tbody > tr:last");
        $(".remove:last").html(btn_minus);
        $("tr.clone:last").html($("tr.clone:last").html().replace("<td>1</td>", "<td>" + nth_row + "</td>"));
        $("tr.clone:last").html($("tr.clone:last").html().replace(/\[.1?\]/g, "[" + nth_row + "]"));
        //$("tr.clone:last").html($("tr.clone:last").html().replace(/id/g, "src"));
        $("tr.clone:last").html($("tr.clone:last").html().replace(/id\=\"\w*\d*\"/g, ""));
    });

    $(document).on("click", ".btn-penceramah-minus", function(){
        $(this).parent().parent().remove();
    });

');

?>