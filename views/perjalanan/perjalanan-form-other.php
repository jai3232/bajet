<?php
use app\models\Jabatan;
use app\models\Unit;
use app\models\Pengguna;
use app\models\RefJenisPerolehan;
use app\models\RefKaedahPerolehan;
use yii\helpers\Html;


if(isset($error)) {
	if($error == 404)
		echo '<div class="alert alert-danger"><strong>Kesilapan!</strong> Rekod tidak ditemui.</div>';
	return false;
}
$months = [
            '01' => 'Jan', '02' => 'Feb', '03' => 'Mac', '04' => 'Apr', '05' => 'Mei', '06' => 'Jun',
            '07' => 'Jul', '08' => 'Ogos', '09' => 'Sep', '10' => 'Okt', '11' => 'Nov', '12' => 'Dis'
          ];
?>
<div id="rujukan">
	<?= 'No: '.$model->kod_id ?><br>
	<?= 'OS: '.$model->kodUnjuran->os ?>
</div>
<div class="panel panel-default">
	<table width="900" border="1" align="center" class="table table-bordered">
	    <tbody>
		    <tr>
				<td colspan="2" align="center"><strong>TUNTUTAN ELAUN PERJALANAN DALAM NEGERI								
				</strong></td>
		    </tr>
		    <tr>
		     	<td colspan="2" align="center"><strong>BAGI BULAN <?= strtoupper($months[$model->bulan].' '.$model->tahun) ?></strong></td>
		    </tr>
		    <tr>
		    	<td colspan="2" align="center"><strong>A. MAKLUMAT PEGAWAI</strong></td>
		    </tr>
		    <tr>
		    	<td width="415" valign="top"><p><strong>NAMA (HURUF BESAR)</strong></p>
		    		<p>No. Kad Pengenalan</p>
		    		<p>No. Telefon</p>
		    		<p>Alamat Emel</p>
		    		<p>Jawatan</p>
		    	</td>
		    	<td width="469" valign="top"><p><strong><?= strtoupper($model->nama) ?>&nbsp;</strong></p>
	    			<p><?= strtoupper($model->no_kp) ?></p>
	    			<p><?= strtoupper($model->no_hp) ?></p>
	    			<p><?= strtolower($model->email) ?></p>	    			
	    			<p><?= strtolower($model->jawatan) ?></p>	    			
	    		</td>
    		</tr>
    		<tr>
    			<td>Nama Bank</td>
    			<td><?= $model->bank ?></td>
    		</tr>
    		<tr>
    			<td>Cawangan Bank</td>
    			<td><?= $model->cawangan_bank ?></td>
    		</tr>
    		<tr>
    			<td>No. Akaun Bank</td>
    			<td><?= $model->akaun_bank ?></td>
    		</tr>
    		<tr>
    			<td>Alamat Pejabat</td>
    			<td><?= $model->alamat_pejabat ?></td>
    		</tr>
    		<tr>
    			<td>Alamat Rumah</td>
    			<td><?= $model->alamat_rumah ?></td>
    		</tr>
    		<tr>
    			<td><strong>Jumlah</strong></td>
    			<td><strong>RM<?= number_format($model->jumlah_kew, 2) ?></strong></td>
    		</tr>
    	</tbody>
	</table>
	
</div>

<?php Html::a('Papar PDF', ['/perjalanan/form-pdf', 'id' => yii::$app->request->get('id')], ['class'=>'btn btn-primary']) ?>


<button class="btn btn-primary" onclick="window.print();">Cetak</button>
<?php



$this->registerJs('

$("#btnPrint").on("click", function () {
            var divContents = $("#content").html();
            var printWindow = window.open("", "", "height=400,width=1200");
            printWindow.document.write("<html><head><title>DIV Contents</title>");
            printWindow.document.write("<style> * {font-family: arial;} table.print tr td {border: 1px solid black;} table.print {border: none; }</style>"); 
            printWindow.document.write("</head><body >");
            printWindow.document.write(divContents);
            printWindow.document.write("</body></html>");
            printWindow.document.close();
            printWindow.print();
        });

');

$this->registerJs('
	setClass("'.$model->kelas_tuntutan.'");	
	setJarak('.$model->jumlah_jarak.');
	jumlahKadarJarak();
	setJumlahElaun();
	$("#jumlah_tuntutan").text(($("#jumlah_kadar_jarak2").text()/1 + $("#jumlah_elaun_makan_harian").text()/1 + $("#jumlah_elaun_penginapan").text()/1 + $("#jumlah_tambang").text()/1 + $("#jumlah_pelbagai").text()/1).toFixed(2) );

	$("#dibayar").text(($("#jumlah_tambang").text()/1 + $("#jumlah_pelbagai").text()/1 + $("#jumlah_elaun_penginapan").text()/1 - $("#jumlah_lojing").text()/1).toFixed(2));
	$("#words").text(numberToWord($("#jumlah_tuntutan").text()));


');

$this->registerJs('
function setClass(c){
	var kadar1 = 0.7;
	var kadar2 = 0.65;
	var kadar3 = 0.55;
	var kadar4 = 0.5;
	switch(c) {
		case "A":
			kadar1 = 0.7;
			kadar2 = 0.65;
			kadar3 = 0.55;
			kadar4 = 0.5;
			break;
		case "B":
			kadar1 = 0.6;
			kadar2 = 0.55;
			kadar3 = 0.5;
			kadar4 = 0.45;
			break;
		case "C":
			kadar1 = 0.5;
			kadar2 = 0.45;
			kadar3 = 0.4;
			kadar4 = 0.35;
			break;
		case "D":
			kadar1 = 0.45;
			kadar2 = 0.4;
			kadar3 = 0.35;
			kadar4 = 0.3;
			break;
		case "E":
			kadar1 = 0.4;
			kadar2 = 0.35;
			kadar3 = 0.3;
			kadar4 = 0.25;
			break;
	}
	$("#kadar1").text(kadar1.toFixed(2));
	$("#kadar2").text(kadar2.toFixed(2));
	$("#kadar3").text(kadar3.toFixed(2));
	$("#kadar4").text(kadar4.toFixed(2));
}

function jumlahKadarJarak(){
	//alert($("#km1").html());
	tempKadarJarak = 0;
	tempKm = 0;
	for(var i = 1; i <= 4; i++) {
		tempVal = $("#km"+i).text()/1 * $("#kadar"+i).text()/1;
		tempKm += $("#km"+i).text()/1;
		tempVal = tempVal.toFixed(2);
		tempKadarJarak += tempVal/1;
		$("#kadar_jarak"+i).text(tempVal);
	}
	$("#jumlah_kadar_jarak").text(tempKadarJarak.toFixed(2));
	$("#jumlah_km").text(tempKm);
	$("#tolak_kadar_jarak").text((0-jarakDuit($(".perjalanan_lalu").eq(0).text()/1)).toFixed(2));
	$("#jumlah_kadar_jarak2").text(($("#jumlah_kadar_jarak").text()/1 + $("#tolak_kadar_jarak").text()/1).toFixed(2));	
}

function setJumlahElaun() {
	total = 0;
	for(var i = 1; i <= 5; i++) {
		temp = $("#kali"+i).text()/1 * $("#elaun_sehari"+i).text()/1 * $("#kadar_elaun"+i).text()/100;
		$("#jumlah_elaun"+i).text(temp.toFixed(2));
		total += temp/1;
	}
	$("#jumlah_elaun_makan_harian").text(total.toFixed(2));
}


function setJarak(j) {
	jumlah_jarak = j;
	//$("#jumlah_jarak0").text(jumlah_jarak);
	//$("#jumlah_jarak").text($("#jumlah_jarak0").text()/1 + $(".perjalanan_lalu").eq(0).text()/1);
	//$("#jumlah_jarak_besar").val(jumlah_jarak);
	$("#km1").text("");
	$("#km2").text("");
	$("#km3").text("");
	$("#km4").text("");
	jumlah_jarak += $(".perjalanan_lalu").eq(0).text()/1;
	if(jumlah_jarak/1 <= 500)
		$("#km1").text(jumlah_jarak);
	else if(jumlah_jarak/1 > 500 && jumlah_jarak/1 <= 1000) {
		$("#km1").text("500");
		$("#km2").text(jumlah_jarak-500);
	}
	else if(jumlah_jarak/1 > 1000 && jumlah_jarak/1 <= 1700) {
		$("#km1").text("500");
		$("#km2").text("500");
		$("#km3").text(jumlah_jarak-1000);
	}
	else {
		$("#km1").text("500");
		$("#km2").text("500");
		$("#km3").text("700");
		$("#km4").text(jumlah_jarak-1700);
	}		
}

function jarakDuit(jarak) {
    jarak = jarak/1;
    temp = 0;
    if(jarak <= 500)
        return (jarak * $("#kadar1").text()/1);
    else if(jarak > 500 && jarak <= 1000) {
        temp = 500 * $("#kadar1").text()/1;
        temp += (jarak - 500) * $("#kadar2").text()/1;
        return temp;
    }
    else if(jarak > 1000 && jarak <= 1700) {
        temp = 500 * $("#kadar1").text()/1;
        temp += 500 * $("#kadar2").text()/1;
        temp += (jarak - 1000) * $("#kadar3").text()/1;
        return temp;
    }
    else {
        temp = 500 * $("#kadar1").text()/1;
        temp += 500 * $("#kadar2").text()/1;
        temp += 700 * $("#kadar3").text()/1;
        temp += (jarak - 1700) * $("#kadar4").text()/1;
        return temp;
        
    }
}

function numberToWord(num) {
	
	var number = new Array("Satu ","Dua","Tiga", "Empat", "Lima", "Enam", "Tujuh", "Lapan", "Sembilan");
	var value = new Array("", "Puluh", "", "", "Puluh", "Ratus", "Ribu");
	num = num.toString();
	var l = num.length;
	//alert(l);	
	var w = "";
	for(var i = l; i >= 0; i--) {
		if(i == 7) {
			w = number[num.charAt(l-i)/1 - 1] + " Ribu ";
		}
		if(i == 6) {
			if(num.charAt(l-i)/1 == 0)
				w += " ";
			else
				w += number[num.charAt(l-i)/1 - 1] + " Ratus ";
		}
		if(i == 5) {
			if(num.charAt(l-i)/1 == 1) {
				w += number[num.charAt(l-4)/1 - 1] + " Belas ";
				continue;
			}
			else if(num.charAt(l-i)/1 == 0)
				w += " ";
			else
				w += number[num.charAt(l-i)/1 - 1] + " Puluh ";
		}
		if(i == 4) {
			if(num.charAt(l-5)/1 == 1) continue;
			if(num.charAt(l-i)/1 == 0)
				w += " ";
			else
				w += number[num.charAt(l-i)/1 - 1] + " ";
		}
		if(i == 2) {
			//alert(num.charAt(l-i));
			if(num.charAt(l-i)/1 == 1) {
				w += number[num.charAt(l-1)/1 - 1] + " Belas Sen Sahaja ";
				break;
			}
			else if(num.charAt(l-i)/1 == 0)
				w += " ";
			else
				w += number[num.charAt(l-i)/1 - 1] + " Puluh ";
		}
		if(i == 1) {
			if(num.charAt(l-i)/1 > 0)
				w += number[num.charAt(l-i)/1 - 1] + " Sen Sahaja ";
			else
				w += " Sahaja";
		}
	
	}
	return "Ringgit Malaysia: "+w;
}


');

$this->registerCss('

	.noborder tr td, .print tr td {
		padding: 5px;
	}

	ol {
    counter-reset: list;
	}
	ol > li {
	    list-style: none;
	    position: relative;
	}
	ol > li:before {
	    counter-increment: list;
	    content: counter(list, lower-alpha) ") ";
	    position: absolute;
	    left: -1.4em;
	}

	#rujukan {
		position: relative;
		border: 3px solid red;
		width: 150px;
        top: 60px;
        left: 5px;
		padding: 1px 3px;
		text-align: center;
		font-weight: bold;
		color: red;

	}

	@media print {
    	.break {page-break-after: always;}

    	.noborder tr td, .noborder tr th , table tr td, td th {border: none !important;}

    	.btn, footer {display: none !important;}

    	table {
            border: solid white !important;
            border-width: 1px 0 0 1px !important;
            border-bottom-style: none;
            border: none;
        }

        th, td {
            border: solid white !important;
            border-width: 0 1px 1px 0 !important;
            border-bottom-style: none;
            border: none;
        }
	}
	

');
?>