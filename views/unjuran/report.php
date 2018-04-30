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
// $unjurans = $unjuran->select(['os', 'SUM(id) AS total'])->where(['tahun' => $year])->groupBy('os')->orderBy('os')->asArray()->all();

$unjurans = \app\models\Unjuran::find()->select(['os', 'SUM(jumlah_unjuran) AS total'])->where(['tahun' => $year])->groupBy('os')->orderBy('os')->asArray()->all();
//print_r($unjurans);	

$report_column = [0 => ['id' => -1, 'jabatan' => 'OS', 'ringkasan' => 'OS']];
$report_column = array_merge($report_column, $jabatans);
array_push($report_column, ['id' => -2, 'jabatan' => 'Jumlah', 'ringkasan' => 'Jumlah Unjuran']);
//array_push($report_column, ['id' => -3, 'jabatan' => 'Mohon Bajet', 'ringkasan' => 'Mohon Bajet']);
array_push($report_column, ['id' => -3, 'jabatan' => 'Jumlah Waran', 'ringkasan' => 'Jumlah Waran']);
array_push($report_column, ['id' => -4, 'jabatan' => 'Perbezaan', 'ringkasan' => 'Perbezaan']);

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
<?php




?>
<div id="unjuran-grid" class="grid-view">
	<table id="unjuran-report" class="table table-condensed table-striped table-bordered table-hover table-responsive">
		<thead class="thead-dark">
			<tr><th>#</th>
				<?php 
					foreach ($report_column as $key => $value) {
						echo "<th>".$value['ringkasan']."</th>";
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

					foreach ($report_column as $key => $value2) {
						$class = '';
						if($value2['jabatan'] == 'OS') {
							$value2['jabatan'] = $value1['os'];
						}
						if($value2['jabatan'] == 'Jumlah Waran'){
							$value2['jabatan'] = number_format($value1['total'], 2); 
							$class = 'class="text-right waran" id="waran-'.$value1['os'].'"';
						}
						if($value2['jabatan'] == 'Perbezaan') {
							$jumlah_unjuran_os = $unjuran->where(['os' => $value1['os'], 'tahun' => $year])->sum('jumlah_unjuran');
							$value2['jabatan'] = number_format($value1['total'] - $jumlah_unjuran_os, 2); 
							$class = 'class="text-right perbezaan" id="perbezaan-'.$value1['os'].'"';	
						}
						if($value2['id'] <= 0) {
							if($value2['jabatan'] == 'Jumlah') {
								//$jumlah_unjuran_os = $unjuran->select('SUM(jumlah_unjuran) AS')
								$jumlah_unjuran_os = $unjuran->where(['os' => $value1['os'], 'tahun' => $year])->sum('jumlah_unjuran');
								echo '<td id="jumlah-'.$value1['os']
									 .'" class="text-right jumlah'.$value2['id']
									 .'">'.number_format($jumlah_unjuran_os).'</td>';
							}
							elseif($value2['jabatan'] == 'Baki')
								echo '<td id="baki-'.$value1['os'].'" class="text-right baki'.$value2['id'].'"></td>';
							else
								echo '<td '.$class.'>'.$value2['jabatan'].'</td>';
						}
						else {
							$jumlah_unjuran_jabatan = $unjuran->where([
								'os' => $value1['os'], 
								'tahun' => $year,
								'id_jabatan' => $value2['id'],
							])->sum('jumlah_unjuran');
							echo '<td class="text-right">'.number_format($jumlah_unjuran_jabatan).'</td>';
						}
						
					}
					echo '</tr>';
				}
			?>
		</tbody>
		<tfoot>
			<tr>
				<?php
					foreach ($report_column as $key => $value) {
						if($value['ringkasan'] == 'OS')
							echo '<th colspan="2">Jumlah</th>';
						elseif($value['id'] > 0) {
							$jumlah_semua_unjuran_jabatan = $unjuran->where([ 
								'tahun' => $year,
								'id_jabatan' => $value['id'],
							])->sum('jumlah_unjuran');
							echo '<th id="footer'.$value['id'].'" class="text-right">'
								 .number_format($jumlah_semua_unjuran_jabatan).'</th>';
						}
						else
							echo '<th id="footer'.$value['id'].'" class="text-right"></th>';
					}
				?>
			</tr>
		</tfoot>
	</table>
	<div class="form-group">
		<!-- <button id="excel_btn" class="btn btn-primary btn-kemaskini">Eksport ke Excel</button> -->
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

	var jumlah = 0;
	var class_jumlah = $(".jumlah-2");
	for(var i = 0; i < class_jumlah.length; i++) {
		jumlah += class_jumlah.eq(i).text().replace(/,/g, "") / 1;
	}
	$("#footer-2").html(jumlah.currency());

	var jumlah_waran = 0;
	var class_waran = $(".waran");
	for(var i = 0; i < class_waran.length; i++) {
		jumlah_waran += class_waran.eq(i).text().replace(/,/g, "") / 1;
	}
	$("#footer-3").html(jumlah_waran.currency());

	var jumlah_perbezaan = 0;
	var class_perbezaan = $(".perbezaan");
	for(var i = 0; i < class_perbezaan.length; i++) {
		jumlah_perbezaan += class_perbezaan.eq(i).text().replace(/,/g, "") / 1;
	}
	$("#footer-4").html(jumlah_perbezaan.currency());

	var year = $("#select-year").val();

	$("#excel-export").click(function(e){
		var uri = $("#unjuran-report").excelexportjs({
            containerid: "unjuran-report", 
            datatype: "table",
            worksheetName: "Unjuran" + year,
            returnUri: true,
        });
        $(this).attr("download", "Unjuran" + year + ".xls") 
               .attr("href", uri)                    
               .attr("target", "_blank") 
	});


	//EXPORT WITH HTML FORMAT
	/*$("#excel_btn").click(function(e) {
	 	let file = new Blob([$("#unjuran-grid").html()], {type:"application/vnd.ms-excel"});

		let url = URL.createObjectURL(file);

		let a = $("<a />", {
		  href: url,
		  download: "filename.xls"
		})
		.appendTo("body")
		.get(0)
		.click();
	  	e.preventDefault();
	});*/




');

//$this->registerJsFile('@web/js/jquery.table2excel.min.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('@web/js/excelexportjs.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>
