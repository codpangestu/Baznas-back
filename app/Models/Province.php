<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Province extends Model
{
    protected $fillable = ['name', 'slug', 'image'];

    /**
     * Eagerly generate slug during saving.
     */
    protected static function booted()
    {
        static::saving(function ($province) {
            if ($province->isDirty('name') && !empty($province->name)) {
                $province->slug = Str::slug($province->name);
            } elseif (empty($province->slug) && !empty($province->name)) {
                $province->slug = Str::slug($province->name);
            }
        });
    }

    /**
     * Get all daerahs (districts) in this province.
     */
    public function daerahs(): HasMany
    {
        return $this->hasMany(Daerah::class);
    }

    /**
     * Get all organizations associated with this province.
     */
    public function organizations(): HasMany
    {
        return $this->hasMany(Organization::class);
    }
}
