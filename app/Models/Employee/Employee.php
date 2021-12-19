<?php

namespace App\Models\Employee;

use App\Models\Company\Company;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $guarded = [
        'first_name', 'last_name'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
