<?php

namespace App\Http\Controllers;

use App\vendor;
use App\item;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vendors = Vendor::latest()->paginate(10);
        return view('vendor.index',compact('vendors'))->with('i', (request()->input('page', 1) - 1) * 10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    		$items = item::all();
        return view('vendor.create', compact('items'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => '',
            'mobile' => 'required|numeric|unique:vendors',
            'address' => 'required',
            'register_number' => 'required|unique:vendors',
            'firm_name' => 'required',
            'item_id' => 'required',
            'gst_number' => 'required|unique:vendors'
        ]);
  			
  			$data = array(
  					'name' => $request->name,
  					'email' => $request->email,
  					'mobile' => $request->mobile,
  					'register_number' => $request->register_number,
  					'firm_name' => $request->firm_name,
  					'gst_number' => $request->gst_number,
  					'alt_number' => $request->alt_number,
  					'address' => $request->address,
  					'item_id' => json_encode($request->item_id),
  			);
  			Vendor::create($data);
   
        return redirect()->route('vendor.index')->with('success','Vendor Added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function show(vendor $vendor)
    {
    		$item_id = json_decode($vendor->item_id);
    		if(!empty($item_id)) {
    			$items = item::whereIn('id',$item_id)->get();
    		}else{
    			$items = array();
    		}
    		return view('vendor.show',compact('vendor','items'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function edit(vendor $vendor)
    {
        $items = item::all();
        return view('vendor.edit',compact('vendor','items'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, vendor $vendor)
    {
        $request->validate([
            'name' => 'required',
            'email' => '',
            'mobile' => 'required|numeric',
            'address' => 'required',
            'register_number' => 'required',
            'firm_name' => 'required',
            'gst_number' => 'required'
        ]);
  				
  			$data = array(
  					'name' => $request->name,
  					'email' => $request->email,
  					'mobile' => $request->mobile,
  					'firm_name' => $request->firm_name,
  					'gst_number' => $request->gst_number,
  					'alt_number' => $request->alt_number,
  					'address' => $request->address,
  					'item_id' => json_encode($request->item_id),
  			);
        $vendor->update($data);
  
        return redirect()->route('vendor.index')->with('success','Vendors details updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function destroy(vendor $vendor)
    {
        $vendor->delete();
        return redirect()->route('vendor.index')->with('success','Vendors record deleted successfully');
    }
}
