@extends('../layouts.sbadmin2')

@section('content')
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
		<form action="{{ route('quotation.store') }}" method="post" enctype="multipart/form-data">
    @csrf
	  <table class="table table-bordered">
	    <tr>
	      <td colspan="2" align="center"><h2 style="margin-top:10.5px">Add Quotation</h2></td>
	    </tr>
	    <tr>
	        <td colspan="2">
	          <div class="row">
	          	<div class="col-md-4">
		              <input type="text" name="register_number" id="register_number" class="form-control input-sm" placeholder="Vendor Registered Number" />
	            </div>
	            <div class="col-md-8">
	              <input type="text" name="firm_name" id="firm_name" class="form-control input-sm" placeholder="Enter Firm Name" /><br>
	            </div>
	            <div class="col-md-6">
		            <input type="text" name="name" id="name" class="form-control input-sm" placeholder="Vendor Name" /><br>
	            </div>
	            <div class="col-md-6">
	              <input type="text" name="email" id="email" class="form-control input-sm" placeholder="Email Address" />
	            </div>

	            <div class="col-md-4">
		              <input type="text" name="mobile" id="mobile" class="form-control input-sm" placeholder="Mobile Number" /><br>
	            </div>
	            <div class="col-md-4">
	              <input type="text" name="alt_number" id="alt_number" class="form-control input-sm" placeholder="Alternate Mobile Number" />
	            </div>
	            <div class="col-md-4">
	              <input type="text" name="gst_number" id="gst_number" class="form-control input-sm" placeholder="GST Number" />
	            </div>

	          </div>
	          <br />
	          <table id="invoice-item-table" class="table table-bordered">
	            <tr>
	              <th width="4%">S.No</th>
	              <th width="20%">Item Name</th>
	              <th width="10%">Quantity</th>
	              <th width="10%">Price</th>
	              <th width="10%">Actual Amt.</th>
	              <th width="22.5%" colspan="2">Tax</th>
	              <th width="12.5%" rowspan="2">Total</th>
	              <th width="3%" rowspan="2"></th>
	            </tr>
	            <tr>
	              <th></th>
	              <th></th>
	              <th></th>
	              <th></th>
	              <th></th>
	              <th>Rate (%)</th>
	              <th>Amt.</th>
	            </tr>
	            <tr>
	              <td><span id="sr_no">1</span></td>
	              <td><input type="text" name="item_name[]" id="item_name1" class="form-control input-sm" /></td>
	              <td><input type="number" name="item_quantity[]" id="order_item_quantity1" data-srno="1" class="form-control input-sm order_item_quantity" /></td>
	              <td><input type="text" name="item_price[]" id="order_item_price1" data-srno="1" class="form-control input-sm number_only order_item_price" /></td>
	              <td><input type="text" name="item_actual_amount[]" id="order_item_actual_amount1" data-srno="1" class="form-control input-sm order_item_actual_amount" readonly /></td>
	              <td><input type="text" name="item_tax1_rate[]" id="order_item_tax1_rate1" data-srno="1" class="form-control input-sm number_only order_item_tax1_rate" /></td>
	              <td><input type="text" name="item_tax1_amount[]" id="order_item_tax1_amount1" data-srno="1" readonly class="form-control input-sm order_item_tax1_amount" /></td>
	              <td><input type="text" name="item_total_amount[]" id="order_item_final_amount1" data-srno="1" readonly class="form-control input-sm order_item_final_amount" /></td>
	              <td></td>
	            </tr>
	          </table>
	          <div align="right">
	            <button type="button" name="add_row" id="add_row" class="btn btn-success btn-xs">+</button>
	          </div>
	          <input type="file" name="file">
	        </td>
	      </tr>
	      <tr>
	        <td align="right"><b>Total</td>
	        <td align="right">
	        	<b><span id="final_total_amt"></span></b>
	        	<input type="hidden" name="item_final_amount" id="item_final_amount" />
	      	</td>
	      </tr>
	      <tr>
	        <td colspan="2"></td>
	      </tr>
	      <tr>
	        <td colspan="2" align="center">
	          <input type="hidden" name="total_item" id="total_item" value="1" />
	          <button type="submit" name="submit" id="create_invoice" class="btn btn-info">Create</button>
	        </td>
	      </tr>
	  </table>
	  </form>
	</div>
@endsection
<script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.7.1.min.js"></script>
<script>
$(document).ready(function(){
  var final_total_amt = $('#final_total_amt').text();
  var count = 1;
  
  $(document).on('click', '#add_row', function(){
    count++;
    $('#total_item').val(count);
    var html_code = '';
    html_code += '<tr id="row_id_'+count+'">';
    html_code += '<td><span id="sr_no">'+count+'</span></td>';
    
    html_code += '<td><input type="text" name="item_name[]" id="item_name'+count+'" class="form-control input-sm" /></td>';
    
    html_code += '<td><input type="text" name="item_quantity[]" id="order_item_quantity'+count+'" data-srno="'+count+'" class="form-control input-sm number_only order_item_quantity" /></td>';
    html_code += '<td><input type="text" name="item_price[]" id="order_item_price'+count+'" data-srno="'+count+'" class="form-control input-sm number_only order_item_price" /></td>';
    html_code += '<td><input type="text" name="item_actual_amount[]" id="order_item_actual_amount'+count+'" data-srno="'+count+'" class="form-control input-sm order_item_actual_amount" readonly /></td>';
    
    html_code += '<td><input type="text" name="item_tax1_rate[]" id="order_item_tax1_rate'+count+'" data-srno="'+count+'" class="form-control input-sm number_only order_item_tax1_rate" /></td>';
    html_code += '<td><input type="text" name="item_tax1_amount[]" id="order_item_tax1_amount'+count+'" data-srno="'+count+'" readonly class="form-control input-sm order_item_tax1_amount" /></td>';
    html_code += '<td><input type="text" name="item_total_amount[]" id="order_item_final_amount'+count+'" data-srno="'+count+'" readonly class="form-control input-sm order_item_final_amount" /></td>';
    html_code += '<td><button type="button" name="remove_row" id="'+count+'" class="btn btn-danger btn-xs remove_row">X</button></td>';
    html_code += '</tr>';
    $('#invoice-item-table').append(html_code);
  });
  
  $(document).on('click', '.remove_row', function(){
    var row_id = $(this).attr("id");
    var total_item_amount = $('#order_item_final_amount'+row_id).val();
    var final_amount = $('#final_total_amt').text();
    var result_amount = parseFloat(final_amount) - parseFloat(total_item_amount);
    $('#final_total_amt').text(result_amount);
    $('#row_id_'+row_id).remove();
    count--;
    $('#total_item').val(count);
  });

  function cal_final_total(count)
  {
    var final_item_total = 0;
    for(j=1; j<=count; j++)
    {
      var quantity = 0;
      var price = 0;
      var actual_amount = 0;
      var tax1_rate = 0;
      var tax1_amount = 0;
      var tax2_rate = 0;
      var tax2_amount = 0;
      var tax3_rate = 0;
      var tax3_amount = 0;
      var item_total = 0;
      quantity = $('#order_item_quantity'+j).val();
      if(quantity > 0)
      {
        price = $('#order_item_price'+j).val();
        if(price > 0)
        {
          actual_amount = parseFloat(quantity) * parseFloat(price);
          $('#order_item_actual_amount'+j).val(actual_amount);
          tax1_rate = $('#order_item_tax1_rate'+j).val();
          if(tax1_rate > 0)
          {
            tax1_amount = parseFloat(actual_amount)*parseFloat(tax1_rate)/100;
            $('#order_item_tax1_amount'+j).val(tax1_amount);
          }
          tax2_rate = $('#order_item_tax2_rate'+j).val();
          if(tax2_rate > 0)
          {
            tax2_amount = parseFloat(actual_amount)*parseFloat(tax2_rate)/100;
            $('#order_item_tax2_amount'+j).val(tax2_amount);
          }
          tax3_rate = $('#order_item_tax3_rate'+j).val();
          if(tax3_rate > 0)
          {
            tax3_amount = parseFloat(actual_amount)*parseFloat(tax3_rate)/100;
            $('#order_item_tax3_amount'+j).val(tax3_amount);
          }
          item_total = parseFloat(actual_amount) + parseFloat(tax1_amount) + parseFloat(tax2_amount) + parseFloat(tax3_amount);
          final_item_total = parseFloat(final_item_total) + parseFloat(item_total);
          $('#order_item_final_amount'+j).val(item_total);
        }
      }
    }
    $('#final_total_amt').text(final_item_total);
    $('#item_final_amount').val(final_item_total);
  }

  $(document).on('blur', '.order_item_price', function(){
    cal_final_total(count);
  });

  $(document).on('blur', '.order_item_tax1_rate', function(){
    cal_final_total(count);
  });

  $(document).on('blur', '.order_item_tax2_rate', function(){
    cal_final_total(count);
  });

  $(document).on('blur', '.order_item_tax3_rate', function(){
    cal_final_total(count);
  });
  
});
</script>