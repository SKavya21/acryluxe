<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'color',
        'sizes',
        'image',
        'images',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'sizes' => 'array',
            'images' => 'array',
        ];
    }

    public function sizeInventory(): array
    {
        return is_array($this->sizes) ? $this->sizes : [];
    }

    public function totalStock(): int
    {
        return array_sum(array_map('intval', $this->sizeInventory()));
    }

    public function imagePaths(): array
    {
        return array_values(array_unique(array_filter(array_merge(
            $this->image ? [$this->image] : [],
            is_array($this->images) ? $this->images : [],
        ))));
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }
}