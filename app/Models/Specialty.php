<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specialty extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
        'min_price_range',
        'max_price_range',
        'type'
    ];

    /**
     * Get the subcategory related to this specialty.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }
}
