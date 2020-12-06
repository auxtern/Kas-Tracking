<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Members extends Model
{
    protected $table = "members";
    protected $primaryKey = "member_id";
    protected $incrementing = false;
}
