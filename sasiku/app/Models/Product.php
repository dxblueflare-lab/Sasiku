<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'image_url',
        'price',
        'original_price',
        'badge',
        'rating',
        'review_count',
        'is_active',
        'is_organic',
        'stock',
        'user_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'original_price' => 'decimal:2',
            'rating' => 'decimal:2',
            'is_active' => 'boolean',
            'is_organic' => 'boolean',
        ];
    }

    /**
     * Get the category that owns the product.
     *
     * @return BelongsTo<Category>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the seller that owns the product.
     *
     * @return BelongsTo<User>
     */
    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Scope a query to only include active products.
     *
     * @param  \Illuminate\Database\Eloquent\Builder<Product>  $query
     * @return \Illuminate\Database\Eloquent\Builder<Product>
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get the product code attribute.
     *
     * @return string
     */
    public function getCodeAttribute(): string
    {
        // Format kode produk: PROD + ID + Tanggal Pembuatan (YYYYMMDD)
        $date = $this->created_at ? $this->created_at->format('Ymd') : now()->format('Ymd');
        return 'PROD' . $this->id . $date;
    }

    /**
     * Get the ingredients associated with this product.
     */
    public function ingredients(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Ingredient::class, 'product_ingredient')
                    ->withPivot(['quantity', 'notes'])
                    ->withTimestamps();
    }
    
    /**
     * Accessor for image URL to ensure proper formatting
     */
    public function getImageUrlAttribute($value)
    {
        if (!$value) {
            return null;
        }
        
        // Return the value as is since it should already be properly formatted
        return $value;
    }
}
