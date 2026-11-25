<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['parent_id', 'name', 'slug', 'description', 'image', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /** Slugs of switched-off categories, cached for the current request. */
    protected static ?array $inactiveSlugCache = null;

    public function parent() {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children() {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function products() {
        return $this->hasMany(Product::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Is the category with this slug switched on? Unknown slugs count as active
     * so hard-coded storefront links don't vanish by accident.
     */
    public static function isSlugActive(string ...$slugs): bool
    {
        if (static::$inactiveSlugCache === null) {
            static::$inactiveSlugCache = static::where('is_active', false)->pluck('slug')->all();
        }

        foreach ($slugs as $slug) {
            if (in_array($slug, static::$inactiveSlugCache, true)) {
                return false;
            }
        }

        return true;
    }

    protected static function booted(): void
    {
        static::saved(fn () => static::$inactiveSlugCache = null);
    }
}
