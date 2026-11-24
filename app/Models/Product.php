<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id', 'name', 'slug', 'sku', 'price', 
        'sale_price', 'stock_quantity', 'description', 
        'specifications', 'is_featured', 'is_active'
    ];

    protected $casts = [
        'specifications' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function images() {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function primaryImage() {
        return $this->hasOne(ProductImage::class)->where('is_primary', true);
    }

    public function variants() {
        return $this->hasMany(ProductVariant::class);
    }

    public function reviews() {
        return $this->hasMany(Review::class)->where('is_approved', true);
    }

    public function bundles() {
        return $this->belongsToMany(Bundle::class, 'bundle_items');
    }

    public function getFormattedPriceAttribute() {
        return '₦' . number_format($this->sale_price ?? $this->price, 2);
    }

    public function getFormattedOriginalPriceAttribute() {
        return $this->sale_price ? '₦' . number_format($this->price, 2) : null;
    }

    public function isPuzzle(): bool {
        return optional($this->category)->slug === 'jigsaw-puzzles';
    }

    /**
     * Puzzles are displayed with the artwork that shows the dividing (cut) lines,
     * so parents can see it is a jigsaw. Falls back to the primary image.
     */
    public function getImageUrlAttribute(): string {
        if ($this->isPuzzle()) {
            $cut = $this->images->first(fn ($img) => str_contains((string) $img->image_path, '_cut'));
            if ($cut) {
                return $cut->url;
            }
        }

        return $this->primaryImage ? $this->primaryImage->url : asset('images/products/placeholder.svg');
    }

    /**
     * Small (~640px) version of image_url for cards, thumbnails and the cart.
     */
    public function getCardImageUrlAttribute(): string {
        return \App\Support\Img::sm($this->image_url);
    }

    /**
     * Gallery images in display order (for puzzles, the cut-line artwork comes first).
     */
    public function getGalleryImagesAttribute() {
        if (! $this->isPuzzle()) {
            return $this->images;
        }

        return $this->images
            ->sortBy(fn ($img) => str_contains((string) $img->image_path, '_cut') ? 0 : 1)
            ->values();
    }
}
