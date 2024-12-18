<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patients extends Model
{
    protected $table = 'tbl_patients';
    protected $primaryKey = 'ptt_id';
    public $timestamps = false;
    public $incrementing = false;
}
