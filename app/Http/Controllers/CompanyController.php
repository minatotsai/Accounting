<?php

namespace App\Http\Controllers;
use Illuminate\Pagination\Paginator;
use Illuminate\Http\Request;
use DB;
use App\Models\Company;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    // 建立AUTH通道
    /*
    public function __construst()
    {
        $this->middleware('auth')->except('index');
        //except->除了,only->只有
    }
    */
    public function index()
    {
        // laravel Query Builder
        // $query = DB::table('companies')->get();
        // return view('companys.list',['query'=>$query]);

        // ORM 方式
        $companies = Company::paginate(10);
        return view('companys.list', ['companies'=> $companies]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('companys.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //進行驗證
        $data = $request->validate([
            'name'=>'required|min:2|max:20|unique:companies'
        ],[
            'name.required' => '商家名稱不得為空!',
            'name.min' => '商家名稱不得少於兩字!',
            'name.max' => '商家名稱不得多於20字!',
            'name.unique' => '商家名稱重複!',
        ]);
        //新增店家
        Company::create($data);
        return redirect()->route('companys.index')->with('success','商家新增成功!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //查詢欲修改的店家
        $company = Company::find($id);
        //回傳
        return view('companys.edit',['company'=> $company]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //驗證
        $data = $request->validate([
            'name'=>'required|min:2|max:20|unique:companies,name,' . $company->id ,
            'status'=>'boolean'
        ],[
            'name.required' => '商家名稱不得為空!',
            'name.min' => '商家名稱不得少於兩字!',
            'name.max' => '商家名稱不得多於20字!',
            'name.unique' => '商家名稱重複!',
            'status.boolean' => '只能為開啟或隱藏!'
        ]);
        //查詢店家
        $company = Company::find($id);
        //進行修改
        $company->update($data);
        //回傳
        return redirect()->route('companys.index')->with('success','商家' . $company->name .'修改成功!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //查詢店家
        $company = Company::find($id);
        //進行刪除
        $company->delete();
        return redirect()->route('companys.index')->with('success','商家' . $company->name .'已被刪除!');
    }
}
