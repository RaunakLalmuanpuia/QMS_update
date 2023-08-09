<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'filename',
        'status',
        'feedback',
        'employee_id',
        'file_path',
        'deleted_by_employee',
        'deleted_by_admin',
        'admin_id',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
