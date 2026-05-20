<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Daerah extends Model
{
    protected $table = 'daerahs';

    protected $fillable = [
        'province_id',
        'name',
        'slug',
        'image',
        'website',
        'instagram',
        'email',
    ];

    /**
     * Eagerly generate slug during saving.
     */
    protected static function booted()
    {
        static::saving(function ($daerah) {
            if ($daerah->isDirty('name') && !empty($daerah->name)) {
                $daerah->slug = Str::slug($daerah->name);
            } elseif (empty($daerah->slug) && !empty($daerah->name)) {
                $daerah->slug = Str::slug($daerah->name);
            }
        });
    }

    /**
     * Get the province this daerah belongs to.
     */
    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }

    /**
     * Get all organizations associated with this daerah.
     */
    public function organizations(): HasMany
    {
        return $this->hasMany(Organization::class);
    }
}
