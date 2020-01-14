<?php //print_r($quotation); die; ?>
<table width="100%" border="1" cellpadding="5" cellspacing="0">
    <tr>
     	<td colspan="2" align="center" style="font-size:18px"><b>Vendor Quotation</b></td>
    </tr>
    <tr>
     <td colspan="2">
      <table width="100%" cellpadding="5">
       <tr>
        <td width="65%">
         To,<br />
         <b>{{ $quotation->firm_name }}</b><br />
         Name : {{ $quotation->name }}<br /> 
         Email Address : {{ $quotation->email }}<br />
         Contact No. : {{ $quotation->mobile }} {{ (!empty($quotation->alt_number)) ? ', '.$quotation->alt_number : '' }}  <br />
        </td>
        <td width="35%">
         Register No. : {{ $quotation->register_number }} <br />
         GST No. : {{ $quotation->gst_number }}<br />
         Qotation Date : {{ $quotation->created_at }}<br />
        </td>
       </tr>
      </table>
      <br />
      <table width="100%" border="1" cellpadding="5" cellspacing="0">
       <tr>
        <th>Sr No.</th>
        <th>Item Name</th>
        <th>Quantity</th>
        <th>Price</th>
        <th>Actual Amt.</th>
        <th colspan="2">Tax</th>
        <th rowspan="2">Total</th>
       </tr>
       <tr>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th>Rate (%)</th>
        <th>Amt.</th>
       </tr>
			<?php 
        $m = 0; 
        $sum_item_actual_amount = 0;
        $item_tax_amount = 0;
        foreach($quotation_item as $row){
        	$m = $m + 1;
        	$sum_item_actual_amount += $row['item_actual_amount'];
        	$item_tax_amount += $row['item_tax1_amount'];
      ?>
      <tr>
		    <td>{{ $m }}</td>
		    <td>{{ $row->item_name }}</td>
		    <td>{{ $row->item_quantity }}</td>
		    <td>{{ $row->item_price }}</td>
		    <td>{{ $row->item_actual_amount }}</td>
		    <td>{{ $row->item_tax1_rate }}</td>
		    <td>{{ $row->item_tax1_amount }}</td>
		    <td>{{ $row->item_total_amount }}</td>
		  </tr>
			<?php } ?>
		  <tr>
		   <td align="right" colspan="7"><b>Total</b></td>
		   <td align="right"><b>{{ $quotation->item_final_amount }}</b></td>
		  </tr>
		  <tr>
		   <td colspan="7"><b>Total Amt. Before Tax :</b></td>
		   <td align="right">{{ $sum_item_actual_amount }}</td>
		  </tr>
		  <tr>
		   <td colspan="7"><b>Total Tax Amt.  :</b></td>
		   <td align="right">{{ $item_tax_amount }}</td>
		  </tr>
		  <tr>
		   <td colspan="7"><b>Total Amt. After Tax :</b></td>
		   <td align="right">{{ $quotation->item_final_amount }}</td>
		  </tr>
		</table>
     </td>
    </tr>
</table>