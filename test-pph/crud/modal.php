<!-- Add Employee Modal -->
<div class="modal fade" id="addEmployeeModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Karyawan Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="create.php" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">NIK</label>
                        <input type="text" class="form-control" name="nik" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Gaji</label>
                        <input type="text" class="form-control" name="gaji" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Hadir Pusat</label>
                        <input type="text" class="form-control" name="hadir_pusat" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Hadir Proyek</label>
                        <input type="text" class="form-control" name="hadir_proyek" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Konsumsi</label>
                        <input type="text" class="form-control" name="konsumsi" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Lembur</label>
                        <input type="text" class="form-control" name="lembur" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tunjangan Lain</label>
                        <input type="text" class="form-control" name="tunjang_lain" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">BPJS: JKK</label>
                        <input type="text" class="form-control" name="jkk" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">BPJS: JKM</label>
                        <input type="text" class="form-control" name="jkm" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">BPJS: Sehat</label>
                        <input type="text" class="form-control" name="sehat" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">PTKP</label>
                        <select class="form-select" name="ptkp" required>
                            <option value="K/0">K/0</option>
                            <option value="K/1">K/1</option>
                            <option value="K/2">K/2</option>
                            <option value="K/3">K/3</option>
                            <option value="TK/0">TK/0</option>
                            <option value="TK/1">TK/1</option>
                            <option value="TK/2">TK/2</option>
                            <option value="TK/3">TK/3</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Employee Modal -->
<div class="modal fade" id="editEmployeeModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Karyawan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="update.php" method="POST">
                <input type="hidden" name="id" id="editId">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">NIK</label>
                        <input type="text" class="form-control" name="nik" id="editNik" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" class="form-control" name="name" id="editName" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Gaji</label>
                        <input type="text" class="form-control" name="gaji" id="editGaji" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Hadir Pusat</label>
                        <input type="text" class="form-control" name="hadir_pusat" id="editHadirPusat" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Hadir Proyek</label>
                        <input type="text" class="form-control" name="hadir_proyek" id="editHadirProyek"
                               required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Konsumsi</label>
                        <input type="text" class="form-control" name="konsumsi" id="editKonsumsi" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Lembur</label>
                        <input type="text" class="form-control" name="lembur" id="editLembur" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tunjangan Lain</label>
                        <input type="text" class="form-control" name="tunjang_lain" id="editTunjangLain"
                               required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">BPJS: JKK</label>
                        <input type="text" class="form-control" name="jkk" id="editJkk" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">BPJS: JKM</label>
                        <input type="text" class="form-control" name="jkm" id="editJkm" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">BPJS Sehat</label>
                        <input type="text" class="form-control" name="sehat" id="editSehat" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">PTKP</label>
                        <select class="form-select" name="ptkp" id="editPtkp" required>
                            <option value="K/0">K/0</option>
                            <option value="K/1">K/1</option>
                            <option value="K/2">K/2</option>
                            <option value="K/3">K/3</option>
                            <option value="TK/0">TK/0</option>
                            <option value="TK/1">TK/1</option>
                            <option value="TK/2">TK/2</option>
                            <option value="TK/3">TK/3</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
