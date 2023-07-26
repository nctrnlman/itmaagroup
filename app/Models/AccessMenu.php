<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccessMenu extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'access_menu'; // Nama tabel di database

    protected $primaryKey = 'id_access'; // Nama kolom primary key
    public $incrementing = false; // Primary key tidak dianggap auto-incrementing
    protected $keyType = 'string';

    protected $fillable = [
        'id_access',
        'idnik',
        'access_type',
    ];
}
