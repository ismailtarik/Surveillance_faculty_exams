<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Enseignant;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
   
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        // Convert email to lowercase
        $request->merge(['email' => strtolower($request->email)]);
    
        // Validate input fields
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
    
        // Determine role based on email
        if ($request->email === 'admin@gmail.com') {
            $role = 'admin';
        } else {
            // Check if the email belongs to an enseignant
            $enseignant = Enseignant::where('email', $request->email)->first();
            $role = $enseignant ? 'enseignant' : 'etudiant';
        }
    
        // Create the user with the appropriate role
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $role, // Assign the determined role
        ]);
    
        // Trigger the registered event
        event(new Registered($user));
    
        // Log in the user
        Auth::login($user);
    
        // Redirect to the dashboard
        return redirect(route('dashboard'));
    }
    
}
