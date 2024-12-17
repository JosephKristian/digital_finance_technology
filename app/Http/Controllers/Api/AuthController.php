<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Umkm;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;

class AuthController extends Controller
{
    public function index()
    {
        return response()->json(['message' => 'List of resources'], 200);
    }

    public function store(Request $request)
    {
        // Validasi data input
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'data' => null,
                'message' => 'Data tidak valid',
                'errorCode' => 422,
                'errors' => $validator->errors()
            ], 422);
        }

        // Membuat user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Trigger event pendaftaran
        event(new Registered($user));

        // Membuat UMKM default untuk user
        $umkm = Umkm::create([
            'id' => (string) \Illuminate\Support\Str::uuid(),
            'user_id' => $user->id,
            'name' => '', // Nilai default
            'address' => '', // Nilai default
            'phone' => '', // Nilai default
            'tax_id' => '', // Nilai default
            'business_type' => '', // Nilai default
            'pdf_path' => '', // Nilai default
            'approve' => false, // Nilai default
        ]);

        // Respons sukses
        return response()->json([
            'status' => 'success',
            'data' => [
                'user' => $user,
                'umkm' => [
                    'id' => $umkm->id,
                    'approve' => $umkm->approve,
                ],
            ],
            'message' => 'User berhasil didaftarkan'
        ], 201);
    }

    public function login(Request $request)
    {
        // Validasi data input
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'data' => null,
                'message' => 'Data tidak valid',
                'errorCode' => 422,
                'errors' => $validator->errors()
            ], 422);
        }

        // Cek apakah email terdaftar
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'data' => null,
                'message' => 'Email tidak terdaftar',
                'errorCode' => 404
            ], 404);
        }

        // Cek password
        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 'error',
                'data' => null,
                'message' => 'Password salah',
                'errorCode' => 401
            ], 401);
        }

        // Login user
        Auth::login($user);

        // Generate token Sanctum
        $token = $user->createToken('YourAppName')->plainTextToken;

        $umkm = Umkm::where('user_id', $user->id)->first();

        return response()->json([
            'status' => 'success',
            'data' => [
                'user' => $user,
                'umkm' => [
                    'approve' => $umkm->approve ?? false,
                ],
                'token' => $token  // Menambahkan token di sini
            ],
            'message' => 'Login berhasil'
        ], 200);
    }



    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'data' => null,
                'message' => 'Email tidak valid',
                'errorCode' => 422,
                'errors' => $validator->errors()
            ], 422);
        }

        $status = Password::sendResetLink($request->only('email'));

        if ($status === Password::RESET_LINK_SENT) {
            return response()->json([
                'status' => 'success',
                'data' => null,
                'message' => 'Link reset password telah dikirim ke email Anda'
            ], 200);
        }

        return response()->json([
            'status' => 'error',
            'data' => null,
            'message' => 'Gagal mengirim link reset password',
            'errorCode' => 500
        ], 500);
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'data' => null,
                'message' => 'Data tidak valid',
                'errorCode' => 422,
                'errors' => $validator->errors()
            ], 422);
        }

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return response()->json([
                'status' => 'success',
                'data' => null,
                'message' => 'Password berhasil direset'
            ], 200);
        }

        return response()->json([
            'status' => 'error',
            'data' => null,
            'message' => 'Gagal mereset password',
            'errorCode' => 500
        ], 500);
    }

    public function profile(){
        $user = auth()->user();
        return response()->json([
            'status'=> true,
            'message'=> 'Profile',
            'data'=> $user,
            'id'=> auth()->user()->id,
        ],200);
    }

    public function logout(Request $request)
    {
        // Mengambil token yang digunakan oleh pengguna yang sedang login
        $user = auth()->user();
        $user->tokens()->delete();
        return response()->json([
            'status' => 'success',
            'data' => null,
            'message' => 'Logout berhasil'
        ], 200);
    }
}
