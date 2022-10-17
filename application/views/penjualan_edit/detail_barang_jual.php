<?php 
						error_reporting(1);
						$b=$brg->row_array();
					?>
					
						<tr>
		                    <th style="width:210px;"></th>
		                    <th>Kode Barang</th>
		                    <th>Satuan</th>
		                    <th>Stok</th>
		                    <th>Harga(Rp)</th>
		                    <th>Keterangan</th>
		                    <th>Jumlah</th>
		                </tr>
						<tr>
							<td style="width:160px;"></td>
							<td><input type="text" id="kode_brg"  name="kode_brg" value="<?php echo $b['barang_id'];?>" style="width:150px;margin-right:5px;" class="form-control input-sm" readonly></td>
		                    <td><input type="text" id="satuan"  name="satuan" value="<?php echo $b['barang_satuan'];?>" style="width:120px;margin-right:5px;" class="form-control input-sm" readonly></td>
		                    <td><input type="text" id="stok"  name="stok" value="<?php echo $b['barang_stok'];?>" style="width:45px;margin-right:5px;" class="form-control input-sm" readonly></td>
		                    <td><input type="text" id="harjul"  name="harjul" value="<?php echo number_format($b['barang_harjul']);?>" style="width:120px;margin-right:5px;text-align:right;" class="form-control input-sm" readonly></td>
		                    <td><input type="text" name="diskon" id="diskon"  class="form-control input-sm" style="width:130px;margin-right:5px;"></td>
		                    <td><input type="number" name="qty" id="qty" value="1" min="1" max="999999999" class="form-control input-sm" style="width:90px;margin-right:5px;" required></td>
		                    <td><button type="submit" class="btn btn-sm btn-primary">Oke</button></td>
						</tr>
					
					