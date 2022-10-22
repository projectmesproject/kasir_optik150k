<?php
error_reporting(1);
$b = $brg->row_array();
?>

<tr>
	<th style="width:210px;"></th>
	<th>Satuan</th>
	<th>Stok</th>
	<th>Harga(Rp)</th>
	<th>Keterangan</th>
	<th>Jumlah</th>
</tr>
<tr>
	<td style="width:160px;"></td>
	<input type="hidden" id="kode_brg" name="kode_brg" value="<?php echo $b['barang_id']; ?>" />
	<td><input type="text" id="satuan" name="satuan" value="<?php echo $b['barang_satuan']; ?>" style="width:120px;margin-right:5px;" class="form-control input-sm" readonly></td>
	<td><input type="text" id="stok" name="stok" value="<?php echo $b['barang_stok']; ?>" style="width:95px;margin-right:5px;" class="form-control input-sm" readonly></td>
	<td><input type="text" id="harjul" name="harjul" value="<?php echo number_format($b['barang_harjul']); ?>" style="width:120px;margin-right:5px;text-align:right;" class="form-control input-sm" readonly></td>
	<td><input type="text" name="diskon" id="diskon" class="form-control input-sm" style="width:130px;margin-right:5px;"></td>
	<td><input type="number" name="qty" id="qty" value="1" min="1" max="999999999" class="form-control input-sm" style="width:90px;margin-right:5px;" required></td>




	<td><button type="submit" class="btn btn-sm btn-primary">Oke</button></td>


</tr>
<tr class="border">
	<td class="p-3" colspan="8">
		<div class="form-check form-check-inline">
			<input class="form-check-input" type="checkbox" id="kotak" value="Kotak">
			<label class="form-check-label" for="kotak">Kotak</label>
		</div>
		<div class="form-check form-check-inline">
			<input class="form-check-input" type="checkbox" id="pembersih_kcmt" value="Pembersih Kaca Mata">
			<label class="form-check-label" for="pembersih_kcmt">Pembersih Kaca Mata</label>
		</div>
		<div class="form-check form-check-inline">
			<input class="form-check-input" type="checkbox" id="paper_bag" value="Paper Bag">
			<label class="form-check-label" for="paper_bag">Paper Bag</label>
		</div>
		<div class="form-check form-check-inline">
			<input class="form-check-input" type="checkbox" id="lap" value="Kain Lap">
			<label class="form-check-label" for="lap">Kain Lap</label>
		</div>
	</td>
</tr>
<br/><br/>