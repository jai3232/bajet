<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Pengguna;

$currentYear = date("Y"); 
for($i = $currentYear - 5; $i < $currentYear + 5; $i++) {
    $yearList[$i] = $i; 
}
if(!isset($_POST['year']))
	$year = $currentYear;
else
	$year = $_POST['year'];

$currentMonth = date("m");
if(!isset($_POST['month']))
    $selectedMonth = $currentMonth;
else
    $selectedMonth =  $_POST['month'];

$months = [
            '' => '',
            '01' => 'Jan', '02' => 'Feb', '03' => 'Mac', '04' => 'Apr', '05' => 'Mei', '06' => 'Jun',
            '07' => 'Jul', '08' => 'Ogos', '09' => 'Sep', '10' => 'Okt', '11' => 'Nov', '12' => 'Dis'
          ];

$this->title = Yii::t('app', 'Kajian Pasaran ').$months[$selectedMonth].' '.$year;
$this->params['breadcrumbs'][] = $this->title;

$ym = $year.'-'.$selectedMonth;
if($selectedMonth == '')
	$ym = '';

$query_perolehan = "SELECT id, kod_id, id_jabatan, tarikh_jadi, catatan1, user FROM perolehan WHERE tarikh_jadi LIKE '$ym%' AND (kaedah_pembayaran = 1 OR kaedah_pembayaran = 2) AND nilai_perolehan > 0 ORDER BY tarikh_jadi";
$row_perolehan =  Yii::$app->db->createCommand($query_perolehan)->queryAll();
$i = 0;

?>

<h2><?= Html::encode($this->title) ?></h2>
<div class="form-group row year">
	<form id="form-year" method="post" class="form-inline">
		<div class="col-xs-4 form-inline">
			<label>Tahun </label>
			<select class="form-control" name="year" id="select-year">
			<?php
				foreach ($yearList as $key => $value) {
					$selected = $value == $year ? 'selected' : '';

					echo '<option value="'.$value.'" '.$selected.'>'.$value.'</option>';
				}
			?>
			</select>
			<label>Bulan </label>
			<select class="form-control" name="month" id="select-month">
			<?php
				foreach ($months as $key => $value) {
					$selected = $key == $selectedMonth ? 'selected' : '';

					echo '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
				}
			?>
			</select>
		</div>
		<input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
	</form>
</div>
<?php
if(count($row_perolehan) > 0) {
?>
<div class="container info tuntutan table-responsive">
	<div class="row">
		<table id="belanja-os-jabatan" class="table table-striped table-hover table-condensed table-bordered">
			<thead>
				<tr>
					<th rowspan="2" scope="col" c>BIL</th>
					<th rowspan="2" scope="col">TARIKH <br>KAJIAN PASARAN</th>
					<th rowspan="2" scope="col">NAMA PEMBEKAL</th>
					<th colspan="2" scope="col" class="text-center">PERIHAL PEROLEHAN</th>
					<th colspan="2" scope="col">HARGA (RM)</th>
					<th rowspan="2" scope="col" width="100">*HARGA BERPATUTAN<br>(Berdasarkan harga anggaran yang disyorkan)</th>
					<th rowspan="2" scope="col">**KAEDAH KAJIAN PASARAN</th>
					<th rowspan="2" scope="col">CATATAN</th>
					<th rowspan="2" scope="col">Pemohon</th>
				</tr>
				<tr>
					<th scope="col" width="300" class="text-center">NAMA</th>
					<th scope="col">KUANTITI</th>
					<th scope="col">SEUNIT</th>
					<th scope="col">NILAI PEROLEHAN</th>
				</tr>
			</thead>
			<tbody>
			<?php
				foreach ($row_perolehan as $key => $value_perolehan) {
			?>
				<tr>
					<td><?= $key + 1 ?></td>
					<td><?= Yii::$app->formatter->asDate(substr($value_perolehan['tarikh_jadi'], 0, 10)) ?></td>
					<td>
						<ul>
						<?php
							$query_pembekal = "SELECT * FROM pembekal WHERE id_perolehan = '".$value_perolehan['id']."'";
							$pembekal =  Yii::$app->db->createCommand($query_pembekal)->queryAll();
							$utama = array();
							$harga = array();
							foreach ($pembekal as $key => $value) {
								echo "<li>".$value['pembekal']."</li>";
								array_push($utama, $value['utama']);
								array_push($harga, $value['harga']);					
							}
						?>
						</ul>
					</td>
					<td>
						<ul>
						<?php
							$query_barangan = "SELECT * FROM barangan WHERE id_perolehan = '".$value_perolehan['id']."'";
							$barangan = Yii::$app->db->createCommand($query_barangan)->queryAll();
							$kuantiti = array();
							foreach ($barangan as $key => $value) {
								echo "<li>".$value['justifikasi']."</li>";
								array_push($kuantiti, $value['kuantiti']);
							}

						?>
						</ul>
					</td>
					<td>
						<?php 
							$jumlah_kuantiti = 0;
							foreach ($kuantiti as $key => $value) {
								echo $value.'<br>';
								$jumlah_kuantiti += $value;
							}
						?>
					</td>
					<td>
						<?php 
							foreach ($harga as $key => $value) {
								echo number_format($value / $jumlah_kuantiti, 2).'<br>';
							}
						?>
					</td>
					<td>
						<?php 
							foreach ($harga as $key => $value) {
								echo number_format($value, 2).'<br>';
							}
						?>
					</td>
					<td>
						<?php
						  	foreach($utama as $u) {
								if($u == 1)
									echo "/<br />";
								else
									echo "X<br />";	
							}
		  				?>
					</td>
					<td>
						Sebutharga Pembekal						 
					</td>
					<td>
						<?= $value_perolehan['catatan1'] == null ? '-' : $value_perolehan['catatan1'] ?>
					</td>
					<td>
						<?php 
							echo Pengguna::findOne($value_perolehan['user'])->nama;
						?>
					</td>
				</tr>
			<?php 
				}
			?>
			</tbody>
		</table>
	</div>
</div>

<?php 
} // close if (count($row_Perolehan))
else {
	echo '<h4>Tiada rekod</h4>';
}

$this->registerJs('
	$("#select-year, #select-month").change(function(){
		$("#form-year").submit();
	});
');

$this->registerCss('
	.table > thead > tr > th {
	     vertical-align: middle;
	}
	ul {
		margin: 0;
		padding: 0;
		padding-left: 13px;
	}
');
?>