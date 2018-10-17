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
$waktu_masuk = [1 => '7:30 AM', '8:00 AM', '8:30 AM', '9:00 AM'];
$waktu_pulang = [1 => '2:30 PM', '3:00 PM', '3:30 PM', '4:00 PM', '4:30 PM', '5:00 PM', '5:30 PM', '6:00 PM'];
?>
<div id="rujukan">
	<?= 'No: '.$model->kod_id ?><br>
	<?= 'OS: '.$model->kodUnjuran->os ?>
</div>
<div class="panel panel-default">
	<table width="900" border="1" align="center" class="table table-bordered">
	    <tbody>
		    <tr>
				<td colspan="4" align="center"><strong>PENYATA TUNTUTAN ELAUN LEBIH MASA								
				</strong></td>
		    </tr>
		    <tr>
		     	<td colspan="4" align="center"><strong>BAGI BULAN <?= strtoupper($months[$model->bulan].' '.$model->tahun) ?></strong></td>
		    </tr>
		    <tr>
		    	<td valign="top">
		    		<p>NAMA (HURUF BESAR)</p>
		    		<p>No. Kad Pengenalan</p>
		    		<p>No. Telefon</p>
		    		<p>Alamat Emel</p>
		    	</td>
		    	<td valign="top"><p><?= strtoupper($model->nama) ?></p>
	    			<p><?= strtoupper($model->no_kp) ?></p>
	    			
	    			<p><?= strtoupper($model->no_hp) ?></p>
	    			<p><?= strtolower($model->email) ?></p>
	    			
	    			
	    		</td>
	    		<td valign="top">
		    		<p>No. Gaji</p>
		    		<p>Gaji Asas</p>
		    		<p>Kadar elaun sejam</p>
		    		<p>Jawatan</p>
		    	</td>
		    	<td valign="top">
		    		<p><?= strtoupper($model->no_gaji) ?></p>
		    		<p><?= 'RM'.number_format($model->gaji_asas, 2) ?></p>
		    		<p><?= 'RM'.number_format($model->kadar_sejam, 2) ?></p>
		    		<p><?= strtoupper($model->jawatan).' '.strtoupper($model->gred_jawatan)  ?></p>
		    	</td>
    		</tr>
    		<tr>
    			<td>Nama Bank / Cawangan</td>
    			<td><?= $model->bank.' / '.$model->cawangan_bank ?></td>
    			<td>No. Akaun Bank</td>
    			<td><?= $model->akaun_bank ?></td>
    		</tr>
    		<tr>
    			<td colspan="4">
	    			<div style="margin: 10px;"></div>
	    			<table class="table table-condensed table-bordered">
	    				<thead>
	    					<tr>
	    						<th rowspan="2" valign="center">
	    							Tarikh
	    						</th>
	    						<th colspan="2">
	    							Hari Bekerja
	    						</th>
	    				
	    						<th colspan="2">
	    							Kerja Lebih Masa
	    						</th>
	    						<th rowspan="2">
	    							Jumlah Jam
	    						</th>
	    						<th colspan="2">
	    							Hari Bekerja<br> Biasa
	    						</th>
	    						<th colspan="2">
	    							Hari Rehat<br> Biasa
	    						</th>
	    						<th colspan="2">
	    							Hari Bekerja<br> Kelepasan AM
	    						</th>
	    						<th rowspan="2">
	    							Butiran Tugas
	    						</th>
	    					</tr>
	    						<th>
	    							Mula
	    						</th>
	    						<th>
	    							Akhir
	    						</th>
	    						<th>
	    							Mula
	    						</th>
	    						<th>
	    							Akhir
	    						</th>
	    						<th>
	    							Siang
	    						</th>
	    						<th>
	    							Malam
	    						</th>
	    						<th>
	    							Siang
	    						</th>
	    						<th>
	    							Malam
	    						</th>
	    						<th>
	    							Siang
	    						</th>
	    						<th>
	    							Malam
	    						</th>
	    					</tr>
	    				</thead>
	    				<tbody>
	    					<?php
	    						foreach ($model_details as $key => $value) {
	    					?>
	    					</tr>
	    						<td><?= $value->tarikh.'<br>'.$value->hari ?></td>
	    						<td>
	    							<?= $waktu_masuk[$value->waktu_masuk] ?>
	    						</td>
	    						<td>
	    							<?= $waktu_pulang[$value->waktu_pulang] ?>
	    						</td>
	    						<td>
	    							<?= date("g:i A", strtotime($value->ot_mula)) ?>
	    						</td>
	    						<td>
	    							<?= date("g:i A", strtotime($value->ot_akhir)) ?>
	    						</td>
	    						<td class="text-right jam-layak"><?= number_format($value->jam_layak, 2) ?></td>
	    						<td class="hari-kerja-siang text-right">
	    							<?php
	    								if($value->kod_hari == 'A' && $value->kod_waktu == 1) {
	    									echo $value->jam_layak * $this->context->getRateDay($value->kod_hari.$value->kod_waktu);
	    								}
	    							?>
	    						</td>
	    						<td class="hari-kerja-malam text-right">
	    							<?php
	    								if($value->kod_hari == 'A' && $value->kod_waktu == 2) {
	    									echo $value->jam_layak * $this->context->getRateDay($value->kod_hari.$value->kod_waktu);
	    								}
	    							?>
	    						</td>
	    						<td class="hari-minggu-siang text-right">
	    							<?php
	    								if($value->kod_hari == 'B' && $value->kod_waktu == 1) {
	    									echo $value->jam_layak * $this->context->getRateDay($value->kod_hari.$value->kod_waktu);
	    								}
	    							?>
	    						</td>
	    						<td class="hari-minggu-malam text-right">
	    							<?php
	    								if($value->kod_hari == 'B' && $value->kod_waktu == 2) {
	    									echo $value->jam_layak * $this->context->getRateDay($value->kod_hari.$value->kod_waktu);
	    								}
	    							?>
	    						</td>
	    						<td class="hari-cuti-siang text-right">
	    							<?php
	    								if($value->kod_hari == 'C' && $value->kod_waktu == 1) {
	    									echo $value->jam_layak * $this->context->getRateDay($value->kod_hari.$value->kod_waktu);
	    								}
	    							?>
	    						</td>
	    						<td class="hari-cuti-malam text-right">
	    							<?php
	    								if($value->kod_hari == 'C' && $value->kod_waktu == 2) {
	    									echo $value->jam_layak * $this->context->getRateDay($value->kod_hari.$value->kod_waktu);
	    								}
	    							?>
	    						</td>
	    						<td><?= $value->butiran ?></td>
	    					</tr>
	    					<?php
	    						}
	    					?>
	    				</tbody>
	    				<tfoot>
	    					</tr>
	    						<th colspan="5" class="text-right">
	    							Jumlah
	    						</th>
	    						<th id="jumlah-jam-layak" class="text-right">
	    							Malam
	    						</th>
	    						<th id="jumlah-hari-kerja-siang" class="jumlah-point text-right">
	    							Siang
	    						</th>
	    						<th id="jumlah-hari-kerja-malam" class="jumlah-point text-right">
	    							Malam
	    						</th>
	    						<th id="jumlah-hari-minggu-siang" class="jumlah-point text-right">
	    							Siang
	    						</th>
	    						<th id="jumlah-hari-minggu-malam" class="jumlah-point text-right">
	    							Malam
	    						</th>
	    						<th id="jumlah-hari-cuti-siang" class="jumlah-point text-right">
	    							Siang
	    						</th>
	    						<th id="jumlah-hari-cuti-malam" class="jumlah-point text-right">
	    							Malam
	    						</th>
	    						<th id="jumlah-jumlah">Butir</th>
	    					</tr>
	    					<tr>
	    						<th colspan="5" class="text-right">Ringgit Malaysia</th>
	    						<th colspan="8" id="rm"></th>
	    					</tr>
	    				</tfoot>
	    			</table>
	    		</td>
    		</tr>
    	</tbody>
	</table>
	<table width="90%" border="0" align="center">
      <tr>
        <td><p>Dengan ini saya mengakui bahawa kerja lebih masa<br />
          tersebut adalah benar dilakukan oleh saya</p>
          <p>___________________________________<br />
            (Tandatangan Pegawai Penuntut)</p>
          <p>Disahkan betul</p>
        <p><br />
          ____________________________<br />
(Tandatangan Ketua Bahagian)</p></td>
        <td><p>Adalah diakui dan disahkan semua tarikh, masa, bilangan jam dan tempat serta<br />
          keterangan bertugas di atas adalah benar dan diluluskan untuk pembayaran.</p>
          <p>Dengan ini saya mengesahkan bahawa pegawai ini dikehendaki menjalankan kerja lebih masa<br />
          mengikut Perintah Am Bac C dan tuntutan ini adalah benar</p>
          <p>&nbsp;</p>
          <p>_________________________________<br />
            (Tandatangan Ketua Jabatan)
          </p></td>
      </tr>
    </table>
    <p>&nbsp;</p>
    <hr style="page-break-before:always" />
    <table align="center">
    	<tr>
    	  <td><strong>PERINGATAN</strong><br />
    	    Sila sertakan sijil untuk tuntutan yang melebihi 1/3 gaji, dengan mengemukakan sebab-sebab<br />
    	    pegawai dibenarkan menuntut elaun lebih masa yang melebihi 1/3 gaji beliau dan hendaklah disahkan oleh Ketua Jabatan</td></tr>
    	<tr>
    	  <td>&nbsp;</td>
  	  </tr>
    	<tr>
    	  <td>&nbsp;</td>
  	  </tr>
    	<tr>
    	  <td>&nbsp;</td>
  	  </tr>
    	<tr>
    	  <td><p>Disahkan bahawa ini telah melebihi had elaun lebih masa yang dibenarkan mengikut syarat-syarat<br />
    	    yang terkandung di dalam Surat Pekeliling Bil. 21 Tahun 1977 (JPA.256/4/1-6(28) bertarikh 5 September 1977</p>
    	    <p>Sebab-sebab pegawai ini dibenarkan menuntut elaun lebih masa yang melebihi 1/3 gaji beliau adalah seperti berikut:-</p>
    	    <p>a)</p></td>
  	  </tr>
    	<tr>
    	  <td>&nbsp;</td>
  	  </tr>
    	<tr>
    	  <td>&nbsp;</td>
  	  </tr>
    	<tr>
    	  <td align="right"><p>_________________________</p>
   	      <p>(Ketua Jabatan)<br />
   	        Cop Jabatan
          </p></td>
  	  </tr>
    </table>

	
</div>

<?php

$this->registerJs('
	var jumlah_jam = 0;
	var jumlah_hari_kerja_siang = 0;
	var jumlah_hari_kerja_malam = 0;
	var jumlah_hari_minggu_siang = 0;
	var jumlah_hari_minggu_malam = 0;
	var jumlah_hari_cuti_siang = 0;
	var jumlah_hari_cuti_malam = 0;

	for(var i = 0; i < $(".jam-layak").length; i++) {
		jumlah_jam += $(".jam-layak").eq(i).text()/1;
		jumlah_hari_kerja_siang += $(".hari-kerja-siang").eq(i).text()/1;
		jumlah_hari_kerja_malam += $(".hari-kerja-malam").eq(i).text()/1;
		jumlah_hari_minggu_siang += $(".hari-minggu-siang").eq(i).text()/1;
		jumlah_hari_minggu_malam += $(".hari-minggu-malam").eq(i).text()/1;
		jumlah_hari_cuti_siang += $(".hari-cuti-siang").eq(i).text()/1;
		jumlah_hari_cuti_malam += $(".hari-cuti-malam").eq(i).text()/1;
	}
	$("#jumlah-jam-layak").text(jumlah_jam.toFixed(2));
	$("#jumlah-hari-kerja-siang").text(jumlah_hari_kerja_siang.toFixed(3));
	$("#jumlah-hari-kerja-malam").text(jumlah_hari_kerja_malam.toFixed(3));
	$("#jumlah-hari-minggu-siang").text(jumlah_hari_minggu_siang.toFixed(3));
	$("#jumlah-hari-minggu-malam").text(jumlah_hari_minggu_malam.toFixed(3));
	$("#jumlah-hari-cuti-siang").text(jumlah_hari_cuti_siang.toFixed(3));
	$("#jumlah-hari-cuti-malam").text(jumlah_hari_cuti_malam.toFixed(3));

	var jumlah_point = 0;
	$(".jumlah-point").each(function(){
		jumlah_point += $(this).text()/1;
	});
	var kadar_sejam = '.$model->kadar_sejam.';
	$("#jumlah-jumlah").html(jumlah_point.toFixed(3) + " X " + "RM" + kadar_sejam + "<br>RM" + (jumlah_point * kadar_sejam).toFixed(2) );
	$("#rm").html(numberToWord((kadar_sejam * jumlah_point).toFixed(2)));

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