<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Include Bootstrap CSS and JS for modal functionality -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="main-content container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class='breadcrumb-header'></nav>
                </div>
            </div>
        </div>

        <div class="row" id="table-bordered">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                    <h4 class="card-title" align="center">
    <?php if (session()->get('level') == 5): ?>
        Tugas
    <?php else: ?>
        Manajemen Tugas
    <?php endif; ?>
</h4>

                        <?php if (session()->get('level') != 5): ?>
    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#tambahTugasModal">Tambah</button>
<?php endif; ?>
                    </div>
                    <div class="card-content">
                        <!-- table bordered -->
                        <div class="table-responsive">
                            <table class="table table-bordered mb-0">
                            <thead>
    <tr>
        <th>No</th>
        <th>Nama Tugas</th>
        <th>Kelas</th>
        <th>Tanggal</th>
        <?php if (session()->get('level') != 5): ?>
            <th>Aksi</th>
        <?php endif; ?>
    </tr>
</thead>

                                <tbody>
    <?php
    $no = 1;
    foreach ($tugas as $task) {
        if ($task->isdelete == 0) {
    ?>
    <tr>
        <td><?= $no++ ?></td>
        <td><?= $task->nama_tugas ?></td>
        <td><?= $task->nama_kelas ?></td>
        <td><?= $task->tanggal ?></td>
        <?php if (session()->get('level') != 5): ?>
            <td>
                <!-- Dropdown button for Aksi -->
                <div class="btn-group">
                    <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        Aksi
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editTugasModal" data-id="<?= $task->id_tugas ?>" data-nama="<?= $task->nama_tugas ?>" data-tanggal="<?= $task->tanggal ?>" data-idkelas="<?= $task->id_kelas ?>">Edit</a></li>
                        <li><a class="dropdown-item" href="<?= base_url('home/hapustugas/' . $task->id_tugas) ?>">Hapus</a></li>
                        <?php if (isset($backup_tugas[$task->id_tugas])): ?>
                        <li>
                            <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#undoEditModal" data-id="<?= $backup_tugas[$task->id_tugas]->id_tugas ?>" data-nama="<?= $backup_tugas[$task->id_tugas]->nama_tugas ?>" data-idkelas="<?= $backup_tugas[$task->id_tugas]->id_kelas ?>" data-tanggal="<?= $backup_tugas[$task->id_tugas]->tanggal ?>">
                                Undo Edit
                            </button>
                        </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </td>
        <?php endif; ?>
    </tr>
    <?php } } ?>
</tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Adding Tugas -->
    <div class="modal fade" id="tambahTugasModal" tabindex="-1" aria-labelledby="tambahTugasModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahTugasModalLabel">Tambah Tugas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="<?= base_url('home/aksi_tambah_tugas') ?>" method="POST" enctype="multipart/form-data">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="nama_tugas">Nama Tugas</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="text" id="nama_tugas" class="form-control" name="nama_tugas" placeholder="Nama Tugas" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="kelas">Kelas</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <select class="form-select" id="kelas" name="kelas">
                                        <option value="">Pilih</option>
                                        <?php foreach ($kelas as $gou) { ?>
                                            <option value="<?= $gou->id_kelas ?>"><?= $gou->nama_kelas ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="tanggal">Tanggal</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="date" id="tanggal" class="form-control" name="tanggal" required>
                                </div>
                                <div class="col-sm-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                                    <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Editing Tugas -->
    <div class="modal fade" id="editTugasModal" tabindex="-1" aria-labelledby="editTugasModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editTugasModalLabel">Edit Tugas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="<?= base_url('home/aksi_edit_tugas') ?>" method="POST" enctype="multipart/form-data">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="edit-nama-tugas">Nama Tugas</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="text" id="edit-nama-tugas" class="form-control" name="nama_tugas" placeholder="Nama Tugas" required>
                                    <input type="hidden" id="edit-id-tugas" name="id">
                                </div>
                                <div class="col-md-4">
                                    <label for="editKelas">Kelas</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <select class="form-select" id="editKelas" name="kelas">
                                        <option value="">Pilih</option>
                                        <?php foreach ($kelas as $gou) { ?>
                                            <option value="<?= $gou->id_kelas ?>"><?= $gou->nama_kelas ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="edit-tanggal">Tanggal</label>
                                </div>
                                <div class="col-md-8 form-group">
                                    <input type="date" id="edit-tanggal" class="form-control" name="tanggal" required>
                                </div>
                                <div class="col-sm-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                                    <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-<!-- Modal for Undo Edit Tugas -->
<div class="modal fade" id="undoEditModal" tabindex="-1" aria-labelledby="undoEditModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="undoEditModalLabel">Undo Edit Tugas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('home/aksi_unedit_tugas') ?>" method="POST">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="undo-nama-tugas">Nama Tugas</label>
                            </div>
                            <div class="col-md-8 form-group">
                                <input type="text" id="undo-nama-tugas" class="form-control" name="nama_tugas" readonly>
                                <input type="hidden" id="undo-id-tugas" name="id">
                            </div>
                            <div class="col-md-4">
                                <label for="undoKelas">Kelas</label>
                            </div>
                            <div class="col-md-8 form-group">
                                <select class="form-select" id="undoKelas" name="kelas" disabled>
                                    <option value="">Pilih</option>
                                    <?php foreach ($kelas as $gou) { ?>
                                        <option value="<?= $gou->id_kelas ?>"><?= $gou->nama_kelas ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="undo-tanggal">Tanggal</label>
                            </div>
                            <div class="col-md-8 form-group">
                                <input type="date" id="undo-tanggal" class="form-control" name="tanggal" readonly>
                            </div>
                            <div class="col-sm-12 d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary me-1 mb-1">Undo</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>




    <!-- JavaScript to handle the Edit and Undo Edit Modals -->
    <script>
        $('#editTugasModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var id = button.data('id'); // Extract info from data-* attributes
            var nama = button.data('nama');
            var tanggal = button.data('tanggal');
            var idkelas = button.data('idkelas');

            var modal = $(this);
            modal.find('#edit-id-tugas').val(id);
            modal.find('#edit-nama-tugas').val(nama);
            modal.find('#edit-tanggal').val(tanggal);
            modal.find('#editKelas').val(idkelas);
        });

        $('#undoEditModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var id = button.data('id'); // Extract info from data-* attributes
    var nama = button.data('nama');
    var tanggal = button.data('tanggal');
    var idkelas = button.data('idkelas'); // Pastikan ada data-idkelas

    var modal = $(this);
    modal.find('#undo-id-tugas').val(id);
    modal.find('#undo-nama-tugas').val(nama);
    modal.find('#undo-tanggal').val(tanggal);
    modal.find('#undoKelas').val(idkelas); // Set value of dropdown
});

    </script>
</body>
</html>
