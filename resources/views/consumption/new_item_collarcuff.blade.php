<input type="hidden" name="id_cons_sup" id="id_cons_sup" value="{{$idsup}}">
<div class="row">
    <div class="col-sm-4">
        <div class="col-sm-4 text-right"><small><b>*Unit</b></small></div>
        <div class="col-sm-8">
            <input type="text" class="form-control" onkeyup="keyUp_unit()" name="unit" id="unit" autocomplete="off" required>
            <div id="unitlist"></div>
        </div>
    </div>
    <div class="col-sm-4 mt-lg-1">
        <div class="col-sm-4 text-right"><small><b>*Qty Per Unit</b></small></div>
        <div class="col-sm-8"><input class="form-control kg_per_pcs" type="number" step="0.01"
                name="qty_unit" id="qty_unit" onkeyup="calc();" required>
        </div>
    </div>
    <div class="col-sm-4 mt-lg-1">
        <div class="col-sm-4 text-right"><small><b>*Budget Price</b></small></div>
        <div class="col-sm-8"><input class="form-control" type="number" step="0.01"
                name="budget_price" id="budget_price" required
                onkeyup="calc();">
        </div>
    </div>
    <div class="col-sm-4">
        <div class="col-sm-4 text-right"><small><b>*Color Name</b></small></div>
        <div class="col-sm-8">
            <input type="hidden" id="id_color" name="id_color" required>
            <input type="text" class="form-control" name="color" id="color" onkeyup="keyUpColor()" autocomplete="off" required>
            <div id="colorlist"></div>
        </div>
    </div>
    <div class="col-sm-4 mt-lg-1">
        <div class="col-sm-4 text-right"><small><b>*Total Qty Pcs</b></small></div>
        <div class="col-sm-8"><input class="form-control total_quantity_pcs" type="number" step="0.01"
                name="total_qty_unit_pcs" id="total_qty_unit_pcs" onkeyup="calc();"
                style="background-color: #FFB09F !important;" required>
        </div>
    </div>
    <div class="col-sm-4 mt-lg-1">
        <div class="col-sm-4 text-right"><small><b>*Supplier Price</b></small></div>
        <div class="col-sm-8"><input class="form-control supplier_price" type="number" step="0.01"
                name="supplier_price" id="supplier_price" required 
                onkeyup="calc();">
        </div>
    </div>
    <div class="col-sm-4">
        <div class="col-sm-4 text-right"><small><b>*Total Quantity</b></small></div>
        <div class="col-sm-8"><input class="form-control form-detail-ma" type="number" step="0.01"
                name="total_qty" id="total_qty" onkeyup="calc();" required>
        </div>
    </div>
    <div class="col-sm-4 mt-lg-1">
        <div class="col-sm-4 text-right"><small><b>*Total Qty Unit</b></small></div>
        <div class="col-sm-8"><input class="form-control total_quantity_kg" type="number" step="0.01"
                name="total_qty_unit" id="total_qty_unit" onkeyup="calc();"
                style="background-color: #FFB09F !important;" required>
        </div>
    </div>
    <div class="col-sm-4 mt-lg-1">
        <div class="col-sm-4 text-right"><small><b>*Amount</b></small></div>
        <div class="col-sm-8"><input class="form-control amount" type="number" step="0.01"
                name="amount" id="amount" required 
                style="background-color: #FFB09F !important;" onkeyup="calc();">
        </div>
    </div>
    <div class="col-sm-4 mt-lg-1">
        <div class="col-sm-4 text-right"><small><b>*Tolerance</b></small></div>
        <div class="col-sm-8"><input class="form-control tolerance" type="number" step="0.01"
                name="tole" id="tole" onkeyup="calc();" required>
        </div>
    </div>
    <div class="col-sm-4 mt-lg-1">
        <div class="col-sm-4 text-right"><small><b>Freight Cost</b></small></div>
        <div class="col-sm-8"><input class="form-control freight_cost" type="number" step="0.01"
                name="freight" id="freight" onkeyup="calc();">
        </div>
    </div>
    <div class="col-sm-4 mt-lg-1">
        <div class="col-sm-4 text-right"><small><b>Amount + Freight</b></small></div>
        <div class="col-sm-8"><input class="form-control amount_with_freight" type="number" step="0.01"
                name="amount_freight" id="amount_freight"
                style="background-color: #FFB09F !important;" onkeyup="calc();">
        </div>
    </div>
</div>
<br>
<div class="row">
    <a href="##" class="btn btn-success" onclick="collarcuff_addrow();">Add Size Range</a>
    <table class="table-bordered table-hover  table-responsive">
        <thead>
            <tr>
                <th>Dimension</th>
                <th>Size</th>
                <th>Total</th>
                <th>Total Tolerance</th>
                <th>Total Rounded</th>
                <td>#</td>
            </tr>
        </thead>
        <tbody id="add-size-range-tbody">
            {{-- --------------------------isi size range-------------------------- --}}
        </tbody>
    </table>
</div>

<script type="text/javascript">
    var count = 1;
    // MCP WORKSHEET
    function collarcuff_addrow(){
        count++;
        bariscollarcuff = '<tr>'+
            '<td>'+'<input type="text" name="dimension[]" id="dimension_'+count+'">'+'</td>'+
            '<td>'+'<input type="hidden" id="id_size_'+count+'" name="id_size[]"><input type="text" name="sizeitem[]" id="sizeitem_'+count+'" onkeyup="keyUpSize('+count+')" autocomplete="off"><div id="sizeitemlist_'+count+'"></div>'+'</td>'+
            '<td>'+'<input style="width:100px !important;" type="number" step="0.001" name="total[]" id="total_'+count+'" class="sr-total" onkeyup="calc();">'+'</td required>'+
            '<td bgcolor="green">'+'<input style="width:100px !important;" type="number" step="0.001" name="total_tole[]" id="total_tole_'+count+'" class="sr-total-tol" onkeyup="calc();" required>'+'</td>'+
            '<td bgcolor="green">'+'<input style="width:100px !important;" type="number" step="0.001" name="total_rounded[]" id="total_rounded_'+count+'" class="sr-total-round" onkeyup="calc();" required>'+'</td>'+
            '<td>'+'<center><a href="#" onclick="$(this).parent().parent().parent().remove();calc();">(X)</a>'+'</center></td>' +
        '</tr>'
        $('#add-size-range-tbody').append(bariscollarcuff);
    }

    function keyUpSize(index){
        var query = $('#sizeitem_'+index).val();
        if(query != '')
        {
            var _token = $('input[name="_token"]').val();
            $.ajax({
            url:"{{ route('autocomplete.sizeInTable') }}",
            method:"POST",
            data:{query:query, _token:_token,index:index},
            success:function(data){
                if (data!='') {
                    $('#sizeitemlist_'+index).fadeIn();
                    $('#sizeitemlist_'+index).html(data);
                    } else {
                    $('#sizeitemlist_'+index).fadeOut();
                    $('#sizeitemlist_'+index).empty();
                    $('#sizeitem_'+index).val('');
                    }
                }
            });
        }
    }

    function pilihSizeInTable(ls,index){
        $('#id_size_'+index).val($('#size_id'+ls+'_'+index).text());
        $('#sizeitem_'+index).val($('#size_name'+ls+'_'+index).text());
        $('#sizeitemlist_'+index).fadeOut();
    }

    function keyUp_unit(){
        var query = $('#unit').val();
        if(query != '')
        {
            var _token = $('input[name="_token"]').val();
            $.ajax({
            url:"{{ route('autocomplete.unit') }}",
            method:"POST",
            data:{query:query, _token:_token},
            success:function(data){
                if (data!='') {
                    $('#unitlist').fadeIn();
                    $('#unitlist').html(data);
                    } else {
                    $('#unitlist').fadeOut();
                    $('#unitlist').empty();
                    $('#unit').val('');
                    }
                }
            });
        }
    }

    function pilihUnit(ls){
        $('#unit').val($('#unit_name'+ls).text());
        $('#unitlist').fadeOut();
    }

    function keyUpColor(){
        var query = $('#color').val();
        if(query != '')
        {
            var _token = $('input[name="_token"]').val();
            $.ajax({
            url:"{{ route('autocomplete.color') }}",
            method:"POST",
            data:{query:query, _token:_token},
            success:function(data){
                if (data!='') {
                    $('#colorlist').fadeIn();
                    $('#colorlist').html(data);
                    } else {
                    $('#colorlist').fadeOut();
                    $('#colorlist').empty();
                    $('#color').val('');
                    }
                }
            });
        }
    }

    function pilihColor(ls){
        $('#id_color').val($('#code_col'+ls).text());
        $('#color').val($('#col'+ls).text());
        $('#colorlist').fadeOut();
    }

    function calc(){
        tolerance = parseFloat($('.tolerance').val());
        tolerance = isNaN(tolerance) ? 0 : tolerance;
        $('.sr-total').each(function(){
            sr_total = parseFloat($(this).val());
            sr_total = isNaN(sr_total) ? 0 : sr_total;
            sr_total_tolerance = sr_total + (sr_total * tolerance / 100);
            sr_total_round = Math.ceil(sr_total_tolerance);
            $(this).parents('tr').find('.sr-total-tol').val(sr_total_tolerance);
            $(this).parents('tr').find('.sr-total-round').val(sr_total_round)
        })
        total_quantity_pcs = 0;
        $('.sr-total-round').each(function(){
            v = $(this).val();
            v = isNaN(v) ? 0 : v;
            total_quantity_pcs += parseFloat($(this).val());
        })
        $('.total_quantity_pcs').val(total_quantity_pcs);
        kg_per_pcs = parseFloat($('.kg_per_pcs').val());
        kg_per_pcs = isNaN(kg_per_pcs) ? 0 : kg_per_pcs;
        if (kg_per_pcs == 0){
            total_quantity_kg = 0
            $('.total_quantity_kg').val(total_quantity_kg.toFixed(2));
            supplier_price = parseFloat($('.supplier_price').val());
            supplier_price = isNaN(supplier_price) ? 0 : supplier_price;
            amount = supplier_price * total_quantity_pcs;
            $('.amount').val(amount.toFixed(2));  
        }
        else{
            total_quantity_kg = total_quantity_pcs * kg_per_pcs;
            $('.total_quantity_kg').val(total_quantity_kg.toFixed(2));
            supplier_price = parseFloat($('.supplier_price').val());
            supplier_price = isNaN(supplier_price) ? 0 : supplier_price;
            amount = supplier_price * total_quantity_kg;
            $('.amount').val(amount.toFixed(2));
        }
        
        freight_cost = $(".freight_cost").val();
        amount_with_freight = (amount + (freight_cost * amount) / 100);
        $(".amount_with_freight").val(amount_with_freight.toFixed(2));
    }
</script>