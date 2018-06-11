<?php
use app\models\Unjuran;
use app\models\Jabatan;
use app\models\Perolehan;
use app\models\Perbelanjaan;
use app\models\Ot;
use app\models\Penceramah;
use app\models\Perjalanan;


// function bakiUnjuran($kod_unjuran)
// {
// 	$perolehan = Perolehan::find()->where(['kod_unjuran' => $kod_unjuran])->sum('nilai_perolehan');
// 	$perbelanjaan = Perbelanjaan::find()->where(['kod_unjuran' => $kod_unjuran])->sum('jumlah_bayaran');
// 	$ot = Ot::find()->where(['kod_unjuran' => $kod_unjuran])->sum('jumlah_kew');
// 	$penceramah = Penceramah::find()->where(['kod_unjuran' => $kod_unjuran])->sum('jumlah_kew');
// 	$perjalanan = Perjalanan::find()->where(['kod_unjuran' => $kod_unjuran])->sum('jumlah_kew');
// 	$unjuran = Unjuran::find()->where(['kod_id' => $kod_unjuran])->sum('jumlah_unjuran');

// 	return $unjuran - ($perolehan + $perbelanjaan + $ot + $penceramah + $perjalanan);
// }

?>

<?php 

$currentYear = date("Y");
$id_jabatan = Yii::$app->user->identity->id_jabatan;

$sql = "SELECT * FROM unjuran WHERE ((os = '21000' OR os = 'AMANAH' OR os LIKE '4%' OR os LIKE 'P%' OR os LIKE 'B%')  AND sah=1 AND tahun='$currentYear' AND kod='A' AND (id_jabatan=$id_jabatan OR FIND_IN_SET('$id_jabatan', unjuran.kongsi) ))";

$unjurans = Yii::$app->db->createCommand($sql)->queryAll();				  					  
?>
<div class="form-group form-inline ">
	<label for="search">Tapisan </label>
	<input name="search" id="search" class="form-control">
</div>

<div id="unjuran-grid" class="grid-view">
	<table id="unjuran-carian" class="table table-condensed table-striped table-bordered table-hover table-responsive">
		<thead class="thead-dark">
			<tr>
				<th>#</th><th>Kod</th><th>OS</th><th>Butiran</th><th>Unjuran</th><th>Baki</th><th>Jabatan</th><th>Pilih</th>
			</tr>
		</thead>
		<tbody id="myTable">
		<?php
			$i = 1;
			foreach ($unjurans as $key => $value) {
				echo '<tr data-dismiss="modal"><td>'.$i++.'</td><td>'.$value['kod_id'].'</td><td>'.$value['os']
					.'</td><td>'.$value['butiran'].'</td><td class="text-right">'.number_format($value['jumlah_unjuran'], 2)
					.'</td><td class="text-right">'.number_format(Unjuran::bakiUnjuran($value['kod_id']), 2).'</td><td><span id="'.$value['id_jabatan'].'" title="'
					.Jabatan::findOne($value['id_jabatan'])->jabatan.'">'
					.Jabatan::findOne($value['id_jabatan'])->ringkasan.'</span></td><td class="text-center">'
					.'<input type="radio" name="pilih" class="pilih" data-dismiss="modal">'.'</td></tr>';
			}
		?>
		</tbody>
	</table>
	<div class="form-group">
		<!-- <button id="excel_btn" class="btn btn-primary btn-kemaskini">Eksport ke Excel</button> -->
		<!-- <a id="excel-export" class="btn btn-primary">Ekstport ke Excel</a> -->
	</div>
</div>

<?php

$this->registerJs('
	$("#search").on("keyup", function() {
	    var value = $(this).val().toLowerCase();
	    $("#myTable tr").filter(function() {
	     	$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
	    });
	});

	$("#myTable tr").on("click", function(){
		var td = $(this).children();
		$("#perolehan-kod_unjuran").val(td.eq(1).html());
		$("#perjalanan-kod_unjuran").val(td.eq(1).html());
		$("#perjalanan-bahagian").val(td.eq(6).children().attr("id"));
		$("#kod-unjuran").html(td.eq(1).html());
		$("#os").html(td.eq(2).html());
		$("#butiran").html(td.eq(3).html());
		$("#jumlah-unjuran").html(td.eq(4).html());
		$("#baki").html(td.eq(5).html());
		$("#jabatan").html(td.eq(6).children().prop("title"));
		$("#perjalanan-id_jabatan").val(td.eq(6).children().prop("id"));
		$("#unjuran_info").slideDown(150);
		$(".perjalanan-form").slideDown(200);
		$(".perbelanjaan-form").slideDown(200);
		$(".first").show(100);
	});
');

?>