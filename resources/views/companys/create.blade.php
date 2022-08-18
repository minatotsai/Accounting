@extends('layouts/top')

@section('bottom')

<form action="{{route('companys.store')}}" method="post">
@csrf
<div class="mb-3 row">
    <label for="staticEmail" class="col-sm-2 col-form-label">請輸入店家名稱</label>
    <div class="col-sm-3">
        <input type="text" class="form-control" id="company" name="name" value="{{old('name')}}" placeholder="">
    </div>
    <div class="col-sm-3">
        <button type="submit" class="btn btn-primary mb-3">新增</button>
    </div>
</div>
@if ($errors->has('name'))
    <div class="alert alert-danger">
        <span class="text">{{ $errors->first('name') }}</span>
    </div>
@endif
</form>
@endsection