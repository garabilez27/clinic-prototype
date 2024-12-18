<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menus extends Model
{
    protected $table = 'tbl_menus';
    protected $primaryKey = 'mn_id';
    public $timestamps = false;
    public $incrementing = false;

    public function subMenus()
    {
        return $this->hasMany(SubMenus::class, 'mn_id');
    }
}
