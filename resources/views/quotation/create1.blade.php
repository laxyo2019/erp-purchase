@extends('../layouts.sbadmin2')

@section('content')
<div class="container-fluid">
    <a href="{{ '/quotation' }}" class="main-title-w3layouts mb-2 float-right"><i class="fa fa-arrow-left"></i>  Back</a>
    <h5 class="main-title-w3layouts mb-2">Add Vendor</h5>
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

            <form action="{{ route('quotation.store') }}" method="post">
                @csrf
                <div class="row">
                    <div class="form-group col-md-6">
                        <label>Registered Vendor Number</label>
                        <input type="text" class="form-control" placeholder="Registered number" name="register_number">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Firm Name</label>
                        <input type="text" class="form-control" placeholder="Firm name...." name="firm_name">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label>Vendor Name</label>
                        <input type="text" class="form-control" placeholder="Name" name="name">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Email</label>
                        <input type="email" class="form-control" placeholder="Email" name="email">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label>Mobile No.</label>
                        <input type="number" class="form-control" placeholder="Mobile Number" name="mobile">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Altername Number</label>
                        <input type="number" class="form-control" placeholder="alternate number" name="alt_number">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                        <label>GST No.</label>
                        <input type="text" class="form-control" placeholder="GST Number" name="gst_number">
                    </div>
                </div>
                <p class="float-right">
                	<a href="#" id="addScnt"><i class="fa fa-plus"></i></a>
                </p>
                <div class="row" id="p_scents">
                    <div id="p_scents_div" class="form-group col-md-12">
                        <label>Add Items</label>
                        <div class="row">
                        	<div class="col-md-6">
                        		<input type="text" class="form-control" placeholder="Name" name="item_name[]">
                        	</div>
                        	<div class="col-md-2">
                        		<input type="text" class="form-control" placeholder="Price" name="item_price[]">
                        	</div>
                        	<div class="col-md-2">
                        		<input type="number" min="1" class="form-control" placeholder="Quantity" name="item_quantity[]">
                        	</div>
                        	<div class="col-md-2">
                        		<input type="text" class="form-control" placeholder="Total" name="item_total[]">
                        	</div>
                        </div>
                    </div>
                </div>
                <button type="submit" name="submit" class="btn btn-primary error-w3l-btn mt-sm-5 mt-3 px-4">Submit</button>
            </form>
        </div>
    </div>
</div>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<script>
	$(function() {
        var scntDiv = $('#p_scents');
        var i = $('#p_scents_div').length + 1;
        
        $('#addScnt').on('click', function() {
            $('<div id="extra_'+i+'" class="form-group col-md-12"><div class="row"><div class="col-md-6"><input type="text" class="form-control" placeholder="Name" name="item_name[]"></div><div class="col-md-2"><input type="text" class="form-control" placeholder="Price" name="item_price[]"></div><div class="col-md-2"><input type="number" min="1" class="form-control" placeholder="Quantity" name="item_quantity[]"></div><div class="col-md-2"><input type="text" class="form-control" placeholder="Total" name="item_total[]"></div></div><p class="float-right" onclick="myFunction('+i+')" id="remScnt"><i class="fa fa-close"></i></p></div>').appendTo(scntDiv);
            i++;
            return false;
        });
	});

	function myFunction(i) {
  		element = document.getElementById("extra_"+i);
    	element.parentNode.removeChild(element);
  }
</script>