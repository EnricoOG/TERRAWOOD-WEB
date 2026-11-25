<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ManualSale extends Model
{
    protected $fillable = ['sale_reference','product_name','quantity','unit_price','total','sold_at','channel','notes','created_by'];
    protected function casts(): array { return ['sold_at'=>'date','quantity'=>'integer','unit_price'=>'decimal:2','total'=>'decimal:2']; }
}
