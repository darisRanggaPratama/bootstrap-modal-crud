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
    <link href="sidebar.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body>

<!-- Sidebar -->
<div id="mySidebar" class="sidebar">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <a href="#"><i class="fas fa-home"></i> Home</a>
    <a href="#"><i class="fas fa-user-graduate"></i> Mahasiswa</a>
    <a href="#"><i class="fas fa-book"></i> Mata Kuliah</a>
    <a href="#"><i class="fas fa-chalkboard-teacher"></i> Dosen</a>
    <a href="#"><i class="fas fa-cog"></i> Settings</a>
</div>

<!-- Button to open sidebar -->
<button class="openbtn" onclick="toggleNav()">&#9776;</button>

<div id="main">

    <div class="container">
        <div class="mt-3">
            <h3 class="text-center">CRUD: PHP & MYSQL + Modal Bootstrap 5</h3>
        </div>
        <div class="card mt-3">
            <div class="card-header bg-primary text-white">
                Data Mahasiswa
            </div>
            <div class="card-body">
                <!--Buttons: Add, Upload, Download-->
                <div class="col-md-12 text-md-end mt-3 mt-md-0">
                    <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle me-2" type="button" id="dropdownMenuButton"
                                data-bs-toggle="dropdown" aria-expanded="false">
                            Actions
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <li>
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-success mb-3 ms-2" data-bs-toggle="modal"
                                        data-bs-target="#modalTambah">
                                    Add
                                </button>
                            </li>
                            <li>
                                <!-- Tambahkan tombol Upload dan Download di bawah tombol Add -->
                                <button type="button" class="btn btn-info mb-3 ms-2" data-bs-toggle="modal"
                                        data-bs-target="#modalUpload">
                                    Upload CSV
                                </button>
                            </li>
                            <li>
                                <a href="download.php" class="btn btn-warning mb-3 ms-2">Download CSV</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Search Container -->
                <div class="search-container">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="searchNim">Search by NIM</label>
                                <input type="text" class="form-control" id="searchNim" placeholder="Enter NIM">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="searchNama">Search by Nama</label>
                                <input type="text" class="form-control" id="searchNama" placeholder="Enter Nama">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="searchAlamat">Search by Alamat</label>
                                <input type="text" class="form-control" id="searchAlamat" placeholder="Enter Alamat">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="searchProdi">Search by Prodi</label>
                                <input type="text" class="form-control" id="searchProdi" placeholder="Enter Prodi">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End: Search Container -->

                <table class="table table-bordered table-hover table-striped">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Edit</th>
                        <th>NIM</th>
                        <th>Nama Lengkap</th>
                        <th>Alamat</th>
                        <th>Jurusan</th>
                        <th>Drop</th>
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
                            <td><i class="far fa-edit" data-bs-toggle="modal"
                                   data-bs-target="#modalUbah<?= $data['id_mhs'] ?>"></i>
                            </td>
                            <td><?php echo $data['nim']; ?></td>
                            <td><?php echo $data['nama']; ?></td>
                            <td><?php echo $data['alamat']; ?></td>
                            <td><?php echo $data['prodi']; ?></td>
                            <td><i class="fas fa-backspace" data-bs-toggle="modal"
                                   data-bs-target="#modalHapus<?= $data['id_mhs'] ?>"></i>
                            </td>
                        </tr>

                        <!-- Modal: Edit -->
                        <div class="modal fade modal-lg" id="modalUbah<?= $data['id_mhs'] ?>" data-bs-backdrop="static"
                             data-bs-keyboard="false"
                             tabindex="-1"
                             aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Record</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                    </div>
                                    <form method="POST" action="aksi_crud.php">
                                        <input type="hidden" id="id" name="id_mhs" value="<?= $data['id_mhs'] ?>">
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="nim" class="form-label">NIM</label>
                                                <input type="text" class="form-control" id="nim" name="tnim"
                                                       value="<?= $data['nim'] ?>"
                                                       placeholder="Masukkan NIM" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="nama" class="form-label">Nama Lengkap</label>
                                                <input type="text" class="form-control" id="nama" name="tnama"
                                                       value="<?= $data['nama'] ?>"
                                                       placeholder="Masukkan nama" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="alamat" class="form-label">Alamat</label>
                                                <textarea type="text" class="form-control" id="alamat" name="talamat"
                                                          placeholder="Masukkan Alamat" rows="3"
                                                          required><?= $data['alamat'] ?></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label for="jurusan" class="form-label">Prodi</label>
                                                <select class="form-select" id="jurusan" name="tprodi" required>
                                                    <option value="<?= $data['prodi'] ?>"><?= $data['prodi'] ?></option>
                                                    <option value="S1 - Teknik Informatika">S1 - Teknik Informatika
                                                    </option>
                                                    <option value="S1 - Sistem Informasi">S1 - Sistem Informasi</option>
                                                    <option value="D3 - Manajemen Informatika">D3 - Manajemen
                                                        Informatika
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary" name="bubah">Edit</button>
                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- End. Modal: Edit -->

                        <!-- Modal: Delete -->
                        <div class="modal fade" id="modalHapus<?= $data['id_mhs'] ?>" data-bs-backdrop="static"
                             data-bs-keyboard="false"
                             tabindex="-1"
                             aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Delete Record</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                    </div>
                                    <form method="POST" action="aksi_crud.php">
                                        <input type="hidden" id="id" name="id_mhs" value="<?= $data['id_mhs'] ?>">
                                        <div class="modal-body">
                                            <h5 class="text-center">Apakah yakin menghapus data ini?
                                                <br>
                                                <span class="text-danger"><b><?= $data['nim'] ?></b> - <b><?= $data['nama'] ?></b> </span>
                                            </h5>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary" name="bhapus">Delete</button>
                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- End. Modal: Delete -->

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
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
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
                                                  placeholder="Masukkan Alamat" rows="3" required></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="jurusan" class="form-label">Prodi</label>
                                        <select class="form-select" id="jurusan" name="tprodi" required>
                                            <option value="S1 - Teknik Informatika">S1 - Teknik Informatika</option>
                                            <option value="S1 - Sistem Informasi">S1 - Sistem Informasi</option>
                                            <option value="D3 - Manajemen Informatika">D3 - Manajemen Informatika
                                            </option>
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
                <!-- End. Modal: Add -->

                <!-- Tambahkan Modal Upload setelah Modal Add yang sudah ada -->
                <div class="modal fade" id="modalUpload" data-bs-backdrop="static" data-bs-keyboard="false"
                     tabindex="-1"
                     aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5">Upload Data CSV</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                            </div>
                            <form method="POST" action="upload.php" enctype="multipart/form-data">
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="csvFile" class="form-label">Pilih File CSV</label>
                                        <input type="file" class="form-control" id="csvFile" name="csvFile"
                                               accept=".csv" required>
                                        <div class="form-text">File CSV harus menggunakan separator semicolon (;)</div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary" name="bupload">Upload</button>
                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
<script src="sidebar.js"></script>
<script src="search.js"></script>
</body>
</html>
