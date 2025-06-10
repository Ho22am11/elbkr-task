<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'product_id', 'quantity' , 'export_type'];
    public $timestamps = false;

    public function product()
    {
        return $this->belongsTo(product::class);
    }

}
