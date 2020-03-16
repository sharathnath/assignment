<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\Constant;
use App\Models\Player;
use App\Models\Team;
use Illuminate\Http\Request;
use Validator;


class PlayerController extends Controller
{

    public function showOnePlayer(Request $request)
    {

        if ($request->has('id')) {

            $filter = array("id" => $request->input('id'));
        }

        if ($request->has('name')) {

            $filter = array("name" => $request->input('name'));
        }

        if (empty($filter))
            return ApiResponse::unprocessableEntity(2, "Invalid Input");



        $result = Player::getPlayer($filter);


        if (empty($result))
            return ApiResponse::unprocessableEntity(2, "Player details not found");



        return ApiResponse::ok(1, $result);
    }

    public function showPlayerbyteam(Request $request)
    {

        if ($request->has('id')) {

            $filter = array("id" => $request->input('id'));
        }

        if ($request->has('name')) {

            $filter = array("name" => $request->input('name'));
        }

        if (empty($filter))
            return ApiResponse::unprocessableEntity(2, "Invalid Input");


        $team = Team::where($filter)->first();
        if (empty($team))
            return ApiResponse::unprocessableEntity(2, "Team details not found");
        return ApiResponse::ok(1, Player::where('team_id', $team->id)->get());
    }

    public function store(Request $request)
    {
        $rules = array(
            'firstName' => 'required',
            'lastName' => 'required',
            'imageUri' => 'required|url',
            'teamId' => 'required|exists:teams,id',
            'id' => 'nullable'
        );

        if (!empty($request->input('id'))) {
            $rules['status'] = 'required|numeric';
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return ApiResponse::unprocessableEntity(1, $validator->errors()->first());
        }

        if (!empty($request->input('id'))) {
            $player = Player::where('id', $request->input('id'))->first();
            if (empty($player))
                return ApiResponse::unprocessableEntity(2, "Team details not found");
        }

        if (!empty($player)) {

            $message = 'Player Updated Successfully.';

            $player->first_name = $request->input('firstName');
            $player->last_name = $request->input('lastName');
            $player->image_uri = $request->input('imageUri');
            $player->status = $request->input('status');
            $player->updated_at = date(Constant::DATETIME_FORMAT_MYSQL);
        } else {

            $message = 'Player Created Successfully.';

            $player = new Player();
            $player->first_name = $request->input('firstName');
            $player->last_name = $request->input('lastName');
            $player->image_uri = $request->input('imageUri');
            $player->team_id = $request->input('teamId');
            $player->created_at = date(Constant::DATETIME_FORMAT_MYSQL);
            $player->status = Player::STATUS_ACTIVE;
        }

        if ($player->save()) {
            return ApiResponse::ok(1, null, $message);
        } else {
            return ApiResponse::unprocessableEntity(3, "Internal Server Error");
        }
    }


    public function delete($id)
    {
        Player::findOrFail($id)->delete();
        return ApiResponse::ok(1, null, 'Deleted Successfully');
    }
}
