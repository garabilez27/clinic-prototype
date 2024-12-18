<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Values extends Model
{
    protected $table = 'tbl_values';
    protected $primaryKey = 'val_id';
    public $timestamps = false;
}
