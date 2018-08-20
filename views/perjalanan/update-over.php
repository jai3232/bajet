<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\dialog\Dialog;
use app\models\Unit;
use yii\jui\DatePicker;
use kartik\time\TimePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Perjalanan */

$this->title = Yii::t('app', 'Kemaskini Perjalanan Luar Negeri: ' . $model->kod_id, [
    'nameAttribute' => '' . $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Perjalanan'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');

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
<div id="unjuran_info" style="display: none;">
    <div class="form-group">
        <label>Kod Unjuran: <span id="kod-unjuran"><?= $model->kod_unjuran ?></span></label>
    </div>
    <div class="form-group">
        <label>OS: <span id="os"><?= $model->kodUnjuran->os ?></span></label>
    </div>
    <div class="form-group">
        <label>Butiran: <span id="butiran"><?= $model->kodUnjuran->butiran ?></span></label>
    </div>
    <div class="form-group">
        <label>Jumlah Unjuran: <span id="jumlah-unjuran"><?= $model->kodUnjuran->jumlah_unjuran ?></span></label>
    </div>
    <div class="form-group">
        <label>Baki: <span id="baki"><?= \app\models\Unjuran::bakiUnjuran($model->kod_unjuran) ?></span></label>
    </div>
    <div class="form-group">
        <label>Unjuran Jabatan: <span id="jabatan"><?= $model->id_jabatan ?></span></label>
    </div>

</div>
<div class="perjalanan-update">

    <h2><?= Html::encode($this->title) ?></h2>
	<?php $form = ActiveForm::begin(["id" => "perjalanan-form", 'action' => ['perjalanan/create-over']]); ?>
    <div class="first" style="display: nonex;">

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
                            'disabled' => true,
                        ]) ?>                
            </div>
            <div class="col-6 col-sm-6">
                <?= $form->field($model, 'tahun')->dropDownList($yearList, 
                        [
                            'prompt' => '- Sila Pilih -',
                            'options' => [date("Y") => ['selected' => true]],
                            'disabled' => true,
                        ]) ?>               
            </div>
        </div>

        <?= $form->field($model, 'no_kp')->textInput(['maxlength' => true, 'value' => $model->no_kp, 'readonly' => true])->label('No. KP tanpa (-)') ?>
        <div class="row row-loader form-group" style="display: none;">
            <div class="loader col-sm-4"></div>
            <div class="col-sm-8" style="height:60px; display:flex; align-items:center; font-weight: bold;">Carian data ....</div>
        </div>

    </div>
    <div class="second" style="display: nonex;">
        <fieldset><legend>Maklumat Personal</legend>
        <?php //= $form->field($model, 'unit')->dropDownList(ArrayHelper::map(Unit::find()->where(['id_jabatan' => yii::$app->user->identity->id_jabatan])->all(), 'id', 'unit'),['prompt' => '- Sila Pilih -']) ?>

        <?= $form->field($model, 'id_unit')->hiddenInput(['maxlength' => true, 'value' => yii::$app->user->identity->id_unit])->label(false) ?>

        <?= $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>

        <div class="row">
            <div class="col-6 col-sm-6">
            <?= $form->field($model, 'no_hp')->textInput(['maxlength' => true])->label('No Telefon/Hp') ?>
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
        
        <?= $form->field($model, 'jenis')->hiddenInput(['value' => 1])->label(false) ?>
        </fieldset>
        <h3>TUNTUTAN LUAR NEGERI </h3>
        <?php
    	foreach ($perjalanan_luar_details as $key => $value) {
    		$num = $key + 1;
    	?>
        <div class="oversea">
            <fieldset>
                <legend>Kenyataan Tuntutan #<span class="nth"><?= $num ?></span></legend>
                <table id="elaun_makan-perjalanan" class="table table-condensed table-striped table-bordered table-hover table-responsive">
                    <tbody>
                        <tr>
                            <td>
                                <label>Dari</label>
                                <?= Html::textInput('PerjalananLuarDetails[dari]['.$num.']', $value->dari, ['class' => 'must form-control', 'placeholder' => 'Nama Negara']) ?>
                                
                            </td>
                            <td>
                                <label>Tarikh Bertolak:</label> <?= Html::textInput('PerjalananLuarDetails[tarikh_bertolak]['.$num.']', Yii::$app->formatter->asDate($value->tarikh_bertolak), ['class' => 'datepicker must form-control', 'readonly' => true]) ?>
                                <label>Waktu Bertolak:</label>
                                <div class="bootstrap-timepicker input-group">
                                    <input type="text" class="form-control time-picker must" name="PerjalananLuarDetails[waktu_bertolak][<?= $num ?>]" placeholder="0:00 AM" value="<?= $value->waktu_bertolak ?>">
                                    <span class="input-group-addon picker"><i class="glyphicon glyphicon-time"></i></span>
                                </div>
                                
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label>Negara / tempat dituju</label>
                                <?= Html::textInput('PerjalananLuarDetails[destinasi]['.$num.']', $value->destinasi, ['class' => 'must form-control']) ?>
                                 <label>Tujuan</label>
                                <?= Html::textInput('PerjalananLuarDetails[tujuan_lawatan]['.$num.']', $value->tujuan_lawatan, ['class' => 'must form-control']) ?>
                                
                            </td>
                            <td>
                                <label>Tarikh tiba di Negara / tempat dituju:</label> <?= Html::textInput('PerjalananLuarDetails[tarikh_sampai]['.$num.']', Yii::$app->formatter->asDate($value->tarikh_sampai), ['class' => 'datepicker must form-control', 'readonly' => true]) ?>
                                <label>Waktu tiba di Negara / tempat dituju: </label>
                                <div class="bootstrap-timepicker input-group">
                                    <input type="text" class="form-control time-picker must" name="PerjalananLuarDetails[waktu_sampai][<?= $num ?>]" placeholder="0:00 AM" value="<?= $value->waktu_sampai ?>">
                                    <span class="input-group-addon picker"><i class="glyphicon glyphicon-time"></i></span>
                                </div>
                                
                            </td>
                        </tr>
                    </tbody>
                </table>
            </fieldset>
            <fieldset>
                <legend>Tuntukan elaun makan / harian</legend>
                <table id="elaun_makan-perjalanan" class="table table-condensed table-striped table-bordered table-hover table-responsive">
                    <thead>
                        <tr><th>Kekerapan Elaun</th><th>Jenis Elaun</th><th>Jumlah Elaun Sehari (RM)</th><th>Sarapan: 20%, Makan Tengahari: 40%, Makan Malam: 40%</th><th>Jumlah Elaun</th></tr>
                    </thead>
                    <tbody>
                        <tr>
                            <?php
                                $kali_makan = ['Pilih'];

                                for($i = 1; $i <= 31; $i++) {
                                    $kali_makan[$i] = $i;
                                }
                                $percent_elaun = ['1' => '100%', '0.8' => '80%', '0.6' => '60%', '0.4' => '40%', '0.2' => '20%'];

                            ?>
                            <td><?= Html::dropDownList('PerjalananLuarDetails[kali_elaun_makan]['.$num.']', $value->kali_elaun_makan, $kali_makan, ['class' => 'kali_luar form-control']) ?></td>
                            <td>X Elaun makan sebanyak</td>
                            <td><?= Html::textInput('PerjalananLuarDetails[elaun_makan]['.$num.']', $value->elaun_makan, ['class' => 'elaun_makan_luar_sehari text-right form-control', 'type' => 'number', 'step' => 0.01]) ?></td>
                            <td><?= Html::dropDownList('PerjalananLuarDetails[peratus_elaun_makan]['.$num.']', $value->peratus_elaun_makan, $percent_elaun, ['class' => 'kadar_elaun_luar form-control']) ?></td>
                            <td class="text-right elaun_makan_luar"><?= number_format($value->kali_elaun_makan * $value->elaun_makan * $value->peratus_elaun_makan, 2) ?></td>
                        </tr>
                        <tr>
                            <td><?= Html::dropDownList('PerjalananLuarDetails[kali_elaun_harian]['.$num.']', $value->kali_elaun_harian, $kali_makan, ['class' => 'kali_luar form-control']) ?></td>
                            <td>X Elaun harian sebanyak</td>
                            <td><?= Html::textInput('PerjalananLuarDetails[elaun_harian]['.$num.']', $value->elaun_harian, ['class' => 'elaun_makan_luar_sehari text-right form-control', 'type' => 'number', 'step' => 0.01]) ?></td>
                            <td><?= Html::dropDownList('PerjalananLuarDetails[peratus_elaun_harian]['.$num.']', $value->peratus_elaun_harian, $percent_elaun, ['class' => 'kadar_elaun_luar form-control']) ?></td>
                            <td class="text-right elaun_makan_luar"><?= number_format($value->kali_elaun_harian * $value->elaun_harian * $value->peratus_elaun_harian, 2) ?></td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr><th colspan="4" class="text-right">Jumlah (RM)</th><th class="text-right jumlah_elaun_makan_luar">0.00</th></tr>
                    </tfoot>
                </table>

            </fieldset>
            <fieldset>
                <legend>Tuntutan Bayaran Sewa Hotel (BSH) / Elaun Lojing</legend>
                <table id="bhs-perjalanan-luar" class="table table-condensed table-striped table-bordered table-hover table-responsive">
                    <thead>
                        <tr><th>Jumlah Malam</th><th>Kadar</th><th>Harga Semalam (RM)</th><th>Jumlah (RM)</th></tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center">
                                <div class="form-group  form-inline">
                                    <label></label>
                                    <?= Html::dropDownList('PerjalananLuarDetails[kali_hotel]['.$num.']', $value->kali_hotel, $kali_makan, ['class' => 'kali_hotel_luar form-control']) ?>
                                </div>
                            </td>
                            <td class="text-center">hari x Bayaran Sewa Hotel sebanyak</td>
                            <td><?= Html::textInput('PerjalananLuarDetails[kos_hotel]['.$num.']', $value->kos_hotel, ['class' => 'hotel_luar_semalam text-right form-control', 'type' => 'number', 'step' => 0.01]) ?></td>
                            <td class="hotel_luar text-right"><?= number_format($value->kali_hotel * $value->kos_hotel, 2) ?></td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td></td>
                            <td class="text-center">Bayaran Perkhidmatan dan Cukai Perkhidmatan(OL21199)</td>
                            <td><?= Html::textInput('PerjalananLuarDetails[cukai]['.$num.']', $value->cukai_hotel, ['type' => 'number', 'step' => 0.01, 'class' => 'cukai_luar text-right form-control']) ?></td>
                            <td class="jumlah_cukai_luar text-right"><?= number_format($value->cukai_hotel, 2) ?></td>
                        </tr>
                        <tr>
                            <td class="text-center">
                                <div class="form-group  form-inline">
                                <?= Html::dropdownList('PerjalananLuarDetails[kali_lojing]['.$num.']', $value->kali_lojing, $kali_makan, ['class' => 'kali_lojing_luar form-control']) ?>
                                </div>
                                    
                            </td>
                            <td class="text-center">hari x Elaun Lojing sebanyak</td>
                            <td><?= Html::textInput('PerjalananLuarDetails[lojing]['.$num.']', $value->lojing, ['type' => 'number', 'step' => 0.01, 'class' => 'lojing_luar_semalam text-right form-control']) ?></td>
                            <td class="lojing_luar text-right"><?= number_format($value->kali_lojing * $value->lojing, 2) ?></td>
                        </tr>
                        <tr><th colspan="3" class="text-right ">Jumlah (RM)</th><th class="text-right jumlah_elaun_penginapan_luar">0.00</th></tr>
                    </tfoot>
                </table>
            </fieldset>
            <fieldset>
                <legend>Tuntutan Pelbagai</legend>
                <table id="pelbagai-perjalanan" class="table table-condensed table-striped table-bordered table-hover table-responsive">
                    <thead>
                        <tr><th>Jenis</th><th>Resit</th><th>Jumlah</th></tr>
                    </thead>
                    <tbody>                
                        <tr>
                            <td>Dobi</td>
                            <td><?= Html::dropDownList('PerjalananLuarDetails[resit_dobi]['.$num.']', $value->resit_dobi, ['Tanpa Resit', 'Dilampirkan'], ['class' => 'form-control']) ?></td>
                            <td><?= Html::textInput('PerjalananLuarDetails[dobi]['.$num.']', $value->dobi, ['class' => 'dobi_luar pelbagai_luar text-right form-control', 'type' => 'number', 'step' => 0.01]) ?></td>
                        </tr>
                        <tr>
                            <td>Pos</td>
                            <td><?= Html::dropDownList('PerjalananLuarDetails[resit_pos]['.$num.']', $value->resit_pos, ['Tanpa Resit', 'Dilampirkan'], ['class' => 'form-control']) ?></td>
                            <td><?= Html::textInput('PerjalananLuarDetails[pos]['.$num.']', $value->pos, ['class' => 'pos_luar pelbagai_luar text-right form-control', 'type' => 'number', 'step' => 0.01]) ?></td>
                        </tr>
                        <tr>
                            <td>Telefon, Teleks, Faks</td>
                            <td><?= Html::dropdownList('PerjalananLuarDetails[resit_telefon]['.$num.']', $value->resit_telefon, ['Tanpa Resit', 'Dilampirkan'], ['class' => 'form-control']) ?></td>
                            <td><?= Html::textInput('PerjalananLuarDetails[telefon]['.$num.']', $value->telefon, ['class' => 'telefon_luar pelbagai_luar text-right form-control', 'type' => 'number', 'step' => 0.01]) ?></td>
                        </tr>
                        <tr>
                            <td>"Tips / Porterage" (15% daripada Elaun Makan)</td>
                            <td></td>
                            <td><?= Html::textInput('PerjalananLuarDetails[porterage]['.$num.']', $value->porterage, ['class' => 'porterage_luar pelbagai_luar text-right form-control', 'type' => 'number', 'step' => 0.01])?></td>
                        </tr>
                        <tr>
                            <td>Cukai Kapal Terbang</td>
                            <td><?= Html::dropDownList('PerjalananLuarDetails[resit_cukai_airport]['.$num.']', $value->resit_cukai_airport, ['Tanpa Resit', 'Dilampirkan'], ['class' => 'form-control']) ?></td>
                            <td><?= Html::textInput('PerjalananLuarDetails[cukai_airport]['.$num.']', $value->cukai_airport, ['class' => 'cukai_airport_luar pelbagai_luar text-right form-control', 'type' => 'number', 'step' => 0.01])?></td>
                        </tr>
                        <tr>
                            <td>Keraian Rasmi</td>
                            <td><?= Html::dropDownList('PerjalananLuarDetails[resit_keraian]['.$num.']', $value->resit_keraian, ['Tanpa Resit', 'Dilampirkan'], ['class' => 'form-control']) ?></td>
                            <td><?= Html::textInput('PerjalananLuarDetails[keraian]['.$num.']', $value->keraian, ['class' => 'keraian pelbagai_luar text-right form-control', 'type' => 'number', 'step' => 0.01])?></td>
                        </tr>
                        <tr>
                            <td>Tambang Teksi / 'Tube' / Keretapi / Bas / Kos</td>
                            <td><?= Html::dropDownList('PerjalananLuarDetails[resit_tambang_kenderaan]['.$num.']', $value->resit_tambang_kenderaan, ['Tanpa Resit', 'Dilampirkan'], ['class' => 'form-control']) ?></td>
                            <td><?= Html::textInput('PerjalananLuarDetails[tambang_kenderaan]['.$num.']', $value->tambang_kenderaan, ['class' => 'tambang_luar pelbagai_luar text-right form-control', 'type' => 'number', 'step' => 0.01])?></td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr><th colspan="2" class="text-right">Jumlah (RM)</th><th class="jumlah_pelbagai_luar text-right">0.00</th></tr>
                    </tfoot>
                </table>
            </fieldset>
        </div>
        <?php
    	}
        ?>
        <button class="btn btn-primary btn-oversea">Tambah Tuntutan Luar Negeri</button>

        <!-- END OVERSEA CLAIM-->

        <H2>TUNTUTAN DALAM NEGERI</H2>
        <fieldset>
            <legend>A. Tuntukan elaun makan dan harian (OL21101)</legend>
            <table id="elaun_makan-perjalanan" class="table table-condensed table-striped table-bordered table-hover table-responsive">
                <thead>
                    <tr><th>Kekerapan Elaun</th><th>Jenis Elaun</th><th>Jumlah Elaun Sehari (RM)</th><th>Sarapan: 20%, Makan Tengahari: 40%, Makan Malam: 40%</th><th>Jumlah Elaun</th></tr>
                </thead>
                <tbody>
                    <tr>
                        <?php
                            $kali_makan = ['Pilih'];

                            for($i = 1; $i <= 31; $i++) {
                                $kali_makan[$i] = $i;
                            }
                            $percent_elaun = ['1' => '100%', '0.8' => '80%', '0.6' => '60%', '0.4' => '40%', '0.2' => '20%'];

                        ?>
                        <td><?= $form->field($model, 'kali_makan')->dropDownList($kali_makan, ['class' => 'kali form-control'])->label(false) ?></td>
                        <td>X Elaun makan sebanyak</td>
                        <td><?= $form->field($model, 'elaun_makan')->textInput(['type' => 'number', 'step' => '0.01', 'class' => 'elaun_makan text-right form-control'])->label(false) ?></td>
                        <td><?= $form->field($model, 'peratus_elaun_makan')->dropDownList($percent_elaun, ['class' => 'kadar_elaun form-control'])->label(false) ?></td>
                        <td class="text-right" id="elaun_makan0">0.00</td>
                    </tr>
                    <tr>
                        <td><?= $form->field($model, 'kali_harian')->dropDownList($kali_makan, ['class' => 'kali form-control'])->label(false) ?></td>
                        <td>X Elaun harian sebanyak</td>
                        <td><?= $form->field($model, 'elaun_harian')->textInput(['type' => 'number', 'step' => '0.01', 'class' => 'elaun_makan text-right form-control'])->label(false) ?></td>
                        <td><?= $form->field($model, 'peratus_elaun_harian')->dropDownList($percent_elaun, ['class' => 'kadar_elaun form-control'])->label(false) ?></td>
                        <td class="text-right" id="elaun_makan1">0.00</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr><th colspan="4" class="text-right">Jumlah (RM)</th><th class="text-right" id="jumlah_elaun_makan">0.00</th></tr>
                </tfoot>
            </table>

        </fieldset>
        <fieldset>
            <legend>B. Tuntutan Bayaran Sewa Hotel (BSH) / Elaun Lojing (OL21102)</legend>
            <table id="bhs-perjalanan" class="table table-condensed table-striped table-bordered table-hover table-responsive">
                <thead>
                    <tr><th>Jumlah Malam</th><th>Kadar</th><th>Harga Semalam (RM)</th><th>Jumlah (RM)</th><th>Tindakan</th></tr>
                </thead>
                <tbody>
                	<?php
                		foreach ($perjalanan_hotel as $key => $value) {
                			$num = $key + 1;
                	?>
                    <tr>
                        <td class="text-center">
                            <div class="form-group  form-inline">
                                <label>Hotel <?= $num ?></label>
                                <?= Html::dropDownList('PerjalananHotel[kali_hotel]['.$num.']', $value->kali_hotel, $kali_makan, ['class' => 'kali_hotel form-control']) ?>
                            </div>
                        </td>
                        <td class="text-center">hari x Bayaran Sewa Hotel sebanyak</td>
                        <td><?= Html::textInput('PerjalananHotel[kos_hotel]['.$num.']', $value->kos_hotel, ['class' => 'hotel text-right form-control', 'type' => 'number', 'step' => 0.01]) ?></td>
                        <td class="penginapan text-right">0.00</td>
                        <td class="text-center">
                        	<button class="btn btn-warning btn-minus"><span class="glyphicon glyphicon-minus-sign icon-size"></span></button>
                        </td>
                    </tr>
                    <?php
                    	}
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td></td>
                        <td class="text-center">Bayaran Perkhidmatan dan Cukai Perkhidmatan(OL21199)</td>
                        <td><?= $form->field($model, 'cukai')->textInput(['class' => 'text-right form-control', 'type' => 'number', 'step' => 0.01])->label(false) ?></td>
                        <td class="penginapan text-right">0.00</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><?= $form->field($model, 'kali_lojing')->dropdownList($kali_makan)->label(false) ?></td>
                        <td class="text-center">hari x Elaun Lojing sebanyak</td>
                        <td><?= $form->field($model, 'lojing')->textInput(['class' => 'text-right form-control', 'type' => 'number', 'step' => 0.01])->label(false) ?></td>
                        <td class="penginapan text-right" id="jumlah_lojing">0.00</td>
                        <td></td>
                    </tr>
                    <tr><th colspan="3" class="text-right">Jumlah (RM)</th><th class="text-right" id="jumlah_elaun_penginapan">0.00</th><th></th></tr>
                </tfoot>
            </table>
            <div class="form-group">
            <button class="btn btn-success" id="btn-hotel" title="Tambah Hotel"><span class="glyphicon glyphicon-plus-sign icon-size"  title="Tambah Hotel"></span></button>
        </div>
        </fieldset>
        <fieldset>
            <legend>C. Tuntutan Pelbagai (*)(OL21199)</legend>
            <table id="pelbagai-perjalanan" class="table table-condensed table-striped table-bordered table-hover table-responsive">
                <thead>
                    <tr><th>Jenis</th><th>Resit</th><th>Jumlah</th></tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class="form-group form-inline">
                                <label>Tol (No. Touch & Go) </label> <?= $form->field($model, 'no_tg')->textInput(['maxlength' => true])->label(false) ?>
                            </div>
                        </td>
                        <td><?= $form->field($model, 'resit_tol')->dropdownList(['Tanpa Resit', 'Dilampirkan', 'Touch n Go'])->label(false) ?></td>
                        <td><?= $form->field($model, 'tol')->textInput(['type' => 'number', 'step' => 0.01, 'class' => 'form-control pelbagai', 'readonly' => true])->label(false) ?></td>
                    </tr>
                    <tr>
                        <td>Tempat Letak Kereta</td>
                        <td><?= $form->field($model, 'resit_pakir')->dropdownList(['Tanpa Resit', 'Dilampirkan'])->label(false) ?></td>
                        <td><?= $form->field($model, 'pakir')->textInput(['type' => 'number', 'step' => 0.01, 'class' => 'form-control pelbagai'])->label(false) ?></td>
                    </tr>
                    <tr>
                        <td>Dobi</td>
                        <td><?= $form->field($model, 'resit_dobi')->dropdownList(['Tanpa Resit', 'Dilampirkan'])->label(false) ?></td>
                        <td><?= $form->field($model, 'dobi')->textInput(['type' => 'number', 'step' => 0.01, 'class' => 'form-control pelbagai'])->label(false) ?></td>
                    </tr>
                    <tr>
                        <td>Pos</td>
                        <td><?= $form->field($model, 'resit_pos')->dropdownList(['Tanpa Resit', 'Dilampirkan'])->label(false) ?></td>
                        <td><?= $form->field($model, 'pos')->textInput(['type' => 'number', 'step' => 0.01, 'class' => 'form-control pelbagai'])->label(false) ?></td>
                    </tr>
                    <tr>
                        <td>Telefon, Teleks, Faks</td>
                        <td><?= $form->field($model, 'resit_telefon')->dropdownList(['Tanpa Resit', 'Dilampirkan'])->label(false) ?></td>
                        <td><?= $form->field($model, 'telefon')->textInput(['type' => 'number', 'step' => 0.01, 'class' => 'form-control pelbagai'])->label(false) ?></td>
                    </tr>
                    <tr>
                        <td>Kerugian pertukaran wang asing
(@3%)<br>[Bagi Singapura, Selatan Thailand, Kalimantan dan Brunei Darussalam</td>
                        <td><?= $form->field($model, 'resit_tukaran')->dropdownList(['Tanpa Resit', 'Dilampirkan'])->label(false) ?></td>
                        <td><?= $form->field($model, 'tukaran')->textInput(['type' => 'number', 'step' => 0.01, 'class' => 'form-control pelbagai'])->label(false) ?></td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr><th colspan="2" class="text-right">Jumlah (RM)</th><th id="jumlah_pelbagai" class="text-right">0.00</th></tr>
                </tfoot>
            </table>
        </fieldset>
        <fieldset>
            <legend>D. Maklumat Perjalanan</legend>
            <div class="form-group">
                <div class="hidden">
                    <?= DatePicker::widget(['options' => ['class' => 'hidden']]); ?>
                    <?= TimePicker::widget([
                            'name' => 'start_time', 
                            'value' => '00:00 AM',
                            'options' => ['class' => 'hidden'],
                            'pluginOptions' => []
                        ]); ?>
                </div>
                <table id="maklumat-perjalanan" class="table table-condensed table-striped table-bordered table-hover table-responsive">
                    <thead bgcolor="#ccc">
                        <tr>
                            <th rowspan="2" scope="col" class="text-center">No</th>
                            <th colspan="3" scope="col" class="text-center">Waktu</th>
                            <th rowspan="2" scope="col" class="text-center">Tujuan / Tempat</th>
                            <th rowspan="2" scope="col" class="text-center">Jarak (Km)</th>
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
                    	<?php 
	                    	$jumlah_perjalanan = count($perjalanan_details);
	                    	foreach ($perjalanan_details as $key => $value) {
	                    		$num = $key + 1;
	                    ?>
                        <tr>
                            <td class="text-center"><?= $num ?></td>
                            <td class="text-center">
                                <?= Html::textInput('PerjalananDetails[tarikh]['.$num.']', Yii::$app->formatter->asDate($value['tarikh']), ['class' => 'form-control datepicker must', 'readonly' => true]) ?>
                            </td>
                            <td class="text-center">
                                <div class="bootstrap-timepicker input-group">
                                    <input type="text" class="form-control time-picker must" name="PerjalananDetails[bertolak][<?= $num ?>]"  value="<?= $value['bertolak'] ?>">
                                    <span class="input-group-addon picker"><i class="glyphicon glyphicon-time"></i></span>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="bootstrap-timepicker input-group">
                                    <input type="text" class="form-control time-picker must" name="PerjalananDetails[sampai][<?= $num ?>]"  value="<?= $value['sampai'] ?>">
                                    <span class="input-group-addon picker"><i class="glyphicon glyphicon-time"></i></span>
                                </div>
                            </td>
                            <td class="text-center"><?= Html::textarea('PerjalananDetails[tujuan]['.$num.']', $value['tujuan'],['class' => 'form-control must', 'cols' => 55]) ?></td>
                            <td class="text-center col-lg-1"><?= Html::textInput('PerjalananDetails[jarak]['.$num.']', $value['jarak'],['class' => 'form-control jarak', 'type' => 'number']) ?></td>
                            <td class="text-center col-lg-1"><?= Html::textInput('PerjalananDetails[kos]['.$num.']', $value['kos'],['class' => 'form-control kos', 'type' => 'number', 'step' => 0.01]) ?></td>
                            <td class="text-center">
								<button class="btn btn-warning btn-minus"><span class="glyphicon glyphicon-minus-sign icon-size"></span></button>	
                            </td>
                        </tr>
                        <?php
	                    	}
	                    ?>
                    </tbody>
                    <tfoot>
                        <tr><th colspan="5" class="text-right">Jumlah</th><th id="jumlah_jarak0" class="text-center">0</th><th id="jumlah_kos" class="text-right">0.00</th><th></th></tr>
                        <tr><th colspan="5" class="text-right">Jumlah Perjalanan Lain-lain (KM):</th><th class="perjalanan_lalu text-center">0</th><th></th><th></th></tr>
                        <tr><th colspan="5" class="text-right">Jumlah Keseluruhan Perjalanan:</th><th id="jumlah_jarak" class="text-center">0</th><th></th><th></th></tr>
                    </tfoot>
                </table>
                <div class="form-group">
                    <button class="btn btn-success" id="btn-perjalanan" title="Tambah Perjalanan"><span class="glyphicon glyphicon-plus-sign icon-size"></span></button>
                </div>
            </div>
        </fieldset>
        <fieldset>
            <legend>E. Tuntutan Elaun Perjalanan Kenderaan (OL 21104)</legend>
            <table id="elaun-perjalanan" class="table table-condensed table-striped table-bordered table-hover table-responsive">
                <thead>
                    <tr><th colspan="5"></th><th>Jumlah RM</th></tr>
                </thead>
                <tbody>
                    <tr><td>500 Km Pertama</td><td id="km1"></td><td>Km X</td><td id="kadar1"></td><td>sen/Km</td><td id="kadar_jarak1">0.00</td></tr>
                    <tr><td>501 Km - 1000 Km</td><td id="km2"></td><td>Km X</td><td id="kadar2"></td><td>sen/Km</td><td id="kadar_jarak2">0.00</td></tr>
                    <tr><td>1001 Km - 1700 Km</td><td id="km3"></td><td>Km X</td><td id="kadar3"></td><td>sen/Km</td><td id="kadar_jarak3">0.00</td></tr>
                    <tr><td>17001 Km ke atas</td><td id="km4"></td><td>Km X</td><td id="kadar4"></td><td>sen/Km</td><td id="kadar_jarak4">0.00</td></tr>
                </tbody>
                <tfoot>
                    <tr><th class="text-right">Jumlah (Km)</th><th id="jumlah_km"></th><th>Km X</th><th></th><th>Jumlah (RM)</th><th id="jumlah_kadar_jarak"></th></tr>
                    <tr><th colspan="5" class="text-right">Perjalanan yang telah dilakukan pada bulan yang sedang dituntut sebanyak <span class="perjalanan_lalu">0</span> Km:</th><th id="tolak_kadar_jarak">0.00</th></tr>
                    <tr><th colspan="5" class="text-right">Jumlah Sebenar (RM)</th><th id="jumlah_kadar_jarak2">0.00</th></tr>
                </tfoot>
            </table>
            <?= $form->field($model, 'jumlah_jarak')->hiddenInput() ?>
            <?= $form->field($model, 'jarak_telah_dituntut')->hiddenInput() ?>
        </fieldset>

        <fieldset>
            <legend>F. Tuntutan Tambang Pengangkutan Awam (*)</legend>
            <table id="tambang-perjalanan" class="table table-condensed table-striped table-bordered table-hover table-responsive">
                <thead>
                    <tr><th>Jenis</th><th>Resit</th><th>Jumlah</th></tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Teksi (OL21104)</td>
                        <td><?= $form->field($model, 'resit_teksi')->dropdownList(['Tanpa Resit', 'Dilampirkan'], ['class' => 'resit form-control']) ?></td>
                        <td><?= $form->field($model, 'teksi')->textInput(['type' => 'number', 'step' => 0.01, 'class' => 'form-control tambang']) ?></td>
                    </tr>
                    <tr>
                        <td>Bas (OL21104)</td>
                        <td><?= $form->field($model, 'resit_bas')->dropdownList(['Tanpa Resit', 'Dilampirkan'], ['class' => 'resit form-control']) ?></td>
                        <td><?= $form->field($model, 'bas')->textInput(['type' => 'number', 'step' => 0.01, 'class' => 'form-control tambang']) ?></td>
                    </tr>
                    <tr>
                        <td>Kereta Api (OL21103)</td>
                        <td><?= $form->field($model, 'resit_keretapi')->dropdownList(['Tanpa Resit', 'Dilampirkan'], ['class' => 'resit form-control']) ?></td>
                        <td><?= $form->field($model, 'keretapi')->textInput(['type' => 'number', 'step' => 0.01, 'class' => 'form-control tambang']) ?></td>
                    </tr>
                    <tr>
                        <td>Terbang (OL21106)</td>
                        <td><?= $form->field($model, 'resit_terbang')->dropdownList(['Tanpa Resit', 'Dilampirkan'], ['class' => 'resit form-control']) ?></td>
                        <td><?= $form->field($model, 'terbang')->textInput(['type' => 'number', 'step' => 0.01, 'class' => 'form-control tambang']) ?></td>
                    </tr>
                    <tr>
                        <td>Feri (OL21105)</td>
                        <td><?= $form->field($model, 'resit_feri')->dropdownList(['Tanpa Resit', 'Dilampirkan'], ['class' => 'resit form-control']) ?></td>
                        <td><?= $form->field($model, 'feri')->textInput(['type' => 'number', 'step' => 0.01, 'class' => 'form-control tambang']) ?></td>
                    </tr>
                    <tr>
                        <td>Lain-lain </td>
                        <td><?= $form->field($model, 'resit_lain')->dropdownList(['Tanpa Resit', 'Dilampirkan'], ['class' => 'resit form-control']) ?></td>
                        <td><?= $form->field($model, 'lain')->textInput(['type' => 'number', 'step' => 0.01, 'class' => 'form-control tambang']) ?></td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr><th colspan="2"></th><th id="jumlah_tambang">0.00</th></tr>
                </tfoot>
            </table>
            <h3 class="text-right">Jumlah Tuntutan (RM) <span id="jumlah_tuntutan">0.00</span></h3>
        </fieldset>
        
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
                    <li>Perbelanjaan yang bertanda (*) berjumlah sebanyak <strong>RM <span id="pendahuluan">0.00</span></strong> sebenarnya
dilakukan dan dibayar oleh saya;</li>
                    <li>Panggilan telefon sebanyak <strong>RM <span id="telefon2">0.00</span></strong> dibuat atas urusan rasmi; dan</li>
                    <li>Pbutir-butir seperti yang dinyatakan di atas adalah benar dan saya bertanggungjawab terhadapnya. 
</li>
                </ol>
                Tarikh: <?= date('d-m-Y') ?>
            </div>
        </fieldset>

        <?= $form->field($model, 'pendahuluan')->hiddenInput()->label(false) ?>

        <?= $form->field($model, 'tuntutan_lain')->hiddenInput(['value' => 0])->label(false) ?>

        <?= $form->field($model, 'jumlah_tuntutan')->hiddenInput()->label(false) ?>

        <?= $form->field($model, 'jumlah_kew')->hiddenInput()->label(false) ?>
        
        <?= $form->field($model, 'id')->hiddenInput()->label(false) ?>

        <?php //= $form->field($model, 'status')->textInput() ?>

        <?php //= $form->field($model, 'cetak')->textInput() ?>

        <?php //= $form->field($model, 'catatan')->textarea(['rows' => 6]) ?>

        <?php //= $form->field($model, 'user')->textInput() ?>

        <?php //= $form->field($model, 'tarikh_jadi')->textInput() ?>

        <?php //= $form->field($model, 'tarikh_kemaskini')->textInput() ?>

        <div class="form-group">
            <?= Html::button(Yii::t('app', 'Save'), ['class' => 'btn btn-success', 'id' => 'simpan-perjalanan']) ?>
            <?= Html::submitButton(Yii::t('app', 'Hantar & Cetak'), ['class' => 'btn btn-warning', 'id' => 'cetak-perjalanan', 'style' => 'display: none;']) ?>
        </div>

    </div>
    <?php ActiveForm::end(); ?>

</div>

<?php
//oversea
$this->registerJs('
    $(".btn-oversea").click(function(){
        // var nth = $(".nth").text() / 1;
        // nth++;
        var nthLen = $(".nth").length + 1;
        var btn_minus = "<div class=\"form-group\"><button class=\"btn btn-warning btn-oversea-minus\">Buang Kenyataan #" + nthLen + "</button></div>";
        $(".oversea").eq(0).clone().insertAfter(".oversea:last").append(btn_minus);

        //$(".oversea").last().html($(".oversea").last().html().replace(/[1]/g, nthLen));
        $(".oversea").last().html($(".oversea").last().html().replace(/\[.1?\]/g, "[" + nthLen + "]"));
        //$(".oversea").last().html($(".oversea").last().html().replace(/hasDatepicker/g, ""));
        //$(".datepicker").removeClass("hasDatepicker");
        $(".oversea").last().html($(".oversea").last().html().replace(/id/g, "src"));

        nthLen = $(".nth").length;
        //console.log(nthLen);
        $(".nth").eq(nthLen - 1).text(nthLen);
        $(".elaun_makan_luar").eq((nthLen - 1) * 2).text("0.00");
        $(".elaun_makan_luar").eq((nthLen - 1) * 2 + 1).text("0.00");
        $(".jumlah_elaun_makan_luar").eq(nthLen - 1).text("0.00");
        $(".hotel_luar").eq(nthLen - 1).text("0.00");
        $(".jumlah_cukai_luar").eq(nthLen - 1).text("0.00");
        $(".lojing_luar").eq(nthLen - 1).text("0.00");
        $(".jumlah_elaun_penginapan_luar").eq(nthLen - 1).text("0.00");
        $(".jumlah_pelbagai_luar").eq(nthLen - 1).text("0.00");

        return false;
    });

    $(document).on("click", ".btn-oversea-minus", function(){
        //alert($(this).index(".btn-oversea-minus"));
        var index = $(this).index(".btn-oversea-minus")/1 + 1;
        $("div.oversea").eq(index).remove();
        //$(this).parentsUntil("div.oversea").css( "background-color", "red" );;
        return false;
    });

    $(document).on("change", ".kali_luar", function(){
        var index = $(this).index(".kali_luar");
        var val = $(this).val()/1 * $(".elaun_makan_luar_sehari").eq(index).val()/1 * $(".kadar_elaun_luar").eq(index).val()/1; 
        $(".elaun_makan_luar").eq(index).text(val.toFixed(2));
        var index_jumlah = Math.floor(index / 2);
        index2 = index - 1;
        if(index % 2 == 0)
            index2 = index + 1;
        var total_val = $(".elaun_makan_luar").eq(index).text()/1 + $(".elaun_makan_luar").eq(index2).text()/1
        $(".jumlah_elaun_makan_luar").eq(index_jumlah).text(total_val.toFixed(2));
        setTotal();
    });

    $(document).on("keyup", ".elaun_makan_luar_sehari", function(){
        var index = $(this).index(".elaun_makan_luar_sehari");
        var val = $(this).val()/1 * $(".kali_luar").eq(index).val()/1 * $(".kadar_elaun_luar").eq(index).val()/1; 
        $(".elaun_makan_luar").eq(index).text(val.toFixed(2));
        var index_jumlah = Math.floor(index / 2);
        index2 = index - 1;
        if(index % 2 == 0)
            index2 = index + 1;
        var total_val = $(".elaun_makan_luar").eq(index).text()/1 + $(".elaun_makan_luar").eq(index2).text()/1
        $(".jumlah_elaun_makan_luar").eq(index_jumlah).text(total_val.toFixed(2));
        setTotal();
    });

    $(document).on("change", ".kadar_elaun_luar", function(){
        $(".kali_luar").trigger("change");
    });

    $(document).on("change", ".kali_hotel_luar", function(){
        var index = $(this).index(".kali_hotel_luar");
        var val = $(this).val()/1 * $(".hotel_luar_semalam").eq(index).val(); 

        $(".hotel_luar").eq(index).text(val.toFixed(2));

        var jumlah_val = val/1 + $(".jumlah_cukai_luar").eq(index).text()/1 + $(".lojing_luar").eq(index).text()/1;
        $(".jumlah_elaun_penginapan_luar").eq(index).text(jumlah_val.toFixed(2));
        setTotal();
    });

    $(document).on("keyup", ".hotel_luar_semalam", function(){
        $(".kali_hotel_luar").trigger("change");
    });

    $(document).on("keyup", ".cukai_luar", function(){
        var index = $(this).index(".cukai_luar");
        var val = $(this).val()/1;
        $(".jumlah_cukai_luar").eq(index).text(val.toFixed(2));
        var jumlah_val = val/1 + $(".hotel_luar").eq(index).text()/1 + $(".lojing_luar").eq(index).text()/1;
        $(".jumlah_elaun_penginapan_luar").eq(index).text(jumlah_val.toFixed(2));
        setTotal();
    });

    $(document).on("change", ".kali_lojing_luar", function(){
        var index = $(this).index(".kali_lojing_luar");
        var val = $(this).val()/1 * $(".lojing_luar_semalam").eq(index).val(); 

        $(".lojing_luar").eq(index).text(val.toFixed(2));

        var jumlah_val = val/1 + $(".jumlah_cukai_luar").eq(index).text()/1 + $(".hotel_luar").eq(index).text()/1;
        $(".jumlah_elaun_penginapan_luar").eq(index).text(jumlah_val.toFixed(2));
        setTotal();
    });

    $(document).on("keyup", ".lojing_luar_semalam", function(){
        $(".kali_lojing_luar").trigger("change");
    });

    $(document).on("keyup", ".pelbagai_luar", function(){
        //var length = $(".pelbagai_luar").length;
        var total = 0;
        var class_name = $(this).prop("class").split(" ")[0];
        var index = $(this).index("." + class_name);
        for(var i = (index * 7); i <= (index * 7 + 6); i++) {
            total += $(".pelbagai_luar").eq(i).val()/1;
        }
        //console.log(index);
        $(".jumlah_pelbagai_luar").eq(index).text(total.toFixed(2));
        setTotal();
    });
');
//end of oversea


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
            var data = {no_kp: nokp, bulan: bulan, tahun: tahun, os: os, jenis: 1};
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
        $(this).timepicker({ /*defaultTime: "08:00 AM",*/ minuteStep: 5});
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
        defaultTime: false,
        minuteStep: 5
        // template: true,
        // showInputs: true,
        // minuteStep: 5
    });

    var ii = 1;
    $("#btn-perjalanan").on("click", function(){
        
        ii++;
        row = "<tr>" +
                "<td class=\"text-center\">" + ii + "</td>" +
                "<td class=\"text-center\">" +
                    "<input type=\"text\" class=\"form-control datepicker must\" name=\"PerjalananDetails[tarikh][" + ii + "]\" readonly></td>" +
                "<td class=\"text-center\">" +
                    "<div class=\"bootstrap-timepicker input-group\">" +
                        "<input type=\"text\" class=\"form-control time-picker must\" name=\"PerjalananDetails[bertolak][" + ii + "]\">" +
                        "<span class=\"input-group-addon picker\"><i class=\"glyphicon glyphicon-time\"></i></span>" +
                    "</div>" +
                "</td>" +
                "<td class=\"text-center\">" +
                    "<div class=\"bootstrap-timepicker input-group\">" +
                        "<input type=\"text\" class=\"form-control time-picker must\" name=\"PerjalananDetails[sampai][" + ii + "]\">" +
                        "<span class=\"input-group-addon picker\"><i class=\"glyphicon glyphicon-time\"></i></span>" +
                    "</div>" +
                "</td>" +
                "<td class=\"text-center\"><textarea class=\"form-control must\" name=\"PerjalananDetails[tujuan][" + ii + "]\" cols=\"55\"></textarea></td>" +
                "<td class=\"text-center col-lg-1\"><input type=\"number\" class=\"form-control jarak\" name=\"PerjalananDetails[jarak][" + ii + "]\"></td>" +
                "<td class=\"text-center col-lg-1\"><input type=\"number\" class=\"form-control kos\" name=\"PerjalananDetails[kos][" + ii + "]\" step=\"0.01\"></td>" +
                 "<td class=\"text-center\"><button class=\"btn btn-warning btn-minus\"><span class=\"glyphicon glyphicon-minus-sign icon-size\"></span></button></td>" +
            "</tr>";
        $("tbody#perjalanan-body").append(row);
        return false;
    });

    $(document).on("click", ".btn-minus", function(e){
        if(confirm("Padam maklumat ini?")) {
            $(this).parent().parent().remove();
            $(".jarak, .kos, .hotel").trigger("keyup");
            setJarak();
            jumlahKadarJarak();
            setJarak();
            setKos();
            setPelbagai();
            setTotal();
        }
        return false;
    });

    $("form#perjalanan-form").on("beforeSubmit", function(){
    	return true;
        if(!checkMust())
            return false; 
        if(checkBaki() && confirm("Hantar tuntutan perjalanan ini?"))
            return true;
        if(!checkBaki())
            alert("Jumlah tuntutan melebihi baki unjuran");
        return false;
    });

    $("#simpan-perjalanan").on("click", function(){
        // console.log($("#perjalanan-form").serialize());
        // return false;
        if(checkMust() && confirm("Simpan tuntutan perjalanan ini?")) {
            $.post("'.Url::to(['perjalanan/create-over']).'", $("form#perjalanan-form").serialize(), function(data){
                if(data)
                    alert("Data berjaya disimpan");
                $("#perjalanan-id").val(data);
                console.log(data);
            });
        }
        return false;
    });

    $("table").on("keyup", ".jarak", function(){
        var sum_jarak = 0;
        $(".jarak").each(function(){
            sum_jarak += $(this).val() / 1;
        });
        console.log(sum_jarak);
        $("#jumlah-jarak").html(sum_jarak)
        $("#perjalanan-jumlah_jarak").val(sum_jarak);
        $(".kelass:checked").trigger("click");
        setJarak();
        jumlahKadarJarak();
        setTotal();
    });

    $("table").on("keyup", ".kos", function(){
        var sum_tol = 0;
        $(".kos").each(function(){
            sum_tol += $(this).val() / 1;
        });
        $("#jumlah_kos").html(sum_tol.toFixed(2));
        $(".kelass:checked").trigger("click");
        setKos();
        setPelbagai();
        setJarak();
        jumlahKadarJarak();
        setTotal();
    });

    $(".kelass").click(function(){
        var kadar1 = 0.7, kadar2 = 0.65, kadar3 = 0.55, kadar4 = 0.5;
        switch($(this).val()) {
            case "A":
                kadar1 = 0.7;
                kadar2 = 0.65;
                kadar3 = 0.55;
                kadar4 = 0.5;
                break;
            case "B":
                kadar1 = 0.6;
                kadar2 = 0.55;
                kadar3 = 0.5;
                kadar4 = 0.45;
                break;
            case "C":
                kadar1 = 0.5;
                kadar2 = 0.45;
                kadar3 = 0.4;
                kadar4 = 0.35;
                break;
            case "D":
                kadar1 = 0.45;
                kadar2 = 0.4;
                kadar3 = 0.35;
                kadar4 = 0.3;
                break;
            case "E":
                kadar1 = 0.4;
                kadar2 = 0.35;
                kadar3 = 0.3;
                kadar4 = 0.25;
                break;
        }
        $("#kadar1").text(kadar1.toFixed(2));
        $("#kadar2").text(kadar2.toFixed(2));
        $("#kadar3").text(kadar3.toFixed(2));
        $("#kadar4").text(kadar4.toFixed(2));
        jumlahKadarJarak();
        setTotal();
    });

    $(".kali").change(function(){
        tempVal = 0;
        for(var i = 0; i < $(".kali").length; i++) {
            $("#elaun_makan"+i).text(($(".kali").eq(i).val() * $(".elaun_makan").eq(i).val() * $(".kadar_elaun").eq(i).val()).toFixed(2));
            tempVal += $("#elaun_makan"+i).text()/1;
        }
        $("#jumlah_elaun_makan").text(tempVal.toFixed(2));
        setTotal();
    });
    
    $(".elaun_makan").keyup(function(){
        var tempVal = 0;
        $(this).val(testNumeric($(this).val()));
        for(var i = 0; i < $(".kali").length; i++) {
            $("#elaun_makan"+i).text(($(".kali").eq(i).val() * $(".elaun_makan").eq(i).val()).toFixed(2));
            tempVal += $("#elaun_makan"+i).text()/1;
        }
        $("#jumlah_elaun_makan").text(tempVal.toFixed(2));
        $(".kali").trigger("change"); 
        setTotal();
    });
    
    $(".kadar_elaun").change(function(){
        $(".kali").trigger("change");   
    });

    var kk = 1;
    $("#btn-hotel").on("click", function(){
        kk++;
        var row = "<tr><td class=\"text-center\"><div class=\"form-group form-inline\"><label>Hotel " + kk + "</label> <select class=\"kali_hotel form-control\" name=\"PerjalananHotel[kali_hotel][" + kk + "]\"><option value=\"0\">Pilih</option><option value=\"1\">1</option><option value=\"2\">2</option><option value=\"3\">3</option><option value=\"4\">4</option><option value=\"5\">5</option><option value=\"6\">6</option><option value=\"7\">7</option><option value=\"8\">8</option><option value=\"9\">9</option><option value=\"10\">10</option><option value=\"11\">11</option><option value=\"12\">12</option><option value=\"13\">13</option><option value=\"14\">14</option><option value=\"15\">15</option><option value=\"16\">16</option><option value=\"17\">17</option><option value=\"18\">18</option><option value=\"19\">19</option><option value=\"20\">20</option><option value=\"21\">21</option><option value=\"22\">22</option><option value=\"23\">23</option><option value=\"24\">24</option><option value=\"25\">25</option><option value=\"26\">26</option><option value=\"27\">27</option><option value=\"28\">28</option><option value=\"29\">29</option><option value=\"30\">30</option><option value=\"31\">31</option></select></div></td>" +
        "<td class=\"text-center\">hari x Bayaran Sewa Hotel sebanyak</td>" +
        "<td><input type=\"number\" class=\"hotel form-control text-right\" name=\"PerjalananHotel[kos_hotel][" + kk + "]\" step=\"0.01\"></td>" +
        "<td class=\"penginapan text-right\">0.00</td><td class=\"text-center\"><button class=\"btn btn-warning btn-minus\"><span class=\"glyphicon glyphicon-minus-sign icon-size\"></span></button></td></tr>";
        $("table#bhs-perjalanan tbody").append(row);
        console.log("K:"+kk);
        return false;

    });

    $(document).on("change", ".kali_hotel", function(){
        var i = $(this).index(".kali_hotel");
        //$(".penginapan").eq(i).text("XXX");
        console.log($(".hotel").eq(i).val());
        $(".penginapan").eq(i).text(($(this).val()/1 * $(".hotel").eq(i).val()/1).toFixed(2));
        setPenginapan();    
        setTotal();
    });
    
    $(document).on("keyup", ".hotel", function(){
        var i = $(this).index(".hotel");
        $(this).val(testNumeric($(this).val()));
        $(".penginapan").eq(i).text(($(".kali_hotel").eq(i).val()/1 * $(this).val()/1).toFixed(2));
        setPenginapan();
        setTotal();
    });
        
    $("#perjalanan-cukai").keyup(function(){
        $(this).val(testNumeric($(this).val())); 
        $(this).parent().parent().next().html(($(this).val()/1).toFixed(2));
        setPenginapan();
        setTotal();
    });
    
    $("#perjalanan-kali_lojing").change(function(){
        $("#jumlah_lojing").html(($(this).val() * $("#perjalanan-lojing").val()).toFixed(2));
        setPenginapan();
        setTotal(); 
    });
    
    $("#perjalanan-lojing").keyup(function(){
        $(this).val(testNumeric($(this).val()));
        $("#jumlah_lojing").html(($(this).val() * $("#perjalanan-kali_lojing").val()).toFixed(2));
        setPenginapan();
        setTotal();
    });

    //$(".resit").parent().addClass("form-inline");
    $("#pendahuluan").parent().addClass("form-inline").css("display", "inline");

    $(".tambang").keyup(function(){
        $(this).val(testNumeric($(this).val()));
        var tempVal = 0;
        for(var i = 0; i < $(".tambang").length; i++) {
            tempVal += $(".tambang").eq(i).val()/1;
        }
        $("#jumlah_tambang").text(tempVal.toFixed(2));
        setTotal();
    });

    $(".tambang, #jumlah_tambang, .pelbagai").addClass("text-right");
    
    $(".pelbagai").keyup(function(){
        $(this).val(testNumeric($(this).val()));
        
        setPelbagai();
        setTotal();
    });

    $("#akuan").on("click", function(){
        if($(this).is(":checked")) {
            $("#simpan-perjalanan").hide();
            $("#cetak-perjalanan").show();
        }
        else {
            $("#simpan-perjalanan").show();
            $("#cetak-perjalanan").hide();
        }

    });

    //onload page
	$(".jarak, .kos, .hotel").trigger("keyup");
	$(".kali, .kali_luar, .kali_hotel_luar, .kali_lojing_luar").trigger("change");
	$(".kali_hotel").trigger("change");
	$("#perjalanan-kali_lojing").trigger("change");
	$("#perjalanan-lojing").trigger("keyup");
	$("#perjalanan-cukai").trigger("keyup");
	$(".tambang, .pelbagai, .pelbagai_luar").trigger("keyup");
');

// FUNCTIONS
$this->registerJs('

function setJarak() {
    var jumlah_jarak = 0;
    for(i = 0; i < $(".jarak").length; i++) {
        jumlah_jarak += $(".jarak").eq(i).val()/1;  
    }
    $("#jumlah_jarak0").text(jumlah_jarak);
    $("#jumlah_jarak").text($("#jumlah_jarak0").text()/1 + $(".perjalanan_lalu").eq(0).text()/1);
    $("#jumlah_jarak_besar").val(jumlah_jarak);
    $("#km1").text("");
    $("#km2").text("");
    $("#km3").text("");
    $("#km4").text("");
    jumlah_jarak += $(".perjalanan_lalu").eq(0).text()/1;
    if(jumlah_jarak/1 <= 500)
        $("#km1").text(jumlah_jarak);
    else if(jumlah_jarak/1 > 500 && jumlah_jarak/1 <= 1000) {
        $("#km1").text("500");
        $("#km2").text(jumlah_jarak-500);
    }
    else if(jumlah_jarak/1 > 1000 && jumlah_jarak/1 <= 1700) {
        $("#km1").text("500");
        $("#km2").text("500");
        $("#km3").text(jumlah_jarak-1000);
    }
    else {
        $("#km1").text("500");
        $("#km2").text("500");
        $("#km3").text("700");
        $("#km4").text(jumlah_jarak-1700);
    }       
}

function setKos() {
    var jumlah_kos = 0;
        for(i = 0; i < $(".kos").length; i++) {
            jumlah_kos += $(".kos").eq(i).val()/1;  
        }
        $("#jumlah_kos").text(jumlah_kos.toFixed(2));
        $("#perjalanan-tol").val($("#jumlah_kos").text()); 
}

function jumlahKadarJarak(){
    //alert($("#km1").html());
    //$("#kadar_jarak1").text("XXX");return;
    tempKadarJarak = 0;
    tempKm = 0;
    for(var i = 1; i <= 4; i++) {
        tempVal = $("#km"+i).text()/1 * $("#kadar"+i).text()/1;
        tempKm += $("#km"+i).text()/1;
        tempVal = tempVal.toFixed(2);
        tempKadarJarak += tempVal/1;
        $("#kadar_jarak"+i).text(tempVal);
    }
    $("#jumlah_kadar_jarak").text(tempKadarJarak.toFixed(2));
    $("#jumlah_km").text(tempKm);
    $("#tolak_kadar_jarak").text((0-jarakDuit($(".perjalanan_lalu").eq(0).text()/1)).toFixed(2));
    $("#jumlah_kadar_jarak2").text(($("#jumlah_kadar_jarak").text()/1 + $("#tolak_kadar_jarak").text()/1).toFixed(2));  
}

function jarakDuit(jarak) {
    jarak = jarak/1;
    temp = 0;
    if(jarak <= 500)
        return (jarak * $("#kadar1").text()/1);
    else if(jarak > 500 && jarak <= 1000) {
        temp = 500 * $("#kadar1").text()/1;
        temp += (jarak - 500) * $("#kadar2").text()/1;
        return temp;
    }
    else if(jarak > 1000 && jarak <= 1700) {
        temp = 500 * $("#kadar1").text()/1;
        temp += 500 * $("#kadar2").text()/1;
        temp += (jarak - 1000) * $("#kadar3").text()/1;
        return temp;
    }
    else {
        temp = 500 * $("#kadar1").text()/1;
        temp += 500 * $("#kadar2").text()/1;
        temp += 700 * $("#kadar3").text()/1;
        temp += (jarak - 1700) * $("#kadar4").text()/1;
        return temp;
        
    }
}

function setTotal() {
    var jumlah_elaun_makan_luar = 0
    for(var j = 0; j < $(".jumlah_elaun_makan_luar").length; j++) {
        jumlah_elaun_makan_luar += $(".jumlah_elaun_makan_luar").eq(j).text().replace(/,/g , "")/1;
    }
    //console.log(jumlah_elaun_makan_luar);

    var jumlah_elaun_penginapan_luar = 0
    for(j = 0; j < $(".jumlah_elaun_penginapan_luar").length; j++) {
        jumlah_elaun_penginapan_luar += $(".jumlah_elaun_penginapan_luar").eq(j).text().replace(/,/g , "")/1;
    }

    //console.log(jumlah_elaun_penginapan_luar);

    var jumlah_pelbagai_luar = 0
    for(j = 0; j < $(".jumlah_pelbagai_luar").length; j++) {
        jumlah_pelbagai_luar += $(".jumlah_pelbagai_luar").eq(j).text().replace(/,/g , "")/1;
    }

    console.log(jumlah_pelbagai_luar);

    $("#jumlah_tuntutan").text(($("#jumlah_kadar_jarak2").text()/1 + $("#jumlah_elaun_makan").text()/1 + $("#jumlah_elaun_penginapan").text()/1 + $("#jumlah_tambang").text()/1 + jumlah_elaun_makan_luar/1 + jumlah_elaun_penginapan_luar/1 + jumlah_pelbagai_luar/1 + $("#jumlah_pelbagai").text()/1).toFixed(2));
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
    var balance = $("#baki").text()/1;
    var spend = $("#perjalanan-jumlah_kew").val()/1;
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



