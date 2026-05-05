<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockOutDetail extends Model
{
    protected $table = 'stock_out_details';
    protected $primaryKey = 'stockout_details_ID';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['stockout_details_ID', 'stockout_ID', 'product_ID', 'quantity'];

    public function stockOut() { return $this->belongsTo(StockOut::class, 'stockout_ID', 'stockout_ID'); }
    public function product()  { return $this->belongsTo(Product::class,  'product_ID',  'product_ID'); }
}
