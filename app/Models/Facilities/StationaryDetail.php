<?php

namespace App\Models\Facilities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StationaryDetail extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'stationary_request_detail';

    protected $primaryKey = 'id_request_detail';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_request_detail',
        'id_ga_stationary',
        'id_atk',
        'total_request',
        'total_approve',
        'feedback',
    ];
}
