<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class AdminManagementController extends Controller
{
    /**
     * Display a listing of admins
     */
    public function index()
    {
        // Only super admin can access
        if (!Auth::user()->isSuperAdmin()) {
            abort(403, 'Hanya Super Admin yang dapat mengakses halaman ini.');
        }

        $admins = User::allAdmins()
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $statistics = [
            'total_admins' => User::allAdmins()->count(),
            'super_admins' => User::superAdmins()->count(),
            'regular_admins' => User::regularAdmins()->count(),
            'active_admins' => User::allAdmins()->where('status', 'active')->count(),
            'inactive_admins' => User::allAdmins()->where('status', 'inactive')->count(),
        ];

        return view('admin.admin-management.index', compact('admins', 'statistics'));
    }

    /**
     * Show the form for creating a new admin
     */
    public function create()
    {
        if (!Auth::user()->isSuperAdmin()) {
            abort(403, 'Hanya Super Admin yang dapat membuat admin baru.');
        }

        return view('admin.admin-management.create');
    }

    /**
     * Store a newly created admin
     */
    public function store(Request $request)
    {
        if (!Auth::user()->isSuperAdmin()) {
            abort(403, 'Hanya Super Admin yang dapat membuat admin baru.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:20',
            'role' => 'required|in:super_admin,admin',
            'status' => 'required|in:active,inactive',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'name.required' => 'Nama wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'role.required' => 'Role wajib dipilih',
            'role.in' => 'Role tidak valid',
            'status.required' => 'Status wajib dipilih',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        try {
            $admin = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'role' => $request->role,
                'status' => $request->status,
                'password' => Hash::make($request->password),
                'password_changed_at' => now(),
            ]);

            // Log activity
            Log::info('New admin created', [
                'created_by' => Auth::user()->id,
                'admin_id' => $admin->id,
                'admin_email' => $admin->email,
                'admin_role' => $admin->role,
                'ip' => $request->ip(),
                'timestamp' => now()
            ]);

            return redirect()->route('admin.admin-management.index')
                ->with('success', 'Admin baru berhasil dibuat.');
        } catch (\Exception $e) {
            Log::error('Failed to create admin', [
                'error' => $e->getMessage(),
                'request' => $request->all(),
                'created_by' => Auth::user()->id,
                'timestamp' => now()
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal membuat admin baru. Silakan coba lagi.');
        }
    }

    /**
     * Show the form for editing the specified admin.
     */
    public function edit(User $user)
    {
        if (!Auth::user()->isSuperAdmin()) {
            abort(403, 'Hanya Super Admin yang dapat mengedit admin.');
        }

        // Allow editing any user, not just admins
        return view('admin.admin-management.edit', compact('user'));
    }

    /**
     * Update the specified admin in storage.
     */
    public function update(Request $request, User $user)
    {
        if (!Auth::user()->isSuperAdmin()) {
            abort(403, 'Hanya Super Admin yang dapat memperbarui admin.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'role' => 'required|in:admin,super_admin',
            'status' => 'required|in:active,inactive',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'password' => 'nullable|string|min:8|confirmed',
            'permissions' => 'nullable|array',
            'permissions.*' => 'string|in:manage_berita,manage_program,manage_layanan,manage_pengaduan,manage_galeri,manage_profil,manage_struktur,view_analytics',
        ]);

        DB::beginTransaction();
        try {
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'role' => $request->role,
                'status' => $request->status,
                'permissions' => $request->permissions ? json_encode($request->permissions) : null,
            ];

            // Handle password update
            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
                $data['password_changed_at'] = now();
            }

            // Handle avatar upload
            if ($request->hasFile('avatar')) {
                // Delete old avatar if exists
                if ($user->avatar) {
                    Storage::disk('public')->delete($user->avatar);
                }

                $avatarPath = $request->file('avatar')->store('avatars', 'public');
                $data['avatar'] = $avatarPath;
            }

            $user->update($data);

            // Log activity
            Log::info('Admin updated', [
                'updated_by' => Auth::user()->id,
                'admin_id' => $user->id,
                'admin_email' => $user->email,
                'changes' => array_keys($data),
                'ip' => $request->ip(),
                'timestamp' => now()
            ]);

            DB::commit();

            return redirect()->route('admin.admin-management.index')
                ->with('success', 'Data admin berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error updating admin: ' . $e->getMessage());

            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui data admin.');
        }
    }

    /**
     * Reset admin password to default password @admin123
     */
    public function resetPassword(Request $request, User $user)
    {
        // Clean any previous output
        if (ob_get_level()) {
            ob_clean();
        }

        Log::info('=== RESET PASSWORD REQUEST RECEIVED ===', [
            'user_id' => $user->id,
            'user_name' => $user->name,
            'request_method' => $request->method(),
            'auth_user_id' => Auth::id(),
            'timestamp' => now()
        ]);

        if (!Auth::user()->isSuperAdmin()) {
            Log::error('Reset password denied: Not super admin');
            return response()->json([
                'success' => false,
                'message' => 'Hanya Super Admin yang dapat reset password admin.'
            ], 403);
        }

        if ($user->id === Auth::id()) {
            Log::error('Reset password denied: Self reset attempt');
            return response()->json([
                'success' => false,
                'message' => 'Gunakan halaman profil untuk mengubah password Anda sendiri.'
            ], 400);
        }

        try {
            // Reset password to default @admin123
            $defaultPassword = '@admin123';

            $user->update([
                'password' => Hash::make($defaultPassword),
                'password_changed_at' => now(),
                'login_attempts' => 0,
                'locked_until' => null,
            ]);

            Log::info('Admin password reset to default by super admin', [
                'reset_by' => Auth::user()->id,
                'admin_id' => $user->id,
                'admin_name' => $user->name,
                'admin_email' => $user->email,
                'new_password' => $defaultPassword,
                'ip' => $request->ip(),
                'timestamp' => now()
            ]);

            $response = [
                'success' => true,
                'message' => "Password untuk admin {$user->name} berhasil direset ke: {$defaultPassword}",
                'new_password' => $defaultPassword
            ];

            Log::info('=== SENDING SUCCESS RESPONSE ===', $response);

            // Ensure clean JSON response
            return response()->json($response, 200)
                ->header('Content-Type', 'application/json; charset=utf-8')
                ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
                ->header('Pragma', 'no-cache')
                ->header('Expires', '0');
        } catch (\Exception $e) {
            Log::error('Failed to reset admin password', [
                'error' => $e->getMessage(),
                'stack_trace' => $e->getTraceAsString(),
                'admin_id' => $user->id,
                'reset_by' => Auth::user()->id,
                'timestamp' => now()
            ]);

            $errorResponse = [
                'success' => false,
                'message' => 'Gagal reset password admin. Silakan coba lagi.',
                'error_details' => $e->getMessage()
            ];

            Log::info('=== SENDING ERROR RESPONSE ===', $errorResponse);

            return response()->json($errorResponse, 500)
                ->header('Content-Type', 'application/json; charset=utf-8')
                ->header('Cache-Control', 'no-cache, no-store, must-revalidate');
        }
    }

    /**
     * Remove the specified admin
     */
    public function destroy(User $user)
    {
        if (!Auth::user()->isSuperAdmin()) {
            abort(403, 'Hanya Super Admin yang dapat menghapus admin.');
        }

        // Prevent super admin from deleting themselves
        if ($user->id === Auth::user()->id) {
            return redirect()->back()
                ->with('warning', 'Anda tidak dapat menghapus akun diri sendiri.');
        }

        // Prevent deletion of the last super admin
        if ($user->isSuperAdmin() && User::superAdmins()->count() <= 1) {
            return redirect()->back()
                ->with('warning', 'Tidak dapat menghapus super admin terakhir dalam sistem.');
        }

        try {
            // Log activity before deletion
            Log::info('Admin account deleted', [
                'deleted_by' => Auth::user()->id,
                'admin_id' => $user->id,
                'admin_email' => $user->email,
                'admin_role' => $user->role,
                'timestamp' => now()
            ]);

            $user->delete();

            return redirect()->route('admin.admin-management.index')
                ->with('success', 'Admin berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Failed to delete admin', [
                'error' => $e->getMessage(),
                'admin_id' => $user->id,
                'deleted_by' => Auth::user()->id,
                'timestamp' => now()
            ]);

            return redirect()->back()
                ->with('error', 'Gagal menghapus admin. Silakan coba lagi.');
        }
    }

    /**
     * Toggle admin status (active/inactive)
     */
    public function toggleStatus(User $user)
    {
        if (!Auth::user()->isSuperAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'Hanya Super Admin yang dapat mengubah status admin.'
            ], 403);
        }

        // Prevent super admin from deactivating themselves
        if ($user->id === Auth::id() && $user->status === 'active') {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak dapat menonaktifkan akun Anda sendiri.'
            ], 400);
        }

        try {
            $user->status = $user->status === 'active' ? 'inactive' : 'active';
            $user->save();

            Log::info('Admin status toggled', [
                'admin_id' => $user->id,
                'new_status' => $user->status,
                'changed_by' => Auth::id()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Status admin berhasil diubah.',
                'new_status' => $user->status
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to toggle admin status', [
                'admin_id' => $user->id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengubah status admin.'
            ], 500);
        }
    }
}
