<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class GroupController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Log::info("group creation request from ip".$request->ip());
        $validate = Validator::make($request->all(), [
            'name' => 'required|max:50',
            'description' => 'required|max:200',
        ]);

        if ($validate->fails()) {
            $data = new \stdClass;
            $data->status = 'error';
            $data->message = 'the group could not be created';
            $data->errors = $validate->errors();
            Log::error("group creation request failed for ".$validate->errors().$request->ip());
            return response(json_encode($data), 400)->header('Content-Type', 'application/json');
        } else {
            $group = new Group();
            $group->name = $request->name;
            $group->description = $request->description;
            $group->save();

            $data = new \stdClass;
            $data->code = '201';
            $data->status = 'sucess';
            $data->message = 'the group was created successfully';
            Log::notice("group creation request successfully from".$request->ip());
            return response(json_encode($data), 200)->header('Content-Type', 'application/json');
        }


        $data = new \stdClass();
        $data->code = 400;
        $data->status = 'error';
        $data->message = 'the parameters are wrong';
        $data->errors = $validate->errors();
        Log::error("group creation request failed for ".$validate->errors().$request->ip());
        return response(json_encode($data), 400)->header('Content-Type', 'application/json');
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Group $group)
    {
        Log::info("group modification request from ip".$request->ip());
        $validate = Validator::make($request->all(), [
            'name' => 'required|max:50',
            'description' => 'required|max:200',
        ]);
        if ($validate->fails()) {
            $data = new \stdClass;
            $data->status = 'error';
            $data->message = 'the group could not be modified';
            $data->errors = $validate->errors();
            Log::error("group modification request failed for ".$validate->errors().$request->ip());
            return response(json_encode($data), 400)->header('Content-Type', 'application/json');
        } else {

            if ($group->name != $request->name) {
                $group->name = $request->name;
            }

            if ($group->description != $request->description) {
                $group->description = $request->description;
            }
            $group->save();

        $data = new \stdClass();
        $data->code = 200;
        $data->status = 'success';
        $data->message = 'the group was successfully modified';
        Log::notice("group modification request successfully from".$request->ip());
        return response(json_encode($data), 200)->header('Content-Type', 'application/json');
        }
        $data = new \stdClass();
        $data->code = 400;
        $data->status = 'error';
        $data->message = 'the parameters are wrong';
        $data->errors = $validate->errors();
        Log::error("group modification request failed for ".$validate->errors().$request->ip());
        return response(json_encode($data), 400)->header('Content-Type', 'application/json');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Group $group)
    {
        $group->delete();

        $data = new \stdClass();
        $data->code = 200;
        $data->status = 'sucess';
        $data->message = 'the group was successfully delete';
        Log::notice("group destroy request successfully ");
        return response(json_encode($data), 200)->header('Content-Type', 'application/json');
    }
}
