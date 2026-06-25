<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    //
    use HasFactory;
    protected $fillable = [
        
        'name',
        'code',
        'head_name',
        'email',
        'phone',
        'description'
    ];

    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    public function officers()
{
    return $this->hasMany(User::class)
                ->whereIn('role', [
                    'officer',
                    'admin',
                    'department_head'
                ]);
}

public function users()
{
    return $this->hasMany(User::class);
}
    
}
