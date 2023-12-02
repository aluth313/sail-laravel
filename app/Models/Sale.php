<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Sale extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function salesDetail(): HasMany
    {
        return $this->hasMany(SalesDetail::class);
    }

    public function customer(): HasOne
    {
        return $this->hasOne(Customer::class, 'id', 'customer_id');
    }

}
