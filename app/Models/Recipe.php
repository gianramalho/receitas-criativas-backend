<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'author_id',
    ];

    public function tags()
    {
        return $this->belongsToMany(Recipe::class, 'recipes_has_tags', 'recipes_id', 'tags_id')
            ->withTimestamps();
    }

    public function reviews()
    {
        return $this->belongsToMany(Device::class, 'review_recipes', 'recipes_id', 'devices_id')
            ->withTimestamps();
    }

    public function favorites()
    {
        return $this->belongsToMany(Device::class, 'favorite_recipes', 'recipes_id', 'devices_id')
            ->withTimestamps();
    }
}
