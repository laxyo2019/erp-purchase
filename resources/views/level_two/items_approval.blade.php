@extends('layouts.sbadmin2')

@section('content')

<div class="container-fluid">
  <a href="{{ '/home' }}" class="main-title-w3layouts mb-2 float-right"><i class="fa fa-arrow-left"></i>  Back</a>
  <h5 class="main-title-w3layouts mb-2">Request For Items</h5>
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
              <th>Item Requirement</th>
              <th>Item Quantity</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @if (!empty($requested))
              @foreach ($requested as $row)
              <tr>
                <td>{{ ++$i }}</td>
                <td>Users created new request</td>
                <td>{{ count(json_decode($row->requested_data)) }}</td>
                <td>
                	<center>
										<span style="@if($row->level2_status == 0) color:#ff9a00 @elseif($row->level2_status == 1) color:green @elseif($row->level2_status == 2) color:#ff0000 @endif; font-weight: bold">
											@if($row->level2_status == 0) Pending @elseif($row->level2_status == 1) Approve @elseif($row->level2_status == 2) Discard @endif
										</span>
									</center>
                </td>
                <td>
                  <a class="btn btn-primary" href="{{ route('edit_leveltwo_approval', $row->id) }}"><i class="fa fa-eye"></i></a>
                </td>
              </tr>
              @endforeach
            @endif
          </tbody>
        </table>
        {!! $requested->links() !!}
      </div>
    </div>
  </div>
</div>
@endsection