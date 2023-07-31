<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GAFacilities extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'ga_facilities'; // Nama tabel di database

    protected $primaryKey = 'id_ga_facilities'; // Nama kolom primary key
    public $incrementing = false; // Primary key tidak dianggap auto-incrementing
    protected $keyType = 'string';

    protected $fillable = [
        'id_ga_facilities',
        'id_nik_request',
        'start_date',
        'end_date',
        'disc_keluhan',
        'status_tiket',
        'lampiran1',
        'lampiran2',
        'nik_pic',
        'kategori_tiket',
        'whatsapp',
        'action_note',
        'justification',
    ];
}
