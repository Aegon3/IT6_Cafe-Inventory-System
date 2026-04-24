<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockOut extends Model
{
    protected $table = 'stock_outs';
    protected $primaryKey = 'stockout_ID';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['stockout_ID','date_issuance','employee_ID'];

    public function employee() { return $this->belongsTo(Employee::class, 'employee_ID', 'employee_ID'); }
    public function details() { return $this->hasMany(StockOutDetail::class, 'stockout_ID', 'stockout_ID'); }
}
