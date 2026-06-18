<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    protected $fillable = [
        'user_id',
        'jenis_izin',
        'tgl_mulai',
        'tgl_selesai',
        'alasan',
        'lampiran',
        'status'
    ];
}