<?php

namespace App\Models\Tasks;

use App\Models\Projects\Project;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'task'; // Nama tabel di database

    protected $primaryKey = 'id_task'; // Nama kolom primary key
    public $incrementing = false; // Primary key tidak dianggap auto-incrementing
    protected $keyType = 'string';

    protected $fillable = [
        'id_task',
        'id_project',
        'title',
        'idnik',
        'description',
        'status',
        'create_date',
        'due_date',
        'file',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class, 'id_project');
    }
}
