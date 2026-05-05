<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockInDetail extends Model
{
    protected $table = 'stock_in_details';
    protected $primaryKey = 'stockin_details_ID';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['stockin_details_ID', 'stockin_ID', 'product_ID', 'quantity', 'cost_per_unit'];

    public function stockIn()  { return $this->belongsTo(StockIn::class,  'stockin_ID',  'stockin_ID'); }
    public function product()  { return $this->belongsTo(Product::class,  'product_ID',  'product_ID'); }
}
