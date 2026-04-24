<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockIn extends Model
{
    protected $table = 'stock_ins';
    protected $primaryKey = 'stockin_ID';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['stockin_ID','date_added','employee_ID'];

    public function employee() { return $this->belongsTo(Employee::class, 'employee_ID', 'employee_ID'); }
    public function details() { return $this->hasMany(StockInDetail::class, 'stockin_ID', 'stockin_ID'); }
}
