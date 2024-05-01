<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    /**
     * Create a new AuthController constructor.
     * checkk if the user is authenticated
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /** 
     * Register function to register a user
     * 
     * @param RegisterRequest $request
     * 
     * @return \Illuminate\Http\JsonResponse
     */

    public function register(RegisterRequest $request)
    {
        try {
            // create a new user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'gender' => $request->gender,
                'role' => $request->role,
                'birthdate' =>  date('Y-m-d', strtotime($request->birthdate)),
                'password' => bcrypt($request->password)
            ]);

            // login the user
            Auth::login($user);
            // generate a token for the user
            $token = JWTAuth::fromUser($user);

            return $this->auth_response(Response::HTTP_CREATED, $user->only(['name', 'email', 'phone', 'gender', 'birthdate', 'role']), $token, 'User berhasil terdaftar!');
        } catch (\Exception $e) {
            return $this->auth_response(Response::HTTP_INTERNAL_SERVER_ERROR, ['error' => $e->getMessage()]);
        }
    }

    /**
     * Login function to login a user
     * 
     * @param LoginRequest $request
     * 
     * @return \Illuminate\Http\JsonResponse
     */

    public function login(LoginRequest $request)
    {
        try {
            // check if the user exists
            if (!$token = JWTAuth::attempt($request->only('email', 'password'))) {
                return $this->auth_response(Response::HTTP_UNAUTHORIZED);
            }

            return $this->auth_response(Response::HTTP_OK, null, $token);
        } catch (\Exception $e) {
            return $this->auth_response(Response::HTTP_INTERNAL_SERVER_ERROR, [$e->getMessage()]);
        }
    }

    /**
     * Logout function to logout a user
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        try {
            Auth::logout();
            return response()->json([
                'success' => true,
                'message' => 'User berhasil logout!'
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'User gagal logout!',
                'errors' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /** 
     * Create Response for Auth
     * 
     * @param int $status_code
     * @param array|null $data
     * @param string $token
     * @param string $message
     * 
     */

    private function auth_response(
        int $status_code,
        array $data = null,
        string $token = null,
        string $message = 'User berhasil login!'
    ) {

        if ($status_code === Response::HTTP_OK || $status_code === Response::HTTP_CREATED) {
            $data = [
                'success' => true,
                'token' => $token,
                'message' => $message,
                'data' => [
                    'name' => Auth::user()->name,
                    'email' => Auth::user()->email,
                    'phone' => Auth::user()->phone,
                    'gender' => Auth::user()->gender,
                    'birthdate' => Auth::user()->birthdate,
                    'role' => Auth::user()->role,
                ]
            ];
        }

        if ($status_code === Response::HTTP_UNAUTHORIZED) {
            $data = [
                'success' => false,
                'message' => 'User gagal login!',
                'errors' => 'Email atau password salah!'
            ];
        }

        if ($status_code === Response::HTTP_INTERNAL_SERVER_ERROR) {
            $data = [
                'success' => false,
                'message' => 'Terjadi kesalahan pada server!',
                'errors' => $data
            ];
        }

        return response()->json($data, $status_code);
    }
}
