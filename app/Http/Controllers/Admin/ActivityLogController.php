<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = ActivityLog::with('user')->orderBy('created_at', 'desc');

        // Filter by action
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        // Filter by user
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Search by description
        if ($request->filled('search')) {
            $query->where('description', 'like', '%' . $request->search . '%');
        }

        $activities = $query->paginate(20);

        // Get filter options
        $actions = ActivityLog::distinct()->pluck('action');
        $users = \App\Models\User::where('role', 'admin')->get();

        return view('admin.sistem.activity-log.index', compact('activities', 'actions', 'users'));
    }

    /**
     * Display the specified resource.
     */
    public function show(ActivityLog $activityLog)
    {
        return view('admin.sistem.activity-log.show', compact('activityLog'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ActivityLog $activityLog)
    {
        try {
            $activityLog->delete();

            return redirect()->route('admin.activity-log.index')
                ->with('success', 'Log aktivitas berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus log aktivitas: ' . $e->getMessage());
        }
    }

    /**
     * Clean up old logs
     */
    public function cleanup(Request $request)
    {
        $days = $request->input('days', 30);

        $deleted = ActivityLog::where('created_at', '<', now()->subDays($days))->delete();

        return redirect()->back()->with('success', "Berhasil menghapus $deleted log aktivitas yang lebih dari $days hari.");
    }

    /**
     * Clear all activity logs
     */
    public function clear(Request $request)
    {
        try {
            $deleted = ActivityLog::count();
            ActivityLog::truncate();

            return redirect()->route('admin.activity-log.index')
                ->with('success', "Berhasil menghapus semua $deleted log aktivitas.");
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus log aktivitas: ' . $e->getMessage());
        }
    }
}
