<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = ['invoice_number', 'invoice_date', 'customer_id', 'tax_percent'];

    /**
     * Get the customer that owns the Invoice
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    /**
     * Get all of the invoice_items for the Invoice
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function invoice_items()
    {
        return $this->hasMany(InvoicesItem::class);
    }

    public function getTotalAmountAttribute()
    {
        $total_amount = 0;
        foreach ($this->invoice_items as $item) {
            $total_amount += $item->price * $item->quantity;
        }
        return $total_amount;
    }
}
