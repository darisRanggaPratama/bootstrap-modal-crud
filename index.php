<?php
// Call Koneksi

global $koneksi;
require_once 'koneksi.php';


?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CRUD</title>
    <!-- CRUD: PHP-MYSQL, Bootstrap 5 + Modal -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <div class="mt-3">
        <h3 class="text-center">CRUD: PHP & MYSQL + Modal Bootstrap 5</h3>
    </div>


    <div class="card mt-3">
        <div class="card-header bg-primary text-white">
            Data Mahasiswa
        </div>
        <div class="card-body">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#modalTambah">
                Add
            </button>

            <table class="table table-bordered table-hover table-striped">
                <thead>
                <tr>
                    <th>No</th>
                    <th>NIM</th>
                    <th>Nama Lengkap</th>
                    <th>Alamat</th>
                    <th>Jurusan</th>
                    <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                <?php
                // Persiapan menampilkan data
                $no = 1;
                $sql = "SELECT * FROM tmhs ORDER BY id_mhs DESC";
                $tampil = mysqli_query($koneksi, $sql);

                while ($data = mysqli_fetch_array($tampil)) :
                    ?>
                    <tr>
                        <td><?php echo $no++; ?>
                        </td>
                        <td>
                            <a href="#" class="btn btn-warning">
                                <i class="far fa-edit"></i>
                            </a>
                            <?php echo $data['nim']; ?>
                        </td>
                        <td><?php echo $data['nama']; ?></td>
                        <td><?php echo $data['alamat']; ?></td>
                        <td><?php echo $data['prodi']; ?></td>
                        <td>
                            <a href="#" class="btn btn-danger">
                                <i class="fas fa-backspace"></i>
                            </a>
                        </td>
                    </tr>

                <?php endwhile; ?>
                </tbody>
            </table>

            <!-- Modal: Add -->
            <div class="modal fade modal-lg" id="modalTambah" data-bs-backdrop="static" data-bs-keyboard="false"
                 tabindex="-1"
                 aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Data Mahasiswa</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form method="POST" action="aksi_crud.php">
                            <div class="modal-body">

                                <div class="mb-3">
                                    <label for="nim" class="form-label">NIM</label>
                                    <input type="text" class="form-control" id="nim" name="tnim"
                                           placeholder="Masukkan NIM" required>
                                </div>
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control" id="nama" name="tnama"
                                           placeholder="Masukkan nama" required>
                                </div>
                                <div class="mb-3">
                                    <label for="alamat" class="form-label">Alamat</label>
                                    <textarea type="text" class="form-control" id="alamat" name="talamat"
                                              placeholder="Masukkan Alamat" rows="3" required> </textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="jurusan" class="form-label">Prodi</label>
                                    <select class="form-select" id="jurusan" name="tprodi" required>
                                        <option value="S1 - Teknik Informatika">S1 - Teknik Informatika</option>
                                        <option value="S1 - Sistem Informasi">S1 - Sistem Informasi</option>
                                        <option value="D3 - Manajemen Informatika">D3 - Manajemen Informatika</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary" name="bsimpan">Save</button>
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>
</html>
