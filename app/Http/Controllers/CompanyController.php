<?php

namespace App\Http\Controllers;
use Illuminate\Pagination\Paginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Company;
use App\Models\Content;
use Laravel\Ui\Presets\React;

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
        //查詢店家
        $company = Company::find($id);
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

    /**
     * api test
     */
    public function get_all_companies() {
        date_default_timezone_set('Asia/Taipei');
        $companies = Company::where('status', 1)->get();
        return response()->json([
            'companies' => $companies,
            'today' => date("Y-m-d")
        ],200);
    }

    public function get_all_companies_index(){
        $companies = Company::all();
        return response()->json([
            'companies' => $companies
        ],200);
    }

    public function search_companies(Request $request) {
        $search = $request->get('s');
        if($search != null){
            $companies = Company::where('name','LIKE',"%$search%")
                    ->get();
            return response()->json([
                'companies' => $companies
            ],200);
        }else{
            return $this->get_all_companies_index();
        }
    }

    public function show_companyForEdit($id){

        if($id != null){
            $company = Company::find($id);
            return response()->json([
                'company' => $company
            ],200);
        }
    }

    public function create_company(Request $request){
        $formdata = [
            'company' => null,
            'created_at' => time()
               ];

        return response()->json($formdata);
    }

    public function show_companyOrder($id){
        $companyOrder = Company::with('contents','contents.product')->find($id);
        // print_r($companyOrder);
        // exit;
        return response()->json([
            'order' => $companyOrder
        ],200);
    }

    public function show_companyOrder_limit(Request $request){

        $id = $request->get('s');
        $searchYear = $request->get('y');
        $searchMonth = $request->get('m');
        $searchDay = $request->get('d');
        
        
        $companyOrder = Company::with(['contents' => function ($query) use ($searchYear,$searchMonth,$searchDay) {
            if($searchYear){
                $query->whereYear('up_at', $searchYear);
            }
            if($searchMonth){
                $query->whereMonth('up_at', $searchMonth);
            }
            if($searchDay){
                $query->whereDay('up_at', $searchDay);
            }
            
                    }, 'contents.product'])->find($id);

        // $companyOrder = Company::with('contents','contents.product')->where('id', '=', 2)
        // ->whereHas('contents', function ($query) use ($searchYear){
        //     $query->whereYear('created_at', '=', $searchYear);
        // })
        // ->toSql(); 

        // $companyOrder = Company::where('id', $id)
        // ->with(['contents' => function ($query) use ($searchYear, $searchMonth, $searchDay){
        //     if(!$searchYear){
        //         $query->whereYear('created_at', $searchYear);
        //     }
        //     if(!$searchMonth){
        //         $query->whereYear('created_at', $searchYear);
        //     }
        //     if(!$searchDay){
        //         $query->whereYear('created_at', $searchYear);
        //     }
        // },'contents.product'])->get();

        // print_r($companyOrder->toSql());
        // exit;
        return response()->json([
            'order' => $companyOrder
        ],200);
    }

    function add_company(Request $request){
        // print_r("request" . $request);
        try{
            $companyData['name'] = $request->input('company_name');
            $companyData['created_at'] = time();
            $companyData['updated_at'] = time();
            // print_r($companyData);
            Company::create($companyData);
            return response()->json(['data'=> 'success'], 200);
        }catch(\Exception $e){
            return response()->json(['error'=> $e->getMessage()], $e->getCode());
        }
    }

    function edit_company(Request $request, $id){
        try{
            
            if($request->input('company_status') != 0 && $request->input('company_status') != 1){
                return response()->json(['error'=> 'status fail'], 422);
            }
            // $companyData['updated_at'] = time();
            $company = Company::where('id', $id)->first();
            $company->name = $request->input('company_name');
            $company->status = $request->input('company_status');
            $company->update($request->all());
            // print_r($companyData);
            // Company::where('id', $companyData['id'])->update(['name'=> $companyData['name'], 'status' => $companyData['status']]);
            // Company::find($companyData['id'])->update($companyData);
            return response()->json(['data'=> 'success'], 200);
            
        }catch(\Exception $e){
            return response()->json(['error'=> $e->getMessage()], $e->getCode());
        }
    }
}
