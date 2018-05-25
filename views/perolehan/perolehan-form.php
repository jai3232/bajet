<?php
use app\models\Jabatan;
use app\models\Unit;
use app\models\Pengguna;
use app\models\RefJenisPerolehan;
use app\models\RefKaedahPerolehan;

?>

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="text-center">BORANG PERMOHONAN PEROLEHAN BEKALAN / PERKHIDMATAN / KERJA</h3>
  	</div>
  	<div class="panel-body">
    	Panel content
  	</div>
  	<ul class="list-group">
    	<li class="list-group-item">
    		<h4>Maklumat Permohonan</h4>
    		<table class="table table-bordered">
    			<tbody>
    				<tr><th class="col-md-3">Nama Jabatan / Bahagian / Unit:</th><td> <?= Jabatan::findOne($model->id_jabatan_asal)->jabatan.' / '.Unit::findOne($model->id_unit)->unit; ?></td></tr>
    				<tr><th>Jenis Perolehan:</th><td> <?= RefJenisPerolehan::findOne($model->jenis_perolehan)->jenis; ?></td></tr>
    				<tr><th>Kaedah Perolehan:</th><td> <?= RefKaedahPerolehan::findOne($model->kaedah_pembayaran)->kaedah; ?></td></tr>
    			</tbody>
    		</table>
    	</li>
	    <li class="list-group-item">
	    	<h5><strong>Barangan / Perkhidmatan / Kerja</strong></h5>
    		<table class="table table-bordered">
    			<thead>
    				<tr><th>Bil</th><th>Justifikasi Keperluan Perolehan<br>(Bekalan / Perkhidmatan / Kerja)</th><th>Kuantiti</th></tr>
    			</thead>
    			<tbody>
    				<?php
    					$i = 1;
    					foreach ($model_barangan as $key => $value) {
    				?>
    				<tr><td><?= $i++; ?></td><td><?= $value->justifikasi ?></td><td><?= $value->kuantiti ?></td></tr>
    				<?php
    					}
    				?>
    			</tbody>
    		</table>
	    </li>
	    <li class="list-group-item">
	    	<h5><strong>Kontraktor / Pembekal</strong></h5>
	    	<table class="table table-bordered">
    			<thead>
    				<tr><th>Bil</th><th>Nama Syarikat & No. ROB/ROC</th><th>Nama Pegawai Untuk Dihubungi & Maklumat Perhubungan</th><th>Jumlah Harga (RM)</th></tr>
    			</thead>
    			<tbody>
    				<?php
    					$i = 1;
    					foreach ($model_pembekal as $key => $value) {
    				?>
    				<tr class="<?= $value->utama ? "success" : ""; ?>">
    					<td><?= $i++; ?><?=  $value->utama ? "<span class=\"glyphicon glyphicon-asterisk\"></span>" : ""; ?></td>
    					<td><?= $value->pembekal ?></td>
    					<td><?= $value->nama_pembekal ?><br><span class="glyphicon glyphicon-phone-alt">Tel: </span><?= $value->no_telefon ?>, <span class="glyphicon glyphicon-envelope">Email:</span> <?= $value->email ?></td>
    					<td class="text-right"><?= $value->harga ?> </td>
    				</tr>
    				<?php
    					}
    				?>
    			</tbody>
    		</table>
	    </li>
	    <li class="list-group-item">
	    	<table class="tables">
	    		<tbody>
	    			<tr>
	    				<td width="50%">
	    					<h5><strong>Peruntukan dikenakan</strong></h5>
	    					<table>
	    						<tr><td class="bordered" width="40px"></td><td> Mengurus (OS ___________ )</td></tr>
	    						<tr><td class="bordered"></td><td> Amanah (Para ______________)</td></tr>
	    						<tr><td class="bordered"></td><td> Pembangunan ( Kod Aktiviti __________ )</td></tr>
	    						<tr><td class="bordered"></td><td>  Lain-Lain (sila nyatakan)________________</td></tr>
	    					</table>
	    				</td>
	    				<td valign="top">
	    					<h5><strong>Dipohon oleh</strong></h5>
	    					<p>&nbsp;</p>
	    					______________________________<br>
	    					( Tandatangan dan cop jawatan)<br>
							Nama : <?= Pengguna::findOne($model->user)->nama ?> <br>
							Tarikh : <?= date('d-m-Y') ?> <br>
	    				</td>
	    			</tr>
	    		</tbody>
	    	</table>
	    </li>
	    <li class="list-group-item">
	    	<table class="tables">
	    		<tbody>
	    			<tr>
	    				<td width="50%">
	    					<h5><strong>Kelulusan Ketua Jabatan / Bahagian / Unit</strong></h5>
	    					<table>
	    						<tr><td class="bordered" width="40px"></td><td>Diluluskan</td></tr>
	    						<tr><td class="bordered"></td><td>Tidak Diluluskan</td></tr>
	    					</table>
	    					<p>&nbsp;</p>
	    					______________________________<br>
	    					( Tandatangan dan cop jawatan)<br>
							Nama : <br>
							Tarikh : <br>
	    				</td>
	    				<td>
	    					<h5><strong>Kelulusan Kewangan</strong></h5>
	    					Ulasan:________________________________________
	    					<p>&nbsp;</p>
	    					______________________________<br>
	    					( Tandatangan dan cop jawatan)<br>
							Nama : <br>
							Tarikh : <br>
	    				</td>
	    			</tr>
	    		</tbody>
	    	</table>
	    </li>
  </ul>
</div>

<?php
$this->registerCss('
	.bordered {
		border: 1px solid black;
	}
');
?>