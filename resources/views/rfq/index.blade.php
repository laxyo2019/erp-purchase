@extends('../layouts.sbadmin2')

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">
  <a href="{{ '/home' }}" class="main-title-w3layouts mb-2 float-right"><i class="fa fa-arrow-left"></i>  Back</a>
  <h5 class="main-title-w3layouts mb-2">Vendors Listing</h5>
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
              <th>Firm Name</th>
              <th>Email</th>
              <th>Mobile No.</th>
              <th>Vendor RegNo.</th>
              <th>GST No.</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
          	<?php //dd($rfq); ?>
            @if (!empty($rfq))
              @foreach ($rfq as $row)
              <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $row->firm_name }}</td>
                <td>{{ $row->email }}</td>
                <td>{{ $row->mobile }}</td>
                <td>{{ $row->register_number }}</td>
                <td>{{ $row->gst_number }}</td>
                <td>
                  <form action="{{ route('rfq.destroy',$row->id) }}" method="POST">
                    <a class="btn btn-success" href="{{ route('rfq.show',$row->id) }}"><i class="fa fa-eye" aria-hidden="true"></i></a>
                    <a class="btn btn-primary" href="{{ route('rfq.edit',$row->id) }}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
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
        {!! $rfq->links() !!}
      </div>
    </div>
  </div>
</div>
@endsection