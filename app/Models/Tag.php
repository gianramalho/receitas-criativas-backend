<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'tags_parent_id',
    ];

    public function recipes()
    {
        return $this->belongsToMany(Recipe::class, 'recipes_has_tags', 'tags_id', 'recipes_id')
            ->withTimestamps();
    }
}
