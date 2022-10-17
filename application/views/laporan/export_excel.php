<h4>Data Barang</h4>
<table border="1" cellpadding="8">
<tr>
  <th>No</th>
  <th>Kode Barang</th>
  <th>Nama Barang</th>
  <th>Satuan</th>
  <th>Harga Jual</th>
  <th>Stok</th>
</tr>
<?php
if( ! empty($data)){ // Jika data pada database tidak sama dengan empty (alias ada datanya)
    $no = 1;
  foreach($data as $d){ // Lakukan looping pada variabel siswa dari controller
    echo "<tr>";
    echo "<td>".$no++."</td>";
    echo "<td>".$d['barang_id']."</td>";
    echo "<td>".$d['barang_nama']."</td>";
    echo "<td>".$d['barang_satuan']."</td>";
    echo "<td>Rp. ".number_format($d['barang_harjul'])."</td>";
    echo "<td>".$d['barang_stok']."</td>";
    echo "</tr>";
  }
}else{ // Jika data tidak ada
  echo "<tr><td colspan='4'>Data tidak ada</td></tr>";
}
?>
</table>