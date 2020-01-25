@extends('../layouts.sbadmin2')
@section('content')

<?php 
	$qid = request()->segment('2');
	$QuotationApproval = App\QuotationApprovals::where('quote_id',$qid)->get();
	$count = count($QuotationApproval);
	if($count > 0){
		$AppVendor_id = $QuotationApproval[0]->vendor_id; //App -> approve
		$AppManager_status = $QuotationApproval[0]->manager_status;
		$AppQuote_id = $QuotationApproval[0]->quote_id;
		$AppLevel1 = $QuotationApproval[0]->level1_status;
		$AppLevel2 = $QuotationApproval[0]->level2_status;
	}else{
		$AppVendor_id = '';
		$AppManager_status = '';
		$AppQuote_id = '';
		$AppLevel1 = '';
		$AppLevel2 = '';
	}
?>
<div class="container-fluid">
		<a href="{{ '/rfq' }}" class="main-title-w3layouts mb-2 float-right"><i class="fa fa-arrow-left"></i>  Back</a>
	  <h5 class="main-title-w3layouts mb-2">Received Quotation</h5>
  	<div class="card shadow mb-4">
  		<div class="card-body">
				<div class="table-responsive">
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
				  <div class="col-md-12 wrap">
			    	<div class="row mb-3">
					    <div class="col-md-12">
					    	<button id="numBntAsc" class="btn btn-dark float-right ml-2">Low To High</button>
					    	<button id="numBntDesc" class="btn btn-dark float-right">High To Low</button>
					    </div>
					  </div>

				    <?php 
				  		foreach ($vendor as $key) {	
				  			$row = $key[0];
				  	?>
				  		<div class="row box pt-3 @if($row->id == $AppVendor_id) bg-primary @endif">
						  	<div class="col-md-12">
						  			<div class="col-md-3 float-left leftdiv">
						  				<div class="text-center" style="@if($row->id == $AppVendor_id) color: #fff @else color: black @endif">
						  						<h3>{{ $row->firm_name }}</h3>
						  						<p>{{ $row->name }}</p>
						  						<span class="span1" style="float: left">{{ $data[0]->quotion_id }}</span>
						  						<span class="span2" style="float: right">{{ $row->register_number }}</span>
						  				</div>
						  			</div>
						  			<div class="col-md-7 float-left div-center">
						  				<table class="@if($row->id == $AppVendor_id) table table-borderless @else table @endif" style="@if($row->id == $AppVendor_id) color: #fff; @else color: black @endif">
											  <thead>
											    <tr>
											      <th scope="col">#</th>
											      <th scope="col">Item Name</th>
											      <th scope="col">Qty/Price</th>
											      <th scope="col">Amount</th>
											      <th scope="col">Tax</th>
											      <th scope="col">Total</th>
											    </tr>
											  </thead>
											  <tbody>
											  	<?php 
											  		$n = 1;
											  		$total = 0;
											  		foreach($data as $datas){
											  			$vid = $datas->vender_id; 
											  			if($vid == $row->id){
												  			$val = json_decode($datas->items);
												  			if($n > 0){
											  	?>
											    <tr>
											      <th scope="row">{{ $n }}</th>
											      <td>{{ $val->item_name }}</td>
											      <td>{{ $val->item_quantity }} x {{ $val->item_price }}</td>
											      <td>Rs. {{ $val->item_actual_amount }}</td>
											      <td>{{ $val->item_tax1_rate }}%</td>
											      <td>Rs. {{ $val->item_total_amount }} <?php $total +=$val->item_total_amount; ?></td>
											    </tr>
											    <?php } $n++; } } ?>
											  </tbody>
											</table>
						  			</div>
						  			<div class="col-md-2 div-right ttlamt">
						  				<div class="text-center mt-5" style="@if($row->id == $AppVendor_id) color: #fff @else color: black @endif">
						  						<h3>Total</h3>
						  						<span>Rs. {{$total}}</span>
						  				</div>
						  			</div>
						  	</div>
						  	<div class="col-md-12 mb-3">
						  			<div class="div-border">
						  				<form id="addForm{{ $row->id }}" @if($AppQuote_id == $qid) style="pointer-events:none;" @endif >
						  					@csrf
						  					<table class="table table-bordered" style="@if($row->id == $AppVendor_id) color: #fff; @else color: black; margin-bottom: 0; border:1px solid #000 @endif">
						  							<tr>
							  							<td>
							  								Manager : 
							  								<span style="margin-left: 20px;">
							  									<input type="radio" @if($AppManager_status==1 && $AppVendor_id == $row->id) checked disabled @endif @if($AppVendor_id != $row->id && $AppQuote_id == $qid) disabled @endif name="manager_status" value="1"> Approve
							  								</span> 
							  								<input type="hidden" name="quotion_id" value="{{ $data[0]->quotion_id }}">
							  								<input type="hidden" name="quote_id" value="{{ request()->segment(2) }}">
							  								<input type="hidden" name="vender_id" value="{{ $row->id }}">
							  							</td>
							  							<td>
							  								Level 1 : 
							  								@if($AppManager_status == 1 && $AppVendor_id == $row->id)
							  									@if($AppLevel1 == 1) 
							  										<span style=" color:#38fd38; font-weight: bold">Approved</span> 
							  									@elseif($AppLevel1 == 2)
							  										<span style=" color:#ff9a00; font-weight: bold">Discard</span>
							  									@else
																		------
							  									@endif
							  								@endif
							  							</td>
							  							<td>
							  								Level 2 : 
							  								@if($AppManager_status == 1 && $AppVendor_id == $row->id)
							  									@if($AppLevel2 == 1) 
							  										<span style=" color:#38fd38; font-weight: bold">Approved</span> 
							  									@elseif($AppLevel2 == 2)
							  										<span style=" color:#ff9a00; font-weight: bold">Discard</span>
							  									@else
																		------
							  									@endif
							  								@endif
							  							</td>
							  						</tr>
						  					</table>
						  				</form>
						  			</div>
						  	</div>
					  	</div>
						<?php } ?>
				  </div>
				</div>
			</div>
		</div>
</div>

@endsection
<script src='/themes/sb-admin2/vendor/jquery/jquery.min.js'></script>
<script type="text/javascript">
	$(function(){
    var number = [];
    $('.box').each(function(){
      var numArr = [];
      numArr.push($('.ttlamt', this).text());
      numArr.push($(this));
      number.push(numArr);
      number.sort();
    })
    $('#numBntAsc').on('click', function(){
    	var asc = number.sort();
      $('.box').remove();
      for(var i=0; i<asc.length; i++){
        $('.wrap').append(asc[i][1]);
      }
    })
    $('#numBntDesc').on('click', function(){
    	var rev = number.sort().reverse();
      $('.box').remove();
      for(var i=0; i<number.length; i++){
        $('.wrap').append(rev[i][1]);
      }
    })
  })
</script>
<style>
	.leftdiv{
		height: 200px !important;
		overflow: hidden;
		border: 1px solid black;
	}
	.leftdiv > div{
		padding: 6px;
		margin-top: 36px;
	}
	.leftdiv > .span1{
		font-size: 12px;
	}
	.leftdiv > .span2{
		font-size: 12px;
	}
	.div-center{
		height: 200px !important;
		overflow-x: hidden;
		border: 1px solid black;
	}
	.div-right{
		height: 200px !important;
		overflow: hidden;
		border: 1px solid black;
	}
	.div-border{
		border: 1px solid black;
	}
	.quoteDisabled{
		background-color: #dcdab2;
    opacity: 0.4;
	}
</style>
<?php
	foreach ($vendor as $keys) {
		$rows = $keys[0];
?>
<script>
$(document).ready(function() {
  $("#addForm"+{{ $rows->id }}).on('click', function(e) {
 		e.preventDefault();
 		if(confirm("are you sure you wants to approve this Vendor Quotation"))
 		{
	 		$.ajax({
	        type: 'post',
	        url: '/QuotationApproval',
	        data: $('#addForm'+{{ $rows->id }}).serialize(),
	        success: function(data) {
	          	alert("Quotation Approved");
	          	location.reload();
	        },
	    });
	 	}
	});
});
</script>
<?php } ?>