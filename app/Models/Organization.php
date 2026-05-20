<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Organization extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'region',
        'description',
        'logo',
        'website',
        'instagram',
        'email',
        'status',
        'province_id',
        'daerah_id',
    ];

    /**
     * Get the users for the organization.
     *
     * @return HasMany
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get the province this organization belongs to.
     *
     * @return BelongsTo
     */
    public function province(): BelongsTo
    {
        return $this->belongsTo(Province::class);
    }

    /**
     * Get the daerah this organization belongs to.
     *
     * @return BelongsTo
     */
    public function daerah(): BelongsTo
    {
        return $this->belongsTo(Daerah::class);
    }
}
