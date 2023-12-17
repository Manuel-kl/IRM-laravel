<?php

namespace App\Http\Controllers\Users;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\NewAdminRequest;
use App\Models\Admin;

class AdminManager extends Controller
{
    /**
     * Display a listing of all admins.
     * viewAdmins policy is used to check if the user can view admins.
     */
    public function index(): JsonResponse
    {
        $user = auth()->user();

        $this->authorize('viewAdmins', $user);

        $admins = User::where('role', 'admin')
            ->with('admin')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Admins retrieved successfully',
            'data' => $admins,
        ]);
    }

    /**
     * Create a new admin from the existing users
     * manageAdmins policy is used to check if the user can manage admins.
     */
    public function store(NewAdminRequest $request): JsonResponse
    {
        $data = $request->validated();
        $newAdminEmail = $data['email'];

        $currentAdmin = auth()->user();

        $this->authorize('managesAdmins', $currentAdmin);

        $newAdminUser = User::where('email', $newAdminEmail)->first();
        $isExistingAdmin = $newAdminUser->isAdmin();

        if ($isExistingAdmin) {
            return response()->json([
                'success' => false,
                'message' => 'User is already an admin',
            ], 400);
        }

        $newAdminUser->role = 'admin';
        $newAdminUser->save();

        $newAdmin = Admin::create([
            'user_id' => User::where('email', $newAdminEmail)->first()->id,
        ]);


        return response()->json([
            'success' => true,
            'message' => 'Admin created successfully',
            'data' => $newAdmin,
        ]);
    }

    /**
     * Display an admin.
     * viewAdmins policy is used to check if the user can view admins.
     */
    public function show(Admin $admin): JsonResponse
    {
        $user = auth()->user();

        $this->authorize('viewAdmins', $user);

        return response()->json([
            'success' => true,
            'message' => 'Admin retrieved successfully',
            'data' => $admin,
        ]);
    }

    /**
     * Remove the specified admin from the admin list.
     * manageAdmins policy is used to check if the user can manage admins.
     */
    public function destroy(Admin $admin): JsonResponse
    {
        $user = auth()->user();

        $this->authorize('managesAdmins', $user);

        $admin->delete();

        $adminUser = User::find($admin->user_id);
        $adminUser->role = 'user';
        $adminUser->save();

        return response()->json([
            'success' => true,
            'message' => 'Admin deleted successfully',
        ]);
    }
}
