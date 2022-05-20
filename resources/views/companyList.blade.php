@extends('layouts/left')

@section('right')

<div class="top">
<label for="name">請輸入店家名稱</label>
<input type="text" id="name" name="name" size="10">
<input type="button" id="btn" name="insert_btn" value="新增" />
</div>
<hr>

<div class="bottom">
@php
    print_r($query);
@endphp

</div>
@endsection