<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleMenus extends Model
{
    protected $table = 'tbl_role_menus';
    protected $primaryKey = 'rlmn_id';
    public $timestamps = false;
}
