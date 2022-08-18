@extends('layouts/top')

@section('bottom')

<div class="top">
    <a href="{{route('companys.create')}}" class="btn btn-primary">新增店家</a>
    @if(session()->has('success'))
    <div class="alert alert-success" role="alert">
        {{session()->get('success')}}
    </div>
    @endif
</div>
<hr>
<div class="bottom">
<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">店家名稱</th>
      <th scope="col">狀態</th>
      <th scope="col">編輯</th>
      <!-- <th scope="col">刪除</th> -->
    </tr>
  </thead>
  <tbody>
      @foreach($companies as $company)
        <tr>
            <td>{{$company->name}}</td>
            @if( $company->status == "1")
            <td>開啟</td>
            @else
            <td><font color="red">隱藏</td>
            @endif
            <td><a href="{{route('companys.edit',$company)}}" role="btn" class="btn btn-warning" id="update-btn">修改</a></td>
            <!-- <td>
                <form action="{{route('companys.destroy',$company)}}" method="post">
                @csrf
                @method('delete')
                <button type="submit" class="btn btn-danger">刪除</button>
                </form>
            </td> -->
      </tr> 
      @endforeach
      
  </tbody>
  
</table>
{{$companies->links()}}
</div>

@endsection