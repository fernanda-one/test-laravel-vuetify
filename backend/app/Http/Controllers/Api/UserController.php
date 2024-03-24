<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\UserUpdateRegisterRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

use function PHPUnit\Framework\isEmpty;

class UserController extends Controller
{
    public function register(UserRegisterRequest $request)
    {
        $data = $request->validated();
        $user = User::where('email',$data['email'])->first();
        if($user){
            return response([
                'status'=>false,
                'message'=>'email has been used!',
                'data'=>null
            ],400);
        }
        $user = new User($data);
        $user->role_id = $data['role_id'];
        $user->password = Hash::make($data['password']);
        $user->save();

        return (new UserResource($user))->response()->setStatusCode(201);
    }
    public function update(UserUpdateRequest $request, $id)
    {
        $data = $request->validated();
        $user = User::where('id',$id)->first();
        if(!$user){
            return response([
                'status'=>false,
                'message'=>'user not found!',
                'data'=>null
            ],400);
        }
        $user->update($data);
        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }        
        $user->save();

        return (new UserResource($user))->response()->setStatusCode(201);
    }

    public function getById($id){
        $user = User::where('id',$id)->first();
        if (!$user) {
            return response([
                'status'=>false,
                'message'=>'user not found!',
                'data'=>null
            ],404);
        }
        return response([
            'status'=>false,
            'message'=>'success',
            'data'=>(new UserResource($user))
        ],200);
    }
    public function getAll(){
        $data = User::query();
        $page =$request['page']??1;
        $limit =$request['limit']??10;
        if(!empty($request['search'])){
            $search = "%" . $request['search'] . "%";
            $data->where('name', 'like', $search);
        }
        $data->where('role_id',  2);
        $data->orderBy('created_at', 'DESC');
        $users = $data->paginate();

        return response([
            'status'=>false,
            'message'=>'success',
            'data'=>$users
        ],200);
    }

    public function delete($id){
        $user = User::where($id);
        if (!$user) {
            return response([
                'status'=>false,
                'message'=>'user not found!',
                'data'=>null
            ],404);
        }
        $user->delete();
        return response([
            'status'=>false,
            'message'=>'delete successfully',
            'data'=>null
        ],200);
    }
}
