<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{

    use HasFactory;
    protected $fillable = [
        'employee_id',
        'salary_amount',
        'salary_date',
        'salary_month',
        'salary_year',
    ];

    public function employee(){
        return $this->belongsTo(Employee::class);
    }

}
