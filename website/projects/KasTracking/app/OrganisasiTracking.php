<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrganisasiTracking extends Model
{
    protected $table = 'organisasi_tracking';
    protected $primaryKey = 'tracking_id';
    
    protected $fillable = [
        'tracking_id', 'member_id', 'user_id', 'organisasi_id', 'kategori', 'nominal', 'catatan', 'created_at',
    ];

}
