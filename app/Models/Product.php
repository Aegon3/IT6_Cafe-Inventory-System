<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $primaryKey = 'product_ID';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['product_ID', 'product_name', 'p_unit', 'unit_price'];

    public function stock()           { return $this->hasOne(Stock::class,           'product_ID', 'product_ID'); }
    public function stockRecord()     { return $this->hasOne(Stock::class,           'product_ID', 'product_ID'); }
    public function stockInDetails()  { return $this->hasMany(StockInDetail::class,  'product_ID', 'product_ID'); }
    public function stockOutDetails() { return $this->hasMany(StockOutDetail::class, 'product_ID', 'product_ID'); }
}
