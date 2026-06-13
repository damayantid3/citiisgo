<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Services\ApiService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(private ApiService $api) {}
 
    public function index(Request $request)
    {
        $res   = $this->api->getUsers($request->only(['search','role','status','page']));
        $users = $res->json('data');
        return view('admin.users.index', compact('users'));
    }
 
    public function store(Request $request)
    {
        $this->api->createUser($request->all());
        return redirect()->route('admin.users')->with('success', 'User berhasil ditambahkan.');
    }
 
    public function update(Request $request, $id)
    {
        $this->api->updateUser($id, $request->all());
        return redirect()->route('admin.users')->with('success', 'User diperbarui.');
    }
 
    public function destroy($id)
    {
        $this->api->deleteUser($id);
        return redirect()->route('admin.users')->with('success', 'User dihapus.');
    }
 
    public function changeRole(Request $request, $id)
    {
        $this->api->changeUserRole($id, $request->role);
        return redirect()->route('admin.users')->with('success', 'Role diperbarui.');
    }
}
 