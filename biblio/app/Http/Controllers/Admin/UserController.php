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

    public function restrict(User $user, Request $request)
{
    $validated = $request->validate([
        'days' => 'required|integer|in:1,3,7,30',
        'reason' => 'nullable|string|max:1000',
    ]);

    $user->restricted_until = now()->addDays($validated['days']);
    $user->restriction_reason = $validated['reason'];
    $user->save();

    return back(303);
}

public function removeRestriction(User $user)
{
    $user->restricted_until = null;
    $user->restriction_reason = null;
    $user->save();

    return back(303);
}

}
