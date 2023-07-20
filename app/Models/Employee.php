<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends Model
{
    use HasFactory;

    protected $table = 'user';
    protected $primaryKey = 'idnik';
    protected $fillable = ['idnik', 'nama', 'divisi', 'position', 'lokasi', 'divisi', 'departement', 'section', 'position', 'clasifikasi', 'atasan', 'roaster', 'doh', 'status', 'file_foto'];
    public $timestamps = false;

    public function user()
    {
        return $this->hasOne(User::class);
    }
}
