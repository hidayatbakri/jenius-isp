<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Customer extends Model
{
    use HasFactory;
    protected $guarded = ['created_at'];
    // protected $fillable = ['id', 'onu', 'name', 'type', 'paket', 'email', 'hp', 'address'];

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function paket(): BelongsTo
    {
        return $this->belongsTo(Paket::class);
    }

    public function odp(): BelongsTo
    {
        return $this->belongsTo(Odp::class);
    }
}
