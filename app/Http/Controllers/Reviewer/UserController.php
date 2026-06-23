<?php

namespace App\Http\Controllers\Reviewer;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // ✅ List all users
    public function index()
    {
        $users = User::with('role', 'subAccounts')->paginate(20);
        return view('Reviewer.users.index', compact('users'));
    }

    // ✅ Show single user
    public function show($id)
    {
        $user = User::with('role', 'subAccounts')->findOrFail($id);
        return view('Reviewer.users.show', compact('user'));
    }

    // ✅ Show create form
    public function create()
    {
        $roles = Role::all();
        return view('Reviewer.users.create', compact('roles'));
    }

    // ✅ Store new user
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role_id' => 'required|exists:roles,id',
            'account_status' => 'required|in:active,suspended,blocked,pending',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        User::create($validated);

        return redirect()->route('Reviewer.users.index')->with('success', 'User created successfully.');
    }

    // ✅ Show edit form
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('Reviewer.users.edit', compact('user', 'roles'));
    }

    // ✅ Update user
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $id,
            'password' => 'sometimes|string|min:6',
            'role_id' => 'sometimes|exists:roles,id',
            'account_status' => 'sometimes|in:active,suspended,blocked,pending',
            'profile_picture' => 'sometimes|string',
            'phone' => 'sometimes|string',
            'whatsapp' => 'sometimes|string',
            'address' => 'sometimes|string',
            'city' => 'sometimes|string',
            'state' => 'sometimes|string',
            'postal_code' => 'sometimes|string',
            'country' => 'sometimes|string',
            'website' => 'sometimes|string',
            'bio' => 'sometimes|string',
            'job_title' => 'sometimes|string',
            'two_factor_enabled' => 'sometimes|boolean',
        ]);

        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('Reviewer.users.index')->with('success', 'User updated successfully.');
    }

    // ✅ Delete user
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('Reviewer.users.index')->with('success', 'User deleted successfully.');
    }

    // ✅ Restore deleted user
    public function restore($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->restore();

        return redirect()->route('Reviewer.users.index')->with('success', 'User restored successfully.');
    }

    // ✅ Update user account status
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:active,suspended,blocked,pending',
        ]);

        $user = User::findOrFail($id);
        $user->account_status = $request->status;
        $user->save();

        return redirect()->back()->with('success', 'User status updated successfully.');
    }

    // ✅ Update user role
    public function updateRole(Request $request, $id)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id',
        ]);

        $user = User::findOrFail($id);
        $user->role_id = $request->role_id;
        $user->save();

        return redirect()->back()->with('success', 'User role updated successfully.');
    }

    // ✅ Manage sub-accounts
    public function subAccounts($id)
    {
        $user = User::with('subAccounts')->findOrFail($id);
        return view('Reviewer.users.sub_accounts', ['subAccounts' => $user->subAccounts, 'user' => $user]);
    }
}
