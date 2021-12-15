<?php

use Illuminate\Database\Seeder;
use App\Transaction;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = public_path('transaction.sql');
        $sql = file_get_contents($path);
        DB::unprepared($sql);

    }
}