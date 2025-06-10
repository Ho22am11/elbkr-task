<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'price',  'campany_id', 'category_id'
    ];

    public function attachements()
    {
        return $this->hasMany(ProductAttechment::class);
    }

    public function campany()
    {
        return $this->belongsTo(Campany::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
    public function rates()
    {
        return $this->hasMany(ProductRate::class);
    }
    
}
