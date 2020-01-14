<?php

namespace App\Http\Controllers;

use App\RequestForQuotation;
use Illuminate\Http\Request;
use Auth;
use App\Member;
use App\User;
use App\Notifications\RFQ_Notification;

class RequestForQuotationController extends Controller
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
    		$user_id = Auth::user()->id;
        $request_for_quotation = RequestForQuotation::where('user_id',$user_id)->latest()->paginate(10);
        return view('rfq.index',compact('request_for_quotation'))->with('i', (request()->input('page', 1) - 1) * 10);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('rfq.create');
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
            'item_name' => 'required',
            'quantity' => 'required',
            'description' => 'required',
            'user_id' => 'required'
        ]);
        $data = RequestForQuotation::create($request->all());
        $member_details = $data->user_id;
        $details = Member::where('user_id',$member_details)->get();
        $users = Member::whereIn('role_id',['3','4'])->get();
        foreach ($users as $user) {
        	$send_users = User::find($user->user_id);
        	$send_users->notify(new RFQ_Notification($details));
        }
        return redirect()->route('rfq.index')->with('success','Your RFQ Added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RequestForQuotation  $requestForQuotation
     * @return \Illuminate\Http\Response
     */
    public function show(RequestForQuotation $requestForQuotation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RequestForQuotation  $requestForQuotation
     * @return \Illuminate\Http\Response
     */
    public function edit(RequestForQuotation $requestForQuotation, $id)
    {
    		$data = RequestForQuotation::where('id',$id)->get();
    		foreach ($data as $requestForQuotation) {
        	return view('rfq.edit',compact('requestForQuotation'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RequestForQuotation  $requestForQuotation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    		$request->validate([
            'item_name' => 'required',
            'quantity' => 'required',
            'description' => 'required',
        ]);

    		$data = array(
    				'item_name' => $request->item_name,
    				'quantity'  => $request->quantity,
    				'description' => $request->description
    		);

        RequestForQuotation::where('id',$id)->update($data);
  			return redirect()->route('rfq.index')->with('success','Your RFQ updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RequestForQuotation  $requestForQuotation
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        RequestForQuotation::find($id)->delete();
        return redirect()->route('rfq.index')->with('success','Your RFQ deleted successfully');
    }
}
