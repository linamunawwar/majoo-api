<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Merchant;
use App\Outlet;
use Auth;

class MerchantController extends Controller
{
    public function index()
    {
    	$data = Merchant::where('user_id', Auth::user()->id)->first();
    	if($data){
    		$data->outlets = Outlet::where('merchant_id',$data->id)->get();
    		return response()->json($data, 200);
    	}else{
    		return response()->json($data, 204);
    	}
    }

    public function store(Request $request)
    {
    	$data = Merchant::where('user_id', Auth::user()->id)->first();
    	if ($data){
    		return response()->json([
			        "message" => "This user already has merchant"
			      ], 401); //401 ->unauthorized
    	}else{
    		$merchant = new Merchant;
	    	$merchant->merchant_name = $request->merchant_name;
	    	$merchant->user_id = Auth::user()->id;

	    	if($merchant->save()){
	    		return response()->json([
			        "message" => "Merchant record created"
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
    	if(Merchant::where('id', $id)->exists()) {
        $merchant = Merchant::find($id);
        $merchant->delete();

        return response()->json([
          "message" => "records deleted"
        ], 202);
      } else {
        return response()->json([
          "message" => "Merchant not found"
        ], 404);
      }
    }
}
