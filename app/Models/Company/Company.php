<?php

namespace App\Models\Company;

use App\Models\Employee\Employee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function employee()
    {
        return $this->hasMany(Employee::class);
    }
}
