<?php

namespace App\Models\Projects;

use App\Models\User;
use App\Models\Tasks\Task;
use App\Models\Projects\ProjectMember;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'project'; // Nama tabel di database

    protected $primaryKey = 'id_project'; // Nama kolom primary key
    public $incrementing = false; // Primary key tidak dianggap auto-incrementing
    protected $keyType = 'string';

    protected $fillable = [
        'id_project',
        'title',
        'description',
        'status',
        'categories',
        'create_date',
        'due_date',
        'file',
        'idnik'
    ];


    public function projectMembers()
    {
        return $this->hasMany(ProjectMember::class, 'id_project', 'id_project');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'id_project');
    }
}
