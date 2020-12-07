<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrganisasiUsers extends Model
{
    protected $table = 'organisasi_users';
    protected $primaryKey = null;
    public $incrementing = false;
    
    protected $fillable = [
        'user_id', 'organisasi_id', 'created_at',
    ];
}
