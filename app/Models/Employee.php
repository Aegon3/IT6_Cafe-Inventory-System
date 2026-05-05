<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $primaryKey = 'employee_ID';
    public $incrementing = true;
    protected $keyType = 'int';
    protected $fillable = ['employee_Fname', 'employee_Lname', 'e_role', 'contact_number', 'employee_address', 'sss_number', 'philhealth_number'];

    public function stockIns()  { return $this->hasMany(StockIn::class,  'employee_ID', 'employee_ID'); }
    public function stockOuts() { return $this->hasMany(StockOut::class, 'employee_ID', 'employee_ID'); }

    public function getFullNameAttribute(): string
    {
        return $this->employee_Fname . ' ' . $this->employee_Lname;
    }
}