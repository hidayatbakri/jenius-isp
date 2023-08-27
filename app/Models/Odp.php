<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Odp extends Model
{
    use HasFactory;
    protected $table = 'odp';
    protected $guarded = ['created_at'];

    public function odc(): BelongsTo
    {
        return $this->belongsTo(Odc::class);
    }

    public function customer(): HasMany
    {
        return $this->hasMany(Customer::class);
    }
}
