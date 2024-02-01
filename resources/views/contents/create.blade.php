@extends('layouts/top')

@section('bottom')

<form action="{{route('contents.store')}}" method="post">
@csrf
<div class="input-group mb-3">
    <label class="input-group-text" for="inputGroupSelect01">商家</label>
    <select class="form-select" id="inputGroupSelect01" name="company_id">
        <option selected>請選擇店家</option>
        @foreach($companys as $company)
            <option value="{{$company->id}}">{{$company->name}}</option>
        @endforeach
    </select>
</div>
<div class="input-group mb-4">
    <span class="input-group-text">數量</span>
    <input type="number" id="quantity" name="quantity" step=".1" class="form-control" aria-label="數量" maxlength="5" onkeydown="javascript: return event.keyCode == 69 ? false : true"  value="{{old('quantity')}}">
    <span class="input-group-text">價格/斤</span>
    <input type="number" id="price" name="price" step=".1" class="form-control" aria-label="價格/斤" maxlength="5" onkeydown="javascript: return event.keyCode == 69 ? false : true"  value="{{old('price')}}">
    <span class="input-group-text">總價</span>
    <input type="number" id="amount" name="amount" class="form-control" aria-label="總價" value="{{old('amount')}}">
    <span class="input-group-text">內容</span>
    <input type="text" name="content" class="form-control" aria-label="內容"  value="{{old('content')}}">
    <span class="input-group-text">備註</span>
    <input type="text" name="memo" class="form-control" aria-label="備註" value="{{old('memo')}}">
    <a class="btn add" onclick="alertThis();"><i class="bi bi-plus-lg"></i></a>
</div>
<div class="input-group mb-3">
    
</div>
<div class="row">
    <div class="col-auto">
        <span class="form-control-plaintext">日期:</span>
    </div>
    <div class="col-auto">
        <input type="text" id="datepicker" name="up_at" class="form-control" aria-label="日期">
    </div>
</div>
<div class="col-sm-3">
    <button type="submit" class="btn btn-primary mb-3">新增</button>
</div>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
</form>
@endsection

<link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
<script type="text/javascript">
$(document).ready(function () {
    $( "#datepicker" ).datepicker({
        dateFormat: "yy-mm-dd"
    });

    $('#price,#quantity').on('change', function() {
        
        var price = $("#price").val();
        var quantity = $("#quantity").val();
        if( (price.length == 0) || (quantity.length == 0) )
            return false;
        var array = quantity.split(".");
        var amount = 0;
        var amount_decimal = 0;
        amount = parseInt(price) * parseInt(array[0]);
        if(array[1] != undefined )
            amount_decimal = Math.ceil(parseInt(array[1]) * (parseInt(price) / 16));
        $('#amount').val(amount + amount_decimal);
    });


} );

</script>