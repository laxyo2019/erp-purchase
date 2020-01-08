<?php

namespace App\Http\Controllers;

use App\quotation;
use App\Quotation_items;
use Illuminate\Http\Request;

class QuotationController extends Controller
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
        $quotations = quotation::latest()->paginate(10);
        return view('quotation.index',compact('quotations'))->with('i', (request()->input('page', 1) - 1) * 10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    		return view('quotation.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    		//dd($request);
        $request->validate([
            'name' => 'required',
            'mobile' => 'required|unique:quotations',
            'register_number' => 'required|unique:quotations',
            'firm_name' => 'required',
            'gst_number' => 'required|unique:quotations',
        ]);

        $quotation = quotation::create($request->all());
        $LastInsertId = $quotation->id;
        //print_r($LastInsertId); die;
        if(!empty($LastInsertId)){
        	$count = count($request->item_name);	
			  	if($count != 0){
			  	 	$x = 0;
			  	 	while($x < $count){
			  	 		if($request->item_name[$x] !=''){
							  $quotationItemsTable = array(
						 				'item_name' => $request->item_name[$x],
				            'item_quantity' => $request->item_quantity[$x],
				            'item_price' => $request->item_price[$x],
				            'item_actual_amount' => $request->item_actual_amount[$x],
				            'item_tax1_rate' => $request->item_tax1_rate[$x],
				            'item_tax1_amount' => $request->item_tax1_amount[$x],
				            'item_total_amount' => $request->item_total_amount[$x],
				            'quotation_id' => $LastInsertId,
				            'vendor_regno' => $request->register_number,
						 		);
				        //print_r($quotationItemsTable); die;
				        Quotation_items::create($quotationItemsTable);
							}			  
			  	 		$x++;
			  	 	}
			  	}
        }
        return redirect()->route('quotation.index')->with('success','Quotation Added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\quotation  $quotation
     * @return \Illuminate\Http\Response
     */
    public function show(quotation $quotation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\quotation  $quotation
     * @return \Illuminate\Http\Response
     */
    public function edit(quotation $quotation)
    {
    		$quotation_item = Quotation_items::where('quotation_id',$quotation->id)->where('vendor_regno',$quotation->register_number)->get();
    		return view('quotation.edit', compact('quotation', 'quotation_item'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\quotation  $quotation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, quotation $quotation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\quotation  $quotation
     * @return \Illuminate\Http\Response
     */
    public function destroy(quotation $quotation)
    {
        //
    }
}
