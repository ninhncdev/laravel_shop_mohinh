<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::paginate(10);
        return view('admin.pages.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.pages.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        try {
            $data = $request->all();
            $data['password'] = Hash::make($data['password']);
            User::create($data);
            return redirect()->route('users.index')->with('success', 'Tạo user thành công!');
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return back()->with('error', 'Có lỗi xảy ra, vui lòng thử lại sau.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function edit(User $user)
    {
        return view('admin.pages.users.edit', compact('user'));
    }

    public function update(UpdateRequest $request, User $user)
    {
        try {
            $data = $request->all();
            $data['is_active'] = $request->boolean('is_active');
            $user->update($data);
            return redirect()->route('users.index')->with('success', 'Sửa thông tin người dùng thành công');
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
