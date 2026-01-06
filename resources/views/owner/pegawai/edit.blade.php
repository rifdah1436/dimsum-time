<!DOCTYPE html>
<html lang="id">
<head>
    <title>Edit Pegawai</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'DM Sans', sans-serif; background: #f3f4f6; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; }
        .card { background: white; padding: 30px; border-radius: 12px; width: 100%; max-width: 500px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        h2 { margin-bottom: 20px; color: #1f2937; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: 500; color: #374151; }
        input, select { width: 100%; padding: 10px; border: 1px solid #d1d5db; border-radius: 6px; }
        .btn-submit { background: #3b82f6; color: white; width: 100%; padding: 12px; border: none; border-radius: 6px; font-weight: bold; cursor: pointer; margin-top: 10px; }
        .btn-back { display: block; text-align: center; margin-top: 15px; color: #6b7280; text-decoration: none; }
    </style>
</head>
<body>
    <div class="card">
        <h2>Edit Data Pegawai</h2>
        <form action="{{ route('owner.pegawai.update', $pegawai->id_pengguna) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="nama_lengkap" value="{{ $pegawai->nama_lengkap }}" required>
            </div>
            <div class="form-group">
                <label>Peran / Jabatan</label>
                <select name="peran" required>
                    <option value="kasir" {{ $pegawai->peran == 'kasir' ? 'selected' : '' }}>Kasir</option>
                    <option value="kurir" {{ $pegawai->peran == 'kurir' ? 'selected' : '' }}>Kurir</option>
                    <option value="admin" {{ $pegawai->peran == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="{{ $pegawai->email }}" required>
            </div>
            <div class="form-group">
                <label>Nomor Telepon</label>
                <input type="text" name="nomor_telepon" value="{{ $pegawai->nomor_telepon }}" required>
            </div>
            <div class="form-group">
                <label>Password Baru (Kosongkan jika tidak diganti)</label>
                <input type="password" name="password" placeholder="***">
            </div>
            <button type="submit" class="btn-submit">Update Data</button>
            <a href="{{ route('owner.dashboard') }}" class="btn-back">Batal & Kembali</a>
        </form>
    </div>
</body>
</html>