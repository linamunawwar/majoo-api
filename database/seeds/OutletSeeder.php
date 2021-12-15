<?php

use Illuminate\Database\Seeder;
use App\Outlet;

class OutletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $outlet = new Outlet;
        $outlet->id = 1;
        $outlet->merchant_id = 1;
        $outlet->outlet_name = 'Outlet 1';
        $outlet->created_by = 1;
        $outlet->updated_by = 1;
        $outlet->save();

        $outlet2 = new Outlet;
        $outlet2->id = 2;
        $outlet2->merchant_id = 2;
        $outlet2->outlet_name = 'Outlet 1';
        $outlet2->created_by = 2;
        $outlet2->updated_by = 2;
        $outlet2->save();

        $outlet3 = new Outlet;
        $outlet3->id = 3;
        $outlet3->merchant_id = 1;
        $outlet3->outlet_name = 'Outlet 2';
        $outlet3->created_by = 1;
        $outlet3->updated_by = 1;
        $outlet3->save();
    }
}
