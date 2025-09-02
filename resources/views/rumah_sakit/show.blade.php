@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('rumah-sakit.index') }}">Rumah Sakit</a></li>
                    <li class="breadcrumb-item active">{{ $rumahSakit->nama_rumah_sakit }}</li>
                </ol>
            </nav>

            <div class="d-flex justify-content-between align-items-center">
                <h2 class="font-weight-bold">Detail Rumah Sakit</h2>
                <div>
                    <a href="{{ route('rumah-sakit.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left mr-2"></i> Kembali
                    </a>
                </div>
            </div>
            <hr class="border-secondary mt-2">
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-transparent">
                    <h5 class="card-title mb-0">Informasi Rumah Sakit</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-3 font-weight-bold text-muted">ID:</div>
                        <div class="col-sm-9">
                            <span class="badge badge-secondary">{{ $rumahSakit->id }}</span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3 font-weight-bold text-muted">Nama Rumah Sakit:</div>
                        <div class="col-sm-9">{{ $rumahSakit->nama_rumah_sakit }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3 font-weight-bold text-muted">Alamat:</div>
                        <div class="col-sm-9">{{ $rumahSakit->alamat }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3 font-weight-bold text-muted">Email:</div>
                        <div class="col-sm-9">{{ $rumahSakit->email }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3 font-weight-bold text-muted">Telepon:</div>
                        <div class="col-sm-9">{{ $rumahSakit->telepon }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3 font-weight-bold text-muted">Dibuat pada:</div>
                        <div class="col-sm-9">{{ $rumahSakit->created_at->format('d M Y H:i') }}</div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 font-weight-bold text-muted">Diupdate pada:</div>
                        <div class="col-sm-9">{{ $rumahSakit->updated_at->format('d M Y H:i') }}</div>
                    </div>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Daftar Pasien</h5>
                    <span class="badge badge-primary">{{ $rumahSakit->pasiens->count() }} Pasien</span>
                </div>
                <div class="card-body">
                    @if($rumahSakit->pasiens->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Nama Pasien</th>
                                    <th>Telepon</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($rumahSakit->pasiens as $pasien)
                                <tr>
                                    <td>{{ $pasien->nama_pasien }}</td>
                                    <td>{{ $pasien->no_telepon }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('pasien.show', $pasien->id) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-4">
                        <i class="fas fa-user-injured fa-2x text-muted"></i>
                        <p class="text-muted mt-2">Tidak ada pasien terdaftar</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-transparent">
                    <h5 class="card-title mb-0">Statistik</h5>
                </div>
                <div class="card-body text-center">
                    <div class="display-2 text-primary font-weight-bold">{{ $rumahSakit->pasiens->count() }}</div>
                    <p class="text-muted">Jumlah Pasien</p>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header bg-transparent">
                    <h5 class="card-title mb-0">Aksi Cepat</h5>
                </div>
                <div class="card-body">
                    <a href="{{ route('pasien.create') }}?rumah_sakit_id={{ $rumahSakit->id }}" class="btn btn-success btn-block mb-2">
                        <i class="fas fa-plus mr-2"></i> Tambah Pasien
                    </a>
                    <a href="{{ route('rumah-sakit.edit', $rumahSakit->id) }}" class="btn btn-primary btn-block mb-2">
                        <i class="fas fa-edit mr-2"></i> Edit Rumah Sakit
                    </a>
                    <button class="btn btn-outline-danger btn-block delete-rs-btn" data-id="{{ $rumahSakit->id }}">
                        <i class="fas fa-trash mr-2"></i> Hapus Rumah Sakit
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('.delete-rs-btn').click(function() {
            var rsId = $(this).data('id');
            var rsName = "{{ $rumahSakit->nama_rumah_sakit }}";

            Swal.fire({
                title: 'Hapus Rumah Sakit?',
                html: `Anda yakin ingin menghapus <strong>${rsName}</strong>?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('rumah-sakit') }}/" + rsId,
                        type: 'POST',
                        data: {
                            _method: 'DELETE',
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.success,
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                window.location.href = "{{ route('rumah-sakit.index') }}";
                            });
                        },
                        error: function(xhr) {
                            let errorMessage = 'Terjadi kesalahan. Silakan coba lagi.';

                            if (xhr.responseJSON && xhr.responseJSON.error) {
                                errorMessage = xhr.responseJSON.error;
                            }

                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: errorMessage
                            });
                        }
                    });
                }
            });
        });
    });
</script>
@endpush
@endsection
