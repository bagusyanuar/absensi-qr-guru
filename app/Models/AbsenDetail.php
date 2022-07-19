<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbsenDetail extends Model
{
    use HasFactory;

    protected $table = 'absen_detail';

    protected $fillable = [
        'absen_id',
        'user_id',
        'waktu',
        'tipe',
        'keterangan'
    ];

    public function absen()
    {
        return $this->belongsTo(Absen::class, 'absen_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
