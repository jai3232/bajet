<?php
use app\models\Jabatan;
use app\models\Unit;
use app\models\Pengguna;
use app\models\Unjuran;
use app\models\RefJenisPerolehan;
use app\models\RefKaedahPerolehan;
use yii\helpers\Html;

?>
<div id="rujukan">
	<?= 'No: '.$model->kod_id ?><br>
	<?= 'OS: '.$model->kodUnjuran->os ?>
</div>
<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="text-center">BORANG PANJAR RUNCIT</h3>
  	</div>
  	<ul class="list-group">
    	<li class="list-group-item">
    		<h4>Maklumat Permohonan</h4>
    		<table class="table table-bordered">
    			<tbody>
    				<tr><th>Nama Pemohon</th><td><?= Pengguna::findOne($model->user)->nama ?></td></tr>
    				<tr><th>Jawatan</th><td><?= $model_panjar->jawatan ?></td></tr>
    				<tr><th class="col-md-3">Nama Jabatan / Bahagian / Unit:</th><td> <?= Jabatan::findOne($model->id_jabatan_asal)->jabatan.' / '.Unit::findOne($model->id_unit)->unit; ?></td></tr>
    				<tr><th>Telefon / Sambungan</th><td><?= $model_panjar->sambungan ?></td></tr>
    				<tr><th>Butiran / Tujuran</th><td> <?= $model_panjar->tujuan ?></td></tr>
    				<tr><th>Jumlah</th><td> <?= 'RM'.number_format($model_panjar->jumlah_panjar, 2) ?></td></tr>
    				<tr style="height: 80px;"><th>Tandatangan Pemohon & Tarikh</th><td><br>_________________<br>Tarikh:</td></tr>
    				<tr style="height: 50px;"><th>Sokongan Ketua Jabatan / Unit</th><td></td></tr>
    				<tr style="height: 80px;"><th>Tandatangan Ketua Jabatan / Unit & Tarikh</th><td><br>_________________<br>Tarikh:</td></tr>
    			</tbody>
    		</table>
    	</li>
    	<li class="list-group-item">
    		<h4>Kelulusan</h4>
    		<table class="table table-bordered">
    			<tbody>
    				<tr><th>Peruntukan</th><td>Mengurus / Amanah / Pembangunan</td></tr>
    				<tr><th>Objek Sebagai</th><td><?= $model->kodUnjuran->os ?></td></tr>
    				<tr style="height: 50px;"><th>Pegawai Pelulus</th><td></td></tr>
    				<tr style="height: 80px;"><th>Tandatangan Pegawai Pelulus & Tarikh</th><td><br>_________________<br>Tarikh:</td></tr>
    			</tbody>
    		</table>
    	</li>
  	</ul>
</div>
<?= Html::a('Papar PDF', ['/perolehan/panjar-pdf', 'id' => yii::$app->request->get('id')], ['class'=>'btn btn-primary']) ?>
<?php
$this->registerCss('
	.bordered {
		border: 1px solid black;
	}
	#rujukan {
		position: relative;
		border: 3px solid red;
		width: 200px;
		padding: 1px 3px;
		text-align: center;
		font-weight: bold;
		color: red;

	}
');
?>