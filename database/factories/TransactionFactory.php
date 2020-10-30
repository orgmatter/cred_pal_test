<?php

namespace Database\Factories;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Wallet;
use App\Models\ReferralCode;

class TransactionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Transaction::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'wallet_id' => Wallet::factory(),
            'referral_code_id' => ReferralCode::factory(),
            'type' => 'transfer',
            'amount' => mt_rand(1000, 9999),
            'remarks' => $this->faker->paragraph,
        ];
    }
}
