@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="font-weight-bold">Data Rumah Sakit</h2>
                        <p class="text-muted mb-0">Kelola semua catatan rumah sakit</p>
                    </div>
                    <a href="{{ route('rumah-sakit.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus mr-2"></i> Tambah Rumah Sakit
                    </a>
                </div>
                <hr class="border-secondary mt-2">
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama Rumah Sakit</th>
                                        <th>Alamat</th>
                                        <th>Email</th>
                                        <th>Telepon</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($rumahSakits as $rumahSakit)
                                        <tr>
                                            <td><span class="badge badge-secondary">{{ $loop->iteration }}</span></td>
                                            <td>{{ $rumahSakit->nama_rumah_sakit }}</td>
                                            <td>{{ Str::limit($rumahSakit->alamat, 50) }}</td>
                                            <td>{{ $rumahSakit->email }}</td>
                                            <td>{{ $rumahSakit->telepon }}</td>
                                            <td>
                                                <div class="d-flex justify-content-center">
                                                    <a href="{{ route('rumah-sakit.show', $rumahSakit->id) }}"
                                                        class="btn btn-sm btn-info mr-2" data-toggle="tooltip" title="Detail">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('rumah-sakit.edit', $rumahSakit->id) }}"
                                                        class="btn btn-sm btn-primary mr-2" data-toggle="tooltip" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button class="btn btn-sm btn-danger delete-rs-btn"
                                                        data-id="{{ $rumahSakit->id }}" data-toggle="tooltip" title="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @if($rumahSakits->isEmpty())
                        <div class="text-center py-5">
                            <i class="fas fa-hospital fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Tidak ada data rumah sakit</p>
                            <a href="{{ route('rumah-sakit.create') }}" class="btn btn-primary mt-2">
                                <i class="fas fa-plus mr-2"></i> Tambah Rumah Sakit Pertama
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();

            $(document).on('click', '.delete-rs-btn', function() {
                var rsId = $(this).data('id');
                var rsName = $(this).closest('tr').find('td:eq(1)').text();

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
                                    location.reload();
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
