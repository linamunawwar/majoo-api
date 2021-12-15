<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Merchant;
use App\Outlet;
use Auth;

class OutletController extends Controller
{
    public function index()
    {
    	$merchant = Merchant::where('user_id', Auth::user()->id)->first();
    	if($merchant){
    		$data = Outlet::where('merchant_id',$merchant->id)->get();
    		return response()->json($data, 200);
    	}else{
    		return response()->json($merchant, 204);
    	}
    }

    public function store(Request $request)
    {
    	$data = Merchant::where('user_id', Auth::user()->id)->first();
    	if (!$data){
    		return response()->json([
			        "message" => "Please create a merchant first"
			      ], 401); //401 ->unauthorized
    	}else{
    		$outlet = new Outlet;
	    	$outlet->outlet_name = $request->outlet_name;
	    	$outlet->merchant_id = $data->id;

	    	if($merchant->save()){
	    		return response()->json([
			        "message" => "Outlet record created"
			      ], 201);
	    	}else{
	    		return response()->json([
			        "message" => "The request could not be completed due to a conflict with the current state of the resource."
			      ], 409);
	    	}
    	}
    }

    public function delete($id)
    {
    	if(Outlet::where('id', $id)->exists()) {
        $outlet = Outlet::find($id);
        $outlet->delete();

        return response()->json([
          "message" => "records deleted"
        ], 202);
      } else {
        return response()->json([
          "message" => "Outlet not found"
        ], 404);
      }
    }
}
