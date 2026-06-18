<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

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

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}