<?php

namespace App\Http\Controllers;

use App\Purchase;
use App\Purchase_temperory;
use App\Purchase_item;
use App\purchase_invoice;
use App\item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Helper;
use Response;
class PurchaseController extends Controller
{
		public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
    	$purchases = Purchase::with('item_name.unit')->get();
    	$temp = Purchase_temperory::latest()->first();
    	return view('purchase.index',compact('purchases','temp'));
    }

    public function create()
    {
        //
    }

    /* this function can be used to store item in session */
    public function store(Request $request)
    {	
    	$product = item::where("item_number", $request->item_number)->get();
    	$id = $product[0]->id;
      $cart = session()->get('cart');
      if(!$cart) {
        $cart = [
        	$id => [
	        	"item_number" => $product[0]->item_number,
		        "name" => $product[0]->title,
		        "quantity" => 1
		      ]
        ];
        session()->put('cart', $cart);
        return view('purchase.display_item');
      }

      if(isset($cart[$id])) {
        $cart[$id]['quantity']++;
        session()->put('cart', $cart);
        return view('purchase.display_item');
      }

      $cart[$id] = [
        "item_number" => $product[0]->item_number,
		    "name" => $product[0]->title,
		    "quantity" => 1
      ];
      session()->put('cart', $cart);
      return view('purchase.display_item');
    }

    /* this function can be used to check id wise invoice */
    public function show($id)
    {
    		//
    }

    public function edit(Purchase $purchase)
    {
        //
    }

    public function update(Request $request, Purchase $purchase)
    {
        //
    }

    /* this function can be used to delete single item */
    public function destroy(Request $request, $id)
    {
    		if($id || $id == false) {
          $cart = session()->get('cart'); 
          if(isset($cart[$id])) { 
              unset($cart[$id]); 
              session()->put('cart', $cart);
          }
          session()->flash('success', 'Product removed successfully');
          return redirect()->route('purchase.index')->with('success','Item deleted successfully');
        }
    }

    /* this function can be used to search items */
    public function fetch(Request $request)
    {
    	if($request->get('query'))
      {
	      $query = $request->get('query');
	      $data = item::where('title', 'LIKE', "%{$query}%")->orWhere('item_number', 'LIKE', "%{$query}%")->get();
	      $output = '<ul class="dropdown-menu" style="display:block; position:relative">';
	      if(count($data) != null)
	      {
		      foreach($data as $row)
		      {
		      	$output .= '<li><a id="getItemID" href="?itemId='.$row->id.'" style="pointer-events: none;" value="'.$row->id.'">'.$row->title .' | '.$row->item_number.'</a></li>';
		      }
		    }
		    else
		    {
		    	$output .= '<li><a href="JavaScript:void(0);">No Items available</a></li>';
		    }
	      $output .= '</ul>';
	      echo $output;
      }
    }

    /* this function can be used to update quantity on input field */
    public function updateQty(Request $request)
    {
  		$cart = session()->get('cart');
  		$id = $request->id;
    	$quantity = $request->quantity;
    	if($quantity > 0){
    		if(isset($cart[$id])) {
	    		$cart[$id]['quantity'] = $quantity;
	        session()->put('cart', $cart);
	      }
	    }
    }

    /* this function can be used to store cart data on hold by clicking Hold btn */
    public function holdStatus(Request $request)
    {
    		$cart = session()->get('cart');
    		if(!empty($cart))
    		{ 
    			Helper::emptyCart('cart');
    			$data = Purchase_temperory::all();
    			if(count($data))
    			{
    				$persist = Purchase_temperory::latest()->first();
    				$persist->temp_data = json_encode($cart);
	    			$persist->save();
		    		return redirect()->route('purchase.index')->with('success','Your items are added on Hold.');
    			}
    			else
    			{
	    			$persist = new Purchase_temperory;
	    			$persist->temp_data = json_encode($cart);
	    			$persist->save();
		    		return redirect()->route('purchase.index')->with('success','Your items are added on Hold.');
		    	}
	    	}
	    	else
	    	{
	    		return redirect()->route('purchase.index')->with('alert','First select any items');
	    	}
    }

    /* this function can be used to generate invoice by clicking generate btn */
    public function invoice(Request $request)
    {
    	$cart = session()->get('cart');
  		if(!empty($cart))
  		{
  			Helper::emptyCart('cart');
  			$Purchase_item = Purchase_item::with('item_name.unit')->get();
  			if(!empty($Purchase_item))
  			{
  				Purchase_item::query()->truncate();
  			}
  			$arr = array(
  				//'invoice_no' => date("Ym").'/'.mt_rand(00000, 99999).'/'.count($cart),
  				'invoice_no' => $this->generateInvoiceNumber(),
  				'items' => json_encode($cart)
  			);
  			foreach ($cart as $value) {
    			$data = array(
    				'invoice_no' => $arr['invoice_no'],
    				'item_number' => $value['item_number'], 
    				'quantity' => $value['quantity'], 
    			);
    			Purchase::create($data);
    		}
    		Purchase_item::create($arr);
    		purchase_invoice::create($arr);
    		$purchases = Purchase_item::all();
    		return view('purchase.invoice',compact('purchases'));
    	}
    	else
    	{
    		return redirect()->route('purchase.index')->with('alert','First select any items');
    	}
    }

    /* this function can be used to restore hold cart data by clicking Restore cart item text */
    public function cartRestore()
    {
    	$temp = Purchase_temperory::latest()->first();
    	$id = $temp['id'];
    	$temps = json_decode($temp['temp_data'], true);
    	$cart = $temps;
    	$new_session = session()->get('cart');
    	if(!empty($new_session)){
		    	foreach ($new_session as $key => $val) {
				  	$latest_id = $key;
	    			if(isset($cart[$latest_id])) {
				        $cart[$latest_id]['quantity']++;
				        $data = $cart;
				        //print_r($latest_id); die;
			      }
			   	}
		     //  else{
    			// 		$data = array_merge($cart, $new_session);
    			// }
    	}else{
    			$data = $cart;
    	}
    	session()->put('cart', $data);
    	Purchase_temperory::find($id)->delete();
    	return redirect()->route('purchase.index');
    }

    /* this function can be used to generate invoice number */
    public function generateInvoiceNumber()
   	{
   			$getNum = purchase_invoice::latest()->first();
   			if(!empty($getNum))
   			{
   				$num = $getNum->id+1;
   			}
   			else
   			{
   				$num = 0+1;
   			}
				$invoice_num = str_pad($num, 5, '0', STR_PAD_LEFT);
				return date("Y-m-").$invoice_num;
   	}
}
