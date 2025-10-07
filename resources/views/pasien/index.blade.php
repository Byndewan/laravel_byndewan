@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="font-weight-bold">Data Pasien</h2>
                        <p class="text-muted mb-0">Kelola semua catatan pasien</p>
                    </div>
                    <a href="{{ route('pasien.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus mr-2"></i> Tambah Pasien
                    </a>
                </div>
                <hr class="border-secondary mt-2">
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="rumahSakitFilter" class="form-label">Filter Berdasarkan Rumah Sakit:</label>
                    <select class="form-control" id="rumahSakitFilter">
                        <option value="">Semua Rumah Sakit</option>
                        @foreach ($rumahSakits as $rumahSakit)
                            <option value="{{ $rumahSakit->id }}" {{ $selectedRS == $rumahSakit->id ? 'selected' : '' }}>
                                {{ $rumahSakit->nama_rumah_sakit }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-5">
                <div class="form-group">
                    <label for="searchInput" class="form-label">Cari Pasien:</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-transparent border-right-0">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                        </div>
                        <input type="text" class="form-control border-left-0" id="searchInput" placeholder="Nama, alamat, atau telepon...">
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3 d-flex align-items-end">
                <a href="{{ route('pasien.index') }}" class="btn btn-outline-secondary btn-block" id="resetFilters">
                    <i class="fas fa-redo mr-2"></i> Reset Filter
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover" id="pasienTable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama Pasien</th>
                                        <th>Alamat</th>
                                        <th>No Telepon</th>
                                        <th>Rumah Sakit</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pasiens as $pasien)
                                        <tr>
                                            <td><span class="badge badge-secondary">{{ ($pasiens->currentPage() - 1) * $pasiens->perPage() + $loop->iteration }}</span></td>
                                            <td>{{ $pasien->nama_pasien }}</td>
                                            <td>{{ Str::limit($pasien->alamat, 50) }}</td>
                                            <td>{{ $pasien->no_telepon }}</td>
                                            <td>
                                                <span class="badge badge-light">{{ $pasien->rumahSakit->nama_rumah_sakit }}</span>
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center">
                                                    <a href="{{ route('pasien.show', $pasien->id) }}"
                                                        class="btn btn-sm btn-info mr-2" data-toggle="tooltip" title="Detail">
                                                        <i class="fas fa-eye mt-2"></i>
                                                    </a>
                                                    <a href="{{ route('pasien.edit', $pasien->id) }}"
                                                        class="btn btn-sm btn-primary mr-2" data-toggle="tooltip" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button class="btn btn-sm btn-danger delete-btn"
                                                        data-id="{{ $pasien->id }}" data-toggle="tooltip" title="Hapus">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @if($pasiens->isEmpty())
                        <div class="text-center py-5">
                            <i class="fas fa-user-injured fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Tidak ada data pasien</p>
                            <a href="{{ route('pasien.create') }}" class="btn btn-primary mt-2">
                                <i class="fas fa-plus mr-2"></i> Tambah Pasien Pertama
                            </a>
                        </div>
                        @endif
                    </div>
                    <div class="d-flex justify-content-end">
                        {{ $pasiens->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        let originalData = [];

        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();

            $('#pasienTable tbody tr').each(function() {
                originalData.push({
                    element: $(this),
                    nama: $(this).find('td:eq(1)').text().toLowerCase(),
                    alamat: $(this).find('td:eq(2)').text().toLowerCase(),
                    telepon: $(this).find('td:eq(3)').text().toLowerCase(),
                    rumahSakit: $(this).find('td:eq(4)').text().toLowerCase()
                });
            });

            $('#rumahSakitFilter').change(function() {
                var rumahSakitId = $(this).val();
                if (rumahSakitId) {
                    window.location.href = "{{ route('pasien.index') }}?rumah_sakit_id=" + rumahSakitId;
                } else {
                    window.location.href = "{{ route('pasien.index') }}";
                }
            });

            $('#searchInput').on('keyup', function() {
                const value = $(this).val().toLowerCase();
                $('#pasienTable tbody tr').hide();

                originalData.forEach(item => {
                    if (item.nama.includes(value) ||
                        item.alamat.includes(value) ||
                        item.telepon.includes(value) ||
                        item.rumahSakit.includes(value)) {
                        item.element.show();
                    }
                });

                if ($('#pasienTable tbody tr:visible').length === 0) {
                    if ($('#noResultsMessage').length === 0) {
                        $('#pasienTable').after(
                            '<div id="noResultsMessage" class="text-center py-4">' +
                            '<i class="fas fa-search fa-2x text-muted mb-2"></i>' +
                            '<p class="text-muted">Tidak ada hasil ditemukan</p>' +
                            '</div>'
                        );
                    }
                } else {
                    $('#noResultsMessage').remove();
                }
            });

            $('#resetFilters').click(function(e) {
                e.preventDefault();
                $('#searchInput').val('');
                $('#rumahSakitFilter').val('');
                $('#pasienTable tbody tr').show();
                $('#noResultsMessage').remove();

                const urlParams = new URLSearchParams(window.location.search);
                if (urlParams.has('rumah_sakit_id')) {
                    window.location.href = "{{ route('pasien.index') }}";
                }
            });

            $('.delete-btn').click(function() {
                var pasienId = $(this).data('id');
                var pasienName = $(this).closest('tr').find('td:eq(1)').text();

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
                                    location.reload();
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
