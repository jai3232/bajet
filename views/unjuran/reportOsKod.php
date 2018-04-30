<?php
/* @var $this yii\web\View */
use yii\widgets\MaskedInput;
use yii\helpers\Url;
use yii\helpers\Html;

$currentYear = date("Y"); 
for($i = $currentYear - 5; $i < $currentYear + 5; $i++) {
    $yearList[$i] = $i; 
}
if(!isset($_POST['year']))
	$year = $currentYear;
else
	$year = $_POST['year'];

$this->title = 'Laporan Unjuran '.$year;
$this->params['breadcrumbs'][] = $this->title;

$jabatans = $jabatan->asArray()->orderBy('ringkasan')->all();
$kod = ['A', 'B', 'C', 'D'];
//$unjurans = $unjuran->select(['os', 'SUM(jumlah_unjuran) AS total'])->where(['tahun' => $year])->groupBy('os')->orderBy('os')->asArray()->all();
$unjurans = \app\models\Unjuran::find()->select(['os', 'SUM(jumlah_unjuran) AS total'])->where(['tahun' => $year])->groupBy('os')->orderBy('os')->asArray()->all();
//print_r($unjurans);	

$report_column = [0 => 'OS'];
$report_column = array_merge($report_column, $kod);
array_push($report_column, 'Jumlah');
array_push($report_column, 'Waran Diterima');
array_push($report_column, 'Keperluan Tambahan <br>(B)');
array_push($report_column, 'Keperluan Tambahan <br>(B+C)');
array_push($report_column, 'Keperluan Tambahan <br>(B+C+D)');

$sub_header = [' ', 1, 2, 3, 4, 5, 6, 7, '8=6-7-4-5', '9=6-7-5', '10=6-7'];

//$reports = Agihan::find()->leftJoin('jabatan', 'agihan.id_jabatan = jabatan.id')->where(['tahun' => $year])->asArray()->orderby('os, jabatan.ringkasan')->all();
//echo json_encode($agihans);

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
<!-- <div class="form-group">
	<button class="btn btn-primary btn-kemaskini">Kemaskini Agihan</button>
</div> -->

<div class="output" style="overflow-y: auto">
<div class="grid-view">
	<table id="unjuran-report" class="table table-condensed table-striped table-bordered table-hover table-responsive">
		<thead class="thead-dark">
			<tr><th>#</th>
				<?php 
					foreach ($report_column as $key => $value) {
						echo '<th class="text-center">'.$value.'</th>';
					}
				?>
			</tr>
			<tr>
				<?php
					foreach ($sub_header as $key => $value) {
						echo '<td class="text-center">'.$value.'</td>';
					}
				?>
			</tr>
		</thead>
		<tbody>
			<!-- <tr data-key="7907"><td>1</td></tr> -->
			<?php 
				$i = 1;
				foreach ($unjurans as $key => $value1) {
					echo '<tr><td>'.$i++.'</td>';
					//$agihan_data = $agihan->where(['os' => $value1['os'], 'tahun' => $year])->asArray()->all();
					//print_r($agihan_data); echo "<br>";
					$jumlah_unjuran_os = 0;
					$value4 = 0; $value5 = 0; $value6 = 0; $value7 = 0;
					foreach ($report_column as $key => $value2) {
						if($value2 == 'OS')
							echo '<td>'.$value1['os'].'</td>';
						elseif($value2 == 'A') {
							$jumlah_unjuran_os_kodA = $unjuran->where(['os' => $value1['os'], 'kod' => $value2, 'tahun' => $year])->sum('jumlah_unjuran');
							$jumlah_unjuran_os += $jumlah_unjuran_os_kodA;
							echo '<td class="text-right columnA">'.number_format($jumlah_unjuran_os_kodA, 2).'</td>';
						}
						elseif($value2 == 'B') {
							$jumlah_unjuran_os_kodB = $unjuran->where(['os' => $value1['os'], 'kod' => $value2, 'tahun' => $year])->sum('jumlah_unjuran');
							$jumlah_unjuran_os += $jumlah_unjuran_os_kodB;
							echo '<td class="text-right columnB">'.number_format($jumlah_unjuran_os_kodB, 2).'</td>';
						}
						elseif($value2 == 'C') {
							$jumlah_unjuran_os_kodC = $unjuran->where(['os' => $value1['os'], 'kod' => $value2, 'tahun' => $year])->sum('jumlah_unjuran');
							$value4 = $jumlah_unjuran_os_kodC;
							$jumlah_unjuran_os += $jumlah_unjuran_os_kodC;
							echo '<td class="text-right columnC">'.number_format($jumlah_unjuran_os_kodC, 2).'</td>';
						}
						elseif($value2 == 'D') {
							$jumlah_unjuran_os_kodD = $unjuran->where(['os' => $value1['os'], 'kod' => $value2, 'tahun' => $year])->sum('jumlah_unjuran');
							$value5 = $jumlah_unjuran_os_kodD;
							$jumlah_unjuran_os += $jumlah_unjuran_os_kodD;
							echo '<td class="text-right columnD">'.number_format($jumlah_unjuran_os_kodD, 2).'</td>';
						}
						elseif($value2 == 'Jumlah') {
							$value6 = $jumlah_unjuran_os;
							echo '<td class="text-right jumlah-os">'.number_format($jumlah_unjuran_os, 2).'</td>';
						}
						elseif ($key == 6) {
							$value7 = $value1['total'];
							echo '<td class="text-right jumlah-waran">'.number_format($value1['total'], 2).'</td>';
						}
						elseif ($key == 7) {
							$value8 = $value6 - $value7 - $value4 - $value5;
							echo '<td class="text-right perluB">'.number_format($value8, 2).'</td>';
						}
						elseif ($key == 8) {
							$value9 = $value6 - $value7 - $value5;
							echo '<td class="text-right perluBC">'.number_format($value9, 2).'</td>';
						}
						elseif ($key == 9) {
							$value10 = $value6 - $value7;
							echo '<td class="text-right perluBCD">'.number_format($value10, 2).'</td>';
						}
						else
							echo '<td>x</td>';

						
					}
					echo '</tr>';
				}
			?>
		</tbody>
		<tfoot>
			<tr>
				<?php
					foreach ($report_column as $key => $value) {
						if($value == 'OS')
							echo '<th colspan="2">Jumlah</th>';
						elseif($key < 6)
							echo '<th id="footer'.$value.'" class="text-right"></th>';
						elseif($key == 6)
							echo '<th id="footer-waran" class="text-right"></th>';
						elseif($key == 7)
							echo '<th id="footer-perluB" class="text-right"></th>';
						elseif($key == 8)
							echo '<th id="footer-perluBC" class="text-right"></th>';
						else
							echo '<th id="footer-perluBCD" class="text-right"></th>';
					}
				?>
			</tr>
		</tfoot>
	</table>
	<div class="form-group">
		<a id="excel-export" class="btn btn-primary">Ekstport ke Excel</a>
	</div>
</div>
</div>

<?php 


$this->registerJs('

	$("#select-year").change(function(){
		$("#form-year").submit();
	});

	Number.prototype.currency = function() {
		return this.valueOf().toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
	};

	var total_columnA = 0;
	var columnA_class = $(".columnA");
	for(var i = 0; i < columnA_class.length; i++) {
		total_columnA += columnA_class.eq(i).text().replace(/,/g, "") / 1;
	}
	$("#footerA").html(total_columnA.currency());

	var total_columnB = 0;
	var columnB_class = $(".columnB");
	for(var i = 0; i < columnB_class.length; i++) {
		total_columnB += columnB_class.eq(i).text().replace(/,/g, "") / 1;
	}
	$("#footerB").html(total_columnB.currency());

	var total_columnC = 0;
	var columnC_class = $(".columnC");
	for(var i = 0; i < columnC_class.length; i++) {
		total_columnC += columnC_class.eq(i).text().replace(/,/g, "") / 1;
	}
	$("#footerC").html(total_columnC.currency());

	var total_columnD = 0;
	var columnD_class = $(".columnD");
	for(var i = 0; i < columnD_class.length; i++) {
		total_columnD += columnD_class.eq(i).text().replace(/,/g, "") / 1;
	}
	$("#footerD").html(total_columnD.currency());

	var total_OS = 0;
	var OS_class = $(".jumlah-os");
	for(var i = 0; i < OS_class.length; i++) {
		total_OS += OS_class.eq(i).text().replace(/,/g, "") / 1;
	}
	$("#footerJumlah").html(total_OS.currency());

	var total_waran = 0;
	var waran_class = $(".jumlah-waran");
	for(var i = 0; i < waran_class.length; i++) {
		total_waran += waran_class.eq(i).text().replace(/,/g, "") / 1;
	}
	$("#footer-waran").html(total_waran.currency());

	var total_perluB = 0;
	var perluB_class = $(".perluB");
	for(var i = 0; i < perluB_class.length; i++) {
		total_perluB += perluB_class.eq(i).text().replace(/,/g, "") / 1;
	}
	$("#footer-perluB").html(total_perluB.currency());

	var total_perluBC = 0;
	var perluBC_class = $(".perluBC");
	for(var i = 0; i < perluBC_class.length; i++) {
		total_perluBC += perluBC_class.eq(i).text().replace(/,/g, "") / 1;
	}
	$("#footer-perluBC").html(total_perluBC.currency());

	var total_perluBCD = 0;
	var perluBCD_class = $(".perluBCD");
	for(var i = 0; i < perluBCD_class.length; i++) {
		total_perluBCD += perluBCD_class.eq(i).text().replace(/,/g, "") / 1;
	}
	$("#footer-perluBCD").html(total_perluBCD.currency());

	var year = $("#select-year").val();

	$("#excel-export").click(function(e){
		var uri = $("#unjuran-report").excelexportjs({
            containerid: "unjuran-report", 
            datatype: "table",
            worksheetName: "Unjuran"+year,
            returnUri: true,
        });
        $(this).attr("download", "Unjuran" + year + ".xls") 
               .attr("href", uri)                    
               .attr("target", "_blank") 
	});
');

$this->registerJsFile('@web/js/excelexportjs.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>
