<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Umkm;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Str;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        // Membuat user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);


        $newUser = User::where('email', $user->email)->where('password', $user->password)
            ->first();
        
        event(new Registered($newUser));


        $userId = $newUser->getAttribute('id'); // Mengambil atribut 'id'
         // Menampilkan ID untuk debugging



        Umkm::create([
            'id' => (string) \Illuminate\Support\Str::uuid(),
            'user_id' => $userId,
            'name' => '', // Nilai default
            'address' => '', // Nilai default
            'phone' => '', // Nilai default
            'tax_id' => '', // Nilai default
            'business_type' => '', // Nilai default
            'pdf_path' => '', // Nilai default
            'approve' => false, // Nilai default
        ]);
        



        return redirect(route('login', absolute: false));
    }
}
