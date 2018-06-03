<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\models\Unit;
use app\models\RefJenisPerolehan;
use app\models\RefKaedahPerolehan;
use yii\bootstrap\Modal;
use kartik\dialog\Dialog;

/* @var $this yii\web\View */
/* @var $model app\models\Perolehan */
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

<div class="perolehan-form" style="display: none;">

    <?php $form = ActiveForm::begin(['id' => 'perolehan-form']); ?>

    <?php //= $form->field($model, 'kod_id')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'kod_unjuran')->hiddenInput(['maxlength' => true])->label(false) ?>

    <?= $form->field($model, 'id_jabatan')->hiddenInput()->label('Unjuran Dari Jabatan')->label(false) ?>

    <?= $form->field($model, 'id_jabatan_asal')->hiddenInput(['value' => Yii::$app->user->identity->id_jabatan])->label(false) ?>  

    <?= $form->field($model, 'id_unit')->dropdownList(ArrayHelper::map(Unit::find()
                                    ->where([
                                        'id_jabatan' => Yii::$app->user->identity->id_jabatan])->all(), 
                                        'id', 'unit'), [
                                                            'prompt' => '- Sila Pilih -'

                                                    ])->label('Unit')
    ?>

    <?= $form->field($model, 'jenis_perolehan')->dropdownList(ArrayHelper::map(RefJenisPerolehan::find()->all(), 
                                                                                'id', 'jenis'), [
                                                                                                'prompt' => '- Sila Pilih -'

                                                                                               ]) 

    ?>

    <?= $form->field($model, 'kaedah_pembayaran')->dropdownList(ArrayHelper::map(RefKaedahPerolehan::find()->all(), 
                                                                                'id', 'kaedah'), [
                                                                                                'prompt' => '- Sila Pilih -'

                                                                                               ])
    ?>

    <?= $form->field($model, 'kontrak_pusat')->checkbox(['value' => 1, 'label' => 'Kontrak Pusat']) ?>

    <?php //= $form->field($model, 'id_syarikat')->textInput() ?>

    <?php //= $form->field($model, 'status')->textInput() ?>

    <?php //= $form->field($model, 'tarikh_lulus1')->textInput() ?>

    <?php //= $form->field($model, 'catatan1')->textarea(['rows' => 6]) ?>

    <?php //= $form->field($model, 'lulus_perolehan')->textInput() ?>

    <?php //= $form->field($model, 'status_kewangan')->textInput() ?>

    <?php //= $form->field($model, 'tarikh_lulus2')->textInput() ?>

    <?php //= $form->field($model, 'nolo')->textInput(['maxlength' => true]) ?>

    <?php //= $form->field($model, 'tarikhlo')->textInput() ?>

    <?php //= $form->field($model, 'novoucher')->textInput(['maxlength' => true]) ?>

    <?php //= $form->field($model, 'tarikh_voucher')->textInput() ?>

    <?php //= $form->field($model, 'nilai_perolehan')->textInput() ?>

    <?php //= $form->field($model, 'catatan2')->textarea(['rows' => 6]) ?>

    <?php //= $form->field($model, 'tahun')->textInput(['maxlength' => true]) ?>

    <?php //= $form->field($model, 'tarikh_jadi')->textInput() ?>

    <?php //= $form->field($model, 'tarikh_kemaskini')->textInput() ?>

    <?php //= $form->field($model, 'user')->textInput() ?>
    <!-- <div class="form-group">
        <?= Html::button(Yii::t('app', 'Next'), ['class' => 'btn btn-primary', 'id' => 'seterusnya']) ?>
    </div> -->
    <div class="form-group" id="barangan">
        <h3>Jenis Barang / Perkhidmatan </h3>
        <table id="unjuran-carian" class="table table-condensed table-striped table-bordered table-hover table-responsive">
            <thead class="thead-dark">
                <tr>
                    <th>#</th><th>Justifikasi Keperluan Perolehan <br>(Bekalan / Perkhidmatan / Kerja)</th><th style="width: 20%;">Kuantiti</th><th></th>
                </tr>
            </thead>
            <tbody id="barang_body">
                <tr>
                    <td class="text-center">1</td><td><?= Html::textarea('Barangan[justifikasi][1]', '', ['class' => 'justifikasi form-control must']) ?></td>
                    <td><?= Html::textInput('Barangan[kuantiti][1]', '', ['class' => 'kuantiti form-control must', 'size' => '1', 'type' => 'number']) ?></td>
                    <td class="text-center"> </td>
                </tr>
            </tbody>
        </table>
        <div class="form-group">
            <button class="btn btn-success" id="btn-barangan"><span class="glyphicon glyphicon-plus-sign icon-size"></span></button>
        </div>
    </div>
    <div class="form-group" id="pembekal">
        <h3>Pengesyoran Kontraktor / Pembekal </h3>
        <table id="unjuran-carian" class="table table-condensed table-striped table-bordered table-hover table-responsive">
            <thead class="thead-dark">
                <tr>
                    <th>#</th><th>Keutamaan</th><th>Nama Syarikat & No.ROB/ROC</th><th>Nama Pegawai Untuk dihubungi</th><th>No. Telefon</th><th>Emel</th><th>Jumlah Harga (RM)</th><th></th>
                </tr>
            </thead>
            <tbody id="pembekal_body">
                <tr>
                    <td class="text-center">1</td><td class="text-center"><?= Html::radio('Pembekal[keutamaan]', false, ['class' => 'keutamaan form-check-input', 'value' => 1]) ?></td>
                    <td><?= Html::textInput('Pembekal[pembekal][1]', '', ['class' => 'pembekal form-control must']) ?></td>
                    <td><?= Html::textInput('Pembekal[nama_pembekal][1]', '', ['class' => 'nama_pembekal form-control']) ?></td>
                    <td><?= Html::textInput('Pembekal[telefon][1]', '', ['class' => 'telefon form-control']) ?></td>
                    <td><?= Html::textInput('Pembekal[emel][1]', '', ['class' => 'emel form-control']) ?></td>
                    <td><?= Html::textInput('Pembekal[harga][1]', '', ['class' => 'harga form-control must', 'size' => '1', 'type' => 'number', 'step' => '0.01']) ?></td>
                    <td class="text-center"> </td>
                </tr>
            </tbody>
        </table>
        <div class="form-group">
            <button class="btn btn-success" id="btn-pembekal"><span class="glyphicon glyphicon-plus-sign icon-size"></span></button>
        </div>
    </div>
    <div class="form-group" id="panjar">
        <h3>Panjar </h3>
        <div class="form-group"p>
            <label class="control-label">Dipohon Oleh</label>
            <?= Html::textInput('pemohon', yii::$app->user->identity->nama, ['class' => 'form-control', 'readonly' => true]); ?>
        </div>
        <div class="form-group">
            <label>Jawatan</label>
            <?= Html::textInput('Panjar[jawatan]', '', ['class' => 'form-control']); ?>
        </div>
        <div class="form-group">
            <label>No. Telefon / Sambungan</label>
            <?= Html::textInput('Panjar[sambungan]', '', ['class' => 'form-control']); ?>
        </div>
        <div class="form-group">
            <label>Tujuan</label>
            <?= Html::textarea('Panjar[tujuan]', '', ['class' => 'justifikasi form-control must']) ?>
        </div>
        <div class="form-group">
            <label>Jumlah</label>
            <?= Html::textInput('Panjar[jumlah_panjar]', yii::$app->user->identity->nama, ['class' => 'harga form-control must', 'size' => '1', 'type' => 'number', 'step' => '0.01']); ?>
        </div>
    </div>

    <div class="form-group" style="display: nonex;">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success', 'id' => 'simpan']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$this->registerJs('
    var keutamaan = false;
    var i = 1, j = 1;
    var row = "";

    $("#pilih-unjuran").on("click", function(){
        $("#modal").modal("show").find("#modalContent").load("'.Url::to(['perolehan/unjuran-list']).'");
        //$("#modal-header").html("Penukaran Kod A");
        return false;
    });

    $("#pembekal").hide();
    $("#barangan").hide();
    $("#panjar").hide();

    $("#perolehan-kaedah_pembayaran").change(function(){
        if($(this).val() == 3) {
            $("#pembekal").hide();
            $("#barangan").hide();
            $("#panjar").show();
            keutamaan = true;
        }
        else {
            $("#pembekal").show();
            $("#barangan").show();
            $("#panjar").hide();
            keutamaan = false;
        }
    });

    $("#btn-barangan").on("click", function(e){
        i++;
        row = "<tr><td class=\"text-center\">" + i + "</td>" +
              "<td><textarea class=\"justifikasi form-control must\" name=\"Barangan[justifikasi][" + i + "]\"></textarea></td>" +
              "<td><input type=\"number\" class=\"kuantiti form-control must\" name=\"Barangan[kuantiti][" + i + "]\" size=\"5\"></td>" +
              "<td class=\"text-center\"><button class=\"btn btn-warning btn-minus\"><span class=\"glyphicon glyphicon-minus-sign icon-size\"></span></button></td></tr>";
        $("tbody#barang_body").append(row);
        e.stopPropagation();
        return false;
    });

    $("#btn-pembekal").on("click", function(e){
        j++;
        row = "<tr><td class=\"text-center\">" + j + "</td>" +
              "<td class=\"text-center\"><input type=\"radio\" class=\"keutamaan form-check-input\" name=\"Pembekal[keutamaan]\" value=\"" + j + "\"></td>" +
              "<td><input class=\"pembekal form-control must\" name=\"Pembekal[pembekal][" + j + "]\"></td>" +
              "<td><input class=\"nama_pembekal form-control\" name=\"Pembekal[nama_pembekal][" + j + "]\"></td>" +
              "<td><input class=\"telefon form-control\" name=\"Pembekal[telefon][" + j + "]\"></td>" +
              "<td><input class=\"emel form-control\" name=\"Pembekal[emel][" + j + "]\"></td>" +
              "<td><input type=\"number\" step=\"0.01\" class=\"harga form-control must\" name=\"Pembekal[harga][" + j + "]\" size=\"1\"></td>" +
              "<td class=\"text-center\"><button class=\"btn btn-warning btn-minus\"><span class=\"glyphicon glyphicon-minus-sign icon-size\"></span></button></td></tr>";
        $("tbody#pembekal_body").append(row);
        e.stopPropagation();
        return false;
    });

    $(document).on("click", ".btn-minus", function(e){
        if(confirm("Padam maklumat ini?")) {
            $(this).parent().parent().remove();
        }
        e.stopPropagation();
        return false;
    });

    $("form#perolehan-form").on("beforeSubmit", function(e){

        $(".keutamaan").each(function(){
            if($(this).is(":checked"))
                keutamaan = true;
        });
        if(!keutamaan) {
            alert("Sila Pilih Keutamaan Pembekal");
            e.stopPropagation();
            return false;
        }

        $(".must").each(function(){
            $(this).css("background", "");
        });        

        $(".must").each(function(){
            if($(this).val().length === 0) {
                console.log($(this).attr("name"));
                $(this).css("background", "#f90707");
                $(this).prop("placeholder", "Input ini tidak boleh dibiarkan kosong");
                $(this).focus();
                e.stopPropagation();
                return false;
            }
        });

        if(confirm("Hantar perolehan ini?"))
            return true;

        return false;
    });
');

$this->registerCss('
    .icon-size{
       font-size: 1.5em; 
    }
');
?>
