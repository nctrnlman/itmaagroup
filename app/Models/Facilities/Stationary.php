<?php

namespace App\Models\Facilities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stationary extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'ga_stationary';

    protected $primaryKey = 'id_ga_stationary';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_ga_stationary',
        'nik_request',
        'nik_pic',
        'whatsapp',
        'category',
        'status',
        'start_date',
        'end_date',
    ];
}
