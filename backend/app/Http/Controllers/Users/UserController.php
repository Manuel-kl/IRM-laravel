<?php

namespace App\Http\Controllers\Users;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdateUserRequest;


class UserController extends Controller
{
    /**
     * Display a listing of all users (admins and users)
     * managesAdmins policy is used to check if the user can manage admins.
     */
    public function index(): JsonResponse
    {
        $user = auth()->user();

        $users =  User::where('role', '!=', 'admin')->get();

        $canManageAdmins = $this->authorize('managesAdmins', $user);

        if ($canManageAdmins) {
            $users = User::all();
        }

        return response()->json([
            'success' => true,
            'message' => 'Users retrieved successfully',
            'data' => $users,
        ]);
    }

    /**
     * Display the specified user (admin or user)
     * managesTheirAccount policy is used to check if the user can manage their account.
     */
    public function show(User $user)
    {
        $loggedInUser = auth()->user();

        $isAdmin =  $this->authorize('managesTheirAccount', $user, $loggedInUser);
        $isOwner = $this->authorize('managesTheirAccount', $user);

        if ($isAdmin || $isOwner) {
            return response()->json([
                'success' => true,
                'message' => 'User retrieved successfully',
                'data' => $user,
            ]);
        }
    }

    /**
     * Update the specified user (admin or user)
     * managesTheirAccount policy is used to check if the user can manage their account.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $loggedInUser = auth()->user();

        $this->authorize('managesTheirAccount', $user, $loggedInUser);

        $data = $request->validated();
        $user->update($data);

        return response()->json([
            'success' => true,
            'message' => 'User updated successfully',
            'data' => $user,
        ]);
    }

    /**
     * Remove the specified user (admin or user)
     * managesTheirAccount policy is used to check if the user can manage their account.
     */
    public function destroy(User $user): JsonResponse
    {
        $this->authorize('managesTheirAccount', $user);

        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'User deleted successfully',
        ]);
    }
}
