<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'product_id',
    'product_variant_id',
    'customer_name',
    'customer_email',
    'customer_phone',
    'desired_dates',
    'message',
])]
class Enquiry extends Model
{
    public function boutique(): BelongsTo
    {
        return $this->belongsTo(Boutique::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function variant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }
}
