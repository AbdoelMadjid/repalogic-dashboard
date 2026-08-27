<?php

namespace App\Http\Controllers\Admin\ManajemenPengguna;

use App\Http\Controllers\Controller;
use App\Models\Admin\ManajemenPengguna\UserLogin;
use App\Models\User;
use App\Traits\HasNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DataLoginController extends Controller
{
    use HasNotification;

    /**
     * Tampilkan data riwayat login dan daftar pengguna yang login hari ini.
     */
    public function index(Request $request)
    {
        $period = $request->input('period', 'all');
        $userId = $request->input('user_id');
        $searchTerm = $request->input('search');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // 1. Ringkasan Statistik Utama
        $stats = [
            'total_today' => UserLogin::today()->count(),
            'unique_users_today' => UserLogin::today()->distinct('user_id')->count('user_id'),
            'points_today' => UserLogin::today()->where('points_awarded', 1)->count(),
            'total_all_time' => UserLogin::count(),
        ];

        // 2. Data Pengguna yang Login Hari Ini (Tab 1)
        $todayLogins = UserLogin::with(['user.roles'])
            ->today()
            ->orderBy('login_at', 'desc')
            ->get();

        $todayUsers = $todayLogins->groupBy('user_id')->map(function ($logins) {
            $user = $logins->first()->user;
            $latest = $logins->first();
            $first = $logins->last();
            $pointsEarnedToday = $logins->where('points_awarded', 1)->count();

            return (object) [
                'user' => $user,
                'total_sessions_today' => $logins->count(),
                'points_earned_today' => $pointsEarnedToday,
                'first_login_today' => $first->login_at,
                'last_login_today' => $latest->login_at,
                'latest_ip' => $latest->ip_address,
                'latest_browser' => $latest->browser,
                'latest_platform' => $latest->platform,
                'latest_device_type' => $latest->device_type,
                'latest_latitude' => $latest->latitude,
                'latest_longitude' => $latest->longitude,
                'latest_map_url' => $latest->map_url,
                'latest_login_id' => $latest->id,
            ];
        })->values();

        // 3. Query Riwayat Login Lengkap (Tab 2) dengan Filter Dinamis
        $query = UserLogin::with(['user.roles'])->orderBy('login_at', 'desc');

        if ($period === 'today') {
            $query->today();
        } elseif ($period === 'last7') {
            $query->last7Days();
        } elseif ($period === 'this_month') {
            $query->thisMonth();
        } elseif ($period === 'custom' && $startDate && $endDate) {
            $query->whereBetween('login_at', [
                Carbon::parse($startDate)->startOfDay(),
                Carbon::parse($endDate)->endOfDay(),
            ]);
        }

        if (!empty($userId)) {
            $query->where('user_id', $userId);
        }

        if (!empty($searchTerm)) {
            $query->search($searchTerm);
        }

        $allLogins = $query->paginate(25)->withQueryString();

        // 4. Daftar user untuk dropdown filter
        $usersList = User::select('id', 'name', 'email')->orderBy('name')->get();

        return view('admin.manajemenpengguna.data_login', compact(
            'stats',
            'todayUsers',
            'allLogins',
            'usersList',
            'period',
            'userId',
            'searchTerm',
            'startDate',
            'endDate'
        ));
    }

    /**
     * Ambil data detail riwayat login tunggal (JSON untuk modal).
     */
    public function show($id)
    {
        $login = UserLogin::with(['user.roles'])->findOrFail($id);

        return response()->json([
            'status' => 'success',
            'data' => [
                'id' => $login->id,
                'user_name' => $login->user?->name ?? 'User Terhapus',
                'user_email' => $login->user?->email ?? '-',
                'user_avatar' => $login->user?->avatar_url ?? asset('assets/images/users/default-avatar.svg'),
                'user_role' => $login->user?->role_name ?? 'User',
                'ip_address' => $login->ip_address ?? '-',
                'browser' => $login->browser ?? 'Unknown',
                'platform' => $login->platform ?? 'Unknown',
                'device_type' => $login->device_type ?? 'Desktop',
                'user_agent' => $login->user_agent ?? '-',
                'latitude' => $login->latitude,
                'longitude' => $login->longitude,
                'map_url' => $login->map_url,
                'osm_embed_url' => $login->osm_embed_url,
                'points_awarded' => $login->points_awarded,
                'login_at' => $login->login_at ? $login->login_at->translatedFormat('d F Y, H:i:s') . ' WIB' : '-',
                'created_at_human' => $login->login_at ? $login->login_at->diffForHumans() : '-',
            ],
        ]);
    }

    /**
     * Hapus satu baris riwayat login.
     */
    public function destroy($id)
    {
        $login = UserLogin::findOrFail($id);
        $userName = $login->user?->name ?? 'Pengguna';
        $loginTime = $login->login_at?->format('d/m/Y H:i') ?? '';

        $login->delete();

        $this->notifySuccess("Riwayat login {$userName} ({$loginTime}) berhasil dihapus.");

        return redirect()->route('admin.manajemenpengguna.data-login.index');
    }

    /**
     * Bersihkan riwayat login lama (opsional pemeliharaan data).
     */
    public function clearOldLogs(Request $request)
    {
        $days = (int) $request->input('days', 90);
        if ($days < 7) {
            $days = 7;
        }

        $cutoffDate = Carbon::now()->subDays($days)->startOfDay();
        $deletedCount = UserLogin::where('login_at', '<', $cutoffDate)->delete();

        $this->notifySuccess("Berhasil membersihkan {$deletedCount} data riwayat login yang lebih dari {$days} hari lalu.");

        return redirect()->route('admin.manajemenpengguna.data-login.index');
    }
}
