<!-- Modal Delete -->
<div class="modal fade" id="deleteModal{{ $dataKas->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModal{{ $dataKas->id }}Label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModal{{ $dataKas->id }}Label">Konfirmasi Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Apakah Anda yakin ingin menghapus data ini?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <a href="{{ url('/Kas/delete/'.$dataKas->id) }}" class="btn btn-danger">Hapus</a>
            </div>
        </div>
    </div>
</div>