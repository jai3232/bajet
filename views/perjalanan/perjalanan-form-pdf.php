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
            '07' => 'Jul', '08' => 'Ogo', '09' => 'Sep', '10' => 'Okt', '11' => 'Nov', '12' => 'Dis'
          ];
?>

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
		    	<td valign="top"><p><strong>NAMA (HURUF BESAR)</strong></p>
		    		<p>No. Kad Pengenalan</p>
		    		<p>No. Gaji</p>
		    		<p>No. Telefon</p>
		    		<p>Alamat Emel</p>
		    		<p>Gred/Kategori/Kumpulan</p>
		    		<p>Pendapatan (RM)</p>
		    	</td>
		    	<td valign="top"><p><strong><?= strtoupper($model->nama) ?>&nbsp;</strong></p>
	    			<p><?= strtoupper($model->no_kp) ?></p>
	    			<p><?= strtoupper($model->no_gaji) ?></p>
	    			<p><?= strtoupper($model->no_hp) ?></p>
	    			<p><?= strtolower($model->email) ?></p>
	    			<p><?= strtoupper($model->jawatan) ?></p>
	    			<table width="100%" border="0" cellpadding="0" cellspacing="0" class="noborder">
	    				<tbody>
	    					<tr>
		    					<td>Gaji: </td>
		    					<td align="right">RM</td>
		    					<td align="right" class="gaji"><?= number_format($model->gaji_asas, 2) ?></td>
		    					<td align="right">&nbsp;</td>
		    				</tr>
		    				<tr>
		    					<td>Elaun-elaun:</td>
		    					<td align="right">RM</td>
		    					<td align="right" class="gaji"><?= number_format($model->elaun, 2) ?></td>
		    					<td align="right">&nbsp;</td>
		    				</tr>
		    				<tr>
		    					<td>Elaun Memangku:</td>
		    					<td align="right">RM</td>
		    					<td align="right" class="gaji"><?= number_format($model->elaun_mangku, 2) ?></td>
		    					<td align="right">&nbsp;</td>
		    				</tr>
		    				<tr style="border-top:1px solid black;">
		    					<td style="border-top:1px solid black;">Jumlah Pendapatan:</td>
		    					<td style="border-top:1px solid black;" align="right">RM</td>
		    					<td style="border-top:1px solid black;" align="right">
		    						<?= number_format($model->gaji_asas + $model->elaun + $model->elaun_mangku, 2); ?>
		    					</td>
		    					<td align="right">&nbsp;</td>
		    				</tr>
	    				</tbody>
	    			</table>
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
    			<td>Kenderaan</td>
    			<td><table width="100%" border="0" cellpadding="0" cellspacing="0" class="noborder">
    				<tbody><tr>
    					<td>Jenis Model</td>
    					<td>: <?= $model->model_kereta ?>7</td>
    				</tr>
    				<tr>
    					<td>No. Pendaftaran</td>
    					<td>: <?= $model->no_plate ?></td>
    				</tr>
    				<tr>
    					<td>Kuasa (CC)</td>
    					<td>: <?= $model->cc ?></td>
    				</tr>
    				<tr>
    					<td>Kelas Tuntutan</td>
    					<td>: <?= $model->kelas_tuntutan ?></td>
    				</tr>
    			</tbody></table></td>
    		</tr>
    		<tr>
    			<td>Alamat Pejabat</td>
    			<td><?= $model->alamat_pejabat ?></td>
    		</tr>
    		<tr>
    			<td>Alamat Rumah</td>
    			<td><?= $model->alamat_rumah ?></td>
    		</tr>
    	</tbody>
	</table>
	
</div>
<div class="break"></div>
<div class="panel panel-default">
	<table width="900" border="1" align="center" class="semakan table table-bordered">
		<tbody>
			<tr>
				<td width="80" rowspan="2" align="center"><strong>Tarikh</strong></td>
				<td colspan="2" align="center"><strong>Waktu</strong></td>
				<td rowspan="2" align="center"><strong>Tujuan / Tempat</strong></td>
				<td width="70" rowspan="2" align="center"><strong>Jarak (KM)</strong></td>
				<td width="70" rowspan="2" align="center"><strong>Jumlah Tol (RM)</strong></td>
			</tr>
			<tr>
				<td width="80" align="center"><strong>Bertolak</strong></td>
				<td width="80" align="center"><strong>Sampai</strong></td>
			</tr>
			<?php 
				$jumah_jarak = 0;
				$jumlah_kos = 0;
				foreach ($model_details as $key => $value) {
			?>
			<tr>
				<td align="center"><?= Yii::$app->formatter->asDate($value->tarikh, 'dd-M-Y') ?></td>
				<td align="center"><?= date("g:i A", strtotime($value->bertolak)) ?></td>
				<td align="center"><?=  date("g:i A", strtotime($value->sampai)) ?></td>
				<td align="left"><?= $value->tujuan ?></td>
				<td align="center"><?= $value->jarak ?></td>
				<td align="right"><?= number_format($value->kos, 2) ?></td>
			</tr>
			<?php
				$jumah_jarak += $value->jarak;
				$jumlah_kos += $value->kos;
				}
			?>
			<tr><th colspan="4" class="text-right">Jumlah</th><th class="text-center"><?= $jumah_jarak ?></th><th class="text-right"><?= number_format($jumlah_kos, 2) ?></th></tr>
		</tbody>
	</table>
</div>
<div class="break"></div>
<div class="panel panel-default">
	<table width="898" border="1" align="center" class="semakan table table-bordered print">
		<thead>
			<tr>
				<th align="center">C. TUNTUTAN  ELAUN PERJALANAN KENDERAAN(OL 21104)</th>
			</tr>
			<tr>
				<td align="center">Jumlah Kilometer X Sen / Kilometer</td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td align="right">
					<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
						<tbody class="noborder">
							<tr>
								<td width="27%">500 KM Pertama </td>
								<td width="14%" align="center" id="km1">0</td>
								<td width="14%" align="center">KM X</td>
								<td width="19%" align="center" id="kadar1">0</td>
								<td width="13%" align="center">sen/KM</td>
								<td width="13%" align="right" id="kadar_jarak1">0</td>
							</tr>
							<tr>
								<td>501 KM - 1000 KM</td>
								<td align="center" id="km2"></td>
								<td align="center">KM X</td>
								<td align="center" id="kadar2">0</td>
								<td align="center">sen/KM</td>
								<td align="right" id="kadar_jarak2">0.00</td>
							</tr>
							<tr>
								<td>1001 KM - 1700 KM</td>
								<td align="center" id="km3"></td>
								<td align="center">KM X</td>
								<td align="center" id="kadar3">0</td>
								<td align="center">sen/KM</td>
								<td align="right" id="kadar_jarak3">0.00</td>
							</tr>
							<tr>
								<td>1701 KM ke atas</td>
								<td align="center" id="km4"></td>
								<td align="center">KM X</td>
								<td align="center" id="kadar4">0</td>
								<td align="center">sen/KM</td>
								<td align="right" id="kadar_jarak4">0.00</td>
							</tr>
							<tr>
								<td><strong>Jumlah (KM)</strong></td>
								<td align="center" id="jumlah_km">0</td>
								<td align="center"><br></td>
								<!-- <td align="center" id="kadar5">&nbsp;</td> -->
								<td colspan="2" align="center"><strong>Jumlah (RM)</strong></td>
								<td align="right" id="jumlah_kadar_jarak"></td>
							</tr>
							<tr>
								<td colspan="5" align="right"><strong>Perjalanan yang telah dilakukan pada bulan yang sedang dituntut sebanyak <span class="perjalanan_lalu">0</span> Km</strong>:</td>
								<td align="right" id="tolak_kadar_jarak">0.00</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
			<tr>
				<td align="right" id="jumlah_kadar_jarak4" style="font-weight:bold;">
					<table width="200" border="0" class="noborder">
						<tbody>
							<tr>
								<td align="right">Jumlah (RM)</td>
								<td align="right" id="jumlah_kadar_jarak2"></td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
		</tbody>
	</table>
</div>
<div class="panel panel-default">
	<table width="898" border="1" align="center" class="semakan table table-bordered print">
		<thead>
			<tr><th class="text-center">D. TUNTUTAN ELAUN MAKAN DAN HARIAN(OL21101)</th></tr>
		</thead>
		<tbody>
			<tr>
				<td>
					<table width="100%" border="0" class="noborder" cellspacing="0" cellpadding="0">
						<tbody>
							<tr>
								<td id="kali1"><?= $model->kali_makan ?></td>
								<td>X Elaun Makan sebanyak</td>
								<td class="text-right">RM</td>
								<td align="left" id="elaun_sehari1"><?= $model->elaun_makan ?></td>
								<td>(<span id="kadar_elaun1">100</span>%)</td>
								<td>sehari di semananjung</td>
								<td align="right" id="jumlah_elaun1"><?= number_format(($model->kali_makan * $model->elaun_makan), 2) ?></td>
							</tr>
							<tr>
								<td id="kali2"><?= $model->kali_harian ?></td>
								<td>X Elaun Harian sebanyak</td>
								<td class="text-right">RM</td>
								<td align="left" id="elaun_sehari2"><?= $model->elaun_harian ?></td>
								<td>(<span id="kadar_elaun2">100</span>%)</td>
								<td> sehari di semananjung</td>
								<td align="right" id="jumlah_elaun2"><?= number_format(($model->kali_harian * $model->elaun_harian), 2) ?></td>
							</tr>
							<tr>
								<td id="kali3"><?= $model->kali_makan_sabah ?></td>
								<td>X Elaun Makan sebanyak</td>
								<td class="text-right">RM</td>
								<td align="left" id="elaun_sehari3"><?= $model->elaun_makan_sabah ?></td>
								<td>(<span id="kadar_elaun3">100</span>%)</td>
								<td> sehari di Sabah / Sarawak</td>
								<td align="right" id="jumlah_elaun3"><?= number_format(($model->kali_makan_sabah * $model->elaun_makan_sabah), 2) ?></td>
							</tr>
							<tr>
								<td id="kali4"><?= $model->kali_harian_sabah ?></td>
								<td>X Elaun Harian sebanyak</td>
								<td class="text-right">RM</td>
								<td align="left" id="elaun_sehari4"><?= $model->elaun_harian_sabah ?></td>
								<td>(<span id="kadar_elaun4">100</span>%)</td>
								<td> sehari di Sabah / Sarawak</td>
								<td align="right" id="jumlah_elaun4"><?= number_format(($model->kali_harian_sabah * $model->elaun_harian_sabah), 2) ?></td>
							</tr>
							<tr>
								<td id="kali5"><?= $model->kali_elaun_luar ?></td>
								<td>X Elaun Makan sebanyak</td>
								<td class="text-right">RM</td>
								<td align="left" id="elaun_sehari5"><?= $model->elaun_luar ?></td>
								<td>(<span id="kadar_elaun5">100</span>%)</td>
								<td>sehari luar negara</td>
								<td align="right" id="jumlah_elaun5"><?= number_format(($model->kali_elaun_luar * $model->elaun_luar), 2) ?></td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
			<tr>
				<td align="right" class="text-right" style="font-weight:bold;">
					<table width="200" border="0" align="right" class="noborder">
						<tbody>
							<tr>
								<td align="right">Jumlah (RM)</td>
								<td align="right" id="jumlah_elaun_makan_harian">
									
								</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
		</tbody>
	</table>
</div>
<div class="panel panel-default">
	<table width="898" border="1" align="center" class="semakan table table-bordered print">
		<thead>
			<tr><th colspan="7" class="text-center">E. TUNTUTAN BAYARAN SEWA HOTEL (*)(BSH) / ELAUN LOJING (OL21102)</th></tr>
		</thead>
		<tbody>
			<tr>
			    <td align="right">
			    	<table width="100%" border="0" class="noborder">
			    		<tbody>
			    			<?php
			    				$kos_hotel = 0;
			    				foreach ($model_hotels as $key => $value) {
			    					$kos_hotel += ($value->kos_hotel * $value->kali_hotel);
			    			?>
			    			<tr style="border: none!important;">
						        <td class="kali_hotel"><?= $value->kali_hotel ?></td>
						        <td>hari x Bayaran Sewa Hotel <?= $key + 1 ?> sebanyak</td>
						        <td>RM<span class="hotel"><?= number_format($value->kos_hotel, 2) ?></span> sehari</td>
						        <td align="right" class="penginapan"><?= number_format($value->kali_hotel * $value->kos_hotel, 2) ?></td>
					     	</tr>
					     	<?php
					     		}
					     	?>
					      	<tr>
						        <td>&nbsp;</td>
						        <td>Bayaran Perkhidmatan dan Cukai Perkhidmatan. 6% GST + 10% Perkhidmatan (OL21199)</td>
						        <td>&nbsp;</td>
						        <td align="right" class="penginapan"><?= number_format($model->cukai, 2) ?></td>
					    	</tr>
					    	<tr>
						        <td id="kali_lojing"><?= $model->kali_lojing ?></td>
						        <td>hari x Elaun Lojing sebanyak</td>
						        <td>RM<span id="lojing"><?= number_format($model->lojing, 2) ?></span> sehari </td>
						        <td align="right" class="penginapan" id="jumlah_lojing"><?= number_format($model->lojing * $model->kali_lojing, 2) ?></td>
					    	</tr>
					    </tbody>
					</table>
				</td>
			  </tr>
		</tbody>
		<tfoot>
			<tr>
				<td align="right" style="font-weight: bold;">
					<table width="200" border="0" class="noborder">
				        <tbody>
				        	<tr>
						        <th align="right">Jumlah (RM)</th>
						        <th align="right" id="jumlah_elaun_penginapan"><?= number_format($kos_hotel + $model->cukai + ($model->lojing * $model->kali_lojing), 2) ?></th>
				        	</tr>
				    	</tbody>
					</table>
				</td>
			</tr>
		</tfoot>
	</table>
</div>
<div class="break"></div>
<div class="panel panel-default">
	<?php 
		function receiptStatus($s, $value) {
			if(is_null($value))
				return;
			if($s == 3)
				return 'Touch & Go';
			return $s == 1 ? 'Dilampirkan' : 'Tanpa Resit';
		}
	?>
	<table width="898" border="1" align="center" class="semakan table table-bordered print">
		<thead>
			<tr><th class="text-center">F. TUNTUTAN TAMBANG PENGANGKUTAN AWAM (*)</th></tr>
		</thead>
		<tbody>
			<tr>
				<td>
					<table width="100%" border="0" class="noborder">
						<tbody>
							<tr>
								<td>Teksi(OL21104)</td>
								<td>[ Resit : <?= receiptStatus($model->resit_teksi, $model->teksi) ?> ]</td>
								<td align="right"><span class="tambang"><?= number_format($model->teksi, 2) ?></span></td>
							</tr>
							<tr>
								<td>Bas(OL21104)</td>
								<td>[ Resit : <?= receiptStatus($model->resit_bas, $model->bas) ?>  
								]</td>
								<td align="right"><span class="tambang"><?= number_format($model->bas, 2) ?></span></td>
							</tr>
							<tr>
								<td>Kereta Api(OL21103)</td>
								<td>[ Resit : <?= receiptStatus($model->resit_keretapi, $model->keretapi) ?> 
								]</td>
								<td align="right"><span class="tambang"><?= number_format($model->keretapi, 2) ?></span></td>
							</tr>
							<tr>
								<td>Terbang(OL21106)</td>
								<td>[ Resit : <?= receiptStatus($model->resit_terbang, $model->terbang) ?>  
								]</td>
								<td align="right"><span class="tambang"><?= number_format($model->terbang, 2) ?></span></td>
							</tr>
							<tr>
								<td>Feri(OL21105)</td>
								<td>[ Resit : <?= receiptStatus($model->resit_feri, $model->feri) ?>   
								]</td>
								<td align="right"><span class="tambang"><?= number_format($model->feri, 2) ?></span></td>
							</tr>
							<tr>
								<td>Lain-lain</td>
								<td>[ Resit : <?= receiptStatus($model->resit_lain, $model->lain) ?>  
								]</td>
								<td align="right"><span class="tambang"><?= number_format($model->lain, 2) ?></span></td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
		</tbody>
		<tfoot>
			<tr>
				<th>
					<table width="200" border="0" align="right" class="noborder">
				        <tbody>
				    		<tr>
				        		<th align="right">Jumlah (RM)</th>
				        		<th align="right" id="jumlah_tambang">
				        			<?= number_format($model->teksi + $model->bas + $model->keretapi + $model->terbang + $model->feri + $model->lain, 2) ?>
				        		</th>
				      		</tr>
				    	</tbody>
				    </table>
				</th>
			</tr>
		</tfoot>
	</table>
</div>
<div class="panel panel-default">
	<table width="898" border="1" align="center" class="semakan table table-bordered print">
		<thead>
			<tr><th class="text-center">G. TUNTUTAN PELBAGAI (*) (OL21199)</th></tr>
		</thead>
		<tbody>
			<tr>
				<td>
					<table width="100%" border="0" class="noborder" cellpadding="0" cellspacing="0">
						<tbody>
							<tr>
								<td>Tol (Touch &amp; Go: <?= $model->no_tg ?>)</td>
								<td>[ Resit : <?= receiptStatus($model->resit_tol, $model->tol) ?> ]
								</td>
								<td align="right" class="pelabagai"><?= number_format($model->tol, 2) ?></td>
							</tr>
							<tr>
								<td>Tempat Letak Kereta</td>
								<td>[ Resit : <?= receiptStatus($model->resit_pakir, $model->pakir) ?>
								]</td>
								<td align="right"><span class="pelabagai"><?= number_format($model->pakir, 2) ?></span></td>
							</tr>
							<tr>
								<td>Dobi</td>
								<td>[ Resit : <?= receiptStatus($model->resit_dobi, $model->dobi) ?>
								]</td>
								<td align="right"><span class="pelabagai"><?= number_format($model->dobi, 2) ?></span></td>
							</tr>
							<tr>
								<td>Pos</td>
								<td>[ Resit : <?= receiptStatus($model->resit_pos, $model->pos) ?>
								]</td>
								<td align="right"><span class="pelabagai"><?= number_format($model->pos, 2) ?></span></td>
							</tr>
							<tr>
								<td>Telefon, Teleks, Faks</td>
								<td>[ Resit : <?= receiptStatus($model->resit_telefon, $model->telefon) ?>
								]</td>
								<td align="right"><span class="pelabagai"><?= number_format($model->telefon, 2) ?></span></td>
							</tr>
							<tr>
								<td>Kerugian pertukaran wang asing</td>
								<td>[ Resit : <?= receiptStatus($model->resit_tukaran, $model->tukaran) ?>
								]</td>
								<td align="right"><span class="pelabagai"><?= number_format($model->tukaran, 2) ?></span></td>
							</tr>
							<tr>
								<td colspan="3">(@3%)[Bagi Singapura, Selatan Thailand, Kalimantan dan Brunei Darussalam sahaja]</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
		</tbody>
		<tfoot>			
			<tr>
				<th>
					<table width="300" border="0" align="right" class="noborder">
						<tbody>
							<tr style="font-size: 1.1em;">
								<th align="right">Jumlah Tuntutan (RM)</th>
								<th align="right" class="text-right" id="jumlah_tuntutan">0.00</th>
							</tr>
						</tbody>
					</table><br>
					<table border="0" align="left" class="noborder">
					    <tbody>
					    	<tr>
					        	<th id="words" style="font-size: 1.1em;"></th>
					        </tr>
					    </tbody>
					</table>
				</th>
			</tr>
			<tr>
				<th>
					<table width="200" border="0" align="right" class="noborder">
				        <tbody>
				    		<tr>
				        		<th align="right">Jumlah (RM)</th>
				        		<th align="right" id="jumlah_pelbagai">
				        			<?= number_format($model->tol + $model->pakir + $model->dobi + $model->pos + $model->telefon + $model->tukaran, 2) ?>
				        		</th>
				      		</tr>
				    	</tbody>
				    </table>
				</th>
			</tr>
		</tfoot>
	</table>
</div>
<div class="break"></div>
<div class="panel panel-default">
	<table width="898" border="1" align="center" class="semakan table table-bordered print">
		<thead>
			<tr><th class="text-center">H. PENGAKUAN</th></tr>
		</thead>
		<tbody>
			<tr>
				<td>
					<table width="98%" border="0" align="center" class="noborder">
				        <tbody>
				        	<tr>
				        		<td colspan="2">
				        			Saya mengaku bahawa
									<ol type="a">
										<li>
											Perjalanan pada tarikh-tarikh tersebut adalah benar dan telah dibuat atas urusan rasmi;
										</li>
										<li>
											Tuntutan ini dibuat mengikut kadar dan syarat seperti yang dinyatakan di bawah peraturan-peraturan bagi pegawai
											bertugas rasmi dan/atau pegawai berkursus yang berkuatkuasa semasa; 
										</li>
										<li>
											Perbelanjaan yang bertanda (*) berjumlah sebanyak RM <span id="dibayar"></span>  dilakukan dan dibayar oleh saya;
										</li>
										<li>
											Panggilan telefon sebanyak <?= number_format($model->telefon, 2) ?> dibuat atas urusan rasmi; dan
										</li>
										<li>
											butir-butir seperti yang dinyatakan di atas adalah benar dan saya bertanggungjawab terhadapnya.
										</li>
									</ol>
				        		</td>
				        	</tr>
				        	<tr>
								<td width="60%"></td>
								<td align="right"></td>
							</tr>
							<tr>
								<td width="60%">Tarikh: <?= Yii::$app->formatter->asDate($model->tarikh_jadi) ?> </td>
								<td align="right">__________________<br>(Tandatangan Pegawai)</td>
							</tr>
				    	</tbody>
					</table>

				</td>
			</tr>
		</tbody>
	</table>
</div>
<div class="panel panel-default">
	<table width="898" border="1" align="center" class="semakan table table-bordered print">
		<thead>
			<tr><th class="text-center">I. PENGESAHAN</th></tr>
		</thead>
		<tbody>
			<tr>
				<td>
					<table width="98%" border="0" align="center" class="noborder">
				        <tbody>
				        	<tr>
						        <td colspan="2">Adalah disahkan bahawa perjalanan tersebut adalah atas urusan rasmi.</td>
						     </tr>
						     <tr>
						        <td colspan="2">&nbsp;</td>
						     </tr>
						     <tr>
						        <td width="62%">Tarikh: _________________</td>
						        <td width="38%" align="right">_______________________<br>
						          (Tandatangan Ketua Jabatan)</td>
						     </tr>
						     <tr>
						        <td>&nbsp;</td>
						        <td align="right">&nbsp;</td>
						     </tr>
						     <tr>
						        <td>&nbsp;</td>
						        <td align="right">__________________<br>
						          	b.p Ketua Setiausaha/<br>
									Pegawai Pengawal</td>
						     </tr>
						</tbody>
					</table>

				</td>
			</tr>
		</tbody>
	</table>
</div>
<div class="panel panel-default">
	<table width="898" border="1" align="center" class="semakan table table-bordered print">
		<thead>
			<tr><th class="text-center">J. PENDAHULUAN DIRI (Jika ada)</th></tr>
		</thead>
		<tbody>
			<tr>
				<td>
					<table width="98%" border="0" align="center" class="noborder" style="border-style: hidden;">
						<tbody>
							<tr>
				        		<td colspan="2">Adalah disahkan bahawa perjalanan tersebut adalah atas urusan rasmi.</td>
				      		</tr>
				      		<tr>
				        		<td colspan="2">&nbsp;</td>
				      		</tr>
				      		<tr>
						        <td width="62%">Pendahuluan Diri diberi</td>
						        <td width="38%" align="right">RM________</td>
						     </tr>
						     <tr>
						        <td>Tolak: Tuntutan sekarang</td>
						        <td align="right">RM________</td>
				      		</tr>
				      		<tr>
						        <td>Baki dituntut/Baki dibayar balik</td>
						        <td align="right">RM________<br></td>
						    </tr>
				    	</tbody>
					</table>

				</td>
			</tr>
		</tbody>
	</table>
</div>
<?= Html::a('Papar PDF', ['/perjalanan/form-pdf', 'id' => yii::$app->request->get('id')], ['class'=>'btn btn-primary']) ?>
<?php

$this->registerJsFile("@web/js/jspdf.min.js");

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
		/*padding: 5px;*/
		border: none !important;
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