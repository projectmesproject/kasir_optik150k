        <!-- Begin Page Content -->
        <div class="container-fluid">
            <!-- Page Heading -->
            <h1 class="h3 mb-2 text-gray-800">Cara Bayar</h1>
            <!-- DataTales Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <div>
                            <button class="btn btn-sm btn-primary" onclick="create()"> <i class="fas fa-plus"> Add Data</i> </button>
                        </div>
                        <table class="table" id="table" width="100%">
                            <thead class="thead-light">
                                <tr>
                                    <th>No</th>
                                    <th>Cara Bayar</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function() {
                table = $('#table').DataTable({
                    "lengthChange": false,
                    "paging": false,
                    "ordering": false,
                    "info": false,
                    "processing": true,
                    "serverSide": true,
                    "retrieve": true,
                    "ajax": {
                        "url": "<?= base_url('cara_bayar/list_cara_bayar') ?>",
                        "type": "POST",
                    },
                    "columnDefs": [{}, ],
                });
            });



            function remove(id) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to remove this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "<?= base_url('cara_bayar/remove') ?>",
                            method: 'post',
                            dataType: 'json',
                            data: {
                                id: id
                            },
                            success: function(data) {
                                if (data) {
                                    Swal.fire(
                                        'Deleted!',
                                        'Section has been deleted.',
                                        'success'
                                    )
                                    table.ajax.reload();
                                }
                            }
                        })

                    }
                })
            }

            function get(id) {
                $.ajax({
                    url: "<?= base_url('cara_bayar/get') ?>",
                    method: "post",
                    dataType: "json",
                    data: {
                        id: id,
                    },
                    success: function(data) {
                        let list = "";


                        Swal.fire({
                            title: 'Update List Cara Bayar',
                            html: '<label>Section Name</label>' +
                                '<input id="name" type="text" class="swal2-input" value="' + data.cara_bayar + '"/>',
                            focusConfirm: false,
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'Update',
                            cancelButtonText: 'Cancel',
                            cancelButtonColor: '#d33',
                        }).then(function(result) {
                            if (result.value) {
                                let cara_bayar = $('#name').val();
                                $.ajax({
                                    url: "<?= base_url('cara_bayar/update') ?>",
                                    method: "post",
                                    dataType: "json",
                                    data: {
                                        cara_bayar: cara_bayar,
                                    },
                                    success: function(data) {
                                        Swal.fire(
                                            'Success!',
                                            'Data has been updated!',
                                            'success'
                                        )
                                        table.ajax.reload();
                                    }
                                })
                            }
                        })

                    }
                })
            }

            function create() {
                Swal.fire({
                    title: 'Create Section',
                    html: '<label>Cara Bayar</label>' +
                        '<input id="name" type="text" class="swal2-input" />',
                    focusConfirm: false,
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Create',
                    cancelButtonText: 'Cancel',
                    cancelButtonColor: '#d33',
                }).then(function(result) {
                    if (result.value) {
                        let cara_bayar = $('#name').val();
                        $.ajax({
                            url: "<?= base_url('cara_bayar/create') ?>",
                            method: "post",
                            dataType: "json",
                            data: {
                                cara_bayar: cara_bayar,
                            },
                            success: function(data) {
                                Swal.fire(
                                    'Success!',
                                    'Data has been created!',
                                    'success'
                                )
                                table.ajax.reload();
                            }
                        })
                    }
                });

            }
        </script>