<?php

namespace App\Models\Company;

use App\Models\Employee\Employee;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $guarded = [
        'name',
    ];

    public function employee()
    {
        return $this->hasMany(Employee::class);
    }
}
