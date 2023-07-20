<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticketing extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'ticketing'; // Nama tabel di database

    protected $primaryKey = 'id_tiket'; // Nama kolom primary key
    public $incrementing = false; // Primary key tidak dianggap auto-incrementing
    protected $keyType = 'string';

    protected $fillable = [
        'id_ticket',
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
