<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrganisasiMembers extends Model
{
    protected $table = 'organisasi_members';
    protected $primaryKey = 'member_id';
    public $incrementing = false;
    
    protected $fillable = [
        'member_id', 'user_id', 'organisasi_id', 'nama', 'jenis_kelamin', 'tipe_pembayaran', 'keys', 'whatsapp', 'email', 'created_at',
    ];

}
