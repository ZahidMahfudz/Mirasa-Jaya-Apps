<!-- Modal Tambah -->
<div class="modal fade" id="tambahDataModal" tabindex="-1" aria-labelledby="tambahDataModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahDataModalLabel">Tambah Kas Bank Permata</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Isi formulir tambah data di sini -->
                <form action="{{ route('store-bank-permata') }}" method="post">
                    @csrf
                    <!-- Tambahkan formulir tambah data sesuai kebutuhan -->
                    <div class="my-3 p-3 bg-body rounded shadow-sm">
                        <div class="mb-3 row">
                            <label for="tanggal" class="col-sm-2 col-form-label">Tanggal</label>
                            <div class="col-sm-10">
                                <input type="date" class="form-control" name='tanggal' id="tanggal" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="hal" class="col-sm-2 col-form-label">Hal</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name='hal' id="hal" required>
                            </div>
                        </div>
                        <!-- Field untuk memilih mutasi -->
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">Mutasi</label>
                            <div class="col-sm-10">
                                <select type="text" class="form-control" name="mutasi" id="mutasi" required>
                                    <option value="">Pilih Mutasi</option>
                                    <option value="debit">Debit</option>
                                    <option value="kredit">Kredit</option>
                                </select>
                            </div>
                        </div>
                        <!-- Field untuk Debit -->
                        <div class="mb-3 row" id="debitField" style="display: none;">      
                            <div class="col-sm-12">
                                <div class="input-group">
                                    <span class="input-group-text">Debit</span>
                                    <input type="number" class="form-control" name="debit" id="debit">
                                </div>
                            </div>
                        </div>
                        <!-- Field untuk Kredit -->
                        <div class="mb-3 row" id="kreditField" style="display: none;">
                            <!--<label for="kredit" class="col-sm-2 col-form-label"></!-->
                            <div class="col-sm-12">
                                <div class="input-group">
                                    <span class="input-group-text">Kredit</span>
                                    <input type="number" class="form-control" name="kredit" id="kredit">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary me-1 mb-1" name="submit">Tambah</button>
                        </div>
                    </div>    
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Ambil elemen dropdown mutasi
        const mutasiSelect = document.getElementById('mutasi');
        
        // Ambil elemen field debit dan kredit
        const debitField = document.getElementById('debitField');
        const kreditField = document.getElementById('kreditField');

        // Tambahkan event listener untuk memantau perubahan pada dropdown mutasi
        mutasiSelect.addEventListener('change', function() {
            const selectedMutasi = mutasiSelect.value;

            // Sembunyikan kedua field terlebih dahulu
            debitField.style.display = 'none';
            kreditField.style.display = 'none';

            // Tampilkan field yang sesuai berdasarkan pilihan mutasi
            if (selectedMutasi === 'debit') {
                debitField.style.display = 'block';
            } else if (selectedMutasi === 'kredit') {
                kreditField.style.display = 'block';
            }
        });

        // Inisialisasi tampilan berdasarkan nilai awal dropdown mutasi (jika ada)
        const initialMutasi = mutasiSelect.value;
        if (initialMutasi === 'debit') {
            debitField.style.display = 'block';
        } else if (initialMutasi === 'kredit') {
            kreditField.style.display = 'block';
        }
    });
</script>
