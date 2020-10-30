<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Sequence;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Transaction::factory()
                            ->count(10)
                            ->state(new Sequence(
                                ['type' => 'transfer'],
                                ['type' => 'receive']
                            ))->create();
    }
}
