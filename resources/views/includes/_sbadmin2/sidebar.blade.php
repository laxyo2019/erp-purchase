<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

  <!-- Sidebar - Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{'/home'}}">
    <div class="sidebar-brand-icon rotate-n-15">
      <i class="fas fa-laugh-wink"></i>
    </div>
    <div class="sidebar-brand-text mx-3">Laxyo <sup>ERP</sup></div>
  </a>

  <!-- Divider -->
  <hr class="sidebar-divider my-0">

  <!-- Nav Item - Dashboard -->
  <li class="nav-item active">
    <a class="nav-link" href="{{'/home'}}">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>Dashboard</span></a>
  </li>

  <!-- Divider -->
  <hr class="sidebar-divider">

  <!-- Heading -->
  <div class="sidebar-heading">
    Interface
  </div>

  <!-- Nav Item - Pages Collapse Menu -->
	
	@hasrole(2)
  {{-- <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse0" aria-expanded="true" aria-controls="collapse0">
      <i class="fas fa-fw fa-lock"></i>
      <span>Roles & Permissions</span>
    </a>
    <div id="collapse0" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <a class="collapse-item" href="{{ '/role' }}">Assign Role</a>
        <a class="collapse-item" href="{{ route('/permission') }}">Assign Permission</a>
      </div>
    </div>
  </li> --}}
	<li class="nav-item">
    <a class="nav-link" href="{{ '/role' }}">
      <i class="fa fa-lock" aria-hidden="true"></i>
      <span>Assign Role</span></a>
  </li>

  <li class="nav-item">
    <a class="nav-link" href="{{ '/members' }}">
      <i class="fa fa-plus" aria-hidden="true"></i>
      <span>Members</span></a>
  </li>

  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
      <i class="fas fa-fw fa-shopping-cart"></i>
      <span>Items</span>
    </a>
    <div id="collapse1" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <a class="collapse-item" href="{{ route('item.create') }}">Create Item</a>
        <a class="collapse-item" href="{{ route('item.index') }}">Items Listing</a>
      </div>
    </div>
  </li>
  
  {{-- <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
      <i class="fas fa-fw fa-cog"></i>
      <span>Vendors</span>
    </a>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <a class="collapse-item" href="{{ route('vendor.create') }}">Create Vendor</a>
        <a class="collapse-item" href="{{ route('vendor.index') }}">Vendor Listing</a>
      </div>
    </div>
  </li> --}}

	{{-- <li class="nav-item">
    <a class="nav-link" href="{{ route('purchase.index') }}">
      <i class="fas fa-fw fa-chart-area"></i>
      <span>Purchase</span></a>
  </li>

  <li class="nav-item">
    <a class="nav-link" href="{{ '/item_purchase_history' }}">
      <i class="fa fa-history" aria-hidden="true"></i>
      <span>Purchase History</span></a>
  </li> --}}

  <!-- Divider -->
  <hr class="sidebar-divider">

  <!-- Heading -->
  <div class="sidebar-heading">Setting</div>
  <li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse2" aria-expanded="true" aria-controls="collapse2">
      <i class="fas fa-fw fa-folder"></i>
      <span>Masters</span>
    </a>
    <div id="collapse2" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <a class="collapse-item" href="{{ '/um' }}">Units of Measurement</a>
        <a class="collapse-item" href="{{ '/category' }}">Items Category</a>
        <!-- <a class="collapse-item" href="{{ '/location' }}">Location</a> -->
        <a class="collapse-item" href="{{ '/department' }}">Department</a>
        <a class="collapse-item" href="{{ '/brand' }}">Brand</a>
      </div>
    </div>
  </li>

  <!-- Divider -->
	@endrole

  @hasrole(4)
	<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
      <i class="fas fa-fw fa-cog"></i>
      <span>Quotations</span>
    </a>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <a class="collapse-item" href="{{ route('quotation.create') }}">Create Quotation</a>
        <a class="collapse-item" href="{{ route('quotation.index') }}">Quotation Listing</a>
      </div>
    </div>
  </li>
  @endrole

  <hr class="sidebar-divider d-none d-md-block">

  <!-- Sidebar Toggler (Sidebar) -->
  <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>

</ul>
<!-- End of Sidebar -->