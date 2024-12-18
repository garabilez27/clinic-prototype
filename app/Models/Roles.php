<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    protected $table = 'tbl_roles';
    protected $primaryKey = 'rl_id';
    public $timestamps = false;
    public $incrementing = false;
}
