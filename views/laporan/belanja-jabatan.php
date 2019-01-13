<?php
/* @var $this yii\web\View */
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>

<?php
$currentYear = date("Y"); 
for($i = $currentYear - 5; $i < $currentYear + 5; $i++) {
    $yearList[$i] = $i; 
}
if(!isset($_POST['year']))
	$year = $currentYear;
else
	$year = $_POST['year'];

$sql_jabatan = "SELECT * FROM jabatan ORDER By id";
$jabatan = Yii::$app->db->createCommand($sql_jabatan)->queryAll();
$ringkasan_jabatan= array_column($jabatan, 'ringkasan');
$nama_jabatan= array_column($jabatan, 'jabatan');
$id_jabatan= array_column($jabatan, 'id');

$this->title = 'Laporan Prestasi Perbelanjaan Bahagian '.$year;
$this->params['breadcrumbs'][] = $this->title;
?>
<h2><?= Html::encode($this->title) ?></h2>
<div class="form-group row year">
	<form id="form-year" method="post" class="form-inline">
		<div class="col-xs-4">
			<label>Tahun </label>
			<select class="form-control" name="year" id="select-year">
			<?php
				foreach ($yearList as $key => $value) {
					$selected = $value == $year ? 'selected' : '';
					echo '<option value="'.$value.'" '.$selected.'>'.$value.'</option>';
				}
			?>
			</select>
		</div>
		<input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
	</form>
</div>
<?php
	$sql_waran = "SELECT os As name, SUM(jumlah_waran) AS y FROM waran WHERE tahun=$year GROUP BY os ORDER BY os";
	$row_warans = Yii::$app->db->createCommand($sql_waran)->queryAll();
	$os_agihan = [];
	foreach ($row_warans as $key => $value) {
		array_push($os_agihan, $value["y"]);
	}

	$sql_os_agihan = "SELECT DISTINCT os FROM agihan WHERE tahun='$year' ORDER BY os";
	$os_agihan = Yii::$app->db->createCommand($sql_os_agihan)->queryAll();
	$os_agihan = array_column($os_agihan, 'os');

	$query_perolehan = "SELECT unjuran.os, ROUND(SUM(perolehan.nilai_perolehan), 2) AS lulus_perolehan FROM perolehan LEFT JOIN unjuran ON perolehan.kod_unjuran = unjuran.kod_id WHERE unjuran.tahun='$year' GROUP BY os ORDER BY os";
	// $result_perolehan = mysqli_query($bajet, $query_perolehan);
	// $row_perolehans = mysqli_fetch_all($result_perolehan, MYSQLI_ASSOC);
	$row_perolehans = Yii::$app->db->createCommand($query_perolehan)->queryAll();
	
	$perolehans = [];
	foreach ($row_perolehans as $key => $value) {
		//array_push($perolehans, $value["lulus_perolehan"]);
		$perolehans[$value["os"]] = $value["lulus_perolehan"];
	}

	$ots = [];
	$query_OT = "SELECT unjuran.os, ROUND(SUM(ot.jumlah_kew), 2) AS total_OT FROM ot LEFT JOIN unjuran ON ot.kod_unjuran=unjuran.kod_id  WHERE unjuran.tahun='$year' GROUP BY os ORDER BY os";
	// $result_ot = mysqli_query($bajet, $query_OT);
	// $row_ots =  mysqli_fetch_all($result_ot, MYSQLI_ASSOC);
	$row_ots =  Yii::$app->db->createCommand($query_OT)->queryAll();
	foreach ($row_ots as $key => $value) {
		//array_push($ots, $value["total_OT"]);
		$ots[$value["os"]] = $value["total_OT"];
	}

	$perjalanans = [];
	$query_perjalanan = "SELECT unjuran.os, ROUND(SUM(perjalanan.jumlah_kew), 2) AS total_perjalanan FROM perjalanan LEFT JOIN unjuran ON perjalanan.kod_unjuran=unjuran.kod_id  WHERE unjuran.tahun='$year' GROUP BY os ORDER BY os";
	// $result_perjalanan = mysqli_query($bajet, $query_perjalanan);
	// $row_perjalanans =  mysqli_fetch_all($result_perjalanan, MYSQLI_ASSOC);
	$row_perjalanans =  Yii::$app->db->createCommand($query_perjalanan)->queryAll();
	foreach ($row_perjalanans as $key => $value) {
		$perjalanans[$value["os"]] = $value["total_perjalanan"];
	}

	$penceramahs = [];
	$query_penceramah = "SELECT unjuran.os, ROUND(SUM(penceramah.jumlah_kew), 2) AS total_penceramah FROM penceramah LEFT JOIN unjuran ON penceramah.kod_unjuran=unjuran.kod_id  WHERE unjuran.tahun='$year' GROUP BY os ORDER BY os";
	// $result_penceramah = mysqli_query($bajet, $query_penceramah);
	// $row_penceramahs =  mysqli_fetch_all($result_penceramah, MYSQLI_ASSOC);
	$row_penceramahs =  Yii::$app->db->createCommand($query_penceramah)->queryAll();
	foreach ($row_penceramahs as $key => $value) {
		$penceramahs[$value["os"]] = $value["total_penceramah"];
	}
	// print_r($row_warans);
	$perbelanjaan = [];
	$total_perolehan = [];
	$os_persen = [];
	$baki_belum_belanja = [];
	$i = 0;
	foreach ($row_warans as $key => $value) {
		$sum = 0;
		
		if(array_key_exists($value["name"], $perolehans)) {
			//echo "V:".$value["name"]."#".$value["y"]."<br>";
			$sum +=  $perolehans[$value["name"]];
			//$total_perolehan[] = $perolehans[$value["name"]];
		}
		else {
			//$total_perolehan[] = 0;
		}
		if(array_key_exists($value["name"], $ots)) {
			$sum +=  $ots[$value["name"]];
		}
		if(array_key_exists($value["name"], $perjalanans)) {
			$sum +=  $perjalanans[$value["name"]];
		}
		if(array_key_exists($value["name"], $penceramahs)) {
			$sum +=  $penceramahs[$value["name"]];
		}

		//$perbelanjaan[$value["name"]] = $sum;
		$perbelanjaan[] = $sum;
		if(ctype_digit($value['name']) && $value['name']/1 <= 30000) {
			$perbelanjaan_os1[] = ['name' => $value["name"], "y" => $sum];
		}
		else
			$perbelanjaan_os2[] = ['name' => $value["name"], "y" => $sum];

		// $os_persen[] = $value["name"]." (".number_format((100 * $sum / $os_agihan[$i]), 2)."%)";
		$baki_belum_belanja[] = $os_agihan[$i] - $sum;
		$i++;
	}
	// print_r($perbelanjaan);

?>
<div class="container info tuntutan table-responsive">
	<div class="row">
		<table id="belanja-os-jabatan" class="table table-striped table-hover table-condensed table-bordered">
			<thead>
				<tr>
					<th colspan="2">Bahagian</th>
					<?php
						foreach ($ringkasan_jabatan as $key => $value_jabatan) {
							echo '<th class="text-center"><label title="'.$nama_jabatan[$key].'">'.$value_jabatan.'</label></th>';
						}
					?>
					<th class="text-center">Jumlah</th>
				</tr>
				<tr>
					<th>No</th><th>OS</th>
					<?php
						foreach ($ringkasan_jabatan as $key => $value_jabatan) {
							echo '<th class="text-center"><label title="Belanja / Agihan (%)">B / A (%)</label></th>';
						}
					?>
					<th class="text-center">B / A (%)</th>
				</tr>
			</thead>
			<tbody>
			<?php
				$unjuran_os_jabatan = [];
				$jumlah_permohonan_semua = 0;
				$belanja_jabatan = array_fill(0, count($id_jabatan), 0);

				foreach ($os_agihan as $key_os_agihan => $value_os) {
			?>
				<tr>
					<td><?= ($key_os_agihan + 1) ?></td>	
					<td><?= $value_os ?></td>	
					<?php
						$jumlah_agihan = 0;
						$belanja_os = 0;
						foreach ($id_jabatan as $key_jabatan => $value_id_jabatan) {
							$sql = "SELECT SUM(agihan_jabatan) AS agihan FROM `agihan` WHERE tahun='$year' AND os='$value_os' AND id_jabatan=$value_id_jabatan";
							$agihan_jabatan = Yii::$app->db->createCommand($sql)->queryScalar();
							$jumlah_agihan += $agihan_jabatan;
					?>
						<td class="text-right">
							<?php
								$belanja = belanja($value_id_jabatan, $value_os, $year);
								$belanja_os += $belanja;
								$belanja_jabatan[$key_jabatan] += $belanja;
								$percent = ($agihan_jabatan == 0) ? 0 : $belanja / $agihan_jabatan;
							?>
							<?= number_format($belanja, 2) ?> / 
							<?= number_format($agihan_jabatan, 2).' ('.number_format($percent * 100, 1).')' ?>
						</td>
					<?php
						$unjuran_os_jabatan[$key_os_agihan][$key_jabatan] = $agihan_jabatan;
						}
						$percent_os = $jumlah_agihan == 0 ? 0 : $belanja_os / $jumlah_agihan;
					?>	
					<td class="text-right"><?= number_format($belanja_os, 2).' / '.number_format($jumlah_agihan, 2).' ('.number_format($percent_os * 100, 1).')' ?></td>
				</tr>	
			<?php
					$jumlah_permohonan_semua += $jumlah_agihan;
				}
			?>
			</tbody>
			<tfoot>
				<tr>
					<th colspan="2">Jumlah</th>
					<?php
						$total_belanja = 0;
						foreach ($id_jabatan as $key_jabatan => $value_id_jabatan) {
							$jumlah_agihan_jabatan = array_sum(array_column($unjuran_os_jabatan, $key_jabatan));
							$percent_jabatan = $jumlah_agihan_jabatan == 0 ? 0 : $belanja_jabatan[$key_jabatan] / $jumlah_agihan_jabatan;
							$total_belanja += $belanja_jabatan[$key_jabatan];
							echo '<th class="text-right">'.number_format($belanja_jabatan[$key_jabatan], 2)
								.' / '.number_format($jumlah_agihan_jabatan, 2)
								.' ('.number_format($percent_jabatan * 100, 1).')</th>';
						}
						$total_percent = $jumlah_permohonan_semua == 0 ? 0 : $total_belanja / $jumlah_permohonan_semua;
					?>
					<th class="text-right"><?= number_format($total_belanja, 2).' / '.number_format($jumlah_permohonan_semua, 2).' ('.number_format($total_percent * 100, 1).')' ?></th>
				</tr>
			</tfoot>
		</table>
		<div class="form-group">
			<!-- <button id="excel_btn" class="btn btn-primary btn-kemaskini">Eksport ke Excel</button> -->
			<a id="excel-export" class="btn btn-primary">Eksport ke Excel</a>
		</div>
	</div>
</div>

<?php
function belanja($id_jabatan, $os, $year)
{
	$query_perolehan = "SELECT ROUND(SUM(perolehan.nilai_perolehan), 2) AS belanja FROM perolehan LEFT JOIN unjuran ON perolehan.kod_unjuran = unjuran.kod_id WHERE unjuran.tahun='$year' AND unjuran.os='$os' AND perolehan.id_jabatan=$id_jabatan ";
	$belanja_perolehan = Yii::$app->db->createCommand($query_perolehan)->queryScalar();

	$query_perjalanan = "SELECT ROUND(SUM(perjalanan.jumlah_kew), 2) FROM perjalanan LEFT JOIN unjuran ON perjalanan.kod_unjuran = unjuran.kod_id WHERE unjuran.tahun='$year' AND unjuran.os='$os' AND perjalanan.id_jabatan=$id_jabatan ";
	$belanja_perjalanan = Yii::$app->db->createCommand($query_perjalanan)->queryScalar();

	$query_ot = "SELECT ROUND(SUM(ot.jumlah_kew), 2) FROM ot LEFT JOIN unjuran ON ot.kod_unjuran = unjuran.kod_id WHERE unjuran.tahun='$year' AND unjuran.os='$os' AND ot.id_jabatan=$id_jabatan ";
	$belanja_ot = Yii::$app->db->createCommand($query_ot)->queryScalar();

	$query_penceramah = "SELECT ROUND(SUM(penceramah.jumlah_kew), 2) FROM penceramah LEFT JOIN unjuran ON penceramah.kod_unjuran = unjuran.kod_id WHERE unjuran.tahun='$year' AND unjuran.os='$os' AND penceramah.id_jabatan=$id_jabatan ";
	$belanja_penceramah = Yii::$app->db->createCommand($query_penceramah)->queryScalar();

	$belanja = $belanja_perolehan + $belanja_perjalanan + $belanja_ot + $belanja_penceramah;
	
	return $belanja;
}

?>
<?php
$this->registerJs('
	$("#select-year").change(function(){
		$("#form-year").submit();
	});

	var year = $("#select-year").val();

	$("#excel-export").click(function(e){
		var uri = $("#belanja-os-jabatan").excelexportjs({
            containerid: "belanja-os-jabatan", 
            datatype: "table",
            worksheetName: "Unjuran-OS" + year,
            returnUri: true,
        });
        $(this).attr("download", "Belanja-OS-Jabatan" + year + ".xls") 
               .attr("href", uri)                    
               .attr("target", "_blank") 
	});
');

$this->registerJsFile('@web/js/excelexportjs.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

?>

