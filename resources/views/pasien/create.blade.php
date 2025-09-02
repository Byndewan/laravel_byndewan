@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('pasien.index') }}">Pasien</a></li>
                    <li class="breadcrumb-item active">Tambah Pasien</li>
                </ol>
            </nav>

            <div class="d-flex justify-content-between align-items-center">
                <h2 class="font-weight-bold">Tambah Pasien</h2>
                <a href="{{ route('pasien.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>
            </div>
            <hr class="border-secondary mt-2">
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('pasien.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="nama_pasien" class="form-label">Nama Pasien *</label>
                            <input type="text" class="form-control @error('nama_pasien') is-invalid @enderror"
                                   id="nama_pasien" name="nama_pasien" value="{{ old('nama_pasien') }}" required
                                   placeholder="Masukkan nama lengkap pasien">
                            @error('nama_pasien')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="alamat" class="form-label">Alamat *</label>
                            <textarea class="form-control @error('alamat') is-invalid @enderror"
                                      id="alamat" name="alamat" rows="3" required
                                      placeholder="Masukkan alamat lengkap pasien">{{ old('alamat') }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="no_telepon" class="form-label">No Telepon *</label>
                            <input type="text" class="form-control @error('no_telepon') is-invalid @enderror"
                                   id="no_telepon" name="no_telepon" value="{{ old('no_telepon') }}" required
                                   placeholder="Masukkan nomor telepon pasien">
                            @error('no_telepon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="rumah_sakit_id" class="form-label">Rumah Sakit *</label>
                            <select class="form-control @error('rumah_sakit_id') is-invalid @enderror"
                                    id="rumah_sakit_id" name="rumah_sakit_id" required>
                                <option value="">Pilih Rumah Sakit</option>
                                @foreach($rumahSakits as $rumahSakit)
                                    <option value="{{ $rumahSakit->id }}" {{ old('rumah_sakit_id') == $rumahSakit->id ? 'selected' : '' }}>
                                        {{ $rumahSakit->nama_rumah_sakit }}
                                    </option>
                                @endforeach
                            </select>
                            @error('rumah_sakit_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save mr-2"></i> Simpan
                            </button>
                            <a href="{{ route('pasien.index') }}" class="btn btn-outline-secondary">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
