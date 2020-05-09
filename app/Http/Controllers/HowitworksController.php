<?php

namespace App\Http\Controllers;

use App\HowItWorks;
use App\AdminLog;
use Illuminate\Http\Request;

class HowItWorksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $moduleName="How It Works";
    private $sdc;
    public function __construct(){ $this->sdc = new CoreCustomController(); }
    
    public function index(){
        $tabCount=HowItWorks::count();
        if($tabCount==0)
        {
            return redirect(url('howitworks/create'));
        }else{

            $tab=HowItWorks::orderBy('id','DESC')->first();      
        return view('admin.pages.howitworks.howitworks_edit',['dataRow'=>$tab,'edit'=>true]); 
        }
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){


        
        $tabCount=HowItWorks::count();
        if($tabCount==0)
        {            
        return view('admin.pages.howitworks.howitworks_create');
            
        }else{

            $tab=HowItWorks::orderBy('id','DESC')->first();      
        return view('admin.pages.howitworks.howitworks_edit',['dataRow'=>$tab,'edit'=>true]); 
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
                
                'page_title'=>'required',
                'section_title'=>'required',
                'section_detail'=>'required',
                'module_status'=>'required',
        ]);

        $this->SystemAdminLog("How It Works","Save New","Create New");

        

        $filename_howitworks_5='';
        if ($request->hasFile('page_background')) {
            $img_howitworks = $request->file('page_background');
            $upload_howitworks = 'upload/howitworks';
            $filename_howitworks_5 = env('APP_NAME').'_'.time() . '.' . $img_howitworks->getClientOriginalExtension();
            $img_howitworks->move($upload_howitworks, $filename_howitworks_5);
        }

                
        $tab=new HowItWorks();
        
        $tab->page_title=$request->page_title;
        $tab->section_title=$request->section_title;
        $tab->section_detail=$request->section_detail;
        $tab->section_footer_link_text=$request->section_footer_link_text;
        $tab->section_footer_link_url=$request->section_footer_link_url;
        $tab->page_background=$filename_howitworks_5;
        $tab->module_status=$request->module_status;
        $tab->save();

        return redirect('howitworks')->with('status','Added Successfully !');

    }

    public function ajax(Request $request)
    {
        $this->validate($request,[
                
                'page_title'=>'required',
                'section_title'=>'required',
                'section_detail'=>'required',
                'module_status'=>'required',
        ]);

        $tab=new HowItWorks();
        
        $tab->page_title=$request->page_title;
        $tab->section_title=$request->section_title;
        $tab->section_detail=$request->section_detail;
        $tab->section_footer_link_text=$request->section_footer_link_text;
        $tab->section_footer_link_url=$request->section_footer_link_url;
        $tab->page_background=$filename_howitworks_5;
        $tab->module_status=$request->module_status;
        $tab->save();

        echo json_encode(array("status"=>"success","msg"=>"Added Successfully."));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\HowItWorks  $howitworks
     * @return \Illuminate\Http\Response
     */

    private function methodToGetMembersCount($search=""){

        $tab=Customer::select('id','name','address','phone','email','last_invoice_no','created_at')
                     ->where('store_id',$this->sdc->storeID())->orderBy('id','DESC')
                     ->when($search, function ($query) use ($search) {
                        $query->where('id','LIKE','%'.$search.'%');
                            $query->orWhere('page_title','LIKE','%'.$search.'%');
                            $query->orWhere('section_title','LIKE','%'.$search.'%');
                            $query->orWhere('section_detail','LIKE','%'.$search.'%');
                            $query->orWhere('section_footer_link_text','LIKE','%'.$search.'%');
                            $query->orWhere('section_footer_link_url','LIKE','%'.$search.'%');
                            $query->orWhere('page_background','LIKE','%'.$search.'%');
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
                            $query->orWhere('page_title','LIKE','%'.$search.'%');
                            $query->orWhere('section_title','LIKE','%'.$search.'%');
                            $query->orWhere('section_detail','LIKE','%'.$search.'%');
                            $query->orWhere('section_footer_link_text','LIKE','%'.$search.'%');
                            $query->orWhere('section_footer_link_url','LIKE','%'.$search.'%');
                            $query->orWhere('page_background','LIKE','%'.$search.'%');
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

    
    public function HowItWorksQuery($request)
    {
        $HowItWorks_data=HowItWorks::orderBy('id','DESC')->get();

        return $HowItWorks_data;
    }
    
   

    public function ExportExcel(Request $request) 
    {
         $dataDateTimeIns=formatDateTime(date('d-M-Y H:i:s a'));
        $data=array();
        $array_column=array(
                                'ID','Page Title','Section Title','Section Detail','Section Footer Link Text','Section Footer Link URL','Page Background','Module Status','Created Date');
        array_push($data, $array_column);
        $inv=$this->HowItWorksQuery($request);
        foreach($inv as $voi):
            $inv_arry=array(
                                $voi->id,$voi->page_title,$voi->section_title,$voi->section_detail,$voi->section_footer_link_text,$voi->section_footer_link_url,$voi->page_background,$voi->module_status,formatDate($voi->created_at));
            array_push($data, $inv_arry);
        endforeach;

        $excelArray=array(
            'report_name'=>'How It Works Report',
            'report_title'=>'How It Works Report',
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
                            <th class='text-center' style='font-size:12px;' >Page Title</th>
                        
                            <th class='text-center' style='font-size:12px;' >Section Title</th>
                        
                            <th class='text-center' style='font-size:12px;' >Section Detail</th>
                        
                            <th class='text-center' style='font-size:12px;' >Section Footer Link Text</th>
                        
                            <th class='text-center' style='font-size:12px;' >Section Footer Link URL</th>
                        
                            <th class='text-center' style='font-size:12px;' >Page Background</th>
                        
                            <th class='text-center' style='font-size:12px;' >Module Status</th>
                        
                <th class='text-center' style='font-size:12px;'>Created Date</th>
                </tr>
                </thead>
                <tbody>";

                    $inv=$this->HowItWorksQuery($request);
                    foreach($inv as $voi):
                        $html .="<tr>
                        <td style='font-size:12px;' class='text-center'>".$voi->id."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->page_title."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->section_title."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->section_detail."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->section_footer_link_text."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->section_footer_link_url."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->page_background."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->module_status."</td>
                        <td style='font-size:12px; text-align:center;' class='text-center'>".formatDate($voi->created_at)."</td>
                        </tr>";

                    endforeach;


                $html .="</tbody>
                
                </table>


                ";

                $this->sdc->PDFLayout('How It Works Report',$html);


    }
    public function show(HowItWorks $howitworks)
    {
        
        $tab=HowItWorks::all();return view('admin.pages.howitworks.howitworks_list',['dataRow'=>$tab]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\HowItWorks  $howitworks
     * @return \Illuminate\Http\Response
     */
    public function edit(HowItWorks $howitworks,$id=0)
    {
        $tab=HowItWorks::find($id);      
        return view('admin.pages.howitworks.howitworks_edit',['dataRow'=>$tab,'edit'=>true]);  
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\HowItWorks  $howitworks
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HowItWorks $howitworks,$id=0)
    {
        $this->validate($request,[
                
                'page_title'=>'required',
                'section_title'=>'required',
                'section_detail'=>'required',
                'module_status'=>'required',
        ]);

        $this->SystemAdminLog("How It Works","Update","Edit / Modify");

        

        $filename_howitworks_5=$request->ex_page_background;
        if ($request->hasFile('page_background')) {
            $img_howitworks = $request->file('page_background');
            $upload_howitworks = 'upload/howitworks';
            $filename_howitworks_5 = env('APP_NAME').'_'.time() . '.' . $img_howitworks->getClientOriginalExtension();
            $img_howitworks->move($upload_howitworks, $filename_howitworks_5);
        }

                
        $tab=HowItWorks::find($id);
        
        $tab->page_title=$request->page_title;
        $tab->section_title=$request->section_title;
        $tab->section_detail=$request->section_detail;
        $tab->section_footer_link_text=$request->section_footer_link_text;
        $tab->section_footer_link_url=$request->section_footer_link_url;
        $tab->page_background=$filename_howitworks_5;
        $tab->module_status=$request->module_status;
        $tab->save();

        return redirect('howitworks')->with('status','Updated Successfully !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\HowItWorks  $howitworks
     * @return \Illuminate\Http\Response
     */
    public function destroy(HowItWorks $howitworks,$id=0)
    {
        $this->SystemAdminLog("How It Works","Destroy","Delete");

        $tab=HowItWorks::find($id);
        $tab->delete();
        return redirect('howitworks')->with('status','Deleted Successfully !');}
}
