<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'komentar'; // Nama tabel di database

    protected $primaryKey = 'id_komen_tiket'; // Nama kolom primary key
    public $incrementing = false; // Primary key tidak dianggap auto-incrementing
    protected $keyType = 'string';

    protected $fillable = [
        'id_komen_tiket',
        'id_tiket',
        'nik_komen',
        'datetime',
        'keterangan_komen',
    ];
}
