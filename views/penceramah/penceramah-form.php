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
            1 => 'Jan', 2 => 'Feb', 3=> 'Mac', 4 => 'Apr', 5 => 'Mei', 6 => 'Jun',
            7=> 'Jul', 8 => 'Ogos', 9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Dis'
          ];
$taraf_jawatan = ['Tetap', 'Sementara' , 'Lain-lain'];
?>
<div id="rujukan">
	<?= 'No: '.$model->kod_id ?><br>
	<?= 'OS: '.$model->kodUnjuran->os ?>
</div>
<div class="panel panel-default">
	<table width="900" border="1" align="center" class="table table-bordered"">
	    <tbody>
		    <tr>
		     	<td colspan="4" align="center"><strong>BORANG PERMOHONAN
UNTUK MENJALANKAN TUGAS SEBAGAI <br>
PENSYARAH/PENCERAMAH SAMBILAN ATAU <br>
PENSYARAH/PENCERAMAH SAMBILAN PAKAR <br>
BAGI BULAN <?= strtoupper($months[$model->bulan].' TAHUN '.$model->tahun) ?><br>DIISI DALAM 1 SALINAN</strong>
				</td>
		    </tr>
		    <tr class="swasta">
		    	<td class="text-center">
		    		<strong>Penyata Tuntutan Mengenai Pembayaran Kepada<br>
            		Pensyarah / Penceramah Bukan Anggota Kakitangan Awam</strong>
		    	</td>
		    </tr>
		    <tr>
		    	<td><strong>
		    		Kepada: <br>
		    		Kementerian / Jabatan / Agensi Penganjur <br>
		    		Nama Agensi <br>
		    		Alamat Agensi <br>
		    		</strong>
		    	</td>
		    </tr>
		    <tr>
		    	<td>
					<table class="noborder kerajaan">
						 <tr>
					    	<td><strong>BAHAGIAN I (Diisi oleh Pemohon)	</strong></td>
					    </tr>
					    <tr>
					    	<td><strong>A. BUTIR-BUTIR PERIBADI</strong></td>
					    </tr>
						<tr>
							<td>1. Nama </td><td>&nbsp;: <?= $model->nama ?></td>
						</tr>
						<tr>
							<td>2. No. Kad Pengenalan </td><td>&nbsp;: <?= $model->no_kp ?></td>
						</tr>
						<tr>
							<td>3. Gelaran Jawatan </td><td>&nbsp;: <?= $model->jawatan ?></td>
						</tr>
						<tr>
							<td>4. Gred Jawatan </td><td>&nbsp;: <?= $model->gred_jawatan?></td>
						</tr>
						<tr>
							<td>5. Taraf Jawatan </td><td>&nbsp;: <?= $taraf_jawatan[$model->taraf_jawatan] ?></td>
						</tr>
						<tr>
							<td>6. No. Gaji </td><td>&nbsp;: <?= $model->no_gaji ?></td>
						</tr>
						<tr>
							<td>7. Gaji Asas </td><td>&nbsp;: <?= $model->gaji ?></td>
						</tr>
						<tr>
							<td>8. No. Talifon </td><td>&nbsp;: <?= $model->no_hp ?></td>
						</tr>
						<tr>
							<td>9. Emel </td><td>&nbsp;: <?= $model->email ?></td>
						</tr>
						<tr>
							<td>10. No. Akaun Bank </td><td>&nbsp;: <?= $model->akaun_bank ?></td>
						</tr>
						<tr>
							<td>11. Nama Bank dan Alamat </td><td>&nbsp;: <?= $model->bank ?></td>
						</tr>
						<tr>
							<td>12. Nama Agensi/Jabatan/Syarikat </td><td>&nbsp;: <?= $model->jabatan ?></td>
						</tr>
						<tr>
							<td>13. Alamat Agensi/Jabatan/Syarikat </td><td>&nbsp;: <?= $model->alamat_jabatan ?></td>
						</tr>
					</table>
					<table class="noborder swasta">
						 <tr>
					    	<td><strong>BAHAGIAN I (Diisi oleh Pemohon)	</strong></td>
					    </tr>
					    <tr>
					    	<td><strong>A. BUTIR-BUTIR PERIBADI</strong></td>
					    </tr>
						<tr>
							<td>1. Nama </td><td>&nbsp;: <?= $model->nama ?></td>
						</tr>
						<tr>
							<td>2. No. Kad Pengenalan </td><td>&nbsp;: <?= $model->no_kp ?></td>
						</tr>
						<tr>
							<td>3. Alamat </td><td>&nbsp;: <?= $model->alamat_jabatan ?></td>
						</tr>
						<tr>
							<td>4. Kelayakan Akademik </td><td>&nbsp;: <?= getKelayakan($model->kelayakan) ?></td>
						</tr>
						<tr>
							<td>5. No. Talifon </td><td>&nbsp;: <?= $model->no_hp ?></td>
						</tr>
						<tr>
							<td>6. Emel </td><td>&nbsp;: <?= $model->email ?></td>
						</tr>
						<tr>
							<td>7. No. Akaun Bank </td><td>&nbsp;: <?= $model->akaun_bank ?></td>
						</tr>
						<tr>
							<td>8. Nama Bank dan Alamat </td><td>&nbsp;: <?= $model->bank ?></td>
						</tr>
					</table>
		    	</td>
		    </tr>
		    <tr>
		    	<td>
		    		<table class="noborder">
					    <tr>
					    	<td><strong>B. BUTIR-BUTIR PERMOHONAN</strong></td>
					    </tr>
					 </table>
		    		<table class="table-condensed table-bordered table">
		    			<thead>
		    				<tr>
		    					<th>Bil</th>
		    					<th>Nama Jabatan yang menganjurkan kursus/ceramah</th>
		    					<th>Tarikh Kursus</th>
		    					<th>Jam</th>
		    					<th>Tuntutan (RM)</th>
		    				</tr>
		    			</thead>
		    			<tbody>
		    				<?php
		    					$i = 1;
		    					$jumlah_besar = 0;
		    					foreach ($model_details as $key => $value) {
		    				?>
		    				<tr>
		    					<td><?= $i ?></td>
		    					<td><?= $value->nama_ceramah ?></td>
		    					<td><?= Yii::$app->formatter->asDate($value->tarikh, 'dd-MM-yyyy'); ?></td>
		    					<td class="text-right"><?= $value->tempoh ?></td>
		    					<td class="text-right"><?= number_format($value->jumlah, 2) ?></td>
		    				</tr>
		    				<?php
		    						$jumlah_besar += $value->jumlah;
		    						$i++;
		    					}
		    				?>
		    			</tbody>
		    			<tfoot>
		    				<tr>
		    					<th colspan="4">Jumlah Besar</th><th class="text-right"><?= number_format($jumlah_besar, 2) ?></th>
		    				</tr>
		    			</tfoot>
		    		</table>
		    	</td>
		    </tr>
    	</tbody>
	</table>
	<table width="98%" border="0" align="center" class="noborder">
    	<tr>
        	<td>
        		2. Jumlah besar tuntutan bulanan di para 1 di atas adalah selaras dengan  kelayakan saya seperti ditetapkan di perenggan 2.1 dalam 1Pekeliling Perbendaharaan WP1.8/2013;
        	</td>
      	</tr>
      	<tr><td>atau</td></tr>
      	<tr>
      		<td>
      			3.	Jumlah besar tuntutan bulanan di para 1 di atas adalah melebihi  kelayakan saya seperti ditetapkan di perenggan 2.1 dalam 1Pekeliling Perbendaharaan WP1.8/2013  dan saya telah memulangkan balik lebihan bayaran saguhati yang diterima tersebut iaitu sebanyak RM........................... kepada Kementerian / Jabatan / Agensi.......................................................................Bil.................................................. bertarikh ..........................................
      		</td>
      	</tr>
      	<tr>
      		<td>
      			<p>&nbsp;</p>
      			<p>
					Saya mengaku butir-butir yang dinyatakan di atas adalah benar.
				</p>

				Tandatangan Pemohon	: ....................................<br>
				Nama	: <?= $model->nama ?><br>
				Tarikh	: <?= date('d-m-Y') ?><br>
      		</td>
      	</tr>
    </table>
    <table width="98%" border="0" align="center" class="noborder">
    	<tr><td></td></tr>
    	<tr>
    		<td><strong>BAHAGIAN II</strong></td>
    	</tr>
    	<tr>
    		<td>A. Ulasan Ketua Jabatan</td>
    	</tr>
    	<tr>
    		<td>
    			<table width="98%" border="0">
		            <tr>
		              <td width="60%">Tarikh: ...............................</td>
		              <td width="10%">Tandatangan<br>
		                Nama<br>
		                Jawatan<br>
		                Cop Jabatan </td>
		              <td width="30%">: .................................<br>
		                : .................................<br>
		                : .................................<br>
		                : .................................</td>
		            </tr>
		          </table>

    		</td>
    	</tr>
    	<tr>
    		<td>B. Pengesahan Ketua Jabatan</td>
    	</tr>
    	<tr>
    		<td>
    			Disahkan bahawa pegawai ini adalah seorang pensyarah/penceramah sambilan golongan pakar/bukan golongan pakar*
    		</td>
    	</tr>
    	<tr>
    		<td>
    			<table width="98%" border="0">
		            <tr>
		              <td width="60%">Tarikh: ...............................</td>
		              <td width="10%"><br>Tandatangan<br>
		                Nama<br>
		                Jawatan<br>
		                 Cop Jabatan </td>
		              <td width="30%">: .................................<br>
		                : .................................<br>
		                : .................................<br>
		                : .................................</td>
		            </tr>
		            <tr>
		            	<td> * Potong yang mana tidak berkenaan.</td>
		            </tr>
		          </table>
    		</td>
    	</tr>
    	<tr>
    		<td>
    			<table width="98%" border="0">
    				<tr>
    					<td>
    						<strong>BAHAGIAN III (Diisi oleh Kementerian/Jabatan/Agensi Penganjur)</strong>
    					</td>
    				</tr>
    				<tr>
    					<td>1. Keputusan Permohonan</td>
    				</tr>
		            <tr><td colspan="3">Diluluskan / Tidak diluluskan *</td>
		            <tr>
		              <td width="60%">Tarikh: ...............................</td>
		              <td width="10%">Tandatangan<br>
		                Nama<br>
		                Jawatan<br>
		                 Cop Jabatan </td>
		              <td width="30%">: .................................<br>
		                : .................................<br>
		                : .................................<br>
		                : .................................</td>
		            </tr>
		            <tr>
		            	<td> * Potong yang mana tidak berkenaan.</td>
		            </tr>
		          </table>

    		</td>
    	</tr>
    </table>
</div>

<?php

function getKelayakan($no) {
	if($no == 400)
		return "PhD";
	if($no == 300)
		return "Sarjana";
	if($no == 200)
		return "Sarjana Muda";
	if($no == 100)
		return "Diploma/Siji";	
}

$this->registerJs('

	
	var jenis = '.$model->jenis_penceramah.';
	if(jenis == 0) {
		$(".kerajaan").show();
		$(".swasta").hide();
	}
	else {
		$(".kerajaan").hide();
		$(".swasta").show();
	}

	function numberToWord(num) {
	
		var number = new Array("Satu","Dua","Tiga", "Empat", "Lima", "Enam", "Tujuh", "Lapan", "Sembilan");
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
				if(num.charAt(l-i+1)/1 == 0) {
					w += " Sepuluh ";
				}
				else if(num.charAt(l-i)/1 == 1) {
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
		return w;
		// document.write(w);
	}


');

$this->registerCss('

	.noborder tr td, .print tr td {
		padding: 4px;
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
		top: 70px;
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

        .panel {
        	 margin-top: -100px;
        }


		#rujukan {
			top: 0px;
		}
	}
	

');
?>