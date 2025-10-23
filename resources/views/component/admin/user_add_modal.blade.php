<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah User</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3 needs-validation" id="addUserForm" novalidate>
                    <div class="col-12">
                        <label for="yourName" class="form-label">Nama</label>
                        <input type="text" name="nama" class="form-control" id="yourName" required>
                        <div class="invalid-feedback">Please, enter the name!</div>
                    </div>

                    <div class="col-12">
                        <label for="yourUsername" class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" id="yourUsername" required>
                        <div class="invalid-feedback">Please enter the username!</div>
                    </div>

                    <div class="col-12">
                        <label for="yourEmail" class="form-label">Email</label>
                        <input type="text" name="email" class="form-control" id="yourEmail" required>
                        <div class="invalid-feedback">Please enter the email!</div>
                    </div>


                    <div class="col-12">
                        <label for="yourPassword" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" id="yourPassword" required>
                        <div class="invalid-feedback">Please enter the password!</div>
                    </div>

                    <div class="col-12">
                        <label for="yourPhone" class="form-label">No Hp</label>
                        <input type="text" name="no_hp" class="form-control" id="yourPhone" required>
                        <div class="invalid-feedback">Please enter the phone number!</div>
                    </div>

                    <div class="col-md mb-4">
                        <span class="fw-medium d-block">Jenis Kelamin</span>
                        <div class="form-check form-check-inline mt-2">
                            <input class="form-check-input" type="radio" name="jk" id="inlineRadio1"
                                value="Laki-laki" />
                            <label class="form-check-label" for="inlineRadio1">Laki-laki</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="jk" id="inlineRadio2"
                                value="Perempuan" />
                            <label class="form-check-label" for="inlineRadio2">Perempuan</label>
                        </div>
                    </div>

                    <div class="form-floating form-floating-outline mb-4 flex-fill">
                        <input class="form-control" type="date" name="tgl_lhr" id="html5-date-input" />
                        <label for="html5-date-input">Tanggal Lahir</label>
                    </div>

                    <div class="form-floating form-floating-outline mb-4 flex-fill">
                        <select class="form-select" id="exampleFormControlSelect1" name="role"
                            aria-label="Default select example">
                            <option selected disabled>Pilih salah satu</option>
                            <option value="Admin">Admin</option>
                            <option value="Pasien">Pasien</option>
                            <option value="Dokter">Dokter</option>
                            <option value="Per-clinic">Perawat Klinik</option>
                            <option value="Per-home">Perawat HomeCare</option>
                        </select>
                        <label for="exampleFormControlSelect1">Role</label>
                    </div>
                    <div class="form-floating form-floating-outline mb-4 flex-fill">
                        <select class="form-select" id="exampleFormControlSelect1" name="rumah_sakit"
                            aria-label="Default select example">
                            <option selected disabled>Pilih salah satu</option>
                            <option value="RSJPD Harapan Kita">RSJPD Harapan Kita</option>
                            <option value="Siloam Hospitals">Siloam Hospitals</option>
                        </select>
                        <label for="exampleFormControlSelect1">Rumah Sakit</label>
                    </div>

                    <div class="form-floating mb-3">
                      <textarea class="form-control" name="alamat" placeholder="Please enter the address!" id="floatingTextarea" style="height: 100px;"></textarea>
                      <label for="floatingTextarea">Alamat</label>
                    </div>

                    <div class="row mb-3">
                        <label for="Provinsi" class="col-md-4 col-lg-3 col-form-label">Provinsi</label>
                        <div class="col-md-8 col-lg-9">
                            <select class="form-select profileProvinsi" name="provinsi" id="provinsi"
                                aria-label="Pilih salah satu">
                            </select>
                        </div>

                    </div>

                    <div class="row mb-3">
                        <label for="kabupaten" class="col-md-4 col-lg-3 col-form-label">Kota/Kabupaten</label>
                        <div class="col-md-8 col-lg-9">
                            <select class="form-select profileKab" name="kota_kab" id="kabupaten"
                                aria-label="Pilih salah satu">
                            </select>
                        </div>

                    </div>

                    <div class="row mb-3">
                        <label for="kecamatan" class="col-md-4 col-lg-3 col-form-label">Kecamatan</label>
                        <div class="col-md-8 col-lg-9">
                            <select class="form-select profileKecamatan" name="kecamatan" id="kecamatan"
                                aria-label="Pilih salah satu">
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="kelurahan" class="col-md-4 col-lg-3 col-form-label">Kelurahan</label>
                        <div class="col-md-8 col-lg-9">
                            <select class="form-select profileKelurahan" name="kelurahan" id="kelurahan"
                                aria-label="Pilih salah satu">
                            </select>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" onclick="addUser()">Simpan</button>
            </div>
        </div>
    </div>
</div>

