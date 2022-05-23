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
        <div class="col-md-3">
            <select class="form-select" id="inputGroupSelect01" name="company_id">
                <option value="0">全部</option>
                @foreach($companys as $company)
                    @if($company->id == $rebackcompany_id)
                        <option value="{{$company->id}}" selected>{{$company->name}}</option>
                    @else
                        <option value="{{$company->id}}">{{$company->name}}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            @php
                $years = array(array("year"=>0,"text"=>"全部"),array("year"=>2022,"text"=>"2022"));
                $months = array(array("month"=>0,"text"=>"全部"),array("month"=>1,"text"=>"1"),
                                array("month"=>2,"text"=>"2"),array("month"=>3,"text"=>"3"),
                                array("month"=>4,"text"=>"4"),array("month"=>5,"text"=>"5"),
                                array("month"=>6,"text"=>"6"),array("month"=>7,"text"=>"7"),
                                array("month"=>8,"text"=>"8"),array("month"=>9,"text"=>"9"),
                                array("month"=>10,"text"=>"10"),array("month"=>11,"text"=>"11"),
                                array("month"=>12,"text"=>"12"))
            @endphp
            <select class="form-select" aria-label="Default select example" name="year">
                @foreach($years as $year)
                    @if($year['year'] == $rebackyear)
                        <option value="{{$year['year']}}" selected>{{$year['text']}}</option>
                    @else
                        <option value="{{$year['year']}}">{{$year['text']}}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <select class="form-select" aria-label="Default select example" name="month">
                @foreach($months as $month)
                    @if($month['month'] == $rebackmonth)
                        <option value="{{$month['month']}}" selected>{{$month['text']}}</option>
                    @else
                        <option value="{{$month['month']}}">{{$month['text']}}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary">送出</button>
        </div>
    </div>
</form>
<hr>
<div class="bottom">
<div class="mb-3">
  <label for="exampleFormControlInput1" class="form-label">總和: {{$total}} 元</label>
</div>
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
