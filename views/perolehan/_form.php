<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use app\models\Unit;
use app\models\RefJenisPerolehan;
use app\models\RefKaedahPerolehan;
use yii\bootstrap\Modal;

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

<div class="perolehan-form">

    <?php $form = ActiveForm::begin(); ?>

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
    <div class="form-group">
        <?= Html::button(Yii::t('app', 'Next'), ['class' => 'btn btn-primary', 'id' => 'seterusnya']) ?>
    </div>
    <div class="form-group">
        <h3>Jenis Barang / Perkhidmatan </h3>
        <table id="unjuran-carian" class="table table-condensed table-striped table-bordered table-hover table-responsive">
        <thead class="thead-dark">
            <tr>
                <th>#</th><th>Justifikasi Keperluan Perolehan <br>(Bekalan / Perkhidmatan / Kerja)</th><th>Kuantiti</th><th></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="text-center">1</td><td><?= Html::textarea('Barangan[justifikasi1]', '', ['class' => 'justifikasi form-control']) ?></td><td><?= Html::textInput('Barangan[kuantiti1]', '', ['class' => 'kuantiti form-control', 'size' => '5']) ?></td><td class="text-center"> </td>
            </tr>
        </tbody>
    </table>
    <div class="form-group">
        <button class="btn btn-success" id="btn-barangan"><span class="glyphicon glyphicon-plus-sign icon-size"></span></button>
    </div>
    </div>
    <div class="form-group">
        <h3>Pengesyoran Kontraktor / Pembekal </h3>
        <table id="unjuran-carian" class="table table-condensed table-striped table-bordered table-hover table-responsive">
        <thead class="thead-dark">
            <tr>
                <th>#</th><th>Keutamaan</th><th>Nama Syarikat & No.ROB/ROC</th><th>Nama Pegawai Untuk dihubungi</th><th>No. Telefon</th><th>Jumlah Harga (RM)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="text-center">1</td><td><?= Html::radio('keutamaan', false, ['class' => 'keutamaan form-control']) ?></td><td><?= Html::textInput('Barangan[kuantiti1]', '', ['class' => 'kuantiti form-control', 'size' => '5']) ?></td><td class="text-center"> </td>
            </tr>
        </tbody>
    </table>
    <div class="form-group">
        <button class="btn btn-success" id="btn-pembekal"><span class="glyphicon glyphicon-plus-sign icon-size"></span></button>
    </div>
    </div>

    <div class="form-group" style="display: none;">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$this->registerJs('
    $("#pilih-unjuran").on("click", function(){
        $("#modal").modal("show").find("#modalContent").load("'.Url::to(['perolehan/unjuran-list']).'");
        //$("#modal-header").html("Penukaran Kod A");
        return false;
    });

    var i = 1;
    var row = "";

    $("#btn-barangan").on("click", function(e){
        i++;
        row = "<tr><td class=\"text-center\">" + i + "</td>" +
              "<td><textarea class=\"justifikasi form-control\" name=\"Barangan[justifikasi" + i + "]\"></textarea></td>" +
              "<td><input type=\"text\" class=\"kuantiti form-control\" name=\"Barangan[kuantiti" + i + "]\" size=\"5\"></td>" +
              "<td class=\"text-center\"><button class=\"btn btn-warning btn-minus\"><span class=\"glyphicon glyphicon-minus-sign icon-size\"></span></button></td></tr>";
        $("tbody").append(row);
        e.stopPropagation();
        return false;
    });

    $("#btn-pembekal").on("click", function(e){
        return false;
    });

    $(document).on("click", ".btn-minus", function(e){
        if(confirm("Padam maklumat ini?")) {
            $(this).parent().parent().remove();
        }
        e.stopPropagation();
        return false;
    });
');

$this->registerCss('
    .icon-size{
       font-size: 1.5em; 
    }
');
?>
