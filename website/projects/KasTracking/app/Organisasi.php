<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Organisasi extends Model
{
    protected $table = 'organisasi';
    protected $primaryKey = 'organisasi_id';
    public $incrementing = true;

    protected $fillable = [
        'organisasi_id', 'nama', 'lokasi',
    ];
}
