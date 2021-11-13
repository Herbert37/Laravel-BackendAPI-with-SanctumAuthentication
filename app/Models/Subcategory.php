<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image'
    ];

    /**
     * Get the subcategory related to this specialty.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the specialty related to this subcategory.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function specialties()
    {
        return $this->hasMany(Specialty::class);
    }
}
