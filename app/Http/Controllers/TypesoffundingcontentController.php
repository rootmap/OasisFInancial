<?php

namespace App\Http\Controllers;

use App\TypesOfFundingContent;
use App\AdminLog;
use Illuminate\Http\Request;

class TypesOfFundingContentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $moduleName="Types Of Funding Content";
    private $sdc;
    public function __construct(){ $this->sdc = new CoreCustomController(); }
    
    public function index(){
        $tabCount=TypesOfFundingContent::count();
        if($tabCount==0)
        {
            return redirect(url('typesoffundingcontent/create'));
        }else{

            $tab=TypesOfFundingContent::orderBy('id','DESC')->first();      
        return view('admin.pages.typesoffundingcontent.typesoffundingcontent_edit',['dataRow'=>$tab,'edit'=>true]); 
        }
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){


        
        $tabCount=TypesOfFundingContent::count();
        if($tabCount==0)
        {            
        return view('admin.pages.typesoffundingcontent.typesoffundingcontent_create');
            
        }else{

            $tab=TypesOfFundingContent::orderBy('id','DESC')->first();      
        return view('admin.pages.typesoffundingcontent.typesoffundingcontent_edit',['dataRow'=>$tab,'edit'=>true]); 
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
                'section_background_image'=>'required',
                'section_detail'=>'required',
                'section_notification_for_call'=>'required',
                'section_footer_detail'=>'required',
                'module_status'=>'required',
        ]);

        $this->SystemAdminLog("Types Of Funding Content","Save New","Create New");

        

        $filename_typesoffundingcontent_1='';
        if ($request->hasFile('section_background_image')) {
            $img_typesoffundingcontent = $request->file('section_background_image');
            $upload_typesoffundingcontent = 'upload/typesoffundingcontent';
            $filename_typesoffundingcontent_1 = env('APP_NAME').'_'.time() . '.' . $img_typesoffundingcontent->getClientOriginalExtension();
            $img_typesoffundingcontent->move($upload_typesoffundingcontent, $filename_typesoffundingcontent_1);
        }

                
        $tab=new TypesOfFundingContent();
        
        $tab->section_title=$request->section_title;
        $tab->section_background_image=$filename_typesoffundingcontent_1;
        $tab->section_detail=$request->section_detail;
        $tab->section_notification_for_call=$request->section_notification_for_call;
        $tab->section_footer_detail=$request->section_footer_detail;
        $tab->module_status=$request->module_status;
        $tab->save();

        return redirect('typesoffundingcontent')->with('status','Added Successfully !');

    }

    public function ajax(Request $request)
    {
        $this->validate($request,[
                
                'section_title'=>'required',
                'section_background_image'=>'required',
                'section_detail'=>'required',
                'section_notification_for_call'=>'required',
                'section_footer_detail'=>'required',
                'module_status'=>'required',
        ]);

        $tab=new TypesOfFundingContent();
        
        $tab->section_title=$request->section_title;
        $tab->section_background_image=$filename_typesoffundingcontent_1;
        $tab->section_detail=$request->section_detail;
        $tab->section_notification_for_call=$request->section_notification_for_call;
        $tab->section_footer_detail=$request->section_footer_detail;
        $tab->module_status=$request->module_status;
        $tab->save();

        echo json_encode(array("status"=>"success","msg"=>"Added Successfully."));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TypesOfFundingContent  $typesoffundingcontent
     * @return \Illuminate\Http\Response
     */

    private function methodToGetMembersCount($search=""){

        $tab=Customer::select('id','name','address','phone','email','last_invoice_no','created_at')
                     ->where('store_id',$this->sdc->storeID())->orderBy('id','DESC')
                     ->when($search, function ($query) use ($search) {
                        $query->where('id','LIKE','%'.$search.'%');
                            $query->orWhere('section_title','LIKE','%'.$search.'%');
                            $query->orWhere('section_background_image','LIKE','%'.$search.'%');
                            $query->orWhere('section_detail','LIKE','%'.$search.'%');
                            $query->orWhere('section_notification_for_call','LIKE','%'.$search.'%');
                            $query->orWhere('section_footer_detail','LIKE','%'.$search.'%');
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
                            $query->orWhere('section_background_image','LIKE','%'.$search.'%');
                            $query->orWhere('section_detail','LIKE','%'.$search.'%');
                            $query->orWhere('section_notification_for_call','LIKE','%'.$search.'%');
                            $query->orWhere('section_footer_detail','LIKE','%'.$search.'%');
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

    
    public function TypesOfFundingContentQuery($request)
    {
        $TypesOfFundingContent_data=TypesOfFundingContent::orderBy('id','DESC')->get();

        return $TypesOfFundingContent_data;
    }
    
   

    public function ExportExcel(Request $request) 
    {
         $dataDateTimeIns=formatDateTime(date('d-M-Y H:i:s a'));
        $data=array();
        $array_column=array(
                                'ID','Section Title','Section Background Image','Section Detail','Section Notification For Call','Section Footer Detail','Module Status','Created Date');
        array_push($data, $array_column);
        $inv=$this->TypesOfFundingContentQuery($request);
        foreach($inv as $voi):
            $inv_arry=array(
                                $voi->id,$voi->section_title,$voi->section_background_image,$voi->section_detail,$voi->section_notification_for_call,$voi->section_footer_detail,$voi->module_status,formatDate($voi->created_at));
            array_push($data, $inv_arry);
        endforeach;

        $excelArray=array(
            'report_name'=>'Types Of Funding Content Report',
            'report_title'=>'Types Of Funding Content Report',
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
                        
                            <th class='text-center' style='font-size:12px;' >Section Background Image</th>
                        
                            <th class='text-center' style='font-size:12px;' >Section Detail</th>
                        
                            <th class='text-center' style='font-size:12px;' >Section Notification For Call</th>
                        
                            <th class='text-center' style='font-size:12px;' >Section Footer Detail</th>
                        
                            <th class='text-center' style='font-size:12px;' >Module Status</th>
                        
                <th class='text-center' style='font-size:12px;'>Created Date</th>
                </tr>
                </thead>
                <tbody>";

                    $inv=$this->TypesOfFundingContentQuery($request);
                    foreach($inv as $voi):
                        $html .="<tr>
                        <td style='font-size:12px;' class='text-center'>".$voi->id."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->section_title."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->section_background_image."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->section_detail."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->section_notification_for_call."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->section_footer_detail."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->module_status."</td>
                        <td style='font-size:12px; text-align:center;' class='text-center'>".formatDate($voi->created_at)."</td>
                        </tr>";

                    endforeach;


                $html .="</tbody>
                
                </table>


                ";

                $this->sdc->PDFLayout('Types Of Funding Content Report',$html);


    }
    public function show(TypesOfFundingContent $typesoffundingcontent)
    {
        
        $tab=TypesOfFundingContent::all();return view('admin.pages.typesoffundingcontent.typesoffundingcontent_list',['dataRow'=>$tab]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\TypesOfFundingContent  $typesoffundingcontent
     * @return \Illuminate\Http\Response
     */
    public function edit(TypesOfFundingContent $typesoffundingcontent,$id=0)
    {
        $tab=TypesOfFundingContent::find($id);      
        return view('admin.pages.typesoffundingcontent.typesoffundingcontent_edit',['dataRow'=>$tab,'edit'=>true]);  
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TypesOfFundingContent  $typesoffundingcontent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TypesOfFundingContent $typesoffundingcontent,$id=0)
    {
        $this->validate($request,[
                
                'section_title'=>'required',
                'section_detail'=>'required',
                'section_notification_for_call'=>'required',
                'section_footer_detail'=>'required',
                'module_status'=>'required',
        ]);

        $this->SystemAdminLog("Types Of Funding Content","Update","Edit / Modify");

        

        $filename_typesoffundingcontent_1=$request->ex_section_background_image;
        if ($request->hasFile('section_background_image')) {
            $img_typesoffundingcontent = $request->file('section_background_image');
            $upload_typesoffundingcontent = 'upload/typesoffundingcontent';
            $filename_typesoffundingcontent_1 = env('APP_NAME').'_'.time() . '.' . $img_typesoffundingcontent->getClientOriginalExtension();
            $img_typesoffundingcontent->move($upload_typesoffundingcontent, $filename_typesoffundingcontent_1);
        }

                
        $tab=TypesOfFundingContent::find($id);
        
        $tab->section_title=$request->section_title;
        $tab->section_background_image=$filename_typesoffundingcontent_1;
        $tab->section_detail=$request->section_detail;
        $tab->section_notification_for_call=$request->section_notification_for_call;
        $tab->section_footer_detail=$request->section_footer_detail;
        $tab->module_status=$request->module_status;
        $tab->save();

        return redirect('typesoffundingcontent')->with('status','Updated Successfully !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TypesOfFundingContent  $typesoffundingcontent
     * @return \Illuminate\Http\Response
     */
    public function destroy(TypesOfFundingContent $typesoffundingcontent,$id=0)
    {
        $this->SystemAdminLog("Types Of Funding Content","Destroy","Delete");

        $tab=TypesOfFundingContent::find($id);
        $tab->delete();
        return redirect('typesoffundingcontent')->with('status','Deleted Successfully !');}
}
