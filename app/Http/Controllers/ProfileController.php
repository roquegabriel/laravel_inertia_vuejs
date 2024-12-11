<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    //
    public function edit(Request $request)
    {
        return inertia('Profile/Edit', [
            'user' => $request->user(),
            'status' => session('status'),
        ]);
    }

    public function updateInfo(Request $request): RedirectResponse
    {
        $fields = $request->validate([
            'name' => ['required', 'max:255'],
            'email' => ['required', 'lowercase', 'email', 'max:255'],
            Rule::unique(User::class)->ignore($request->user()->id)
        ]);

        $request->user()->fill($fields);

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return redirect()->route('profile.updateInfo');
    }

    public function updatePassword(Request $request)
    {
        $fields = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', 'min:3'],
        ]);
        
        $request->user()->update([
            'password' => Hash::make($fields['password'])
        ]);

        return redirect()->route('profile.edit');
    }
}
