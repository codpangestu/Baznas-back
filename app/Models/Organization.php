<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Organization extends Model
{
    protected $fillable = [
        'name', 'region', 'description', 'logo', 'website', 'instagram', 'email', 'status'
    ];

    public function users()
    {
        return $this->HasMany(User::class);
    }
}
