@extends('../layouts.sbadmin2')

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">
  <a href="{{ '/home' }}" class="main-title-w3layouts mb-2 float-right"><i class="fa fa-arrow-left"></i>  Back</a>
  <h5 class="main-title-w3layouts mb-2">RFI's Listing</h5>
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
              <th>Items</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @if (!empty($request_for_items))
            	@foreach($request_for_items as $row)
              <tr>
                <td>{{ ++$i }}</td>
                <td>You are generated new items request</td>
                <td>{{ count(json_decode($row->requested_data)) }}</td>
                <td>
                  <form action="{{ route('request_for_item.destroy',$row->id) }}" method="POST">
                    <a class="btn btn-primary" href="{{ route('request_for_item.edit',$row->id) }}"><i class="fa fa-eye" aria-hidden="true"></i></a>
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
                  </form>
                </td>
              </tr>
              @endforeach
            @endif
          </tbody>
        </table>
        {!! $request_for_items->links() !!}
      </div>
    </div>
  </div>
</div>
@endsection