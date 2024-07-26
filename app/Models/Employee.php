<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'contact_number', 'email', 'date_of_birth', 'address', 'employee_register_number'
    ];

    // Define the attributes that should be hidden for arrays
    protected $hidden = [];

    // Define the attributes that should be cast to native types
    protected $casts = [
        'date_of_birth' => 'date',
    ];
    
}
