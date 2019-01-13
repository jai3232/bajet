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

// WARAN MENGIKUT OS

$sql_waran = "SELECT os As name, SUM(jumlah_waran) AS y FROM waran WHERE tahun=$year GROUP BY os ORDER BY os";
// $row_warans = mysqli_fetch_all($result_waran, MYSQLI_ASSOC);
$row_warans = Yii::$app->db->createCommand($sql_waran)->queryAll();

$waran_counter1  = 0;
$waran_counter2  = 0;
$row_warans1 = [];
$row_warans2 = [];
foreach ($row_warans as $key => $value) {
	if(ctype_digit($value['name']) && $value['name']/1 <= 30000) {
		$row_warans1[$waran_counter1]['name'] = $row_warans[$key]['name']; 
		$row_warans1[$waran_counter1]['y'] = $row_warans[$key]['y'] /1; 
		$waran_counter1++;

	}
	else {
		$row_warans2[$waran_counter2]['name'] = $row_warans[$key]['name']; 
		$row_warans2[$waran_counter2]['y'] = $row_warans[$key]['y'] /1; 
		$waran_counter2++;
	}

}

$this->title = 'Laporan Agihan '.$year;
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
<!-- Agihan Waran Mengikut OS 11000 - 30000 -->
<div class="row">
	<div class="col-sm-6">
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
			        'title' => ['text' => 'Agihan Waran Mengikut OS 11000 - 30000 Tahun '.$year],
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
			                'data' => $row_warans1,//[[1, 2],[3, 4]],//$data,
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
	<!-- Agihan Waran Mengikut OS 40000 +++ -->
	<div class="col-sm-6">
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
			        'title' => ['text' => 'Agihan Waran Mengikut OS 40000 - * Tahun '.$year],
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
			                'data' => $row_warans2,//[[1, 2],[3, 4]],//$data,
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
</div>
<?php
	$os_agihan = [];
	foreach ($row_warans as $key => $value) {
		array_push($os_agihan, $value["y"]);
	}

	// $os = []; $baki_agihan = [];
	// foreach ($row_agihans as $key => $value) {
	// 	array_push($os, $value["os"]);
	// 	// array_push($bkp, $value["bkp"]);
	// 	// array_push($bko, $value["bko"]);
	// 	// array_push($kk, $value["kk"]);
	// 	// array_push($pem, $value["pem"]);
	// 	// array_push($ppk, $value["ppk"]);
	// 	// array_push($ppl, $value["ppl"]);
	// 	// array_push($spd, $value["spd"]);
	// 	array_push($baki_agihan, $value["baki"]);
	// }
	// $query_os = "SELECT os FROM agihan WHERE tahun='$year' AND os IN (SELECT DISTINCT os FROM waran WHERE tahun='$year') ORDER BY agihan.os";
	// $os = Yii::$app->db->createCommand($query_os)->queryAll();
	// print_r($os);

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
		$os_persen[] = $value["name"]." (".number_format((100 * $sum / $os_agihan[$i]), 2)."%)";
		$baki_belum_belanja[] = $os_agihan[$i] - $sum;
		$i++;
	}
?>
<div id="perbelanjaan-agihan" style="min-width: 310px; max-width: 1600px; height: 700px; margin: 0 auto"></div>
<script type="text/javascript">
	// Highcharts.chart('perbelanjaan-agihan', {

	//     title: {
	//         text: 'Agihan dan Perbelanjaan mengikut OS'
	//     },
	//     // subtitle: {
	//     //     text: 'Source: thesolarfoundation.com'
	//     // },
	//      xAxis: {
	//         categories: <?= json_encode($os_persen); ?>// ['Apples', 'Oranges', 'Pears', 'Grapes', 'Bananas']
	//     },
	//     yAxis: {
	//         title: {
	//             text: 'RM'
	//         }
	//     },
	//     legend: {
	//         layout: 'vertical',
	//         align: 'right',
	//         verticalAlign: 'middle'
	//     },

	//     // plotOptions: {
	//     //     series: {
	//     //         label: {
	//     //             connectorAllowed: false
	//     //         },
	//     //         pointStart: 2010
	//     //     }
	//     // },
	//     plotOptions: {
	//         series: {
	//             label: {
 //                	connectorAllowed: false
 //            	},	
 //            	allowPointSelect: true,
	//             cursor: 'pointer',
	//             dashStyle: 'dash',
	//             dataLabels: {
	//                 enabled: true,
	//                 format: '<b>{point.y:,.0f}</b>',
	//                 style: {
	//                     color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
	//                 },
	//                 allowOverlap: true,
	//             }
	//         }
	//     },

	//     series: [{
	//         name: 'Agihan',
	//         data: <?= str_replace('"', '', json_encode($os_agihan)) ?>, //[43934, 52503, 57177, 69658, 97031, 119931, 137133, 154175]
	//         color: 'green',
	//         dataLabels: {
 //                y: -35,
 //                x: 0,
 //                color: 'green'
	//         },
	//     }, {
	//         name: 'Perbelanjaan',
	//         data: <?= str_replace('"', '', json_encode($perbelanjaan)) ?>, //[14222916, 24064, 29742, 29851, 32490, 30282, 38121, 40434]
	//         color: 'black',
	//         dataLabels: {
 //                y: 30,
 //                x: 0,
 //                color: 'black',
	//         }
	//     }/*, {
	//         name: 'Perolehan',
	//         data: <?= str_replace('"', '', json_encode($total_perolehan)) ?> //[14222916, 24064, 29742, 29851, 32490, 30282, 38121, 40434]
	//     }*/],

	//     responsive: {
	//         rules: [{
	//             condition: {
	//                 maxWidth: 500
	//             },
	//             chartOptions: {
	//                 legend: {
	//                     layout: 'horizontal',
	//                     align: 'center',
	//                     verticalAlign: 'bottom'
	//                 }
	//             }
	//         }]
	//     }

	// });
</script>
<?php

$this->registerJs('
	$("#select-year").change(function(){
		$("#form-year").submit();
	});


	Highcharts.chart("perbelanjaan-agihan", {

	    title: {
	        text: "Agihan mengikut OS"
	    },
	    // subtitle: {
	    //     text: "Source: thesolarfoundation.com"
	    // },
	     xAxis: {
	        categories: '.json_encode($os_persen).'
	    },
	    yAxis: {
	        title: {
	            text: "RM"
	        }
	    },
	    legend: {
	        layout: "vertical",
	        align: "right",
	        verticalAlign: "middle"
	    },

	    // plotOptions: {
	    //     series: {
	    //         label: {
	    //             connectorAllowed: false
	    //         },
	    //         pointStart: 2010
	    //     }
	    // },
	    plotOptions: {
	        series: {
	            label: {
	            	connectorAllowed: false
	        	},	
	        	allowPointSelect: true,
	            cursor: "pointer",
	            dashStyle: "dash",
	            dataLabels: {
	                enabled: true,
	                format: "<b>{point.y:,.0f}</b>",
	                style: {
	                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || "black"
	                },
	                allowOverlap: true,
	            }
	        }
	    },

	    series: [{
	        name: "Agihan",
	        data: '.str_replace("\"", "", json_encode($os_agihan)).', //[43934, 52503, 57177, 69658, 97031, 119931, 137133, 154175]
	        color: "green",
	        dataLabels: {
	            y: -35,
	            x: 0,
	            color: "green"
	        },
	    }, 
	    /*{
	        name: "Perbelanjaan",
	        data: '.str_replace("\"", "", json_encode($perbelanjaan)).', //[14222916, 24064, 29742, 29851, 32490, 30282, 38121, 40434]
	        color: "black",
	        dataLabels: {
	            y: 30,
	            x: 0,
	            color: "black",
	        }
	    }*/],

	    responsive: {
	        rules: [{
	            condition: {
	                maxWidth: 500
	            },
	            chartOptions: {
	                legend: {
	                    layout: "horizontal",
	                    align: "center",
	                    verticalAlign: "bottom"
	                }
	            }
	        }]
	    }

	});
');

?>

