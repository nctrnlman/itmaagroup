<?php

namespace App\Models\Facilities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Other extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'ga_other_facilities';

    protected $primaryKey = 'id_ga_other_facilities';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_ga_other_facilities',
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
