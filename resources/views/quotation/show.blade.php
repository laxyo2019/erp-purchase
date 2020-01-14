@extends('../layouts.sbadmin2')

@section('content')
<div class="table-responsive">
	<a class="float-right" href="{{ route('export_quotation',$quotation->id) }}" title="PDF Download"><i class="fa fa-file-pdf-o" aria-hidden="true" style="font-size: 22px"></i></a>
	@include('quotation.testpdf')
</div>
@endsection