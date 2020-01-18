<?php

namespace App\Http\Controllers;

use App\RequestForItem;
use Illuminate\Http\Request;
use Auth;
use App\Member;
use App\vendor;
use App\RfiUsers;
use App\RfiManager;
use App\User;
use App\VendorsMailSend;
use App\Notifications\RFQ_Notification;
use \App\Mail\SendMailToVendors;
use Laravel\LegacyEncrypter\McryptEncrypter;
use PDF;
use DB;

class RequestForItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    		$user_id = Auth::user()->id;
        $request_for_items = RfiUsers::where('user_id',$user_id)->latest()->paginate(10);
        return view('request_for_item.index', compact('request_for_items'))->with('i', (request()->input('page', 1) - 1) * 10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('request_for_item.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /*$request->validate([
            'item_name' => 'required',
            'quantity' => 'required',
            'description' => 'required',
            'user_id' => 'required'
        ]);*/

        $id = Auth::user()->id;
        $getRoles = Auth::user();
        $role = $getRoles->roles;
        $rolename = $role[0]->name;
      	$count = count($request->item_name);	
		  	if($count != 0){
		  	 	$x = 0;
		  	 	$data = array();
		  	 	while($x < $count){
		  	 		if($request->item_name[$x] !=''){
						  $RequestForItem = array(
					 				'item_name' => $request->item_name[$x],
			            'quantity' => $request->quantity[$x],
			            'description' => $request->description[$x],
			            'user_id' => $request->user_id[$x],
					 		);
					 		$data[] = $RequestForItem;
					 		//RequestForItem::create($RequestForItem);
						}			  
		  	 		$x++;
		  	 	}
		  	 	$request_data = new RfiUsers;
    			$request_data->requested_data = json_encode($data);
    			$request_data->user_id = $id;
    			$request_data->requested_role = ($rolename == 'users') ? 'Users' : 'Manager';
    			$request_data->save();

    			$request_data = new RfiManager;
    			$request_data->data = json_encode($data);
    			$request_data->requested_id = $id;
    			$request_data->save();

    			$member_details = $request_data->requested_id;
	        $details = Member::where('user_id',$member_details)->get();
	        $users = Member::whereIn('role_id',['3','4'])->get();
	        foreach ($users as $user) {
	        	$send_users = User::find($user->user_id);
	        	$send_users->notify(new RFQ_Notification($details));
	        }
		  	}
      	return redirect()->route('request_for_item.index')->with('success','Your RFI Added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RequestForItem  $requestForItem
     * @return \Illuminate\Http\Response
     */
    public function show(RequestForItem $requestForItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RequestForItem  $requestForItem
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
    		$data = RfiUsers::where('id',$id)->get();
        foreach ($data as $requestForItem) {
        	return view('request_for_item.edit',compact('requestForItem'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RequestForItem  $requestForItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RequestForItem $requestForItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RequestForItem  $requestForItem
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        RfiUsers::find($id)->delete();
        return redirect()->route('request_for_item.index')->with('success','Your RFI deleted successfully');
    }

    public function UsersRequest()
    {
    		$uid = Auth::user()->id;
    		$request_for_items = RfiUsers::latest()->paginate(10);
    		foreach ($request_for_items as $key) {
    			$mid = $key->id;
    			$MailStatus = VendorsMailSend::where('quotion_sent_id',$mid)->get();
    		}
    		return view('request_for_item.user_request', compact('request_for_items', 'MailStatus'))->with('i', (request()->input('page', 1) - 1) * 10);
    }

    public function UsersRequestStatus(Request $request, $id)
    {
    		$loggedin_Id = Auth::user()->id;
    		$data = RfiUsers::where('id',$id)->get();
        foreach ($data as $requestForItem) {
        	$requested_user_id = $requestForItem->user_id;
        	//if($requested_user_id != $loggedin_Id){
	        	$mem = Member::where('user_id',$requested_user_id)->get();
	    			foreach ($mem as $mem_details) {
	        		return view('request_for_item.user_req_status',compact('requestForItem', 'mem_details'));
	        	}
	        /*}else{
	        		return redirect()->route('user_request');
	        }*/
        }
    }

    public function UsersRequestUpdate(Request $request, $id){
    		$request->validate([
            'status' => 'required'
        ]);

    		$count = count($request->item_name);	
		  	if($count != 0){
		  	 	$x = 0;
		  	 	$data = array();
		  	 	while($x < $count){
		  	 		if($request->item_name[$x] !=''){
						  $RequestForItem = array(
					 				'item_name' => $request->item_name[$x],
			            'quantity' => $request->quantity[$x],
			            'description' => $request->description[$x],
			            'user_id' => $request->user_id,
					 		);
					 		$data[] = $RequestForItem;
						}			  
		  	 		$x++;
		  	 	}
    			$update_data = array(
								'requested_data' 	=>		json_encode($data),
								'user_id'					=>		$request->user_id,
								'manager_status'	=>		$request->status,
    			);
    			RfiUsers::where('id', $id)->update(['requested_data'=> json_encode($data), 'user_id' => $request->user_id, 'manager_status' => $request->status,]);
    		}
    		return redirect()->route('user_request')->with('success','Your status has been updated');
    }

    public function ApplyForQuotation($id)
    {
    		$data = RfiUsers::where('id',$id)->get();
    		$vendor = vendor::all();
	  		$role = $data[0]->requested_role;
	  		if($role == 'Manager'){
	  			$status = 0;
	  		}else{
	  			$status = 1;
	  		}
	  		$requested = RfiUsers::where('id',$id)->where('requested_role',$role)->where('manager_status',$status)->get();
	  		return view('request_for_item.applyforquotation',compact('requested','vendor'));
    }

    public function RfiQuotationToMail(Request $request, $id){
    		//$email = $request->vendor_name;
    		$vendor_id = $request->vendor_id;
    		foreach ($vendor_id as $vendor_ids) {
    			$vendor = vendor::find($vendor_ids);
    			$tbl = $request->table;
    			$pdf = PDF::loadView('request_for_item.rfi_quotation', compact('tbl'));
    			$pdf = $pdf->Output('', 'S');
    			//$pdf->stream('rfi_quotation'.date("d-M-Y").'.pdf', array("Attachment" => False));

    			$rfq = RfiUsers::find($id);
    			$autoId = DB::select(DB::raw("SELECT nextval('vendors_mail_sends_id_seq')"));
  				$nextval = $autoId[0]->nextval+1;
  				//$nextval = Helper::getRFQSendMailAutoIncrementId();
    			$data = array(
    					'email'		=>		json_encode($vendor_id),
    					'quotion_id'	=>	'#RFI'.str_pad($nextval, 4, '0', STR_PAD_LEFT),
    					'quotion_sent_id' => $id,
    					'item_list'		=>	$rfq->requested_data
    			);
    			$datas = VendorsMailSend::create($data);
    			$quotion_id = $datas->id;
    			$details = array(
    				'table' => $request->table,
    				'name' => $vendor->name,
    				'email' => $vendor->email,
    				'pdf' => $pdf,
    				'quotion_id' => $quotion_id,
    				'vendor_id' => $vendor->id,
    			);
    			\Mail::to($vendor->email)->send(new SendMailToVendors($details));

    			return redirect()->route('user_request')->with('success','Mail sends successfully');
    		}
    }
}
