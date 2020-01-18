@extends('../layouts.sbadmin2')

@section('content')
<?php
    $s = substr(str_shuffle(str_repeat("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ", 5)), 0, 10);
?>  
<div class="container-fluid">
    <a href="{{ '/item' }}" class="main-title-w3layouts mb-2 float-right"><i class="fa fa-arrow-left"></i>  Back</a>
    <h5 class="main-title-w3layouts mb-2">Add Item</h5>
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

            <form action="{{ route('item.store') }}" method="post">
                @csrf
                <div class="row">
                    {{-- <div class="form-group col-md-6">
                        <label>Item Number</label>
                        <input type="text" class="form-control" value="{{ $s }}" name="item_number" readonly="">
                    </div> --}}
                    <div class="form-group col-md-12">
                        <label>Add Title</label>
                        <input type="text" class="form-control" placeholder="Add Title" name="title">
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label>Select Category</label>
                        <select name="category_id" id="category" class="form-control">
                            <option disabled="" selected="">Select Category</option>
                            @foreach ($category as $categorys)
                                <option value="{{ $categorys->id }}" data-id="{{ $categorys->id }}">{{ $categorys->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-group col-md-6">
                        <label>Select Subcategory</label>
                        <select name="brand" class="form-control">
                            <option disabled="" selected="">Select Subcategory</option>
                            @foreach ($brand as $brands)
                                <option value="{{ $brands->id }}">{{ $brands->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label>Select Department</label>
                        <select name="department" class="form-control">
                            <option disabled="" selected="">Select Department</option>
                            @foreach ($department as $departments)
                                <option value="{{ $departments->id }}">{{ $departments->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label>Select Unit</label>
                        <select name="unit_id" class="form-control">
                            <option disabled="" selected="">Select Units</option>
                            @foreach ($units as $unit)
                                <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-12">
                        <label>Description</label>
                        <textarea name="description" class="form-control" rows="5" placeholder="Add description"></textarea>
                    </div>
                </div>
                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>
@endsection
