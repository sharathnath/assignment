<?php

# app/Models/Product.php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;


/**
 * @property int $id
 * @property string $name
 * @property string $logoUri
 * @property int $status
 * @property mixed $createdAt
 * @property mixed $updatedAt
 */

class Team extends Model
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'logo_uri',
        'status',
        'updated_date'
    ]; 


    /**
     * Get the players for the team.
     */
    public function players()
    {
        return $this->hasMany('App\Models\Players');
    }

}