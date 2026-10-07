<?php

namespace App\Http\Controllers\Admin\ManajemenPengguna;

use App\Http\Controllers\Controller;
use App\Models\Admin\ManajemenPengguna\ActivityLog;
use App\Models\User;
use App\Traits\HasNotification;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ActivityLogController extends Controller
{
    use HasNotification;

    /**
     * Display activity log listing & analytics metrics.
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        if (!$user || (!$user->hasRole('superadmin') && !$user->can('read manajemenpengguna/activity-log'))) {
            abort(403, 'Anda tidak memiliki hak akses untuk melihat data riwayat log aktivitas.');
        }

        $query = ActivityLog::with(['causer'])->latest();

        $filterLogName = $request->input('log_name', '');
        $filterEvent = $request->input('event', '');
        $filterCauserId = $request->input('causer_id', '');
        $filterDateRange = $request->input('date_range', '');
        $filterDateStart = $request->input('date_start', '');
        $filterDateEnd = $request->input('date_end', '');
        $searchKeyword = $request->input('search', '');

        // Filter: Log Name / Modul
        if (!empty($filterLogName)) {
            $query->where('log_name', $filterLogName);
        }

        // Filter: Event
        if (!empty($filterEvent)) {
            $query->where('event', $filterEvent);
        }

        // Filter: Actor / User
        if (!empty($filterCauserId)) {
            $query->where('causer_id', $filterCauserId);
        }

        // Filter: Search Keyword
        if (!empty($searchKeyword)) {
            $query->where(function ($q) use ($searchKeyword) {
                $q->where('description', 'like', "%{$searchKeyword}%")
                    ->orWhere('log_name', 'like', "%{$searchKeyword}%")
                    ->orWhere('event', 'like', "%{$searchKeyword}%")
                    ->orWhere('ip_address', 'like', "%{$searchKeyword}%")
                    ->orWhereHas('causer', function ($uq) use ($searchKeyword) {
                        $uq->where('name', 'like', "%{$searchKeyword}%")
                            ->orWhere('email', 'like', "%{$searchKeyword}%");
                    });
            });
        }

        // Filter: Rentang Waktu (Date Range)
        if (!empty($filterDateRange)) {
            if ($filterDateRange === 'today') {
                $query->whereDate('created_at', Carbon::today());
            } elseif ($filterDateRange === '7_days') {
                $query->where('created_at', '>=', Carbon::now()->subDays(7));
            } elseif ($filterDateRange === '30_days') {
                $query->where('created_at', '>=', Carbon::now()->subDays(30));
            } elseif ($filterDateRange === 'custom' && !empty($filterDateStart) && !empty($filterDateEnd)) {
                $query->whereBetween('created_at', [
                    Carbon::parse($filterDateStart)->startOfDay(),
                    Carbon::parse($filterDateEnd)->endOfDay(),
                ]);
            }
        } elseif (!empty($filterDateStart) && !empty($filterDateEnd)) {
            $query->whereBetween('created_at', [
                Carbon::parse($filterDateStart)->startOfDay(),
                Carbon::parse($filterDateEnd)->endOfDay(),
            ]);
        }

        // Metrics Summary
        $today = Carbon::today();
        $totalLogs = ActivityLog::count();
        $todayLogs = ActivityLog::whereDate('created_at', $today)->count();
        $updateLogs = ActivityLog::where('event', 'updated')->count();
        $deleteLogs = ActivityLog::where('event', 'deleted')->count();

        // Dropdown Filter Options
        $modules = ActivityLog::select('log_name')->distinct()->pluck('log_name')->filter()->values();
        $events = ['created', 'updated', 'deleted', 'login', 'custom'];
        $users = User::orderBy('name')->get(['id', 'name', 'email']);

        $logs = $query->paginate(25)->withQueryString();

        return view('admin.manajemenpengguna.activity_log', compact(
            'totalLogs',
            'todayLogs',
            'updateLogs',
            'deleteLogs',
            'modules',
            'events',
            'users',
            'logs',
            'filterLogName',
            'filterEvent',
            'filterCauserId',
            'filterDateRange',
            'filterDateStart',
            'filterDateEnd',
            'searchKeyword'
        ));
    }

    /**
     * Show modal detail with visual JSON / Table diff.
     */
    public function show(int $id): JsonResponse
    {
        $user = auth()->user();
        if (!$user || (!$user->hasRole('superadmin') && !$user->can('read manajemenpengguna/activity-log'))) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki hak akses untuk melihat data riwayat log aktivitas.',
            ], 403);
        }

        $log = ActivityLog::with(['causer'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $log->id,
                'description' => $log->description,
                'log_name' => $log->log_name,
                'log_name_label' => $log->log_name_label,
                'event' => $log->event,
                'event_badge_class' => $log->event_badge_class,
                'event_icon' => $log->event_icon,
                'subject_type' => $log->subject_type,
                'subject_id' => $log->subject_id,
                'causer_name' => $log->causer ? $log->causer->name : 'Sistem / Otomatis',
                'causer_email' => $log->causer ? $log->causer->email : '-',
                'causer_avatar' => $log->causer ? $log->causer->avatar_url : asset('assets/images/users/user-default.jpg'),
                'ip_address' => $log->ip_address ?: '-',
                'user_agent' => $log->user_agent ?: '-',
                'created_at' => $log->created_at->format('Y-m-d H:i:s'),
                'time_ago' => $log->created_at->diffForHumans(),
                'properties' => $log->properties,
            ],
        ]);
    }

    /**
     * Delete a specific activity log record.
     */
    public function destroy(int $id)
    {
        $user = auth()->user();
        if (!$user || (!$user->hasRole('superadmin') && !$user->can('delete manajemenpengguna/activity-log'))) {
            abort(403, 'Anda tidak memiliki hak akses untuk menghapus riwayat log aktivitas.');
        }

        $log = ActivityLog::findOrFail($id);
        $log->delete();

        $this->notifySuccess('Catatan riwayat aktivitas berhasil dihapus.', 'Berhasil!');
        return redirect()->back();
    }

    /**
     * Clear / Purge old activity logs based on days retention.
     */
    public function clear(Request $request)
    {
        $user = auth()->user();
        if (!$user || (!$user->hasRole('superadmin') && !$user->can('delete manajemenpengguna/activity-log'))) {
            abort(403, 'Anda tidak memiliki hak akses untuk membersihkan riwayat log aktivitas.');
        }

        $days = (int) $request->input('days', 30);

        if ($days === 0) {
            // Delete all
            ActivityLog::truncate();
            $message = 'Seluruh catatan riwayat log aktivitas berhasil dibersihkan.';
        } else {
            $threshold = Carbon::now()->subDays($days);
            $deletedCount = ActivityLog::where('created_at', '<', $threshold)->delete();
            $message = "Sebanyak {$deletedCount} catatan log aktivitas yang berusia lebih dari {$days} hari berhasil dibersihkan.";
        }

        $this->notifySuccess($message, 'Pembersihan Log Selesai!');
        return redirect()->route('admin.manajemenpengguna.activity-log.index');
    }
}
