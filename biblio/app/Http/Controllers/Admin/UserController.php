<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Carbon\Carbon;

class UserController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Users', [
            'users' => User::select('id', 'name', 'email', 'role', 'restricted_until')->get(),

        ]);
    }

    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:admin,user',
        ]);

        if ($user->id === auth()->id()) {
            return back()->withErrors([
                'role' => 'You cannot change your own role.',
            ]);
        }

        $user->update([
            'role' => $request->role,
        ]);

        return back();
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->withErrors([
                'user' => 'You cannot delete yourself.',
            ]);
        }

        $user->delete();

        return back();
    }

    public function restrict(User $user, \Illuminate\Http\Request $request)
{
    $days = (int) $request->days;

    if (!in_array($days, [1, 7, 30])) {
    abort(422);
}


    $user->restricted_until = Carbon::now()->addDays($days);
    $user->save();

    return back(303);

}
}
