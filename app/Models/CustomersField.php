<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomersField extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id', 'field_key', 'field_value'];
}
