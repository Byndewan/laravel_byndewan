<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Pasien;
use App\Models\RumahSakit;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public function index(){
        $stats = $this->getDashboardStatistics();

        return view('index', array_merge([
            'rumahSakitCount' => RumahSakit::count(),
            'pasienCount' => Pasien::count(),
            'recentActivities' => $this->getRecentActivities()
        ], $stats));
    }

    public function getDashboardStatistics()
    {
        return [
            'avgPatientsPerHospital' => $this->calculateAvgPatientsPerHospital(),
            'avgPatientsPerDay' => $this->calculateAvgPatientsPerDay(),
            'growthRate' => $this->calculateMonthlyGrowthRate(),
            'hospitalDistribution' => $this->getHospitalDistribution(),
            'patientTrend' => $this->getPatientTrend(),
        ];
    }

    private function calculateAvgPatientsPerHospital(){
        $totalHospitals = RumahSakit::count();
        if ($totalHospitals === 0) return 0;

        $totalPatients = Pasien::count();
        $avgPatients = $totalPatients / $totalHospitals;
        $maxCapacity = 150;
        $percentage = min(100, ($avgPatients / $maxCapacity) * 100);

        return round($percentage, 1);
    }

    private function calculateAvgPatientsPerDay(){
        $totalPatients = Pasien::count();
        $days = 30;
        $avgPerDay = $totalPatients / $days;

        return round($avgPerDay);
    }

    private function calculateMonthlyGrowthRate(){
        $currentMonthCount = Pasien::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $previousMonthCount = Pasien::whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->count();

        if ($previousMonthCount === 0) {
            return $currentMonthCount > 0 ? 100 : 0;
        }

        $growthRate = (($currentMonthCount - $previousMonthCount) / $previousMonthCount) * 100;

        return round($growthRate, 1);
    }

    private function getHospitalDistribution(){
        $distribution = RumahSakit::withCount('pasiens')
            ->orderBy('pasiens_count', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($hospital) {
                return [
                    'label' => $hospital->nama_rumah_sakit,
                    'data' => $hospital->pasiens_count
                ];
            });

        return [
            'labels' => $distribution->pluck('label')->toArray(),
            'data' => $distribution->pluck('data')->toArray()
        ];
    }

    private function getPatientTrend(){
        $trend = Pasien::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as count')
            )
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $labels = [];
        $data = [];

        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $labels[] = now()->subDays($i)->format('M d');

            $found = $trend->firstWhere('date', $date);
            $data[] = $found ? $found->count : 0;
        }

        return [
            'labels' => $labels,
            'data' => $data
        ];
    }

    public function getStats(){
        return response()->json($this->getDashboardStatistics());
    }

    private function getRecentActivities($limit = 5){
        $activities = [];

        $recentPatients = Pasien::with('rumahSakit')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        foreach ($recentPatients as $patient) {
            $activities[] = [
                'type' => 'patient_created',
                'title' => 'Pasien baru ditambahkan',
                'details' => $patient->nama_pasien . ' - ' . $patient->rumahSakit->nama_rumah_sakit,
                'icon' => 'fa-user-plus',
                'color' => 'bg-primary',
                'timestamp' => $patient->created_at,
                'time_ago' => $this->getTimeAgo($patient->created_at)
            ];
        }

        $recentHospitals = RumahSakit::orderBy('updated_at', 'desc')
            ->where('updated_at', '>', DB::raw('created_at'))
            ->limit(3)
            ->get();

        foreach ($recentHospitals as $hospital) {
            $activities[] = [
                'type' => 'hospital_updated',
                'title' => 'Rumah sakit diperbarui',
                'details' => $hospital->nama_rumah_sakit,
                'icon' => 'fa-hospital',
                'color' => 'bg-success',
                'timestamp' => $hospital->updated_at,
                'time_ago' => $this->getTimeAgo($hospital->updated_at)
            ];
        }

        usort($activities, function($a, $b) {
            return $b['timestamp'] <=> $a['timestamp'];
        });

        return array_slice($activities, 0, $limit);
    }

    private function getTimeAgo($timestamp){
        $now = Carbon::now();
        $diff = $timestamp->diffForHumans($now, true);

        return $diff . ' yang lalu';
    }

    public function getActivities(){
        $activities = $this->getRecentActivities();

        return response()->json([
            'activities' => $activities
        ]);
    }

    public static function logActivity($type, $title, $details = null, $icon = 'fa-info', $color = 'bg-secondary'){
        ActivityLog::create([
            'type' => $type,
            'title' => $title,
            'details' => $details,
            'icon' => $icon,
            'color' => $color,
            'user_id' => auth()->id()
        ]);
    }

}
