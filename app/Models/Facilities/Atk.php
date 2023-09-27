<?php

namespace App\Models\Facilities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Atk extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $table = 'atk';

    protected $primaryKey = 'id_atk';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_atk',
        'description',
    ];
}
