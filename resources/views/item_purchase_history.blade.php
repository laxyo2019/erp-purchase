@extends('layouts.sbadmin2')

@section('content')

<div class="container-fluid">
  <a href="{{ '/home' }}" class="main-title-w3layouts mb-2 float-right"><i class="fa fa-arrow-left"></i>  Back</a>
  <h5 class="main-title-w3layouts mb-2">Item Purchase History</h5>
  <div class="card shadow mb-4">
    <div class="card-body">
    	<form id="addForm">
        @csrf
        <div class="row">
          <div class="form-group col-md-2"></div>
          <div class="form-group col-md-3">
             	<input class="form-control" type="text" placehoder="Start Date" id="startdate" name="start" placeholder="Start Date" />
          </div>
          <div class="form-group col-md-3">
              <input class="form-control" type="text" placehoder="End Date" id="enddate" name="end" placeholder="End Date" />    
          </div>
          <div class="form-group col-md-4">
            <button type="submit" name="submit" id="addUnit" class="btn btn-primary">Filter</button>
            <button type="button" name="reset" id="reset" class="btn btn-dark">Reset</button>
            {{-- <a class="float-right" href="{{ route('purchase_history_pdf') }}" title="PDF Download"><i class="fa fa-file-pdf-o" aria-hidden="true" style="font-size: 22px"></i></a> --}}
          </div>
        </div>
      </form>
      <br>
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTables" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>S.No</th>
              <th>Invoice Number</th>
              <th>Purchase Item</th>
              <th>Date</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody id="tbody">
            @if (!empty($purchase))
              @foreach ($purchase as $row)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $row->invoice_no }}</td>
                <td><?php $data = json_decode($row->items,true); echo count($data); ?></td>
                <td>{{ date("d-m-Y", strtotime($row->created_at)) }}</td>
                <td>
                	<a class="btn btn-success" href="{{ route('show',$row->id) }}" title="Show">See Invoice</a>
                </td>
              </tr>
              @endforeach
            @endif
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection

<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.5/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
<script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.7.1.min.js"></script>
<script src="http://code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
<script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.0/jquery.dataTables.min.js"></script>

<script>
$(document).ready(function () {
    $.noConflict();
    var table = $('#dataTables').DataTable();
});
</script>
<script type="text/javascript">
$(document).ready(function(){
		$("#startdate, #enddate").datepicker({
			maxDate: 0,
			dateFormat: 'yy/mm/dd',
		});
		$("#enddate").change(function () {
	    var startDate = document.getElementById("startdate").value;
	    var endDate = document.getElementById("enddate").value;
	 
	    if ((Date.parse(endDate) <= Date.parse(startDate))) {
        alert("End date should be greater than Start date");
        document.getElementById("enddate").value = "";
	    }
		});
});
</script>
<script type="text/javascript">
	$(document).ready(function() {
		$("#addForm").on('submit', function(e) {
	    e.preventDefault();
	    var html = [];
	    $.ajax({
	      type: 'post',
	      url: '{{ route("date_filter") }}',
	      data: $('#addForm').serialize(),
	      success: function(data) {
	      	var tst = JSON.parse(data);
	      	$('#tbody').empty();
	      	$.each(tst, function (i) {
	      		var count = JSON.parse(tst[i].items);
	      		var item_counts = Object.keys(count).length;
	      		var ids = tst[i].id;
	      		var sno = i+1;
		      	$('#tbody').append('<tr><td>'+sno+'</td><td>'+tst[i].invoice_no+'</td><td>'+item_counts+'</td><td>'+tst[i].created_at+'</td><td><a class="btn btn-success" href="{{ "unique_invoice" }}/'+ids+'" title="Show">See Invoice</a></td></tr>');
		      	//console.log(tst[i].invoice_no);
					});
	      },
	    });
	  });
	});

	$(document).ready(function(){
	  $("#reset").click(function(){
	    location.reload(true);
	  });
	});
</script>