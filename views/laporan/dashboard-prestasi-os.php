<?php
use app\models\Pengguna;
use app\models\Jabatan;
use app\models\Unit;
use app\models\KumpulanPengguna;
use app\models\Perjalanan;
use app\models\Penceramah;
use app\models\Ot;
use yii\helpers\Html;
use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;

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

$this->title = 'Prestasi OS Bahagian '.$year;
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
<div class="chart table-responsive" style="overflow-x: auto; margin-top: 10px;">
	<?php
		$sql_agihan_jabatan_os = "SELECT os, SUM(agihan_jabatan) AS agihan_jabatan FROM agihan WHERE tahun='$year' AND agihan_jabatan > 0 GROUP BY os  ORDER BY os";
		$agihan_jabatan_os = Yii::$app->db->createCommand($sql_agihan_jabatan_os)->queryAll();
		// print_r($agihan_jabatan_os);
	?>
	<div class="row">
		<?php
			$sql_belanja_perolehan = "SELECT unjuran.os, SUM(nilai_perolehan) AS belanja FROM `perolehan` RIGHT JOIN unjuran on unjuran.kod_id = perolehan.kod_unjuran WHERE perolehan.tahun='$year' GROUP by unjuran.os ORDER by unjuran.os";
			$belanja_perolehan = Yii::$app->db->createCommand($sql_belanja_perolehan)->queryAll();

			$sql_belanja_perjalanan = "SELECT unjuran.os, SUM(jumlah_kew) AS belanja FROM `perjalanan` RIGHT JOIN unjuran on unjuran.kod_id = perjalanan.kod_unjuran WHERE perjalanan.tahun='$year' GROUP by unjuran.os ORDER by unjuran.os";
			$belanja_perjalanan = Yii::$app->db->createCommand($sql_belanja_perjalanan)->queryAll();

			$sql_belanja_ot = "SELECT unjuran.os, SUM(jumlah_kew) AS belanja FROM `ot` RIGHT JOIN unjuran on unjuran.kod_id = ot.kod_unjuran WHERE ot.tahun='$year' GROUP by unjuran.os ORDER by unjuran.os";
			$belanja_ot = Yii::$app->db->createCommand($sql_belanja_ot)->queryAll();

			$sql_belanja_penceramah = "SELECT unjuran.os, SUM(jumlah_kew) AS belanja FROM `penceramah` RIGHT JOIN unjuran on unjuran.kod_id = penceramah.kod_unjuran WHERE penceramah.tahun='$year' GROUP by unjuran.os ORDER by unjuran.os";
			$belanja_penceramah = Yii::$app->db->createCommand($sql_belanja_penceramah)->queryAll();

			// print_r($belanja_perolehan);
			// echo '<br><br>';
			// print_r($belanja_perjalanan);
			// echo '<br><br>';
			// print_r($belanja_ot);
			// echo '<br><br>';
			// print_r($belanja_penceramah);
			// echo '<br><br>';
			// $testval = [];
			foreach ($agihan_jabatan_os as $key => $value) {
				$index_perolehan = array_search($value['os'], array_column($belanja_perolehan, 'os'));
				if($index_perolehan === false)
					$agihan_jabatan_os[$key]['belanja'] = 0;
				else
					$agihan_jabatan_os[$key]['belanja'] = $belanja_perolehan[$index_perolehan]['belanja']/1;

				$index_perjalanan = array_search($value['os'], array_column($belanja_perjalanan, 'os'));
				if($index_perjalanan === false)
					$agihan_jabatan_os[$key]['belanja'] += 0;
				else
					$agihan_jabatan_os[$key]['belanja'] += $belanja_perjalanan[$index_perjalanan]['belanja']/1;

				$index_ot = array_search($value['os'], array_column($belanja_ot, 'os'));
				if($index_ot === false)
					$agihan_jabatan_os[$key]['belanja'] += 0;
				else
					$agihan_jabatan_os[$key]['belanja'] += $belanja_ot[$index_ot]['belanja']/1;

				$index_penceramah = array_search($value['os'], array_column($belanja_penceramah, 'os'));
				if($index_penceramah === false)
					$agihan_jabatan_os[$key]['belanja'] += 0;
				else
					$agihan_jabatan_os[$key]['belanja'] += $belanja_penceramah[$index_penceramah]['belanja']/1;
			
			}
			// print_r($val);echo 'val:'.$val.', os:'.$value['os'].'#';
			// print_r($agihan_jabatan_os);
			// print_r($testval);
			// for($k = 0; $k < sizeof($agihan_jabatan_os); $k++) {
			foreach ($agihan_jabatan_os as $key => $value) {
				// $agihan_jabatan_os[$key]['belanja'] = 1000 * $key;
				// array_push($agihan_jabatan_os[$k], ['belanja' => 1000]);
				$value = $agihan_jabatan_os[$key];
		?>
			<div class="col-sm-4">
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
					        'title' => ['text' => 'OS: '.$value['os']],
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
					                'name' => 'Elements',
					                'data' => [
					                    ['Baki Agihan', ($value['agihan_jabatan']/1 - $value['belanja']/1)],
					                    ['Belanja', $value['belanja']/1],
					                ],
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
		<?php
			}
			// print_r($agihan_jabatan_os);
		?>			
	</div>
</div>
<?php
$this->registerCss('
	.info {
		width: 100%;
		background: #eee;
		border-radius: 5px;
		-webkit-box-shadow: 2px 2px 8px 0px rgba(94,94,94,0.78);
    	box-shadow: 2px 2px 8px 0px rgba(94,94,94,0.78);

	}
	#table-personal {
		margin: 15px;
		font-weight: bold;
	}

	ol.pembekal, ol.barangan {
		margin: 0;
		padding: 15px;
	}
	/*
	@media screen and (min-width: 768px) {
	    body { padding-top: 70px; }
	} */
	@media (max-width:992px) and (min-width:768px) {
		body { padding-top: 70px; }
	}
	@media (max-width:1200px) and (min-width:992px) {
		body { padding-top: 30px; }
	}
');

?>

<?php
$this->registerJs('
	$("#select-year").change(function(){
		$("#form-year").submit();
	});

	var year = $("#select-year").val();	
');


?>
