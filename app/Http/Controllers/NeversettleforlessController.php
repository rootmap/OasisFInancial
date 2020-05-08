<?php

namespace App\Http\Controllers;

use App\NeverSettleForLess;
use App\AdminLog;
use Illuminate\Http\Request;

class NeverSettleForLessController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $moduleName="Never Settle For Less";
    private $sdc;
    public function __construct(){ $this->sdc = new CoreCustomController(); }
    
    public function index(){
        $tabCount=NeverSettleForLess::count();
        if($tabCount==0)
        {
            return redirect(url('neversettleforless/create'));
        }else{

            $tab=NeverSettleForLess::orderBy('id','DESC')->first();      
        return view('admin.pages.neversettleforless.neversettleforless_edit',['dataRow'=>$tab,'edit'=>true]); 
        }
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){


        
        $tabCount=NeverSettleForLess::count();
        if($tabCount==0)
        {            
        return view('admin.pages.neversettleforless.neversettleforless_create');
            
        }else{

            $tab=NeverSettleForLess::orderBy('id','DESC')->first();      
        return view('admin.pages.neversettleforless.neversettleforless_edit',['dataRow'=>$tab,'edit'=>true]); 
        }
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    private function SystemAdminLog($module_name="",$action="",$details=""){
        $tab=new AdminLog();
        $tab->module_name=$module_name;
        $tab->action=$action;
        $tab->details=$details;
        $tab->admin_id=$this->sdc->admin_id();
        $tab->admin_name=$this->sdc->UserName();
        $tab->save();
    }


    public function store(Request $request)
    {
        $this->validate($request,[
                
                'section_title'=>'required',
                'section_detail'=>'required',
                'section_image'=>'required',
                'module_status'=>'required',
        ]);

        $this->SystemAdminLog("Never Settle For Less","Save New","Create New");

        

        $filename_neversettleforless_2='';
        if ($request->hasFile('section_image')) {
            $img_neversettleforless = $request->file('section_image');
            $upload_neversettleforless = 'upload/neversettleforless';
            $filename_neversettleforless_2 = env('APP_NAME').'_'.time() . '.' . $img_neversettleforless->getClientOriginalExtension();
            $img_neversettleforless->move($upload_neversettleforless, $filename_neversettleforless_2);
        }

                
        $tab=new NeverSettleForLess();
        
        $tab->section_title=$request->section_title;
        $tab->section_detail=$request->section_detail;
        $tab->section_image=$filename_neversettleforless_2;
        $tab->module_status=$request->module_status;
        $tab->save();

        return redirect('neversettleforless')->with('status','Added Successfully !');

    }

    public function ajax(Request $request)
    {
        $this->validate($request,[
                
                'section_title'=>'required',
                'section_detail'=>'required',
                'section_image'=>'required',
                'module_status'=>'required',
        ]);

        $tab=new NeverSettleForLess();
        
        $tab->section_title=$request->section_title;
        $tab->section_detail=$request->section_detail;
        $tab->section_image=$filename_neversettleforless_2;
        $tab->module_status=$request->module_status;
        $tab->save();

        echo json_encode(array("status"=>"success","msg"=>"Added Successfully."));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\NeverSettleForLess  $neversettleforless
     * @return \Illuminate\Http\Response
     */

    private function methodToGetMembersCount($search=""){

        $tab=Customer::select('id','name','address','phone','email','last_invoice_no','created_at')
                     ->where('store_id',$this->sdc->storeID())->orderBy('id','DESC')
                     ->when($search, function ($query) use ($search) {
                        $query->where('id','LIKE','%'.$search.'%');
                            $query->orWhere('section_title','LIKE','%'.$search.'%');
                            $query->orWhere('section_detail','LIKE','%'.$search.'%');
                            $query->orWhere('section_image','LIKE','%'.$search.'%');
                            $query->orWhere('module_status','LIKE','%'.$search.'%');
                            $query->orWhere('created_at','LIKE','%'.$search.'%');

                        return $query;
                     })
                     ->count();
        return $tab;
    }


    private function methodToGetMembers($start, $length,$search=''){

        $tab=Customer::select('id','name','address','phone','email','last_invoice_no','created_at')
                     ->where('store_id',$this->sdc->storeID())->orderBy('id','DESC')
                     ->when($search, function ($query) use ($search) {
                        $query->where('id','LIKE','%'.$search.'%');
                            $query->orWhere('section_title','LIKE','%'.$search.'%');
                            $query->orWhere('section_detail','LIKE','%'.$search.'%');
                            $query->orWhere('section_image','LIKE','%'.$search.'%');
                            $query->orWhere('module_status','LIKE','%'.$search.'%');
                            $query->orWhere('created_at','LIKE','%'.$search.'%');

                        return $query;
                     })
                     ->skip($start)->take($length)->get();
        return $tab;
    }

    public function datatable(Request $request){

        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $search = $request->get('search');

        $search = (isset($search['value']))? $search['value'] : '';

        $total_members = $this->methodToGetMembersCount($search); // get your total no of data;
        $members = $this->methodToGetMembers($start, $length,$search); //supply start and length of the table data

        $data = array(
            'draw' => $draw,
            'recordsTotal' => $total_members,
            'recordsFiltered' => $total_members,
            'data' => $members,
        );

        echo json_encode($data);

    }

    
    public function NeverSettleForLessQuery($request)
    {
        $NeverSettleForLess_data=NeverSettleForLess::orderBy('id','DESC')->get();

        return $NeverSettleForLess_data;
    }
    
   

    public function ExportExcel(Request $request) 
    {
         $dataDateTimeIns=formatDateTime(date('d-M-Y H:i:s a'));
        $data=array();
        $array_column=array(
                                'ID','Section Title','Section Detail','Section Image','Module Status','Created Date');
        array_push($data, $array_column);
        $inv=$this->NeverSettleForLessQuery($request);
        foreach($inv as $voi):
            $inv_arry=array(
                                $voi->id,$voi->section_title,$voi->section_detail,$voi->section_image,$voi->module_status,formatDate($voi->created_at));
            array_push($data, $inv_arry);
        endforeach;

        $excelArray=array(
            'report_name'=>'Never Settle For Less Report',
            'report_title'=>'Never Settle For Less Report',
            'report_description'=>'Report Genarated : '.$dataDateTimeIns,
            'data'=>$data
        );

        $this->sdc->ExcelLayout($excelArray);
        
    }

    public function ExportPDF(Request $request)
    {

        $html="<table class='table table-bordered' style='width:100%;'>
                <thead>
                <tr>
                <th class='text-center' style='font-size:12px;'>ID</th>
                            <th class='text-center' style='font-size:12px;' >Section Title</th>
                        
                            <th class='text-center' style='font-size:12px;' >Section Detail</th>
                        
                            <th class='text-center' style='font-size:12px;' >Section Image</th>
                        
                            <th class='text-center' style='font-size:12px;' >Module Status</th>
                        
                <th class='text-center' style='font-size:12px;'>Created Date</th>
                </tr>
                </thead>
                <tbody>";

                    $inv=$this->NeverSettleForLessQuery($request);
                    foreach($inv as $voi):
                        $html .="<tr>
                        <td style='font-size:12px;' class='text-center'>".$voi->id."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->section_title."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->section_detail."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->section_image."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->module_status."</td>
                        <td style='font-size:12px; text-align:center;' class='text-center'>".formatDate($voi->created_at)."</td>
                        </tr>";

                    endforeach;


                $html .="</tbody>
                
                </table>


                ";

                $this->sdc->PDFLayout('Never Settle For Less Report',$html);


    }
    public function show(NeverSettleForLess $neversettleforless)
    {
        
        $tab=NeverSettleForLess::all();return view('admin.pages.neversettleforless.neversettleforless_list',['dataRow'=>$tab]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\NeverSettleForLess  $neversettleforless
     * @return \Illuminate\Http\Response
     */
    public function edit(NeverSettleForLess $neversettleforless,$id=0)
    {
        $tab=NeverSettleForLess::find($id);      
        return view('admin.pages.neversettleforless.neversettleforless_edit',['dataRow'=>$tab,'edit'=>true]);  
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\NeverSettleForLess  $neversettleforless
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, NeverSettleForLess $neversettleforless,$id=0)
    {
        $this->validate($request,[
                
                'section_title'=>'required',
                'section_detail'=>'required',
                'module_status'=>'required',
        ]);

        $this->SystemAdminLog("Never Settle For Less","Update","Edit / Modify");

        

        $filename_neversettleforless_2=$request->ex_section_image;
        if ($request->hasFile('section_image')) {
            $img_neversettleforless = $request->file('section_image');
            $upload_neversettleforless = 'upload/neversettleforless';
            $filename_neversettleforless_2 = env('APP_NAME').'_'.time() . '.' . $img_neversettleforless->getClientOriginalExtension();
            $img_neversettleforless->move($upload_neversettleforless, $filename_neversettleforless_2);
        }

                
        $tab=NeverSettleForLess::find($id);
        
        $tab->section_title=$request->section_title;
        $tab->section_detail=$request->section_detail;
        $tab->section_image=$filename_neversettleforless_2;
        $tab->module_status=$request->module_status;
        $tab->save();

        return redirect('neversettleforless')->with('status','Updated Successfully !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\NeverSettleForLess  $neversettleforless
     * @return \Illuminate\Http\Response
     */
    public function destroy(NeverSettleForLess $neversettleforless,$id=0)
    {
        $this->SystemAdminLog("Never Settle For Less","Destroy","Delete");

        $tab=NeverSettleForLess::find($id);
        $tab->delete();
        return redirect('neversettleforless')->with('status','Deleted Successfully !');}
}
