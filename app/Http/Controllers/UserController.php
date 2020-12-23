<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->get(); 
        
        return response()->json([
            'response_code' => '00',
            'response_message' => 'Berhasil menampilkan',
            'data' => UserResource::collection($users),
        ]);
    }

    public function store(Request $request)
    {
        $user = User::create([
            'id' => $request->id,
            'name' => $request->name,   
        ]);

        return response()->json([
            'response_code' => '00',
            'response_message' => 'Berhasil menambahkan user',
            'data' => new UserResource($user),
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $user->name = $request->name;
        $user->save();

        return response()->json([
            'response_code' => '00',
            'response_message' => 'Berhasil Update user',
            'data' => new UserResource($user),
        ]);
    }

    public function delete($id)
    {   
        User::destroy($id);

        return response()->json([
            'response_code' => '00',
            'response_message' => 'Berhasil Hapus',
        ]);
    }
}
