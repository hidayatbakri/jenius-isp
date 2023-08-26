<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Paket extends Model
{
    use HasFactory;
    protected $table = 'paket';
    protected $guarded = ['id'];

    public function customer(): HasOne
    {
        return $this->hasOne(Customer::class);
    }
}
