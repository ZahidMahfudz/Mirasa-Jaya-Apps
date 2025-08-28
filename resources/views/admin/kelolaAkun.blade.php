<x-layout-admin>
    <x-slot:title>Kelola Akun</x-slot>
    <x-slot:tabs>Admin-Kelola Akun</x-slot>

    <div class="mt-2">
        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#tambahAkun">Tambah Akun</button>
    </div>

    <div class="mt-2">
        <table class="table table-bordered table-striped table-sm border border-dark align-middle">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($user as $item)
                    <tr>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->username }}</td>
                        <td>{{ $item->role }}</td>
                        <td>
                            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#editAkun-{{ $item->id }}">Edit</button>
                            <a href="/deleteAkun/{{ $item->id }}" class="btn btn-danger">Hapus</a>
                        </td>
                    </tr>

                    <div class="modal fade" id="editAkun-{{ $item->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">Edit Akun</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="editAkun/{{ $item->id }}" method="POST">
                                        @csrf
                                        <div class="mt-2">
                                            <label for="role-{{ $item->id }}" class="form-label">Role:</label>
                                            <select name="role" id="role-{{ $item->id }}" class="form-select" required>
                                                <option value='{{ $item->role }}' selected>{{ $item->role }}</option>
                                                <option value="admin">Admin</option>
                                                <option value="manager">Manager</option>
                                                <option value="owner">Owner</option>
                                                <option value="pemasaran">Pemasaran</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label for="nama-{{ $item->id }}" class="form-label">Nama :</label>
                                            <input type="text" name="nama" id="nama-{{ $item->id }}" class="form-control" value="{{ $item->name }}">
                                        </div>
                                        <div class="mt-2">
                                            <label for="username-{{ $item->id }}" class="form-label">Username:</label>
                                            <input type="text" name="username" id="username-{{ $item->id }}" class="form-control" value="{{ $item->username }}">
                                        </div>
                                        <div class="mt-2">
                                            <label for="password_edit-{{ $item->id }}" class="form-label">Ganti Password (optional):</label>
                                            <input type="text" name="password_edit" id="password_edit-{{ $item->id }}" class="form-control">
                                        </div>
                                        
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Edit</button>
                                        </div>
                                    </form>
                                    <!-- Hasil untuk edit -->
                                    <div id="hasil-edit-{{ $item->id }}" class="mt-3">
                                        <p>Silahkan Copy dan berikan dahulu kepada yang bersangkutan sebelum menambahkan</p>
                                        <p id="hasil-role-edit-{{ $item->id }}" style="margin-bottom:0%;"></p>
                                        <p id="hasil-nama-edit-{{ $item->id }}" style="margin-bottom:0%;"></p>
                                        <p id="hasil-username-edit-{{ $item->id }}" style="margin-bottom:0%;"></p>
                                        <p id="hasil-password-edit-{{ $item->id }}" style="margin-bottom:0%;"></p>
                                    </div>
                                    
                                    <script>
                                        document.getElementById('role-{{ $item->id }}').addEventListener('input', function() {
                                            const nama = document.getElementById('role-{{ $item->id }}').value;
                                            
                                            // Menampilkan hasil di bawah form
                                            document.getElementById('hasil-role-edit-{{ $item->id }}').innerText = `Role : ${nama}`;
                                        });
                                        document.getElementById('nama-{{ $item->id }}').addEventListener('input', function() {
                                            const nama = document.getElementById('nama-{{ $item->id }}').value;
                                            
                                            // Menampilkan hasil di bawah form
                                            document.getElementById('hasil-nama-edit-{{ $item->id }}').innerText = `Nama : ${nama}`;
                                        });
                                        document.getElementById('username-{{ $item->id }}').addEventListener('input', function() {
                                            const username = document.getElementById('username-{{ $item->id }}').value;
                                            
                                            // Menampilkan hasil di bawah form
                                            document.getElementById('hasil-username-edit-{{ $item->id }}').innerText = `Username : ${username}`;
                                        });
                                        document.getElementById('password_edit-{{ $item->id }}').addEventListener('input', function() {
                                            const password = this.value || '(Password tidak diubah)';
                                            
                                            // Menampilkan hasil di bawah form
                                            document.getElementById('hasil-password-edit-{{ $item->id }}').innerText = `Password : ${password}`;
                                        });
                                    </script>
                                </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="modal fade" id="tambahAkun" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Tambah Akun</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="tambahAkun" method="POST">
                        @csrf
                        <div class="mt-2">
                            <label for="role" class="form-label">Role:</label>
                            <select name="role" id="role" class="form-select" required>
                                <option selected disabled>Pilih Role</option>
                                <option value="admin">Admin</option>
                                <option value="manager">Manager</option>
                                <option value="owner">Owner</option>
                                <option value="pemasaran">pemasaran</option>
                            </select>
                        </div>
                        <div>
                            <label for="nama" class="form-label">Nama :</label>
                            <input type="text" name="nama" id="nama" class="form-control" required>
                        </div>
                        <div class="mt-2">
                            <label for="username" class="form-label">Username:</label>
                            <input type="text" name="username" id="username" class="form-control" required>
                        </div>
                        <div class="mt-2">
                            <label for="password_tambah" class="form-label">Password:</label>
                            <input type="text" name="password_tambah" id="password_tambah" class="form-control" required>
                        </div>
                        
                        
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Tambah</button>
                        </div>
                    </form>
                    
                    <!-- Hasil akan ditampilkan di sini -->
                    <div id="hasil" class="mt-3">
                        <p>Silahkan Copy dan berikan dahulu kepada yang bersangkutan sebelum menambahkan</p>
                        <p id="hasil-role" style="margin-bottom:0%;"></p>
                        <p id="hasil-nama" style="margin-bottom:0%;"></p>
                        <p id="hasil-username" style="margin-bottom:0%;"></p>
                        <p id="hasil-password" style="margin-bottom:0%;"></p>
                    </div>
                    
                    <script>
                        // Fungsi untuk menampilkan hasil
                        document.getElementById('password_tambah').addEventListener('input', function() {
                            const nama = document.getElementById('nama').value;
                            const username = document.getElementById('username').value;
                            const password = document.getElementById('password_tambah').value || '(Password tidak diubah)';
                            const role = document.getElementById('role').value;
                    
                            // Menampilkan hasil di bawah form
                            document.getElementById('hasil-nama').innerText = `Nama : ${nama}`;
                            document.getElementById('hasil-username').innerText = `Username : ${username}`;
                            document.getElementById('hasil-password').innerText = `Password : ${password}`;
                            document.getElementById('hasil-role').innerText = `Role : ${role}`;
                        });
                    </script>
                    
                    
                </div>
        </div>
    </div>

    
</x-layout-admin>