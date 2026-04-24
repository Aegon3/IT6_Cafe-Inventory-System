<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $primaryKey = 'stock_ID';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['stock_ID', 'product_ID', 'quantity', 'min_stock'];

    public function product() { return $this->belongsTo(Product::class, 'product_ID', 'product_ID'); }
}