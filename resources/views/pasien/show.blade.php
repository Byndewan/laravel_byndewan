@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('pasien.index') }}">Pasien</a></li>
                    <li class="breadcrumb-item active">{{ $pasien->nama_pasien }}</li>
                </ol>
            </nav>

            <div class="d-flex justify-content-between align-items-center">
                <h2 class="font-weight-bold">Detail Pasien</h2>
                <div>
                    <a href="{{ route('pasien.index') }}" class="btn btn-secondary">
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
                    <h5 class="card-title mb-0">Informasi Pasien</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-3 font-weight-bold text-muted">ID Pasien:</div>
                        <div class="col-sm-9">
                            <span class="badge badge-secondary">{{ $pasien->id }}</span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3 font-weight-bold text-muted">Nama Pasien:</div>
                        <div class="col-sm-9">{{ $pasien->nama_pasien }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3 font-weight-bold text-muted">Alamat:</div>
                        <div class="col-sm-9">{{ $pasien->alamat }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3 font-weight-bold text-muted">No Telepon:</div>
                        <div class="col-sm-9">{{ $pasien->no_telepon }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3 font-weight-bold text-muted">Rumah Sakit:</div>
                        <div class="col-sm-9">
                            <a href="{{ route('rumah-sakit.show', $pasien->rumahSakit->id) }}" class="text-primary">
                                {{ $pasien->rumahSakit->nama_rumah_sakit }}
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3 font-weight-bold text-muted">Tanggal Dibuat:</div>
                        <div class="col-sm-9">{{ $pasien->created_at->format('d M Y H:i') }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-transparent">
                    <h5 class="card-title mb-0">Informasi Rumah Sakit</h5>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <i class="fas fa-hospital fa-2x text-primary"></i>
                        <h5 class="mt-2">{{ $pasien->rumahSakit->nama_rumah_sakit }}</h5>
                    </div>

                    <div class="mb-2">
                        <i class="fas fa-map-marker-alt text-muted mr-2"></i>
                        <span class="text-muted">{{ Str::limit($pasien->rumahSakit->alamat, 40) }}</span>
                    </div>

                    <div class="mb-2">
                        <i class="fas fa-phone text-muted mr-2"></i>
                        <span class="text-muted">{{ $pasien->rumahSakit->telepon }}</span>
                    </div>

                    <div class="mb-3">
                        <i class="fas fa-envelope text-muted mr-2"></i>
                        <span class="text-muted">{{ $pasien->rumahSakit->email }}</span>
                    </div>

                    <a href="{{ route('rumah-sakit.show', $pasien->rumahSakit->id) }}" class="btn btn-outline-primary btn-sm btn-block">
                        Lihat Detail Rumah Sakit
                    </a>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header bg-transparent">
                    <h5 class="card-title mb-0">Aksi Cepat</h5>
                </div>
                <div class="card-body">
                    <a href="{{ route('pasien.edit', $pasien->id) }}" class="btn btn-primary btn-block mb-2">
                        <i class="fas fa-edit mr-2"></i> Edit Pasien
                    </a>
                    <button class="btn btn-outline-danger btn-block delete-btn" data-id="{{ $pasien->id }}">
                        <i class="fas fa-trash mr-2"></i> Hapus Pasien
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('.delete-btn').click(function() {
            var pasienId = $(this).data('id');
            var pasienName = "{{ $pasien->nama_pasien }}";

            Swal.fire({
                title: 'Hapus Pasien?',
                html: `Anda yakin ingin menghapus <strong>${pasienName}</strong>?`,
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
                        url: "{{ url('pasien') }}/" + pasienId,
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
                                window.location.href = "{{ route('pasien.index') }}";
                            });
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Terjadi kesalahan. Silakan coba lagi.'
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
