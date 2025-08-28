<!-- Modal Tambah Data -->
@foreach($kas as $data)
<div class="modal fade" id="editDataModal{{ $data->id }}" tabindex="-1" aria-labelledby="editDataModal{{ $data->id }}Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editDataModal{{ $data->id }}Label">Edit Data Kas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ url('/Kas/update/'.$data->id) }}" method="POST">
                    @csrf
                    <!-- Form fields -->
                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ $data->tanggal }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="kas" class="form-label">Nama Kas</label>
                        <input type="text" class="form-control" id="kas" name="kas" value="{{ $data->kas }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="jumlah" class="form-label">Jumlah</label>
                        <input type="number" class="form-control" id="jumlah" name="jumlah" value="{{ $data->jumlah }}"required>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach