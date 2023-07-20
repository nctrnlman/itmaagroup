<?php

namespace App\Models\Projects;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectMember extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'project_member'; // Nama tabel di database

    protected $primaryKey = 'id_project_member'; // Nama kolom primary key
    public $incrementing = false; // Primary key tidak dianggap auto-incrementing
    protected $keyType = 'string';

    protected $fillable = [
        'id_project_member',
        'id_project',
        'idnik',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class, 'id_project', 'id_project');
    }
}
