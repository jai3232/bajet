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

// $bajet = mysqli_connect('localhost', 'root', '', 'bajet') or trigger_error(mysqli_error($bajet),E_USER_ERROR); 

$sql_unjuran_kod = "SELECT kod, ROUND(SUM(jumlah_unjuran), 2) AS unjuran FROM unjuran WHERE tahun='$year' GROUP BY kod";
$row_unjuran_kod = Yii::$app->db->createCommand($sql_unjuran_kod)->queryAll();
// print_r(json_encode($row_unjuran_kod)); 
// print_r(array_values($row_unjuran_kod));
$unjuran_kod= [];
foreach ($row_unjuran_kod as $key => $value) {
	$value['unjuran'] = $value['unjuran'] / 1;
	$unjuran_kod[] = array_values($value);
}

$sql_unjuran_jabatan_kod = "SELECT id_jabatan, ROUND(SUM(jumlah_unjuran), 2) AS unjuran, kod FROM unjuran WHERE tahun='$year' GROUP BY id_jabatan, kod";
$row_unjuran_jabatan_kod = Yii::$app->db->createCommand($sql_unjuran_jabatan_kod)->queryAll();
// print_r($row_unjuran_jabatan_kod); print("<br><br>");

$kod = ["A", "B", "C", "D"];
// $jabatan = ["bko", "bkp", "kk", "pem", "ppk", "ppl", "spd"];
$sql_jabatan = "SELECT * FROM jabatan ORDER By id";
$jabatan = Yii::$app->db->createCommand($sql_jabatan)->queryAll();
$nama_jabatan= array_column($jabatan, 'jabatan');
$ringkasan_jabatan= array_column($jabatan, 'ringkasan');
$id_jabatan= array_column($jabatan, 'id');
// print_r($row_unjuran_jabatan_kod);
$A = []; $B = []; $C = []; $D = [];
// print_r($nama_jabatan); echo 'XXXX';
// print_r($row_unjuran_jabatan_kod);

$found = false;
for($i = 0; $i < count($kod); $i++) {
	for($j = 0; $j < count($id_jabatan); $j++) {
		foreach ($row_unjuran_jabatan_kod as $key => $value) {
			if($kod[$i] == $value['kod'] && $id_jabatan[$j] == $value['id_jabatan'])
			{
				if($kod[$i] == 'A')
					array_push($A, $value['unjuran']/1);
				if($kod[$i] == 'B')
					array_push($B, $value['unjuran']/1);
				if($kod[$i] == 'C')
					array_push($C, $value['unjuran']/1);
				if($kod[$i] == 'D')
					array_push($D, $value['unjuran']/1);

				$found = true;
				break;
			}
			else
				$found = false;
		}
		if(!$found) {
			if($kod[$i] == 'A')
				array_push($A, 0);
			if($kod[$i] == 'B')
				array_push($B, 0);
			if($kod[$i] == 'C')
				array_push($C, 0);
			if($kod[$i] == 'D')
				array_push($D, 0);
		}
	}
}

$this->title = 'Laporan Unjuran '.$year;
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
<div class="col-sm-12">
	<?php
		echo Highcharts::widget([
		    'options' => [
		    	'chart' => [
		    		'borderColor' => '#ccc',
		    		'borderWidth' => '1',
		    		'borderRadius' => '5',
		    		// 'backgroundColor' => '#eee',
		    		// 'shadow' => true,
		    		'type' => 'line',
		    	],
		        'title' => ['text' => 'Unjuran mengikut kod tahun '.$year],
		        'plotOptions' => [
		            'pie' => [
		                'cursor' => 'pointer',
		                'dataLabels' => [
		                	'enabled' => true,
		                	'format' => '<b>{point.name}</b>: {point.percentage:.1f} %',
		                	// 'style' => [
		                	// 	'color' => ('Highcharts.theme' && 'Highcharts.theme.contrastTextColor') || 'black'
		                	// ],
		                ]
		            ],
		        ],
		        'series' => [
		            [ // new opening bracket
		                'type' => 'pie',
		                'name' => 'RM',
		                'data' => $unjuran_kod,//[[1, 2],[3, 4]],//$data,
		                // [
		                //     // ['Baki Agihan', 1000],
		                // ],
		            ] // new closing bracket
		        ],
		        'credits' => ['enabled' => false],
		        'exporting' => [
		        	'enabled' => false,
		        ]
		    ],
		]);
	?>
</div>
<div class="col-sm-12">
	<?php
		echo Highcharts::widget([
		    'scripts' => [
		        'modules/exporting',
		        'themes/grid-light',
		    ],
		    'options' => [
		        'title' => [
		            'text' => 'Unjuran Mengikut Kod Setiap Bahagian Tahun '.$year,
		        ],
		        'xAxis' => [
		            'categories' => $nama_jabatan,//['Jabatan 1', 'Jabatan 2', 'Jabatan 3', 'Jabatan 4', 'Jabatan 5'],
		            'title' => [
		            	'text' => '<strong>Bahagian</strong>',
		            ]
		        ],
		        'yAxis' => [
		        	'title' => [
		        		'text' => 'RM',
		        	]
		        ],
		        'labels' => [
		            'items' => [
		                [
		                    'html' => 'Jumlah Agihan & Perbelanjaan',
		                    'style' => [
		                        'left' => '50px',
		                        'top' => '18px',
		                        'color' => new JsExpression('(Highcharts.theme && Highcharts.theme.textColor) || "black"'),
		                    ],
		                ],
		            ],
		        ],
		        'series' => [
		            [
		                'type' => 'column',
		                'name' => 'Kod A',
		                'data' => $A, // [23, 32, 43, 121, 4],
		            ],
		            [
		                'type' => 'column',
		                'name' => 'Kod B',
		                'data' => $B, // [23, 32, 43, 121, 5],
		            ],
		            [
		                'type' => 'column',
		                'name' => 'Kod C',
		                'data' => $C, // [23, 32, 43, 121, 22],
		            ],
		            [
		                'type' => 'column',
		                'name' => 'Kod D',
		                'data' => $D, // [23, 32, 43, 121, 34],
		            ],

		        ],
		        'credits' => ['enabled' => false],
		        'exporting' => [
		        	'enabled' => false,
		        ]
		    ]
		]);

	?>
</div>
<?php

// $sql_os_jabatan = "SELECT os, id_jabatan, SUM(jumlah_unjuran) AS unjuran FROM `unjuran` WHERE tahun='2018' GROUP BY os, id_jabatan ORDER BY os, id_jabatan";
// $os_jabatan = Yii::$app->db->createCommand($sql_os_jabatan)->queryAll();
$sql_os_unjuran = "SELECT DISTINCT os FROM unjuran WHERE tahun='$year' ORDER BY os";
$os_unjuran = Yii::$app->db->createCommand($sql_os_unjuran)->queryAll();
// print_r($nama_jabatan);
$os_unjuran = array_column($os_unjuran, 'os');
?>

<h3>Ringkasan Unjuran OS - Bahagian <?= $year ?></h3>
	<div class="container info tuntutan table-responsive">
		<div class="row">
			<table id="unjuran-os" class="table table-striped table-hover table-condensed table-bordered">
				<thead>
					<tr>
						<th>No</th><th>OS</th>
						<?php
							foreach ($ringkasan_jabatan as $key => $value_jabatan) {
								echo '<th class="text-center"><label title="'.$nama_jabatan[$key].'">'.$value_jabatan.'</label></th>';
							}
						?>
						<th>Jumlah Permohonan</th>
					</tr>
				</thead>
				<tbody>
				<?php
					$unjuran_os_jabatan = [];
					$jumlah_permohonan_semua = 0;
					foreach ($os_unjuran as $key_os_unjuran => $value_os) {
				?>
					<tr>
						<td><?= ($key_os_unjuran + 1) ?></td>	
						<td><?= $value_os ?></td>	
						<?php
							$jumlah_permohonan = 0;
							foreach ($id_jabatan as $key_jabatan => $value_id_jabatan) {
								$sql = "SELECT SUM(jumlah_unjuran) AS unjuran FROM `unjuran` WHERE tahun='$year' AND os='$value_os' AND id_jabatan=$value_id_jabatan";
								$unjuran_jabatan = Yii::$app->db->createCommand($sql)->queryScalar();
								$jumlah_permohonan += $unjuran_jabatan;
						?>
							<td class="text-right"><?= number_format($unjuran_jabatan, 2) ?></td>
						<?php
							$unjuran_os_jabatan[$key_os_unjuran][$key_jabatan] = $unjuran_jabatan;
							}
						?>	
						<td class="text-right"><?= number_format($jumlah_permohonan, 2) ?></td>
					</tr>	
				<?php
						$jumlah_permohonan_semua += $jumlah_permohonan;
					}
				?>
				</tbody>
				<tfoot>
					<tr>
						<th colspan="2">Jumlah</th>
						<?php
							foreach ($id_jabatan as $key_jabatan => $value_id_jabatan) {
								echo '<th class="text-right">'.number_format(array_sum(array_column($unjuran_os_jabatan, $key_jabatan)), 2).'</th>';
							}
						?>
						<th class="text-right"><?= number_format($jumlah_permohonan_semua, 2) ?></th>
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
$this->registerJs('
	$("#select-year").change(function(){
		$("#form-year").submit();
	});

	var year = $("#select-year").val();

	$("#excel-export").click(function(e){
		var uri = $("#unjuran-os").excelexportjs({
            containerid: "unjuran-os", 
            datatype: "table",
            worksheetName: "Unjuran-OS" + year,
            returnUri: true,
        });
        $(this).attr("download", "Unjuran" + year + ".xls") 
               .attr("href", uri)                    
               .attr("target", "_blank") 
	});
');

$this->registerJsFile('@web/js/excelexportjs.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

?>
