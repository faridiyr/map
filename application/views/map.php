<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Simple Location Mapping</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Simple Tables</li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-sm-3">
                                    <button type="button" class="btn btn-block btn-primary" data-toggle="modal" data-target="#modal-add">
                                        <i class="fa fa-plus"></i>&ensp;Tambah Data
                                    </button>
                                </div>
                                <div class="col-sm-3">
                                    <a href="<?= site_url("Map/pdf") ?>">
                                        <button type="button" class="btn btn-block btn-info">
                                            <i class="fa fa-file-pdf"></i>&ensp;PDF Report
                                        </button>
                                    </a>
                                </div>
                                <div class="col-sm-3">
                                    <a href="<?= site_url("Map/pdf_active") ?>">
                                        <button type="button" class="btn btn-block btn-success">
                                            <i class="fa fa-file-pdf"></i>&ensp;Location Active
                                        </button>
                                    </a>
                                </div>
                                <div class="col-sm-3">
                                    <a href="<?= site_url("Map/pdf_not_active") ?>">
                                        <button type="button" class="btn btn-block btn-danger">
                                            <i class="fa fa-file-pdf"></i>&ensp;Location Not Active
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-8">
                                    <?php if ($this->session->flashdata('notification_berhasil') != '') { ?>
                                        <div class="alert alert-success alert-dismissable">
                                            <i class="glyphicon glyphicon-ok"></i>
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <?php echo $this->session->flashdata('notification_berhasil'); ?>
                                        </div>
                                    <?php } else if ($this->session->flashdata('notification_gagal') != '') { ?>
                                        <div class="alert alert-danger alert-dismissable">
                                            <i class="glyphicon glyphicon-ok"></i>
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            <?php echo $this->session->flashdata('notification_gagal'); ?>
                                        </div>
                                    <?php } ?>
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th style="text-align: center;">No</th>
                                                <th style="text-align: center;">Place</th>
                                                <th style="text-align: center;">Latitude</th>
                                                <th style="text-align: center;">Longitude</th>
                                                <th style="text-align: center;">Status</th>
                                                <th style="text-align: center;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $no = 0;
                                            foreach ($location as $item) {
                                                $no++;
                                            ?>
                                                <tr>
                                                    <td style="text-align: center;"><?= $no ?></td>
                                                    <td><?= $item['location'] ?></td>
                                                    <td><?= $item['latitude'] ?></td>
                                                    <td><?= $item['longitude'] ?></td>
                                                    <td style="text-align: center;">
                                                        <span class="right badge 
                                                        <?php
                                                        if ($item['is_active'] === 'Active') {
                                                            echo 'badge-success';
                                                        } else if ($item['is_active'] === 'Not Active') {
                                                            echo 'badge-danger';
                                                        }
                                                        ?>">
                                                            <?= $item['is_active'] ?>
                                                        </span>
                                                    </td>
                                                    <td style="text-align: center;">

                                                        <!-- Tombol Edit -->
                                                        <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal-edit<?= $item['id'] ?>">
                                                            <span btn-icon-left>
                                                                <i class="fa fa-edit"></i>
                                                            </span>
                                                        </button>

                                                        <!-- Tombol Hapus -->
                                                        <button onclick="delete_repositori_ajax(<?= $item['id'] ?>)" type="submit" class="btn btn-danger btn-sm">
                                                            <span btn-icon-left>
                                                                <i class="fa fa-trash"></i>
                                                            </span>
                                                        </button>

                                                    </td>
                                                </tr>
                                            <?php
                                            } ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-lg-4">
                                    <div id="googleMap" style="width:100%;height:750px"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.row -->
</div><!-- /.container-fluid -->


<!-- modal -->

<!-- modal add -->
<div class="modal fade" id="modal-add">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add a Location</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form role="form" enctype="multipart/form-data" action="<?= site_url('Map/add') ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="location">Location</label>
                        <input type="text" class="form-control" id="location" name="location" placeholder="Enter Location" required>
                    </div>
                    <div class="form-group">
                        <label for="latitude">Latitude</label>
                        <input type="text" class="form-control" id="latitude" name="latitude" placeholder="Enter Latitude Coordinate" required>
                    </div>
                    <div class="form-group">
                        <label for="longitude">Longitude</label>
                        <input type="text" class="form-control" id="longitude" name="longitude" placeholder="Enter Longitude Coordinate" required>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="Active" checked>
                        <label class="form-check-label" for="is_active">Lokasi Active</label>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- modal edit -->
<?php
foreach ($location as $item) {
?>
    <div class="modal fade" id="modal-edit<?= $item['id'] ?>">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit a Location</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form enctype="multipart/form-data" action="<?= site_url('Map/edit') ?>" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <input hidden type="text" class="form-control" id="id" name="id" placeholder="Enter Id" value="<?= $item['id'] ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="location">Location</label>
                            <input type="text" class="form-control" id="location" name="location" placeholder="Enter Location" value="<?= $item['location'] ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="latitude">Latitude</label>
                            <input type="text" class="form-control" id="latitude" name="latitude" placeholder="Enter Latitude Coordinate" value="<?= $item['latitude'] ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="longitude">Longitude</label>
                            <input type="text" class="form-control" id="longitude" name="longitude" placeholder="Enter Longitude Coordinate" value="<?= $item['longitude'] ?>" required>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="Active" <?php
                                                                                                                            if ($item['is_active'] === 'Active') {
                                                                                                                                echo 'checked';
                                                                                                                            }
                                                                                                                            ?>>
                            <label class="form-check-label" for="is_active">Lokasi Active</label>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
<?php
}
?>

<script type="text/javascript">
    function delete_repositori_ajax(id) {
        if (confirm("Anda yakin ingin menghapus data ini ?")) {
            ;
            $.ajax({
                url: 'Map/delete',
                type: 'POST',
                data: {
                    id: id
                },
                success: function() {
                    alert('Delete data berhasil');
                    location.reload();
                },
                error: function() {
                    alert('Delete data gagal');
                }
            });
        }
    }
</script>

</section>
<!-- /.content -->
</div>