<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\Constant;
use App\Models\Team;
use Illuminate\Http\Request;
use Validator;


class TeamController extends Controller
{

    public function showAllTeams()
    {
        return ApiResponse::ok(1, Team::all());
    }

    public function showOneTeam($id)
    {
        return ApiResponse::ok(1, Team::find($id));
    }

    public function store(Request $request)
    {
        $rules = array(
            'name' => 'required|unique:teams',
            'logoUri' => 'required|url',
            'id' => 'nullable'
        );

        if (!empty($request->input('id'))) {
            $rules['status'] = 'required|numeric';
            unset($rules['name']);
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return ApiResponse::unprocessableEntity(1, $validator->errors()->first());
        }

        if (!empty($request->input('id'))) {
            $team = Team::where('id', $request->input('id'))->first();
            if (empty($team))
                return ApiResponse::unprocessableEntity(2, "Team details not found");
        }

        if (!empty($team)) {

            $message = 'Team Updated Successfully.';

            $team->logo_uri = $request->input('logoUri');
            $team->status = $request->input('status');
            $team->updated_at = date(Constant::DATETIME_FORMAT_MYSQL);
        } else {

            $message = 'Team Created Successfully.';

            $team = new Team();
            $team->name = $request->input('name');
            $team->logo_uri = $request->input('logoUri');
            $team->created_at = date(Constant::DATETIME_FORMAT_MYSQL);
            $team->status = Team::STATUS_ACTIVE;
        }

        if ($team->save()) {
            return ApiResponse::ok(1, null, $message);
        } else {
            return ApiResponse::unprocessableEntity(3, "Internal Server Error");
        }
    }


    public function delete($id)
    {
        Team::findOrFail($id)->delete();
        return ApiResponse::ok(1, null, 'Deleted Successfully');
    }
}
