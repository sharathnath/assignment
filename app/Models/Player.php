<?php

# app/Models/Product.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


/**
 * @property int $id
 * @property int $teamId
 * @property string $firstName
 * @property string $lastName
 * @property string $imageUri
 * @property int $status
 * @property mixed $createdAt
 * @property mixed $updatedAt
 */

class Player extends Model
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'image_uri',
        'status',
        'created_date',
        'updated_date'
    ];


    public function team()
    {
        return $this->belongsTo('App\Models\Team');
    }


    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }


    public static function getPlayer($filter)
    {

        if (isset($filter['id'])) {
            $player = Player::find($filter['id']);
            $result['firstName'] = $player->first_name;
            $result['lastName'] = $player->last_name;
            $result['imageUri'] = $player->image_uri;
            $result['team'] = $player->team->name;
            return  $result;
        }

        if (isset($filter['name'])) {
            $player = Player::whereLike('first_name', $filter['name'])->orWhereLike('last_name', $filter['name'])->get();
            if (empty($player)) return false;
            foreach ($player as $row) {

                $result['full_name'] = $row->full_name;
                $result['lastName'] = $row->last_name;
                $result['imageUri'] = $row->image_uri;
                $result['team'] = $row->team->name;
                $resultset[] = $result;
            }
            return  $resultset;
        }
    }


    public function scopeWhereLike($query, $column, $value)
    {
        return $query->where($column, 'like', '%' . $value . '%');
    }

    public function scopeOrWhereLike($query, $column, $value)
    {
        return $query->orWhere($column, 'like', '%' . $value . '%');
    }
}
