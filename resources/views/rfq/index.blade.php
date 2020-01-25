@extends('../layouts.sbadmin2')

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">
  <a href="{{ '/home' }}" class="main-title-w3layouts mb-2 float-right"><i class="fa fa-arrow-left"></i>  Back</a>
  <h5 class="main-title-w3layouts mb-2">Received Quotation</h5>
  <div class="card shadow mb-4">
    <div class="card-body">
      <div class="table-responsive">
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>S.No</th>
              <th>Quotation Id</th>
              <th>Vendor's Firm Name</th>
              <th>Items Counts</th>
              <th>Manager</th>
              <th>Level 1</th>
              <th>Level 2</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
          	<?php //print_r($data); die; ?>
          		@if (!empty($data))
	              @foreach ($data as $row)
	              <tr>
	                <td>{{ ++$i }}</td>
	                <td>{{ $row->quotion_id }}</td>
	                <td>
	                	<select class="form-control">
	                		@foreach($vendor as $vndr)
												<option>{{ $vndr[0]->firm_name }}</option>
	                		@endforeach
	                	</select>
	                </td>
	                <td>{{ count(json_decode($row->item_list)) }}</td>
	                <td>
	                	@if($row->manager_status == 1) 
	                		<span style=" color:green ; font-weight: bold">Approved</span>
	                	@endif
	                </td>
	                <td>
										@if($row->level1_status == 1) 
	                		<span style=" color:green ; font-weight: bold">Approved</span>
	                	@elseif($row->level1_status == 2)
	                		<span style=" color:#ff9a00; font-weight: bold">Discard</span>
	                	@endif
	                </td>
	                <td>
	                	@if($row->level2_status == 1) 
	                		<span style=" color:green ; font-weight: bold">Approved</span>
	                	@elseif($row->level2_status == 2)
	                		<span style=" color:#ff9a00; font-weight: bold">Discard</span>
	                	@endif
	                </td>
	                <td>
	                  <a class="btn btn-success" href="{{ route('rfq.show',$row->id) }}" title="Sent Quotation"> <i class="fa fa-mail-forward"></i></a>
	                  <a class="btn btn-success" href="{{ route('receivedQuotation',$row->id) }}" title="Received Quotation"><i class="fa fa-mail-reply"></i> </a>
	                </td>
	              </tr>
	              @endforeach
	            @endif
          </tbody>
        </table>
        {!! $rfq->links() !!}
      </div>
    </div>
  </div>
</div>
@endsection