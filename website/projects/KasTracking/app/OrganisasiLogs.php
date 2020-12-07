<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrganisasiLogs extends Model
{
    protected $table = 'organisasi_logs';
    protected $primaryKey = 'logs_id';
    
    protected $fillable = [
        'user_id', 'organisasi_id', 'pesan', 'created_at',
    ];
}
