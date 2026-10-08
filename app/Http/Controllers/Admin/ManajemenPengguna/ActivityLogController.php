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

        // Handle Yajra DataTables AJAX Server-Side Request
        if ($request->ajax() && ($request->has('draw') || $request->wantsJson())) {
            $query = ActivityLog::with(['causer'])->select('activity_logs.*');

            return DataTables::of($query)
                ->filter(function ($query) use ($request) {
                    if ($request->filled('log_name')) {
                        $query->where('activity_logs.log_name', $request->input('log_name'));
                    }
                    if ($request->filled('event')) {
                        $query->where('activity_logs.event', $request->input('event'));
                    }
                    if ($request->filled('causer_id')) {
                        $query->where('activity_logs.causer_id', $request->input('causer_id'));
                    }
                    if ($request->filled('date_range')) {
                        $range = $request->input('date_range');
                        if ($range === 'today') {
                            $query->whereDate('activity_logs.created_at', Carbon::today());
                        } elseif ($range === '7_days') {
                            $query->where('activity_logs.created_at', '>=', Carbon::now()->subDays(7));
                        } elseif ($range === '30_days') {
                            $query->where('activity_logs.created_at', '>=', Carbon::now()->subDays(30));
                        } elseif ($range === 'custom' && $request->filled('date_start') && $request->filled('date_end')) {
                            $query->whereBetween('activity_logs.created_at', [
                                Carbon::parse($request->input('date_start'))->startOfDay(),
                                Carbon::parse($request->input('date_end'))->endOfDay(),
                            ]);
                        }
                    } elseif ($request->filled('date_start') && $request->filled('date_end')) {
                        $query->whereBetween('activity_logs.created_at', [
                            Carbon::parse($request->input('date_start'))->startOfDay(),
                            Carbon::parse($request->input('date_end'))->endOfDay(),
                        ]);
                    }

                    $searchVal = $request->input('search.value');
                    if (!empty($searchVal)) {
                        $query->where(function ($q) use ($searchVal) {
                            $q->where('activity_logs.description', 'like', "%{$searchVal}%")
                                ->orWhere('activity_logs.log_name', 'like', "%{$searchVal}%")
                                ->orWhere('activity_logs.event', 'like', "%{$searchVal}%")
                                ->orWhere('activity_logs.ip_address', 'like', "%{$searchVal}%")
                                ->orWhereHas('causer', function ($uq) use ($searchVal) {
                                    $uq->where('name', 'like', "%{$searchVal}%")
                                        ->orWhere('email', 'like', "%{$searchVal}%");
                                });
                        });
                    }
                })
                ->addIndexColumn()
                ->addColumn('created_at_formatted', function ($log) {
                    return '<div class="d-flex flex-column text-start">
                        <span class="fw-semibold text-dark fs-12">' . $log->created_at->format('Y-m-d H:i:s') . '</span>
                        <span class="text-muted fs-11">' . $log->created_at->diffForHumans() . '</span>
                    </div>';
                })
                ->addColumn('causer_formatted', function ($log) {
                    if ($log->causer) {
                        return '<div class="d-flex align-items-center gap-2 text-start">
                            <img src="' . e($log->causer->avatar_url) . '" class="rounded-circle border flex-shrink-0" width="32" height="32" alt="Avatar">
                            <div class="d-flex flex-column overflow-hidden">
                                <span class="fw-semibold text-dark fs-12 text-truncate">' . e($log->causer->name) . '</span>
                                <span class="text-muted fs-11 text-truncate">' . e($log->causer->email) . '</span>
                            </div>
                        </div>';
                    }
                    return '<div class="d-flex align-items-center gap-2 text-start">
                        <img src="' . asset('assets/images/users/user-default.jpg') . '" class="rounded-circle border flex-shrink-0" width="32" height="32" alt="Avatar">
                        <div class="d-flex flex-column overflow-hidden">
                            <span class="fw-semibold text-dark fs-12 text-truncate">Sistem / Tamu</span>
                            <span class="text-muted fs-11 text-truncate">' . e($log->ip_address ?: '127.0.0.1') . '</span>
                        </div>
                    </div>';
                })
                ->addColumn('module_formatted', function ($log) {
                    return '<span class="badge bg-light text-dark border fs-11">' . e($log->log_name_label) . '</span>';
                })
                ->addColumn('event_formatted', function ($log) {
                    return '<span class="badge ' . $log->event_badge_class . ' fs-11 d-inline-flex align-items-center gap-1">
                        <i class="' . $log->event_icon . '"></i>' . ucfirst($log->event) . '
                    </span>';
                })
                ->addColumn('description_formatted', function ($log) {
                    return '<span class="fs-12 text-dark text-start d-block">' . e($log->description ?: '-') . '</span>';
                })
                ->addColumn('diff_formatted', function ($log) {
                    if (!empty($log->properties)) {
                        return '<span class="badge bg-info-subtle text-info border border-info-subtle fs-11">
                            <i class="ti ti-diff me-1"></i>Ada Diff
                        </span>';
                    }
                    return '<span class="badge bg-secondary-subtle text-secondary border fs-11">Polos</span>';
                })
                ->addColumn('action', function ($log) {
                    $canDelete = auth()->user()->can('delete manajemenpengguna/activity-log');
                    $csrf = csrf_field();
                    $deleteUrl = route('admin.manajemenpengguna.activity-log.destroy', $log->id);

                    $btn = '<div class="d-inline-flex gap-1">
                        <button type="button" class="btn btn-sm btn-subtle-primary btn-view-detail" data-id="' . $log->id . '" title="Lihat Detail Diff Perubahan">
                            <i class="ti ti-eye"></i>
                        </button>';

                    if ($canDelete) {
                        $btn .= '<form action="' . $deleteUrl . '" method="POST" class="d-inline" data-confirm="Hapus catatan riwayat log ini?">
                            ' . $csrf . '
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="btn btn-sm btn-subtle-danger" title="Hapus Catatan Log">
                                <i class="ti ti-trash"></i>
                            </button>
                        </form>';
                    }
                    $btn .= '</div>';
                    return $btn;
                })
                ->rawColumns(['created_at_formatted', 'causer_formatted', 'module_formatted', 'event_formatted', 'description_formatted', 'diff_formatted', 'action'])
                ->make(true);
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

        return view('admin.manajemenpengguna.activity_log', compact(
            'totalLogs',
            'todayLogs',
            'updateLogs',
            'deleteLogs',
            'modules',
            'events',
            'users'
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
