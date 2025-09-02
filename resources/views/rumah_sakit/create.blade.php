@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('rumah-sakit.index') }}">Rumah Sakit</a></li>
                    <li class="breadcrumb-item active">Tambah Rumah Sakit</li>
                </ol>
            </nav>

            <div class="d-flex justify-content-between align-items-center">
                <h2 class="font-weight-bold">Tambah Rumah Sakit</h2>
                <a href="{{ route('rumah-sakit.index') }}" class="btn btn-secondary">
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
                    <form action="{{ route('rumah-sakit.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="nama_rumah_sakit" class="form-label">Nama Rumah Sakit *</label>
                            <input type="text" class="form-control @error('nama_rumah_sakit') is-invalid @enderror"
                                   id="nama_rumah_sakit" name="nama_rumah_sakit" value="{{ old('nama_rumah_sakit') }}" required
                                   placeholder="Masukkan nama rumah sakit">
                            @error('nama_rumah_sakit')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="alamat" class="form-label">Alamat *</label>
                            <textarea class="form-control @error('alamat') is-invalid @enderror"
                                      id="alamat" name="alamat" rows="3" required
                                      placeholder="Masukkan alamat lengkap rumah sakit">{{ old('alamat') }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email" class="form-label">Email *</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                   id="email" name="email" value="{{ old('email') }}" required
                                   placeholder="Masukkan email rumah sakit">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="telepon" class="form-label">Telepon *</label>
                            <input type="text" class="form-control @error('telepon') is-invalid @enderror"
                                   id="telepon" name="telepon" value="{{ old('telepon') }}" required
                                   placeholder="Masukkan nomor telepon rumah sakit">
                            @error('telepon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fas fa-save mr-2"></i> Simpan
                            </button>
                            <a href="{{ route('rumah-sakit.index') }}" class="btn btn-outline-secondary">
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
