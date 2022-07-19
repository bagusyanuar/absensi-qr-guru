<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absen extends Model
{
    use HasFactory;

    protected $table = 'absen';

    protected $fillable = [
        'tanggal',
        'code'
    ];

    public function detail()
    {
        return $this->hasMany(AbsenDetail::class, 'absen_id')->orderBy('id', 'ASC');
    }
}
