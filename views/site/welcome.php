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

$user_id = Yii::$app->user->identity->id;
$id_jabatan_pengguna = Yii::$app->user->identity->id_jabatan;
$year = date('Y');
$model = Pengguna::findOne($user_id);

$sql = "SELECT * FROM perjalanan WHERE user=$user_id AND tahun='".$year
	  ."' AND (status = 'A' OR status = 'X')";
$perjalanan = Yii::$app->db->createCommand($sql)->queryAll();
$sql = "SELECT * FROM penceramah WHERE user=$user_id AND tahun='".$year
	  ."' AND status = 'A'";
$penceramah = Yii::$app->db->createCommand($sql)->queryAll();
$sql = "SELECT * FROM ot WHERE user=$user_id AND tahun='".$year
	  ."' AND status = 'A'";
$ot= Yii::$app->db->createCommand($sql)->queryAll();

$sql = "SELECT *, perolehan.id AS pid, perolehan.kod_id AS pkod_id FROM perolehan RIGHT JOIN unjuran ON unjuran.kod_id=perolehan.kod_unjuran "
	  // ."LEFT JOIN pembekal ON pembekal.id_perolehan = perolehan.id "
	  // ."LEFT JOIN barangan ON barangan.id_perolehan = perolehan.id "
	  // ."LEFT JOIN panjar ON panjar.id_perolehan = perolehan.id "
	  ."WHERE perolehan.user=$user_id AND perolehan.tahun='".$year."' AND status_kewangan = 0";
$perolehan = Yii::$app->db->createCommand($sql)->queryAll();
// echo "XX:".Yii::$app->conf->getConfig('smtp').':'.Yii::$app->conf->getConfig('port');
// print_r(Yii::$app->conf->getConfig('port'));
?>

<div class="welcome-index">
	<h3>Maklumat personal</h3>
	<div class="container info personal">
		<div class="row">
			<div class="col-sm-3">
				<?php
					$photo = 'personal.png';
					if($model->photo != null)
						$photo = $model->photo;
				?>
				<?= Html::img('uploads/pengguna/'.$photo, 
						[
							'width' => 150, 
							'height' => 150,
							'style' => [
											'margin' => '10px', 
											'border-radius' => '50%',
											'border' => '1px solid #666',
											'box-shadow' => '2px 2px 8px 0px rgba(94,94,94,0.78)',
										]
						]); 

				?>
			</div>
			<div class="col-sm-9">
				<table id="table-personal">
					<tbody>
						<tr>
							<td>
								Nama 
							</td>
							<td>&nbsp;:&nbsp;</td>
							<td>
								<?= $model->nama ?>
							</td>
						</tr>
						<tr>
							<td>
								No. KP 
							</td>
							<td>&nbsp;:&nbsp;</td>
							<td>
								<?= $model->no_kp ?>
							</td>
						</tr>
						<tr>
							<td>
								Jabatan / Unit 
							</td>
							<td>&nbsp;:&nbsp;</td>
							<td>
								<?= Jabatan::findOne($model->id_jabatan)->jabatan.' / '.Unit::findOne($model->id_unit)->unit ?>
							</td>
						</tr>
						<tr>
							<td>
								Emel 
							</td>
							<td>&nbsp;:&nbsp;</td>
							<td>
								<?= $model->emel ?>
							</td>
						</tr>
						<tr>
							<td>
								Level
							</td>
							<td>&nbsp;:&nbsp;</td>
							<td>
								<?= KumpulanPengguna::findOne($model->level)->butiran ?>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="chart table-responsive" style="overflow-x: auto; margin-top: 10px;">
		<?php
			$jabatans = Jabatan::find()->select(['id', 'jabatan'])->asArray()->orderBy('id')->all();
			$jabatan = array_column($jabatans, 'jabatan');
			$id_jabatan = array_column($jabatans, 'id');

			$sql_chart = "SELECT id_jabatan, ROUND(SUM(agihan_jabatan), 2) AS agihan FROM `agihan` "
						."WHERE tahun = ".$year." GROUP BY id_jabatan"
						." ORDER BY id_jabatan";
			$agihan_jabatans = Yii::$app->db->createCommand($sql_chart)->queryAll();

			$agihan_jabatans = array_column($agihan_jabatans, 'agihan'); //multi to single
			$agihan_jabatans = array_map('intval', $agihan_jabatans); // to intiger
			$jumlah_agihan = array_sum($agihan_jabatans);

			$sql_perolehan = "SELECT id_jabatan, ROUND(SUM(nilai_perolehan), 2) AS nilai FROM `perolehan` WHERE tahun = ".$year." GROUP BY id_jabatan ORDER BY id_jabatan";
			$perolehan_jabatan = Yii::$app->db->createCommand($sql_perolehan)->queryAll();
			// $perolehan_jabatan = array_column($perolehan_jabatan, 'nilai'); //multi to single
			// $perolehan_jabatan = array_map('intval', $perolehan_jabatan); // to intiger
			// print_r($perolehan_jabatan);

			$sql_perjalanan = "SELECT id_jabatan, ROUND(SUM(jumlah_kew), 2) AS nilai FROM perjalanan WHERE tahun = ".$year." GROUP BY id_jabatan ORDER BY id_jabatan";
			$perjalanan_jabatan = Yii::$app->db->createCommand($sql_perjalanan)->queryAll();

			$sql_ot = "SELECT id_jabatan, ROUND(SUM(jumlah_kew), 2) AS nilai FROM ot WHERE tahun = ".$year." GROUP BY id_jabatan ORDER BY id_jabatan";
			$ot_jabatan = Yii::$app->db->createCommand($sql_ot)->queryAll();

			$sql_penceramah = "SELECT id_jabatan, ROUND(SUM(jumlah_kew), 2) AS nilai FROM penceramah WHERE tahun = ".$year." GROUP BY id_jabatan ORDER BY id_jabatan";
			$penceramah_jabatan = Yii::$app->db->createCommand($sql_penceramah)->queryAll();

			$jumlah_perolehan = array_sum(array_column($perolehan_jabatan, 'nilai'));
			$jumlah_perjalanan = array_sum(array_column($perjalanan_jabatan, 'nilai'));
			$jumlah_ot = array_sum(array_column($ot_jabatan, 'nilai'));
			$jumlah_penceramah = array_sum(array_column($penceramah_jabatan, 'nilai'));
			$jumlah_perbelanjaan = $jumlah_perolehan + $jumlah_perjalanan + $jumlah_ot + $jumlah_penceramah;

			$belanja_jabatan = [];
			foreach ($id_jabatan as $key => $value_id_jabatan) {
				$belanja_jabatan[] = 0;
			}

			for($j = 0; $j < count($id_jabatan); $j++) {
				foreach ($perolehan_jabatan as $key => $value_perolehan_jabatan) {
					if($value_perolehan_jabatan['id_jabatan'] == $id_jabatan[$j])
						$belanja_jabatan[$j] += $value_perolehan_jabatan['nilai'];
				}
				foreach ($perjalanan_jabatan as $key => $value_perjalanan_jabatan) {
					if($value_perjalanan_jabatan['id_jabatan'] == $id_jabatan[$j])
						$belanja_jabatan[$j] += $value_perjalanan_jabatan['nilai'];
				}
				foreach ($penceramah_jabatan as $key => $value_penceramah_jabatan) {
					if($value_penceramah_jabatan['id_jabatan'] == $id_jabatan[$j])
						$belanja_jabatan[$j] += $value_penceramah_jabatan['nilai'];
				}
				foreach ($ot_jabatan as $key => $value_ot_jabatan) {
					if($value_ot_jabatan['id_jabatan'] == $id_jabatan[$j])
						$belanja_jabatan[$j] += $value_ot_jabatan['nilai'];
				}
				
			}
			if(Yii::$app->user->identity->level <= 4) {
				echo Highcharts::widget([
				    'scripts' => [
				        'modules/exporting',
				        'themes/grid-light',
				    ],
				    'options' => [
				        'title' => [
				            'text' => 'Agihan & Perbelanjaan Jabatan Tahun '.$year,
				        ],
				        'xAxis' => [
				            'categories' => $jabatan,//['Jabatan 1', 'Jabatan 2', 'Jabatan 3', 'Jabatan 4', 'Jabatan 5'],
				            'title' => [
				            	'text' => '<strong>Jabatan</strong>',
				            ]
				        ],
				        'yAxis' => [
				        	'title' => [
				        		'text' => '',
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
				                'name' => 'Agihan (RM)',
				                'data' => $agihan_jabatans,
				            ],
				            [
				                'type' => 'column',
				                'name' => 'Belanja (RM)',
				                'data' => $belanja_jabatan,
				            ],
				            // [
				            //     'type' => 'column',
				            //     'name' => 'Joe',
				            //     'data' => [4, 3, 3, 9, 0],
				            // ],
				            // [
				            //     'type' => 'spline',
				            //     'name' => 'Average',
				            //     'data' => [3, 2.67, 3, 6.33, 3.33],
				            //     'marker' => [
				            //         'lineWidth' => 2,
				            //         'lineColor' => new JsExpression('Highcharts.getOptions().colors[3]'),
				            //         'fillColor' => 'white',
				            //     ],
				            // ],
				            [
				                'type' => 'pie',
				                'name' => 'RM',
				                'data' => [
				                    [
				                        'name' => 'Jumlah Agihan',
				                        'y' => $jumlah_agihan,
				                        'color' => new JsExpression('Highcharts.getOptions().colors[0]'), // Jane's color
				                    ],
				                    [
				                        'name' => 'Jumlah Perbelanjaan',
				                        'y' => $jumlah_perbelanjaan,
				                        'color' => new JsExpression('Highcharts.getOptions().colors[1]'), // John's color
				                    ],
				                    // [
				                    //     'name' => 'Joe',
				                    //     'y' => 19,
				                    //     'color' => new JsExpression('Highcharts.getOptions().colors[2]'), // Joe's color
				                    // ],
				                ],
				                'center' => [100, 80],
				                'size' => 100,
				                'showInLegend' => false,
				                'dataLabels' => [
				                    'enabled' => false,
				                ],
				            ],
				        ],
				    ]
				]);
			}

		?>
	</div>
	<div class="chart table-responsive" style="overflow-x: auto; margin-top: 10px;">
		<h2>Perbelanjaan Jabatan berdasarkan OS</h2>
		<?php
			$sql_agihan_jabatan_os = "SELECT os, agihan_jabatan FROM agihan WHERE id_jabatan=$id_jabatan_pengguna AND tahun='$year' AND agihan_jabatan > 0  ORDER BY os";
			$agihan_jabatan_os = Yii::$app->db->createCommand($sql_agihan_jabatan_os)->queryAll();
			// print_r($agihan_jabatan_os);
		?>
		<div class="row" style="overflow-x: auto; white-space: nowrap;">
			<?php
				$sql_belanja_perolehan = "SELECT unjuran.os, SUM(nilai_perolehan) AS belanja FROM `perolehan` RIGHT JOIN unjuran on unjuran.kod_id = perolehan.kod_unjuran WHERE perolehan.id_jabatan=$id_jabatan_pengguna AND perolehan.tahun='$year' GROUP by unjuran.os ORDER by unjuran.os";
				$belanja_perolehan = Yii::$app->db->createCommand($sql_belanja_perolehan)->queryAll();

				$sql_belanja_perjalanan = "SELECT unjuran.os, SUM(jumlah_kew) AS belanja FROM `perjalanan` RIGHT JOIN unjuran on unjuran.kod_id = perjalanan.kod_unjuran WHERE perjalanan.id_jabatan=$id_jabatan_pengguna AND perjalanan.tahun='$year' GROUP by unjuran.os ORDER by unjuran.os";
				$belanja_perjalanan = Yii::$app->db->createCommand($sql_belanja_perjalanan)->queryAll();

				$sql_belanja_ot = "SELECT unjuran.os, SUM(jumlah_kew) AS belanja FROM `ot` RIGHT JOIN unjuran on unjuran.kod_id = ot.kod_unjuran WHERE ot.id_jabatan=$id_jabatan_pengguna AND ot.tahun='$year' GROUP by unjuran.os ORDER by unjuran.os";
				$belanja_ot = Yii::$app->db->createCommand($sql_belanja_ot)->queryAll();

				$sql_belanja_penceramah = "SELECT unjuran.os, SUM(jumlah_kew) AS belanja FROM `penceramah` RIGHT JOIN unjuran on unjuran.kod_id = penceramah.kod_unjuran WHERE penceramah.id_jabatan=$id_jabatan_pengguna AND penceramah.tahun='$year' GROUP by unjuran.os ORDER by unjuran.os";
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
				if(Yii::$app->user->identity->level <= 7) {
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
				}
				// print_r($agihan_jabatan_os);
			?>			
		</div>
	</div>
	<h3>Info Tuntutan Belum Selesai</h3>
	<div class="container info tuntutan table-responsive">
		<div class="row">
			<table class="table table-striped table-hover table-condensed">
				<thead>
					<tr><th>No</th><th>Kod ID</th><th>Jenis Tuntutan</th><th>Nama</th><th>No KP</th><th>Bulan</th><th>Jumlah (RM)</th><th>Status</th></tr>
				</thead>
				<tbody>
					<?php
						$i = 1;
						foreach ($perjalanan as $key => $value) {
					?>
					<tr>
						<td><?= $i++; ?></td>
						<td><?= $value['kod_id'] ?></td>
						<td><?= $value['jenis'] == 1 ? 'Dalam' : 'Luar'; ?></td>
						<td><?= $value['nama'] ?></td>
						<td><?= $value['no_kp'] ?></td>
						<td><?= $value['bulan'] ?></td>
						<td class="text-right"><?= number_format($value['jumlah_kew'], 2) ?></td>
						<td><?= $value['status'] == 'A' ? 'Diproses' : 'Draf' ?></td>
					</tr>
					<?php
						}
						foreach ($penceramah as $key => $value) {
					?>
					<tr>
						<td><?= $i++; ?></td>
						<td><?= $value['kod_id'] ?></td>
						<td>Penceramah</td>
						<td><?= $value['nama'] ?></td>
						<td><?= $value['no_kp'] ?></td>
						<td><?= $value['bulan'] ?></td>
						<td class="text-right"><?= number_format($value['jumlah_kew'], 2) ?></td>
						<td><?= $value['status'] == 'A' ? 'Diproses' : 'Draf' ?></td>
					</tr>
					<?php
						}
						foreach ($ot as $key => $value) {
					?>
					<tr>
						<td><?= $i++; ?></td>
						<td><?= $value['kod_id'] ?></td>
						<td>OT</td>
						<td><?= $value['nama'] ?></td>
						<td><?= $value['no_kp'] ?></td>
						<td><?= $value['bulan'] ?></td>
						<td class="text-right"><?= number_format($value['jumlah_kew'], 2) ?></td>
						<td><?= $value['status'] == 'A' ? 'Diproses' : 'Draf' ?></td>
					</tr>
					<?php
						}
					?>
				</tbody>
			</table>
		</div>
	</div>
	<h3>Senarai Perolehan Belum Selesai</h3>
	<div class="container info perolehan table-responsive">
		<div class="row">
			<table class="table table-striped table-hover table-condensed table-bordered">
				<thead>
					<tr><th>No</th><th>Kod ID</th><th>OS</th><th>Jabatan / Unit</th><th>Jenis Perolehan</th><th>Barang / Perkhidmatan</th><th>Pembekal</th><th width="90">Tarikh</th><th>Jumlah (RM)</th><th>Status</th></tr>
				</thead>
				<tbody>
				<?php
					$j = 0;;
					foreach ($perolehan as $key => $value) {
						$j++;
				?>
					<tr>
						<td><?= $j ?></td>
						<td><?= $value['pkod_id'] ?></td>
						<td><?= $value['os'] ?>
						<td><?= \app\models\Jabatan::findOne($value['id_jabatan'])->jabatan.' / '.\app\models\Unit::findOne($value['id_unit'])->unit ?>
						<td>
							<?= \app\models\RefJenisPerolehan::findOne($value['jenis_perolehan'])->jenis 
								.' / '.\app\models\RefKaedahPerolehan::findOne($value['kaedah_pembayaran'])->kaedah
							?>
						</td>
						<td>
							<ol class="barangan">
							<?php
								$sql_barangan = 'SELECT * FROM barangan WHERE id_perolehan = '.$value['pid'];
								$barangan = Yii::$app->db->createCommand($sql_barangan)->queryAll();
								if(count($barangan) > 0) {
									foreach ($barangan as $key => $value_barangan) {
										echo '<li>'.$value_barangan['justifikasi'].'</li>';
									}
								}
							?>
							</ol>
						</td>
						<td>
							<ol class="pembekal">
							<?php 
								$sql_pembekal = 'SELECT * FROM pembekal WHERE id_perolehan = '.$value['pid'];
								$pembekal = Yii::$app->db->createCommand($sql_pembekal)->queryAll();
								if(count($pembekal) > 0)
									foreach ($pembekal as $key => $value_pembekal) {
										if($value_pembekal['utama'] == 1)
											echo '<li><strong>'.$value_pembekal['pembekal'].'*</strong></li>';
										else
											echo '<li>'.$value_pembekal['pembekal'].'</li>';
									}
								else
									echo '-';
							?>
							</ol>
						</td>
						<td><?= Yii::$app->formatter->asDate(substr($value['tarikh_jadi'], 0, 10), 'dd-M-Y') ?></td>
						<td class="text-right"><?= number_format($value['nilai_perolehan'], 2) ?></td>
						<?php $status = ['A', 'B', 'C']; ?>
						<td><?= $status[$value['status_kewangan']]  ?></td>
					</tr>
				<?php
					}
				?>	
				</tbody>
			</table>
		</div>
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