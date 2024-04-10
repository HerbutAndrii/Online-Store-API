<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'price', 'rate', 'company_id', 'category_id'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function company() {
        return $this->belongsTo(Company::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function ratings() {
        return $this->hasMany(Rating::class);
    }

    public function usersWhoHaveProductInCart() {
        return $this->belongsToMany(User::class, 'cart');
    } 

    public function reviews() {
        return $this->hasMany(Review::class);
    }
}
