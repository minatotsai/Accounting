@extends('layouts/left')

@section('right')
<form action="{{route('companys.update', $company)}}" method="post">
@csrf
@method('patch')
<div class="form-group">
    <label for="formGroupExampleInput">店家名稱</label>
    <input type="text" class="form-control" id="name" name="name" value="{{$company->name}}">
</div>
<div class="form-check form-check-inline">
  <input class="form-check-input" type="radio" name="status" id="inlineRadio1" value="1" {{ ($company->status == "1") ? "checked" : "" }}>
  <label class="form-check-label" for="inlineRadio1">開啟</label>
</div>
<div class="form-check form-check-inline">
  <input class="form-check-input" type="radio" name="status" id="inlineRadio2" value="0" {{ ($company->status == "0") ? "checked" : ""}} >
  <label class="form-check-label" for="inlineRadio2">隱藏</label>
</div>
<div class="col-sm-3">
    <button type="submit" class="btn btn-primary mb-3">修改</button>
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