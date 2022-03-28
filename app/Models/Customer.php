<?php

namespace App\Models;

use App\Models\CustomersField;
use App\Models\CustomerTransaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'address', 'postcode', 'city', 'state', 'country_id', 'phone', 'email', 'user_id'];

    protected static function booted()
    {
        if (auth()->check()) {
            static::addGlobalScope('user', function (Builder $builder) {
                $builder->where('user_id', auth()->id());
            });
        }
    }

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

    // public function debts(){
    //     return $this->hasMany('App\Debt','project_id')->selectRaw('debts.*,sum(total) as sum')->groupBy('currency_list');
    // }

    public function transactions()
    {
        return $this->hasMany(CustomerTransaction::class, 'customer_id')
        ->selectRaw('customer_transactions.customer_id, sum(amount) as amount, MONTH(date_created) as month, YEAR(date_created) as year')
        ->groupBy('customer_id', 'month', 'year');
    }

    // public function transactions()
    // {
    //     return $this->hasMany(CustomerTransaction::class, 'customer_id');
    // }
}
