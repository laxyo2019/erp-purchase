@extends('../layouts.sbadmin2')

@section('content')
<div class="container-fluid">
    <a href="{{ '/request_for_item' }}" class="main-title-w3layouts mb-2 float-right"><i class="fa fa-arrow-left"></i>  Back</a>
    <h5 class="main-title-w3layouts mb-2">Update User RFI</h5>
    <div class="card shadow mb-4">
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Warning!</strong> Please check your input code<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
						<?php //print_r($requested[0]->requested_data); die; ?>
            <form action="{{ route('update_leveltwo_approval',$requested[0]->id) }}" method="post">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="form-group col-md-3"></div>
                    <div class="form-group col-md-6">
                        <select class="form-control">
                        	<option disabled="" selected="">Select Vendors</option>
                        	<option value="">JK Super Cement</option>
                        	<option value="">Railways</option>
                        	<option value="">Construction</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3"></div>
                </div>
								<table width="100%" border="1" cellpadding="5" cellspacing="0">
								    <tr>
								     	<td colspan="2" align="center" style="font-size:18px"><b>Request for Quotation</b></td>
								    </tr>
								    <tr>
									    <td colspan="2">
										    <table width="100%" cellpadding="5">
										      <tr>
										        <td width="65%">
										         To,<br />
										         <b></b><br />
										         Name : Laxyo Energy Ltd. <br /> 
										         Email Address : info@laxyo.com<br />
										         Contact No. : 0731-4043798 <br />
										        </td>
										        <td width="35%">
										         Register No. : 0123456789 <br />
										         GST No. : lax1234<br />
										         Date : {{ date("d-m-Y H:i:s") }}<br />
										        </td>
										      </tr>
										    </table>
										    <br />
										    <table class="table table-hover">
										    	<thead>
											      <tr>
											        <th scope="col">Sr No.</th>
											        <th scope="col">Item Name</th>
											        <th scope="col">Quantity</th>
											        <th scope="col">Description</th>
											      </tr>
											    </thead>
											    <tbody>
											      <?php 
											        $m = 0; 
											        foreach($requested as $rows){
											        	$value = json_decode($rows->requested_data);
											        	foreach ($value as $row) {
											        		$m = $m + 1;
											      ?>
										      	<tr>
													    <td>{{ $m }}</td>
													    <td>{{ $row->item_name }}</td>
													    <td>{{ $row->quantity }}</td>
													    <td>{{ $row->description }}</td>
													  </tr>
														<?php } } ?>
													</tbody>
												</table>
									   	</td>
									  </tr>
								</table>
            </form>
        </div>
    </div>
</div>
@endsection