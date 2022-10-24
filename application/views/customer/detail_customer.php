<?php 
						error_reporting(0);
						$b=$brg->row_array();
					?>
					<table>
						<tr>
		                    <th style="width:300px;"></th>
                            <th>Kode Customer</th>
		                    <th></th>
		                    <th>Nama</th>
		                    <th>Alamat</th>
		                </tr>
						<tr>
							<td style="width:160px;"></th>
                            <td><input type="text" name="kd_customer1" value="<?php echo $b['kd_customer'];?>" style="width:150px;margin-right:5px;" class="form-control input-sm" readonly> <small class="form-text text-danger"><?= form_error('kd_customer');?></small></td>
							<td><input type="hidden" name="kd_customer" value="<?php echo $kd_cus;?>" style="width:150px;margin-right:5px;" class="form-control input-sm" required> <small class="form-text text-danger"><?= form_error('kd_customer');?></small></td>
		                    <td><input type="text" name="nama" value="<?php echo $b['nama'];?>" style="width:200px;margin-right:5px;" class="form-control input-sm" required><small class="form-text text-danger"><?= form_error('nama');?></small></td>
		                    <td><input type="text" name="alamat" value="<?php echo $b['alamat'];?>" style="width:300px;margin-right:5px;" class="form-control input-sm" required><small class="form-text text-danger"><?= form_error('alamat');?></small></td>
		                    
						</tr>
					</table>
					