@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h2 class="font-weight-bold">Dashboard</h2>
                    <div class="d-flex">
                        <span class="mr-2 text-muted">{{ now()->format('l, d F Y') }}</span>
                    </div>
                </div>
                <hr class="border-secondary mt-2">
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col-lg-6 mb-4">
                <div class="stat-card slide-in">
                    <i class="fas fa-hospital text-primary"></i>
                    <h3 class="text-primary">{{ $rumahSakitCount }}</h3>
                    <p>Rumah Sakit</p>
                </div>
            </div>

            <div class="col-md-6 col-lg-6 mb-4">
                <div class="stat-card slide-in" style="animation-delay: 0.1s;">
                    <i class="fas fa-user-injured text-success"></i>
                    <h3 class="text-success">{{ $pasienCount }}</h3>
                    <p>Pasien</p>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-header bg-transparent border-bottom-0 pt-4">
                        <h5 class="card-title mb-0">Distribusi Pasien per Rumah Sakit</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="hospitalDistributionChart" height="250"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-8 mb-4">
                <div class="card">
                    <div class="card-header bg-transparent border-bottom-0 pt-4">
                        <h5 class="card-title mb-0">Trend Pendaftaran Pasien (30 Hari)</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="patientTrendChart" height="250"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div
                        class="card-header bg-transparent border-bottom-0 pt-4 d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Aktivitas Terbaru</h5>
                        <button class="btn btn-sm btn-outline-secondary" id="refreshActivities">
                            <i class="fas fa-sync-alt"></i>
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush" id="activitiesList">
                            @foreach ($recentActivities as $activity)
                                <div class="list-group-item border-0 px-0 activity-item activity-item-custom">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle {{ $activity['color'] }} text-white d-flex align-items-center justify-content-center mr-3"
                                            style="width: 40px; height: 40px;">
                                            <i class="fas {{ $activity['icon'] }}"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-0">{{ $activity['title'] }}</h6>
                                            <small class="text-muted" data-toggle="tooltip"
                                                title="{{ $activity['timestamp']->format('Y-m-d H:i:s') }}">
                                                {{ $activity['time_ago'] }}
                                            </small>
                                            @if (!empty($activity['details']))
                                                <div class="mt-1">
                                                    <small class="text-muted">{{ $activity['details'] }}</small>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        @if (empty($recentActivities))
                            <div class="text-center py-4">
                                <i class="fas fa-history fa-2x text-muted mb-2"></i>
                                <p class="text-muted">Tidak ada aktivitas terbaru</p>
                            </div>
                        @endif
                    </div>
                    <div class="card-footer bg-transparent border-0 text-center">
                        <a href="{{ route('pasien.index') }}" class="text-primary font-weight-bold">
                            Lihat semua data baru <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header bg-transparent border-bottom-0 pt-4">
                        <h5 class="card-title mb-0">Statistik Cepat</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <small class="text-muted d-block">Pasien per Rumah Sakit</small>
                            <div class="progress mt-2" style="height: 8px;">
                                <div class="progress-bar bg-primary" role="progressbar"
                                    style="width: {{ $avgPatientsPerHospital }}%;"
                                    aria-valuenow="{{ $avgPatientsPerHospital }}" aria-valuemin="0" aria-valuemax="100">
                                </div>
                            </div>
                            <small class="text-muted">{{ number_format($avgPatientsPerHospital, 1) }}% dari kapasitas
                                maksimal</small>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted d-block">Rata-rata Pasien per Hari</small>
                            <h4 class="mb-0">{{ $avgPatientsPerDay }}</h4>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted d-block">Pertumbuhan Bulanan</small>
                            <div class="d-flex align-items-center">
                                <h4 class="mb-0 mr-2 {{ $growthRate >= 0 ? 'text-success' : 'text-danger' }}">
                                    {{ $growthRate >= 0 ? '+' : '' }}{{ number_format($growthRate, 1) }}%
                                </h4>
                                <i
                                    class="fas {{ $growthRate >= 0 ? 'fa-arrow-up text-success' : 'fa-arrow-down text-danger' }}"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        $(document).ready(function() {
            const hospitalCtx = document.getElementById('hospitalDistributionChart').getContext('2d');
            const hospitalChart = new Chart(hospitalCtx, {
                type: 'doughnut',
                data: {
                    labels: {!! json_encode($hospitalDistribution['labels']) !!},
                    datasets: [{
                        data: {!! json_encode($hospitalDistribution['data']) !!},
                        backgroundColor: [
                            '#4361ee', '#3a0ca3', '#7209b7', '#f72585', '#4cc9f0',
                            '#4895ef', '#560bad', '#b5179e', '#f15bb5', '#fee440'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right',
                        }
                    }
                }
            });

            const trendCtx = document.getElementById('patientTrendChart').getContext('2d');
            const trendChart = new Chart(trendCtx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($patientTrend['labels']) !!},
                    datasets: [{
                        label: 'Jumlah Pasien',
                        data: {!! json_encode($patientTrend['data']) !!},
                        borderColor: '#4361ee',
                        backgroundColor: 'rgba(67, 97, 238, 0.1)',
                        fill: true,
                        tension: 0.4,
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });

            setInterval(function() {
                updateDashboardStats();
            }, 300000);
        });

        function updateDashboardStats() {
            $.ajax({
                url: "{{ route('dashboard.stats') }}",
                type: 'GET',
                success: function(response) {
                    $('.stat-card:eq(0) h3').text(response.rumahSakitCount);
                    $('.stat-card:eq(1) h3').text(response.pasienCount);
                    $('.progress-bar').css('width', response.avgPatientsPerHospital + '%').attr('aria-valuenow',
                        response.avgPatientsPerHospital);
                    $('.progress-bar').next('small').text(response.avgPatientsPerHospital +
                        '% dari kapasitas rata-rata');
                    $('.mb-3:eq(1) h4').text(response.avgPatientsPerDay);

                    const growthElement = $('.mb-3:eq(2) h4');
                    const iconElement = $('.mb-3:eq(2) i');
                    growthElement.removeClass('text-success text-danger');
                    iconElement.removeClass('fa-arrow-up fa-arrow-down text-success text-danger');

                    if (response.growthRate >= 0) {
                        growthElement.addClass('text-success').text('+' + response.growthRate + '%');
                        iconElement.addClass('fa-arrow-up text-success');
                    } else {
                        growthElement.addClass('text-danger').text(response.growthRate + '%');
                        iconElement.addClass('fa-arrow-down text-danger');
                    }
                },
                error: function(xhr) {
                    console.error('Error updating dashboard statistics');
                }
            });
        }

        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();

            $('#refreshActivities').click(function() {
                const button = $(this);
                button.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i>');

                $.ajax({
                    url: "{{ route('dashboard.activities') }}",
                    type: 'GET',
                    success: function(response) {
                        updateActivitiesList(response.activities);
                        button.prop('disabled', false).html('<i class="fas fa-sync-alt"></i>');
                    },
                    error: function(xhr) {
                        button.prop('disabled', false).html('<i class="fas fa-sync-alt"></i>');
                        toastr.error('Gagal memuat aktivitas');
                    }
                });
            });

            setInterval(function() {
                updateActivities();
            }, 120000);

            @if (config('broadcasting.connections.pusher.key'))
                Echo.channel('dashboard-activities')
                    .listen('NewActivity', (e) => {
                        addNewActivity(e.activity);
                    });
            @endif
        });

        function updateActivities() {
            $.ajax({
                url: "{{ route('dashboard.activities') }}",
                type: 'GET',
                success: function(response) {
                    updateActivitiesList(response.activities);
                }
            });
        }

        function updateActivitiesList(activities) {
            const activitiesList = $('#activitiesList');

            if (activities.length === 0) {
                activitiesList.html(`
            <div class="text-center py-4">
                <i class="fas fa-history fa-2x text-muted mb-2"></i>
                <p class="text-muted">Tidak ada aktivitas terbaru</p>
            </div>
            `);
                return;
            }

            let html = '';
            activities.forEach(activity => {
                html += `
            <div class="list-group-item border-0 px-0 activity-item activity-item-custom">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle ${activity.color} text-white d-flex align-items-center justify-content-center mr-3"
                        style="width: 40px; height: 40px;">
                        <i class="fas ${activity.icon}"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="mb-0">${activity.title}</h6>
                        <small class="text-muted" data-toggle="tooltip" title="${activity.timestamp}">
                            ${activity.time_ago}
                        </small>
                        ${activity.details ? `
                                    <div class="mt-1">
                                        <small class="text-muted">${activity.details}</small>
                                    </div>
                                    ` : ''}
                    </div>
                </div>
            </div>
            `;
            });

            activitiesList.html(html);
            $('[data-toggle="tooltip"]').tooltip();
        }

        function addNewActivity(activity) {
            const activitiesList = $('#activitiesList');
            const noActivities = activitiesList.find('.text-center').length > 0;

            if (noActivities) {
                activitiesList.empty();
            }

            const newActivity = `
            <div class="list-group-item border-0 px-0 activity-item activity-item-custom" style="animation: fadeIn 0.5s;">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle ${activity.color} text-white d-flex align-items-center justify-content-center mr-3"
                        style="width: 40px; height: 40px;">
                        <i class="fas ${activity.icon}"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="mb-0">${activity.title}</h6>
                        <small class="text-muted" data-toggle="tooltip" title="${activity.timestamp}">
                            ${activity.time_ago}
                        </small>
                        ${activity.details ? `
                                    <div class="mt-1">
                                        <small class="text-muted">${activity.details}</small>
                                    </div>
                                    ` : ''}
                    </div>
                </div>
            </div>
            `;

            activitiesList.prepend(newActivity);
            if (activitiesList.find('.activity-item').length > 10) {
                activitiesList.find('.activity-item').last().remove();
            }

            $('[data-toggle="tooltip"]').tooltip();
        }
    </script>
@endpush
