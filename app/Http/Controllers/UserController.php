<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Log::info("user creation request from ip".$request->ip());
        $validate = Validator::make($request->all(), [
            'username' => 'required|max:15|unique:Users,username',
            'name' => 'required|max:50',
            'lastname' => 'required|max:50',
            'email' => 'required|max:50|unique:Users,email',
        ]);


        if ($validate->fails()) {
            $data = new \stdClass;
            $data->status = 'error';
            $data->message = 'the user could not be created';
            $data->errors = $validate->errors();
            Log::error("user creation request failed for ".$validate->errors().$request->ip());
            return response(json_encode($data), 400)->header('Content-Type', 'application/json');
        } else {
            $user = new User();
            $user->username = $request->username;
            $user->name = $request->name;
            $user->lastname = $request->lastname;
            $user->email = $request->email;
            $user->save();

            $data = new \stdClass;
            $data->code = '201';
            $data->status = 'sucess';
            $data->message = 'the user was created successfully';
            Log::notice("user creation request successfully from".$request->ip());
            return response(json_encode($data), 201)->header('Content-Type', 'application/json');
        }

        $data = new \stdClass();
        $data->code = 400;
        $data->status = 'error';
        $data->message = 'the parameters are wrong';
        $data->errors = $validate->errors();
        Log::error("user creation request failed for ".$validate->errors().$request->ip());
        return response(json_encode($data), 400)->header('Content-Type', 'application/json');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        Log::info("user modification request from ip".$request->ip());
        $validate = Validator::make($request->all(), [
            'username' => 'required|max:15|unique:Users,username',
            'name' => 'required|max:50',
            'lastname' => 'required|max:50',
            'email' => 'required|max:50|unique:Users,email',
        ]);
        if ($validate->fails()) {
            $data = new \stdClass;
            $data->status = 'error';
            $data->message = 'the user could not be modified';
            $data->errors = $validate->errors();
            Log::error("user modification request failed for ".$validate->errors().$request->ip());
            return response(json_encode($data), 400)->header('Content-Type', 'application/json');
        } else {

            if ($user->username != $request->username) {
                $user->username = $request->username;
            }
            if ($user->name != $request->name) {
                $user->name = $request->name;
            }
            if ($user->lastname != $request->lastname) {
                $user->lastname = $request->lastname;
            }
            if ($user->email != $request->email) {
                $user->email = $request->email;
            }

            $user->save();

            $data = new \stdClass();
            $data->code = 200;
            $data->status = 'success';
            $data->message = 'the user was successfully modified';
            Log::notice("user modification request successfully from".$request->ip());
            return response(json_encode($data), 200)->header('Content-Type', 'application/json');
        }


        $data = new \stdClass();
        $data->code = 400;
        $data->status = 'error';
        $data->message = 'the parameters are wrong';
        $data->errors = $validate->errors();
        Log::error("user modification request failed for ".$validate->errors().$request->ip());
        return response(json_encode($data), 400)->header('Content-Type', 'application/json');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        $data = new \stdClass();
        $data->code = 200;
        $data->status = 'sucess';
        $data->message = 'the user was successfully delete';
        Log::notice("user destroy request successfully ");
        return response(json_encode($data), 200)->header('Content-Type', 'application/json');
    }

    public function asignate(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'user_id' => 'required|max:8|exists:Users,id',
            'group_id' => 'required|max:8|exists:Groups,id',
        ]);
        if ($validate->fails()) {
            $data = new \stdClass();
            $data->code = 400;
            $data->status = 'error';
            $data->message = 'the user could not be asignated to a group';
            $data->errors = $validate->errors();
            Log::error("user asignation to a group request failed for ".$validate->errors().$request->ip());
            return response(json_encode($data), 400)->header('Content-Type', 'application/json');
        } else {
            $user = User::find($request->user_id);
            $group = Group::find($request->group_id);
            $group->users()->attach($user->id);
            $data = new \stdClass();
            $data->code = 200;
            $data->status = 'sucess';
            $data->message = 'the user was successfully asignated to a group';
            Log::notice("user asignation to a group request successfully from".$request->ip());
            return response(json_encode($data), 200)->header('Content-Type', 'application/json');
        }
    }
}
