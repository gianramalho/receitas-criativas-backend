<?php

namespace App\Models\Domain;

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

    /**
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function recipes()
    {
        return $this->belongsToMany(Recipe::class, 'recipes_has_tags', 'tags_id', 'recipes_id')
            ->withTimestamps();
    }
}
