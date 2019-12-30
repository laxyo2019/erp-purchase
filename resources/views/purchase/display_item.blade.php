<?php //print_r(session('cart')); die; ?>
@if(session('cart'))
@foreach(session('cart') as $id => $purchase)
	<tr>
		<td>{{ $purchase['item_number'] }}</td>
		<td>{{ $purchase['name'] }}</td>
		<td>
			<input id="chngQty{{ $id }}" min="1" type="number" value="{{ $purchase['quantity'] }}" style="width:50px" onchange="myFunction({{ $id }})"> {{-- {{ $purchase['item_name']->unit->name }} --}}
			<input type="hidden" name="purchase_id" id="purchase_id" value="{{ $id }}">
			<img src="https://konferencja.jemi.edu.pl/application-form/web/img/loader.gif" id="loading{{ $id }}" width="30px" class="load-cls" />
		</td>
		<td>
      <form action="{{ route('purchase.destroy',$id) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger" title="Delete"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
      </form>
		</td>
	</tr>
@endforeach
@else
	<tr>
		<td colspan="4"><center>No items in your cart</center></td>
	</tr>
@endif