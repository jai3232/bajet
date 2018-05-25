<?php
/* @var $this yii\web\View */
use yii\widgets\MaskedInput;
use app\models\Agihan;
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

$this->title = 'Agihan Waran '.$year;
$this->params['breadcrumbs'][] = $this->title;

$jabatans = $jabatan->asArray()->orderBy('ringkasan')->all();
$warans = $waran->select(['os', 'SUM(jumlah_waran) AS total'])->where(['tahun' => $year])->groupBy('os')->orderBy('os')->asArray()->all();
//print_r($warans);	

$agihan_column = [0 => ['id' => -1, 'jabatan' => 'OS', 'ringkasan' => 'OS']];
$agihan_column = array_merge($agihan_column, $jabatans);
array_push($agihan_column, ['id' => -2, 'jabatan' => 'Jumlah', 'ringkasan' => 'Jumlah']);
array_push($agihan_column, ['id' => -3, 'jabatan' => 'Baki', 'ringkasan' => 'Baki']);
array_push($agihan_column, ['id' => -4, 'jabatan' => 'Jumlah Waran', 'ringkasan' => 'Jumlah Waran']);

//$agihans = Agihan::find()->leftJoin('jabatan', 'agihan.id_jabatan = jabatan.id')->where(['tahun' => $year])->asArray()->orderby('os, jabatan.ringkasan')->all();
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
	<table class="table table-condensed table-striped table-bordered table-hover table-responsive">
		<thead class="thead-dark">
			<tr><th>#</th>
				<?php 
					foreach ($agihan_column as $key => $value) {
						echo "<th>".$value['ringkasan']."</th>";
					}
				?>
			</tr>
		</thead>
		<tbody>
			<!-- <tr data-key="7907"><td>1</td></tr> -->
			<?php 
				$i = 1;
				foreach ($warans as $key => $value1) {
					echo '<tr><td>'.$i++.'</td>';
					//$agihan_data = $agihan->where(['os' => $value1['os'], 'tahun' => $year])->asArray()->all();
					//print_r($agihan_data); echo "<br>";

					foreach ($agihan_column as $key => $value2) {
						$class = '';
						if($value2['jabatan'] == 'OS') {
							$value2['jabatan'] = $value1['os'];
						}
						if($value2['jabatan'] == 'Jumlah Waran'){
							$value2['jabatan'] = number_format($value1['total'], 2); 
							$class = 'class="text-right waran" id="waran-'.$value1['os'].'"';
						}
						if($value2['id'] <= 0) {
							if($value2['jabatan'] == 'Jumlah')
								echo '<td id="jumlah-'.$value1['os'].'" class="text-right jumlah'.$value2['id'].'"></td>';
							elseif($value2['jabatan'] == 'Baki')
								echo '<td id="baki-'.$value1['os'].'" class="text-right baki'.$value2['id'].'"></td>';
							else
								echo '<td '.$class.'>'.$value2['jabatan'].'</td>';
						}
						else {
						$agihan_exist = Agihan::find()->where([
											'os' => $value1['os'],
											'id_jabatan' => $value2['id'], 
											'tahun' => $year
										])->exists();

						if(!$agihan_exist) {
							$model_agihan = new Agihan();
							$model_agihan->os = $value1['os'];
							$model_agihan->id_jabatan = $value2['id'];
							$model_agihan->agihan_jabatan = 0;
							$model_agihan->baki = 0;
							$model_agihan->tahun = $year;
							$model_agihan->user = Yii::$app->user->identity->id;
							if(!$model_agihan->save())
								return print_r($model_agihan->getErrors());
						}

							//echo '<td> <input type="number" id="'.$value1['os'].'_'.$value2['id'].'" class="input-agihan text-right column'.$value2['id'].'"></td>';
							$input_value = Agihan::find()->select(['agihan_jabatan'])->where([
											'os' => $value1['os'],
											'id_jabatan' => $value2['id'], 
											'tahun' => $year
										])->asArray()->one()['agihan_jabatan'];

							echo '<td>'. MaskedInput::widget([
							    'name' => $value1['os'].'_'.$value2['id'],
							    'id' => $value1['os'].'_'.$value2['id'],
							    'value' => $input_value,
							    'options' => [
							    	'class' => 'form-control input-agihan column'.$value2['id'].' row-'.$value1['os'],
							    ],
							    'clientOptions' => [
							        'alias' => 'decimal',
							        'digits' => 2,
							        'digitsOptional' => true,
							        'radixPoint' => '.',
							        'groupSeparator' => ',',
							        'autoGroup' => true,
							        'removeMaskOnSubmit' => true,
							    ],
							]).'</td>';
						}
					}
					echo '</tr>';
				}
			?>
		</tbody>
		<tfoot>
			<tr>
				<?php
					foreach ($agihan_column as $key => $value) {
						if($value['ringkasan'] == 'OS')
							echo '<th colspan="2">Jumlah</th>';
						else
							echo '<th id="footer'.$value['id'].'" class="text-right"></th>';
					}
				?>
			</tr>
		</tfoot>
	</table>
	<!-- <div class="form-group">
		<button class="btn btn-primary btn-kemaskini">Kemaskini Agihan</button>
	</div> -->
</div>
</div>

<?php 
/*echo MaskedInput::widget([
    'name' => 'phone',
    'id' => 'y',
    'options' => [
    	'class' => 'y',
    ],
    'clientOptions' => [
        'alias' => 'decimal',
        'digits' => 2,
        'digitsOptional' => true,
        'radixPoint' => '.',
        'groupSeparator' => ',',
        'autoGroup' => true,
        'removeMaskOnSubmit' => true,
    ],
]);*/
	$this->registerCss('
		.input_agihan {
			text-align: right;
		}
	');

	$this->registerJs('

		var background_red = false;

		$("#select-year").change(function(){
			$("#form-year").submit();
		});
		var jumlah_input_agihan = $(".input-agihan").length;
		var input_agihan = $(".input-agihan");
		// for(var i = 0; i < jumlah_input_agihan; i++) {
		// 	input_agihan.eq(i).val(0);
		// }

		var input_value;

		$(".input-agihan").on("focus", function(data){
			input_value = $(this).val();
		});

		$(".input-agihan").keyup(function(){
			
			var id = $(this).attr("id");
			var os = id.split("_")[0];
			var jabatan = id.split("_")[1];
			var column_jabatan = $(".column"+jabatan);
			var total_column = 0;
			for(var i = 0; i < column_jabatan.length; i++) {
				total_column += column_jabatan.eq(i).val().replace(/,/g, "") / 1;
			}
			$("#footer"+jabatan).html(total_column.currency());

			var row_os = $(".row-"+os);
			var total_row = 0;
			for(var i = 0; i < row_os.length; i++) {
				total_row += row_os.eq(i).val().replace(/,/g, "") / 1;
			}

			$("#jumlah-"+os).html(total_row.currency());
			$("#baki-"+os).html(($("#waran-"+os).text().replace(/,/g, "") / 1 - $("#jumlah-"+os).text().replace(/,/g, "") / 1).currency());

			//$("#waran-"+os).text().replace(/,/g, "") / 1 >= 0
			if($("#baki-"+os).text().replace(/,/g, "") / 1 < 0 && $(this).val().replace(/,/g, "") / 1 > 0) {
				$(this).css("background", "red");
				background_red = true;
				alert("Agihan melebihi waran peruntukan");
			}
			else {
				$(this).css("background", "");	
				background_red = false;
			}
		});

		Number.prototype.currency = function() {
			return this.valueOf().toFixed(2).replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
		};

		$(".input-agihan").trigger("keyup");

		$(".input-agihan").change(function(data){
			if($(this).val() == "") {
				$(this).focus();
				$(this).attr("placeholder", "Sila masukkan nombor.");
				$(this).css("background", "red");
				return false;
			}
			else if($(this).css("background") == "red")
				$(this).css("background", "");

			var jumlah = 0;
			var class_jumlah = $(".jumlah-2");
			for(var i = 0; i < class_jumlah.length; i++) {
				jumlah += class_jumlah.eq(i).text().replace(/,/g, "") / 1;
			}
			$("#footer-2").html(jumlah.currency());

			var jumlah_baki = 0;
			var class_baki = $(".baki-3");
			for(var i = 0; i < class_baki.length; i++) {
				jumlah_baki += class_baki.eq(i).text().replace(/,/g, "") / 1;
			}
			$("#footer-3").html(jumlah_baki.currency());

			var jumlah_waran = 0;
			var class_waran = $(".waran");
			for(var i = 0; i < class_waran.length; i++) {
				jumlah_waran += class_waran.eq(i).text().replace(/,/g, "") / 1;
			}
			$("#footer-4").html(jumlah_waran.currency());

			//if($(this).css("background") != "red") {
			if(!background_red) {
				if(confirm("Simpan kemaskini data?")) {
					var id = $(this).attr("id");
					var os = id.split("_")[0];
					var jabatan = id.split("_")[1];
					var val = $(this).val().replace(/,/g, "");
					$(this).css("background", "white");
					$.post("'.Url::to(['waran/update-agihan']).'", {os:os, jabatan:jabatan, tahun:'.$year.', value:val}, function(data){ 
						if(data)
							alert("Kemaskini berjaya");
					});
				}
				else {
					$(this).val(input_value);
				}
			}
		});

		var jumlah = 0;
		var class_jumlah = $(".jumlah-2");
		for(var i = 0; i < class_jumlah.length; i++) {
			jumlah += class_jumlah.eq(i).text().replace(/,/g, "") / 1;
		}
		$("#footer-2").html(jumlah.currency());

		var jumlah_baki = 0;
		var class_baki = $(".baki-3");
		for(var i = 0; i < class_baki.length; i++) {
			jumlah_baki += class_baki.eq(i).text().replace(/,/g, "") / 1;
		}
		$("#footer-3").html(jumlah_baki.currency());

		var jumlah_waran = 0;
		var class_waran = $(".waran");
		for(var i = 0; i < class_waran.length; i++) {
			jumlah_waran += class_waran.eq(i).text().replace(/,/g, "") / 1;
		}
		$("#footer-4").html(jumlah_waran.currency());


		// $(".input-agihan").inputmask("numeric", {
		//     radixPoint: ".",
		//     groupSeparator: ",",
		//     digits: 2,
		//     autoGroup: true,
		//     prefix: "$ ", //Space after $, this will not truncate the first character.
		//     rightAlign: false,
		//     oncleared: function () { self.Value(""); }
		// });
		
	');
?>
