<div class="container-fluid">
	<!-- Page Heading -->
	<h1 class="h3 mb-2 text-gray-800">Laporan Data Barang</h1>
	<!-- DataTales Example -->
	<div class="card shadow mb-4">
		<div class="card-body">
			<form id="form-filter">
				<div class="row">
					<div class="col-2">
						<label>Kategori</label>
					</div>
					<div class="col-4">
						<select class="form-control select" name="kategori_nama" id="kategori_nama">
							<option value="">-Select Kategori-</option>
							<?php foreach ($selectKategori as $row) { ?>
								<option value="<?= $row->kategori_nama; ?>"><?= $row->kategori_nama; ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				<div class="row mb-2">
					<div class="col-2">
						<label>Nama Barang</label>
					</div>
					<div class="col-4">
						<select name="barang_nama" id="barang_nama" class="form-control select">
							<option value="" selected>-Select Barang-</option>
							<?php foreach ($selectBarang as $row) { ?>
								<option value="<?= $row->barang_nama; ?>"><?= $row->barang_nama; ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				<button type="button" class="btn btn-secondary float-right ml-2"><i class="fa fa-reply"></i> Reset</i></button>
				<button type="button" class="btn btn-success float-right" id="btn-filter"><i class="fa fa-filter"> Filter</i></button>
			</form>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table align="center" style="width:900px;margin-bottom:20px;" id="tableBarang">
					<thead>
						<th>No.</th>
						<th>Nama Barang</th>
						<th>Satuan</th>
						<th>Harga Jual</th>
						<th>Stok</th>
						<th>Kategori</th>
					</thead>
					<tbody></tbody>
				</table>
			</div>
		</div>
	</div>

</div>
<script type="text/javascript">
	var table;
	$(document).ready(function() {

		$('.select').select2();
		//datatables
		table = $('#tableBarang').DataTable({

			"processing": true,
			"serverSide": true,
			"order": [],
			"ajax": {
				"url": "<?php echo site_url('laporan/laporan_data_barang') ?>",
				"type": "POST",
				"data": function(data) {
					data.barang_nama = $('#barang_nama').val();
					data.kategori_nama = $('#kategori_nama').val();
				}
			},


			"columnDefs": [{
				"targets": [0],
				"orderable": false,
			}, ],

		});
		$('#btn-filter').click(function() {
			table.ajax.reload();
		});
		$('#btn-reset').click(function() {
			$('#form-filter')[0].reset();
			table.ajax.reload();
		});

	});
</script>