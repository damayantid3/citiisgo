<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Services\ApiService;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function __construct(private ApiService $api) {}
 
    public function showForm()
    {
        if (session('api_token')) {
            return redirect()->route(session('user_role') === 'admin' ? 'admin.dashboard' : 'pengelola.dashboard');
        }
        return view('auth.login');
    }
 
    public function login(Request $request)
    {
        $request->validate(['email'=>'required|email','password'=>'required']);
 
        $res = $this->api->login($request->email, $request->password);
 
        if (!$res->successful() || !$res->json('success')) {
            return back()->withErrors(['email' => $res->json('message') ?? 'Login gagal.']);
        }
 
        $data = $res->json('data');
        $user = $data['user'];
        $role = $user['role'];
 
        if (!in_array($role, ['admin','pengelola'])) {
            return back()->withErrors(['email' => 'Akses ditolak. Panel web hanya untuk Admin dan Pengelola.']);
        }
 
        session([
            'api_token' => $data['token'],
            'user'      => $user,
            'user_role' => $role,
        ]);
 
        return redirect()->route($role === 'admin' ? 'admin.dashboard' : 'pengelola.dashboard');
    }
 
    public function logout(Request $request)
    {
        $this->api->logout();
        $request->session()->flush();
        return redirect()->route('login');
    }
}
 