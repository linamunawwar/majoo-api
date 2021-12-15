<?php

use Illuminate\Database\Seeder;
use App\Merchant;

class MerchantSedder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $merchant = new Merchant;
        $merchant->user_id = 1;
        $merchant->merchant_name = "Merchant 1";
        $merchant->created_by = 1;
        $merchant->updated_by = 1;
        $merchant->save();

        $merchant2 = new Merchant;
        $merchant2->user_id = 2;
        $merchant2->merchant_name = "Merchant 2";
        $merchant2->created_by = 2;
        $merchant2->updated_by = 2;
        $merchant2->save();

    }
}
