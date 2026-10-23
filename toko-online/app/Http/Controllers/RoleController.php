<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangeRoleRequest;
use App\Models\User;
use App\Services\RoleManagementService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class RoleController extends Controller
{
    public function index(): View
    {
        return view('admin.users.roles', [
            'users' => User::query()
                ->orderBy('id_user')
                ->get([
                    'id_user',
                    'nama_lengkap',
                    'username',
                    'role',
                ]),
        ]);
    }

    public function update(
        ChangeRoleRequest $request,
        User $user,
        RoleManagementService $service
    ): RedirectResponse {
        $data = $request->validated();

        $service->changeRole(
            $request->user(),
            $user,
            $data['role']
        );

        return back()->with('status', 'Role diperbarui.');
    }
}