<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        $permissions = Permission::all();
        return view('admin.users.edit', compact('user', 'roles', 'permissions'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|min:4|max:50',
            'cellphone' => 'required|ir_mobile'
        ]);

        try {
            DB::beginTransaction();

            $user->update([
                'name' => $request->name,
                'cellphone' => $request->cellphone,
                'email' => $request->email
            ]);

            $user->syncRoles($request->role);
            $permission = $request->except('_token', '_method', 'name', 'email', 'cellphone', 'role');
            $user->syncPermissions($permission);

            DB::commit();
        } catch (\Exception $ex) {
            DB::rollBack();
            alert()->error('مشکل در ویرایش مشخصات کاربر', $ex->getMessage())->persistent('حله');
            return redirect()->back();
        }

        alert()->success('با تشکر','مشخصات کاربر با موفقیت ویرایش شد!');
        return redirect()->route('admin.users.index');
    }
}
