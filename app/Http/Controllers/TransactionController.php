<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaction;
use App\Merchant;
use App\Outlet;
use Auth;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class TransactionController extends Controller
{

	public function paginate($items, $perPage = 10, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    public function store(Request $request)
    {
		$trans = new Transaction;
    	$trans->merchant_id = $request->merchant_id;
    	$trans->outlet_id = $request->outlet_id;

    	if($trans->save()){
    		return response()->json([
		        "message" => "Transaction record created"
		      ], 201);
    	}else{
    		return response()->json([
		        "message" => "The request could not be completed due to a conflict with the current state of the resource."
		      ], 409);
    	}
    }

    public function delete($id)
    {
    	if(Transaction::where('id', $id)->exists()) {
        $trans = Transaction::find($id);
        $trans->delete();

        return response()->json([
          "message" => "records deleted"
        ], 202);
      } else {
        return response()->json([
          "message" => "Transaction not found"
        ], 404);
      }
    }

    public function getByMerchant($month,$year)
    {
    	$merchant = Merchant::where('user_id', Auth::user()->id)->first();
    	if($merchant){
    		$days = cal_days_in_month(CAL_GREGORIAN,$month, $year);
    		
	    	for ($i=1; $i <=$days ; $i++) { 
	    		$date = $year.'-'.$month.'-'.$i;
	    		$transactions = Transaction::where('merchant_id',$merchant->id)
	    									->whereDate('created_at',$date)
	    									->get();
	    		$omzet = 0;
	    		foreach ($transactions as $key => $transaction) {
	    			$omzet = $omzet + $transaction->bill_total;
	    		}
	    		$data['omzet'][$i] = $omzet;
	    	}
	    	$myCollectionObj = collect($data['omzet']);
  			$data['Nama merchant'] = $merchant->merchant_name;
        	$data['omzet'] = $this->paginate($myCollectionObj);
	    	return response()->json($data, 200);
    	}else{
    		return response()->json([
	          "message" => "data not found"
	        ], 404);
    	}	
    }
    	
    public function getByMerchantOutlet($month,$year)
    {
    	$merchant = Merchant::where('user_id', Auth::user()->id)->first();
    	if($merchant){
    		$data['Nama merchant'] = $merchant->merchant_name;
    		$outlets = Outlet::where('merchant_id',$merchant->id)->get();
    		if($outlets){
    			foreach ($outlets as $key => $outlet) {
    				$days = cal_days_in_month(CAL_GREGORIAN,$month, $year);
			    	for ($i=1; $i <=$days ; $i++) { 
			    		$date = $year.'-'.$month.'-'.$i;
			    		$transactions = Transaction::where('merchant_id',$merchant->id)
			    									->where('outlet_id',$outlet->id)
			    									->whereDate('created_at',$date)
			    									->get();
			    		$omzet = 0;
			    		foreach ($transactions as $key2 => $transaction) {
			    			$omzet = $omzet + $transaction->bill_total;
			    		}
			    		$data['outlet'][$key]['omzet'][$i] = $omzet;
			    	}
			    	$data['outlet'][$key]['nama outlet'] =  $outlet->outlet_name;
			    	$myCollectionObj = collect($data['outlet'][$key]['omzet']);
        			$data['outlet'][$key]['omzet'] = $this->paginate($myCollectionObj);
    			}
	    			
		    	return response()->json($data, 200);
    		}else{
    			return response()->json([
    			  "data" =>$data,
		          "message" => "your merchant doesn't have outlet yet."
		        ], 204);
    		}
    	}else{
    		return response()->json([
	          "message" => "data not found"
	        ], 404);
    	}	
    }
}
