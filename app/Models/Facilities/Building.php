<?php

namespace App\Models\Facilities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'ga_building';

    protected $primaryKey = 'id_ga_building';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_ga_building',
        'nik_request',
        'nik_pic',
        'whatsapp',
        'file',
        'description',
        'category',
        'status',
        'justification',
        'action_note',
        'start_date',
        'end_date',
    ];
}
