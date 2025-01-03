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
use Illuminate\Support\Str; 

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
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
    ]);

    // Jika validasi gagal
    if ($validator->fails()) {
        $messages = collect($validator->errors()->toArray())
            ->mapWithKeys(function ($errors, $field) {
                return [$field => implode(' ', $errors)];
            });

        return response()->json([
            'status' => 'error',
            'code' => 422,
            'data' => null,
            'message' => 'Validasi gagal',
            'errors' => $messages,
        ], 422);
    }

    // Membuat user baru
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

    $newUser = User::where('email', $user->email)->where('password', $user->password)
        ->first();

    // Trigger event pendaftaran dan kirim email verifikasi
    event(new Registered($newUser));
    $newUser->sendEmailVerificationNotification();

    // Membuat UMKM default untuk user
    $umkm = Umkm::create([
        'id' => (string) Str::uuid(),
        'user_id' => $newUser->id,
        'name' => '',
        'address' => '',
        'phone' => '',
        'tax_id' => '',
        'business_type' => '',
        'pdf_path' => '',
        'approve' => false,
    ]);

    $token = $newUser->createToken('digital_financial_technology')->plainTextToken;

    // Respons sukses
    return response()->json([
        'status' => 'success',
        'code' => 201,
        'data' => [
            'user' => [
                'id' => $newUser->id,
                'name' => $newUser->name,
                'email' => $newUser->email,
            ],
            'umkm' => [
                'id' => $umkm->id,
                'approve' => $umkm->approve,
            ],
        ],
        'message' => 'User berhasil didaftarkan. Silakan verifikasi email Anda.',
    ], 201)->header('Authorization', "Bearer $token");
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
            'code' => 422,
            'data' => null,
            'message' => 'Data tidak valid',
            'errors' => $validator->errors(),
        ], 422);
    }

    // Cek apakah email terdaftar
    $user = User::where('email', $request->email)->first();
    if (!$user) {
        return response()->json([
            'status' => 'error',
            'code' => 404,
            'data' => null,
            'message' => 'Email tidak terdaftar',
        ], 404);
    }

    // Cek password
    if (!Hash::check($request->password, $user->password)) {
        return response()->json([
            'status' => 'error',
            'code' => 401,
            'data' => null,
            'message' => 'Password salah',
        ], 401);
    }

    // Login user
    Auth::login($user);

    // Generate token Sanctum
    $token = $user->createToken('digital_financial_technology')->plainTextToken;

    $umkm = Umkm::where('user_id', $user->id)->first();

    return response()->json([
        'status' => 'success',
        'code' => 200,
        'data' => [
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
            'umkm' => [
                'id' => $umkm->id,
                'approve' => $umkm->approve,
            ],
        ],
        'message' => 'User berhasil login !!',
    ], 200)->header('Authorization', "Bearer $token");
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

    public function profile()
    {
        $user = auth()->user();
        return response()->json([
            'status' => true,
            'message' => 'Profile',
            'data' => $user,
            'id' => auth()->user()->id,
        ], 200);
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
