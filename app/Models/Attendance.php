<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'user_id',
        'nama',
        'tanggal',
        'jam_masuk',
        'jam_pulang',
        'foto_masuk',
        'foto_pulang',
        'status',
        'gps_status',
        'total_jam'
    ];
    public function user()
{
    return $this->belongsTo(User::class);
}
}
