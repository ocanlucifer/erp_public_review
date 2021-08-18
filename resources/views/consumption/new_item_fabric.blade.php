<a href="##" class="btn btn-success" onclick="fabitem_addrow();">Add Item</a>
<br>
<table class="table-bordered table-hover  table-responsive">
	<thead>
		<th>Color</th>
		<th>Total Qty</th>
		<th>Kom</th>
		<th>Width</th>
		<th>W Unit</th>
		<th>Kons. Budget</th>
		<th>Kons. Marker</th>
		<th>Marker Efi</th>
		<th>Qty Unit</th>
		<th>Tol</th>
		<th>Qty Unit Tol</th>
		<th>Qty Sample</th>
		<th>Qty Purc</th>
		<th>Budget Pri</th>
		<th>Sup Price</th>
		<th>Amount</th>
		<th>Freight</th>
		<th>Amount + Freight</th>
		<th>Unit</th>
		<th>#</th>
	</thead>
	<tbody id="fabitem_tbody">
		
	</tbody>
</table>

<script type="text/javascript">
	var count = 1;
    // MCP WORKSHEET
    function fabitem_addrow(){
        count++;
        baris = '<tr>'+
        '<td class="td-input">'+'<input type="hidden" id="id_color_'+count+'" name="id_color[]"><textarea rows="2" name="color[]" id="color_'+count+'" onkeyup="keyUpColor('+count+')" autocomplete="off"></textarea><div id="colorlist_'+count+'"></div>'+'</td>'+
            '<td>'+'<input style="width:40px !important;" onkeyup="calculate('+count+')" type="number" step="0.001" name="total_qty[]" id="total_qty_'+count+'">'+'</td>'+
            '<td>'+'<input type="text" style="width:70px !important;" name="komponen[]" id="komponen_'+count+'">'+'</td>'+
            '<td>'+'<input type="number" step="0.001" style="width:40px !important;" onkeyup="calculate('+count+')" name="width[]" id="width_'+count+'">'+'</td>'+
            '<td>'+'<input type="text" style="width:50px !important;" onkeyup="keyUp_w_unit('+count+')" name="w_unit[]" id="w_unit_'+count+'" autocomplete="off"><div id="w_unitlist_'+count+'"></div>'+'</td>'+
            '<td>'+'<input type="number" step="0.001" style="width:50px !important;" onkeyup="calculate('+count+')" name="kons_budget[]" id="kons_budget_'+count+'">'+'</td>'+
            '<td>'+'<input type="number" step="0.001" style="width:40px !important;" onkeyup="calculate('+count+')" name="kons_marker[]" id="kons_marker_'+count+'" value=0>'+'</td>'+
            '<td>'+'<input type="number" step="0.001" style="width:50px !important;" onkeyup="calculate('+count+')" name="kons_efi[]" id="kons_efi_'+count+'">'+'</td>'+
            '<td bgcolor="green">'+'<input type="number" step="0.001" style="width:60px !important;" onkeyup="calculate('+count+')" name="qty_unit[]" id="qty_unit_'+count+'">'+'</td>'+
            '<td>'+'<input type="number" step="0.001" style="width:30px !important;" onkeyup="calculate('+count+')" name="tole[]" id="tole_'+count+'" value=0>'+'</td>'+
            '<td bgcolor="green">'+'<input type="number" step="0.001" style="width:60px !important;" onkeyup="calculate('+count+')" name="qty_unit_tole[]" id="qty_unit_tole_'+count+'">'+'</td>'+
            '<td>'+'<input type="number" step="0.001" style="width:60px !important;" onkeyup="calculate('+count+')" name="qty_sample[]" id="qty_sample_'+count+'" value=0>'+'</td>'+
            '<td bgcolor="green">'+'<input type="number" step="0.001" style="width:40px !important;" onkeyup="calculate('+count+')" name="qty_purch[]" id="qty_purch_'+count+'">'+'</td>'+
            '<td>'+'<input type="number" step="0.001" style="width:50px !important;" onkeyup="calculate('+count+')" name="budget_price[]" id="budget_price_'+count+'">'+'</td>'+
            '<td>'+'<input type="number" step="0.001" style="width:45px !important;" onkeyup="calculate('+count+')" name="supplier_price[]" id="supplier_price_'+count+'">'+'</td>'+
            '<td bgcolor="green">'+'<input type="number" step="0.001" style="width:45px !important;" onkeyup="calculate('+count+')" name="amount[]" id="amount_'+count+'">'+'</td>'+
            '<td>'+'<input type="number" step="0.001" style="width:45px !important;" onkeyup="calculate('+count+')" name="freight[]" id="freight_'+count+'">'+'</td>'+
            '<td bgcolor="green">'+'<input type="number" step="0.001" style="width:70px !important;" onkeyup="calculate('+count+')" name="amount_freight[]" id="amount_freight_'+count+'">'+'</td>'+
            '<td>'+'<input type="text" style="width:50px !important;" onkeyup="keyUpUnit('+count+')" name="unit[]" id="unit_'+count+'" autocomplete="off"><div id="unitlist_'+count+'"></div>'+'</td>'+
            '<td>'+'<center><a href="#" onclick="$(this).parent().parent().parent().remove();">(X)</a>'+'</center></td>' +
        '</tr>'
        $('#fabitem_tbody').append(baris);
    }

    function keyUpColor(index){
    	var query = $('#color_'+index).val();
        if(query != '')
        {
            var _token = $('input[name="_token"]').val();
            $.ajax({
            url:"{{ route('autocomplete.colorInTable') }}",
            method:"POST",
            data:{query:query, _token:_token,index:index},
            success:function(data){
                if (data!='') {
                    $('#colorlist_'+index).fadeIn();
                    $('#colorlist_'+index).html(data);
                    } else {
                    $('#colorlist_'+index).fadeOut();
                    $('#colorlist_'+index).empty();
                    $('#color_'+index).val('');
                    }
                }
            });
        }
    }

    function pilihColorInTable(ls,index){
        $('#id_color_'+index).val($('#code_col'+ls+'_'+index).text());
        $('#color_'+index).val($('#col'+ls+'_'+index).text());
        $('#colorlist_'+index).fadeOut();
    }

    function keyUpUnit(index){
    	var query = $('#unit_'+index).val();
        if(query != '')
        {
            var _token = $('input[name="_token"]').val();
            $.ajax({
            url:"{{ route('autocomplete.UnitInTable') }}",
            method:"POST",
            data:{query:query, _token:_token,index:index},
            success:function(data){
                if (data!='') {
                    $('#unitlist_'+index).fadeIn();
                    $('#unitlist_'+index).html(data);
                    } else {
                    $('#unitlist_'+index).fadeOut();
                    $('#unitlist_'+index).empty();
                    $('#unit_'+index).val('');
                    }
                }
            });
        }
    }

    function pilihUnitInTable(ls,index){
        $('#unit_'+index).val($('#unit'+ls+'_'+index).text());
        $('#unitlist_'+index).fadeOut();
    }

    function keyUp_w_unit(index){
    	var query = $('#w_unit_'+index).val();
        if(query != '')
        {
            var _token = $('input[name="_token"]').val();
            $.ajax({
            url:"{{ route('autocomplete.wUnitInTable') }}",
            method:"POST",
            data:{query:query, _token:_token,index:index},
            success:function(data){
                if (data!='') {
                    $('#w_unitlist_'+index).fadeIn();
                    $('#w_unitlist_'+index).html(data);
                    } else {
                    $('#w_unitlist_'+index).fadeOut();
                    $('#w_unitlist_'+index).empty();
                    $('#w_unit_'+index).val('');
                    }
                }
            });
        }
    }

    function pilihW_UnitInTable(ls,index){
        $('#w_unit_'+index).val($('#w_unit'+ls+'_'+index).text());
        $('#w_unitlist_'+index).fadeOut();
    }

    function calculate(index) {
    	total_quantity 	= $('#total_qty_'+index).val();
    	width 			= $('#width_'+index).val();
    	kons_budget 	= $('#kons_budget_'+index).val();
    	kons_marker		= $('#kons_marker_'+index).val();
    	kons_efi 		= $('#kons_efi_'+index).val();
    	// qty_unit 		= $('#qty_unit_'+index).val(); //quantity kilogram
    	tole 			= $('#tole_'+index).val();
    	// qty_unit_tole 	= $('#qty_unit_tole_'+index).val(); //quantity kilogram tolerance
    	qty_sample 		= $('#qty_sample_'+index).val();
    	// qty_purch 		= $('#qty_purch_'+index).val(); //qty purchase
    	budget_price 	= $('#budget_price_'+index).val();
    	supplier_price 	= $('#supplier_price_'+index).val();
    	// amount 			= $('#amount_'+index).val(); //amount
    	freight 		= $('#freight_'+index).val();
    	// amount_freight 	= $('#amount_freight_'+index).val(); // amount with fright

    	qty_unit = total_quantity * kons_marker / 12;
	    if(qty_unit < 1)
	     	qty_unit = Math.ceil(qty_unit);
	    else
	      	qty_unit = qty_unit;

	    if(tole > 0)
	      	qty_unit_tole = qty_unit + (qty_unit * tole / 100)
	    else
	      	qty_unit_tole = qty_unit;

	    qty_unit_tole = parseFloat(qty_unit_tole) + parseFloat(qty_sample);

	    rounding_values = qty_unit_tole - Math.floor(qty_unit_tole);
	    if (qty_unit_tole > 1){
      		if (rounding_values >= 0.3){
	      		qty_purch = Math.ceil(qty_unit_tole);
	   		} else {
	      		qty_purch = Math.floor(qty_unit_tole);
	      	}
	    } else {
	      	qty_purch = Math.ceil(qty_unit_tole);
	    }

	    amount = supplier_price * qty_purch;
	    amount_with_freight = amount + ((freight * amount) / 100);

	    $('#qty_purch_'+index).val(qty_purch);
	    $('#qty_unit_'+index).val(qty_unit.toFixed(2));
	    $('#qty_unit_tole_'+index).val(qty_unit_tole.toFixed(2));
	    $('#amount_'+index).val(amount.toFixed(2));
	    $('#amount_freight_'+index).val(amount_with_freight.toFixed(2));
    }
</script>
