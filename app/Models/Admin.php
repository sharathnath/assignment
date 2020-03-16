<?php

# app/Models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $name
 * @property mixed $email
 * @property string $password
 * @property mixed $createdOn
 * @property mixed $updatedOn
 */

class Admin extends Model {

    public $timestamps = false;

    protected $fillable = ['name', 'username', 'password', 'createdOn', 'udpatedOn'];
}