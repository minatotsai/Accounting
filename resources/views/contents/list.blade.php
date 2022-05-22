@extends('layouts/left')

@section('right')

<div class="top">    
    <a href="{{route('contents.create')}}" class="btn btn-primary">新增訂單</a>   
    @if(session()->has('success'))
    <div class="alert alert-success" role="alert">
        {{session()->get('success')}}
    </div>
    @endif
</div>
<form method="get" action="{{route('contents.index')}}">
    <div class="row g align-items-center" style="padding-top:20px">
        <div class="col-md-2">
            <select class="form-select" aria-label="Default select example" name="year">
                <option value="2022" selected>2022</option>
            </select>
        </div>
        <div class="col-md-2">
            <select class="form-select" aria-label="Default select example" name="month">
                <option value="0" selected>全部</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary">送出</button>
        </div>
    </div>
</form>
<hr>
<div class="bottom">
<table class="table table-hover">
  <thead>
    <tr>
        <th scope="col">訂單編號</th>
        <th scope="col">店家名稱</th>
        <th scope="col">數量</th>
        <th scope="col">價格/斤</th>
        <th scope="col">總價</th>
        <th scope="col">訂單日期</th>
        <th scope="col">內容</th>
        <th scope="col">備註</th>
        <th scope="col">編輯</th>
        <th scope="col">刪除</th>
    </tr>
  </thead>
  <tbody>
    @foreach($contents as $content)
            <tr>
                <td>{{$content->id}}</td>
                <td>{{$content->name}}</td>
                <td>{{$content->quantity}}</td>
                <td>{{$content->price}}</td>
                <td>{{$content->amount}}</td>
                <td>{{$content->up_at}}</td>
                <td>{{$content->content}}</td>
                <td>{{$content->memo}}</td>
                <td><a href="{{route('contents.edit',$content)}}" role="btn" class="btn btn-warning" id="update-btn">編輯</a></td>
                <td>
                    <form action="{{route('contents.destroy',$content)}}" method="post">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-danger">刪除</button>
                    </form>
                </td>
        </tr> 
    @endforeach
      
  </tbody>
  
</table>
</div>

@endsection
