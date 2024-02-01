<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Content;
use App\Models\Company;
use Illuminate\Support\Facades\DB;

class ContentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //剛進網頁時
        $content = new Content();
        $year = ($request->year == null) ? 0 : $request->year;
        $month = ($request->month == null) ? 0 : $request->month;
        $content->company_id = ($request->company_id == null) ? 0 : $request->company_id;

        $contents = Content::select('contents.*','companies.name')->join('companies','contents.company_id','=','companies.id');
        $total = DB::table('contents');
        if($year != 0){
            $contents = $contents->whereYear('up_at', $year);
            $total = $total->whereYear('up_at', $year);
        }
        if($month != 0){
            $contents = $contents->whereMonth('up_at',$month);
            $total = $total->whereMonth('up_at',$month);
        } 
        if($content->company_id != 0){
            $contents = $contents->where('company_id', "=" ,$content->company_id);
            $total = $total->where('company_id', "=" ,$content->company_id);
        }
            
        $contents = $contents ->orderBy('up_at','asc')->get();
        $total = $total->whereNull('deleted_at')->sum('amount');
                                                                  
        //查詢所有店家
        $companys = Company::select('id','name')->get();
        //總和值
        return view('contents.list', ['contents'=> $contents,'companys'=> $companys, 'rebackyear' => $year,
                                    'rebackmonth' => $month, 'rebackcompany_id' => $content->company_id, 'total' => $total]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //查詢所有開啟的店家
        $companys = Company::select('id','name')->where('status', '=' , 1)->get();
        return view('contents.create', ['companys'=> $companys]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //驗證
        $content = $request->validate([
            'company_id'=>'required',
            'quantity'=>'required|numeric',
            'price'=>'required|numeric',
            'amount'=>'required|numeric',
            'content'=>'required',
            'up_at'=>'required|date',

        ],[
            'company_id.required' => '商家不得為空!',
            'quantity.required' => '數量不得為空!',
            'price.required' => '斤數不得為空!',
            'amount.required' => '總額不得為空!',
            'content.required' => '內容不得為空!',
            'up_at.required' => '日期不得為空!',
            'quantity.numeric' => '商家名稱不得為空!',
            'price.numeric' => '商家名稱不得為空!',
            'amount.numeric' => '商家名稱不得為空!',
        ]);
        //查詢店家
        $company = Company::find($content["company_id"]);
        //找不到店家回傳錯誤
        if($company == null)
            return redirect()->back()->withErrors(['errors' => '找不到商家',]);
        //新增訂單
        Content::create($content);
        //回傳成功
        return redirect()->route('contents.index')->with('success','新增成功!');
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
        //查詢訂單
        $content = Content::find($id);
        //查詢所有店家
        $companys = Company::select('id','name')->where('status', '=' , 1)->get();
        //回傳欲修改的訂單
        return view('contents.edit',['content'=> $content, 'companys' => $companys]);
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
        //查詢有無此店家
        $company = Company::find($id);
        //進行認證
        $data = $request->validate([
            'company_id'=>'required',
            'quantity'=>'required|numeric',
            'price'=>'required|numeric',
            'amount'=>'required|numeric',
            'content'=>'required',
            'up_at'=>'required|date',

        ],[
            'company_id.required' => '商家不得為空!',
            'quantity.required' => '數量不得為空!',
            'price.required' => '斤數不得為空!',
            'amount.required' => '總額不得為空!',
            'content.required' => '內容不得為空!',
            'up_at.required' => '日期不得為空!',
            'quantity.numeric' => '商家名稱不得為空!',
            'price.numeric' => '商家名稱不得為空!',
            'amount.numeric' => '商家名稱不得為空!',
        ]);
        //查詢店家
        $company = Company::find($data["company_id"]);
        //找不到店家回傳錯誤
        if($company == null)
            return redirect()->back()->withErrors(['errors' => '找不到商家',]);
        $content = Content::find($id);
        //進行資料修改
        $content->update($data);
        //回傳成功
        return redirect()->route('contents.index')->with('success','訂單編號: ' . $content->id .' 修改成功!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $content=Content::find($id);
       $content->delete();
       return redirect()->route('contents.index')->with('success','訂單編號: ' . $content->id .' 已被刪除!');
    }

    /**
     * vue 
     * add content
     */
    public function add_content( Request $request ){
        // $contentData = new Content();
        // $contentData->up_at = $request->input('date');
        // $contentData->memo = $request->input('terms_and_conditions');
        // $contentData->company_id = $request->input('company_id');
        $contentItem = $request->input('items');

        $contentData['up_at'] = $request->input('date');
        $contentData['memo'] = $request->input('terms_and_conditions');
        $contentData['company_id'] = $request->input('company_id');
        date_default_timezone_set('Asia/Taipei');
        $contentData['created_at'] = date("Y-m-d h:i:s");
        $contentData['updated_at'] = date("Y-m-d h:i:s");

        //$content = Content::create($contentData);


        foreach(json_decode($contentItem) as $item){
            // $contentData->price = $item->p_price;
            // $contentData->content = $item->id;
            // $contentData->quantity = $item->quantity;
            // $contentData->amount = $this->amount($contentData->price, $contentData->quantity);
            // $contentData;
            // Content::create($contentData);
            $contentData['price'] = $item->p_price;
            $contentData['content'] = $item->id;
            $contentData['quantity'] = $item->quantity;
            $contentData['amount'] = $this->amount($item->p_price, $item->quantity);
            $query= Content::create($contentData);
            // $query = 0;
            //print_r($contentData);
            if($query){
                return response()->json([
                    'data' => 'success'
                ],200);
            }else{
                return response()->json([
                    'message' => 'fail'
                ],422);
            }
        }

    }

    function amount( int $price, float $quantity){
        return $price * $quantity;
    }

    public function delete_order($id){
        $contentItem = Content::findOrFail($id);
        $contentItem->delete();
    }
}
