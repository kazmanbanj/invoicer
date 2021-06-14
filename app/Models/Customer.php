<?php

namespace App\Models;

use App\Models\CustomersField;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'address', 'postcode', 'city', 'state', 'country_id', 'postcode', 'phone', 'email'];

    /**
     * Get all of the customer_fields for the Customer
     */
    public function customer_fields()
    {
        return $this->hasMany(CustomersField::class);
    }

    /**
     * Get the country that owns the Customer
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
