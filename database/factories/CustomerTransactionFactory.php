<?php

namespace Database\Factories;

use App\Models\CustomerTransaction;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerTransactionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CustomerTransaction::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $timestamp = rand( strtotime("Jan 01 2022"), strtotime("Mar 01 2022") );
        $random_Date = date("Y-m-d", $timestamp );

        return [
            'customer_id' => rand(1, 2),
            'amount' => rand(1, 2),
            'date_created' => $random_Date,
        ];
    }
}
