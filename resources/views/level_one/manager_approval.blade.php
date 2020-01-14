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

        <button class="tablink" onclick="openPage('Home', this, 'red')">Approval from Purchase Manager</button>
				<button class="tablink" onclick="openPage('News', this, 'green')" id="defaultOpen">Request for Purchase Manager</button>

				<div id="Home" class="tabcontent">
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
	            @if (!empty($managerApproval))
	              @foreach ($managerApproval as $row)
	              <tr>
	                <td>{{ ++$i }}</td>
	                <td>User Request approved by managers</td>
	                <td>{{ count(json_decode($row->requested_data)) }}</td>
	                <td>
	                	<center>
											<span style="@if($row->level1_status == 0) color:#ff9a00 @elseif($row->level1_status == 1) color:green @elseif($row->level1_status == 2) color:#ff0000 @endif; font-weight: bold">
												@if($row->level1_status == 0) Pending @elseif($row->level1_status == 1) Approve @elseif($row->level1_status == 2) Discard @endif
											</span>
										</center>
	                </td>
	                <td>
	                  <a class="btn btn-primary" href="{{ route('edit_levelone_approval', $row->id) }}"><i class="fa fa-eye"></i></a>
	                </td>
	              </tr>
	              @endforeach
	            @endif
	          </tbody>
	        </table>
	      </div>
	      <div id="News" class="tabcontent">
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
											<span style="@if($row->level1_status == 0) color:#ff9a00 @elseif($row->level1_status == 1) color:green @elseif($row->level1_status == 2) color:#ff0000 @endif; font-weight: bold">
												@if($row->level1_status == 0) Pending @elseif($row->level1_status == 1) Approve @elseif($row->level1_status == 2) Discard @endif
											</span>
										</center>
	                </td>
	                <td>
	                  <a class="btn btn-primary" href="{{ route('edit_levelone_approval', $row->id) }}"><i class="fa fa-eye"></i></a>
	                </td>
	              </tr>
	              @endforeach
	            @endif
	          </tbody>
	        </table>
				</div>

        {!! $requested->links() !!}
      </div>
    </div>
  </div>
</div>
@endsection
<style>
* {box-sizing: border-box}

/* Set height of body and the document to 100% */
body, html {
  height: 100%;
  margin: 0;
  font-family: Arial;
}

/* Style tab links */
.tablink {
  background-color: #555;
  color: white;
  float: left;
  border: none;
  outline: none;
  cursor: pointer;
  padding: 14px 16px;
  font-size: 17px;
  width: 50%;
}

.tablink:hover {
  background-color: #777;
}

/* Style the tab content (and add height:100% for full page content) */
.tabcontent {
  color: black;
  display: none;
  padding: 100px 20px;
  height: 100%;
}
</style>
<script>
function openPage(pageName,elmnt,color) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablink");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].style.backgroundColor = "";
  }
  document.getElementById(pageName).style.display = "block";
  elmnt.style.backgroundColor = color;
}
document.getElementById("defaultOpen").click();
</script>