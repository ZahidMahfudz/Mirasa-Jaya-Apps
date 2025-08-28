<!-- Modal Edit -->
@foreach ($kas_bank_permata as $bank_permata)
<div class="modal fade" id="editModal{{ $bank_permata->id }}" tabindex="-1" role="dialog" aria-labelledby="editModal{{ $bank_permata->id }}Label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModal{{ $bank_permata->id }}Label">Edit Kas Bank Permata</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Formulir Anda untuk pengeditan data -->
                <!-- Pastikan menggunakan permintaan POST untuk menangani pembaruan -->
                <form action="{{ url('Bank-Permata/update/'.$bank_permata->id) }}" method="post">
                    @csrf
                    <div class="my-3 p-3 bg-body rounded shadow-sm">
                        <div class="mb-3 row">
                            <label for="tanggal{{ $bank_permata->id }}" class="col-sm-2 col-form-label">Tanggal</label>
                            <div class="col-sm-10">
                                <input type="date" class="form-control" name='tanggal' id="tanggal{{ $bank_permata->id }}" value="{{ \Carbon\Carbon::parse($bank_permata->tanggal)->format('Y-m-d') }}" required>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="hal{{ $bank_permata->id }}" class="col-sm-2 col-form-label">Hal</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name='hal' id="hal{{ $bank_permata->id }}" value="{{ $bank_permata->hal }}" required>
                            </div>
                        </div>
                        <!-- Field untuk memilih mutasi -->
                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label">Mutasi</label>
                            <div class="col-sm-10">
                                <select type="text" class="form-control" name="mutasi" id="mutasi{{ $bank_permata->id }}" required>
                                    <option value="">Pilih Mutasi</option>
                                    <option value="debit" {{ $data->mutasi == 'debit' ? 'selected' : '' }}>Debit</option>
                                    <option value="kredit" {{ $data->mutasi == 'kredit' ? 'selected' : '' }}>Kredit</option>
                                </select>
                            </div>
                        </div>
                        <!-- Field untuk Debit -->
                        <div class="mb-3 row" id="debitField{{ $bank_permata->id }}" style="display: none;">      
                            <div class="col-sm-12">
                                <div class="input-group">
                                    <span class="input-group-text">Debit</span>
                                    <input type="number" class="form-control" name="debit" id="debit{{ $bank_permata->id }}" value="{{ $bank_permata->debit }}">
                                </div>
                            </div>
                        </div>
                        <!-- Field untuk Kredit -->
                        <div class="mb-3 row" id="kreditField{{ $bank_permata->id }}" style="display: none;">
                            <div class="col-sm-12">
                                <div class="input-group">
                                    <span class="input-group-text">Kredit</span>
                                    <input type="number" class="form-control" name="kredit" id="kredit{{ $bank_permata->id }}" value="{{ $bank_permata->kredit }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary me-1 mb-1" name="submit">Edit</button>
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
        const mutasiSelect{{ $bank_permata->id }} = document.getElementById('mutasi{{ $bank_permata->id }}');
        
        // Ambil elemen field debit dan kredit
        const debitField{{ $bank_permata->id }} = document.getElementById('debitField{{ $bank_permata->id }}');
        const kreditField{{ $bank_permata->id }} = document.getElementById('kreditField{{ $bank_permata->id }}');

        // Tambahkan event listener untuk memantau perubahan pada dropdown mutasi
        mutasiSelect{{ $bank_permata->id }}.addEventListener('change', function() {
            const selectedMutasi{{ $bank_permata->id }} = mutasiSelect{{ $bank_permata->id }}.value;

            // Sembunyikan kedua field terlebih dahulu
            debitField{{ $bank_permata->id }}.style.display = 'none';
            kreditField{{ $bank_permata->id }}.style.display = 'none';

            // Tampilkan field yang sesuai berdasarkan pilihan mutasi
            if (selectedMutasi{{ $bank_permata->id }} === 'debit') {
                debitField{{ $bank_permata->id }}.style.display = 'block';
            } else if (selectedMutasi{{ $bank_permata->id }} === 'kredit') {
                kreditField{{ $bank_permata->id }}.style.display = 'block';
            }
        });

        // Inisialisasi tampilan berdasarkan nilai awal dropdown mutasi
        const initialMutasi{{ $bank_permata->id }} = mutasiSelect{{ $bank_permata->id }}.value;
        if (initialMutasi{{ $bank_permata->id }} === 'debit') {
            debitField{{ $bank_permata->id }}.style.display = 'block';
        } else if (initialMutasi{{ $bank_permata->id }} === 'kredit') {
            kreditField{{ $bank_permata->id }}.style.display = 'block';
        }
    });
</script>
@endforeach
