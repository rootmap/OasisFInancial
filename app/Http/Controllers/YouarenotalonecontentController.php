<?php

namespace App\Http\Controllers;

use App\YouAreNotAloneContent;
use App\AdminLog;
use Illuminate\Http\Request;

class YouAreNotAloneContentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $moduleName="You Are Not Alone Content";
    private $sdc;
    public function __construct(){ $this->sdc = new CoreCustomController(); }
    
    public function index(){
        $tabCount=YouAreNotAloneContent::count();
        if($tabCount==0)
        {
            return redirect(url('youarenotalonecontent/create'));
        }else{

            $tab=YouAreNotAloneContent::orderBy('id','DESC')->first();      
        return view('admin.pages.youarenotalonecontent.youarenotalonecontent_edit',['dataRow'=>$tab,'edit'=>true]); 
        }
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){


        
        $tabCount=YouAreNotAloneContent::count();
        if($tabCount==0)
        {            
        return view('admin.pages.youarenotalonecontent.youarenotalonecontent_create');
            
        }else{

            $tab=YouAreNotAloneContent::orderBy('id','DESC')->first();      
        return view('admin.pages.youarenotalonecontent.youarenotalonecontent_edit',['dataRow'=>$tab,'edit'=>true]); 
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
                'section_link_text'=>'required',
                'section_link_url'=>'required',
                'module_status'=>'required',
        ]);

        $this->SystemAdminLog("You Are Not Alone Content","Save New","Create New");

        
        $tab=new YouAreNotAloneContent();
        
        $tab->section_title=$request->section_title;
        $tab->section_detail=$request->section_detail;
        $tab->section_link_text=$request->section_link_text;
        $tab->section_link_url=$request->section_link_url;
        $tab->module_status=$request->module_status;
        $tab->save();

        return redirect('youarenotalonecontent')->with('status','Added Successfully !');

    }

    public function ajax(Request $request)
    {
        $this->validate($request,[
                
                'section_title'=>'required',
                'section_detail'=>'required',
                'section_link_text'=>'required',
                'section_link_url'=>'required',
                'module_status'=>'required',
        ]);

        $tab=new YouAreNotAloneContent();
        
        $tab->section_title=$request->section_title;
        $tab->section_detail=$request->section_detail;
        $tab->section_link_text=$request->section_link_text;
        $tab->section_link_url=$request->section_link_url;
        $tab->module_status=$request->module_status;
        $tab->save();

        echo json_encode(array("status"=>"success","msg"=>"Added Successfully."));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\YouAreNotAloneContent  $youarenotalonecontent
     * @return \Illuminate\Http\Response
     */

    private function methodToGetMembersCount($search=""){

        $tab=Customer::select('id','name','address','phone','email','last_invoice_no','created_at')
                     ->where('store_id',$this->sdc->storeID())->orderBy('id','DESC')
                     ->when($search, function ($query) use ($search) {
                        $query->where('id','LIKE','%'.$search.'%');
                            $query->orWhere('section_title','LIKE','%'.$search.'%');
                            $query->orWhere('section_detail','LIKE','%'.$search.'%');
                            $query->orWhere('section_link_text','LIKE','%'.$search.'%');
                            $query->orWhere('section_link_url','LIKE','%'.$search.'%');
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
                            $query->orWhere('section_link_text','LIKE','%'.$search.'%');
                            $query->orWhere('section_link_url','LIKE','%'.$search.'%');
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

    
    public function YouAreNotAloneContentQuery($request)
    {
        $YouAreNotAloneContent_data=YouAreNotAloneContent::orderBy('id','DESC')->get();

        return $YouAreNotAloneContent_data;
    }
    
   

    public function ExportExcel(Request $request) 
    {
         $dataDateTimeIns=formatDateTime(date('d-M-Y H:i:s a'));
        $data=array();
        $array_column=array(
                                'ID','Section Title','Section Detail','Section Link Text','Section Link URL','Module Status','Created Date');
        array_push($data, $array_column);
        $inv=$this->YouAreNotAloneContentQuery($request);
        foreach($inv as $voi):
            $inv_arry=array(
                                $voi->id,$voi->section_title,$voi->section_detail,$voi->section_link_text,$voi->section_link_url,$voi->module_status,formatDate($voi->created_at));
            array_push($data, $inv_arry);
        endforeach;

        $excelArray=array(
            'report_name'=>'You Are Not Alone Content Report',
            'report_title'=>'You Are Not Alone Content Report',
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
                        
                            <th class='text-center' style='font-size:12px;' >Section Link Text</th>
                        
                            <th class='text-center' style='font-size:12px;' >Section Link URL</th>
                        
                            <th class='text-center' style='font-size:12px;' >Module Status</th>
                        
                <th class='text-center' style='font-size:12px;'>Created Date</th>
                </tr>
                </thead>
                <tbody>";

                    $inv=$this->YouAreNotAloneContentQuery($request);
                    foreach($inv as $voi):
                        $html .="<tr>
                        <td style='font-size:12px;' class='text-center'>".$voi->id."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->section_title."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->section_detail."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->section_link_text."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->section_link_url."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->module_status."</td>
                        <td style='font-size:12px; text-align:center;' class='text-center'>".formatDate($voi->created_at)."</td>
                        </tr>";

                    endforeach;


                $html .="</tbody>
                
                </table>


                ";

                $this->sdc->PDFLayout('You Are Not Alone Content Report',$html);


    }
    public function show(YouAreNotAloneContent $youarenotalonecontent)
    {
        
        $tab=YouAreNotAloneContent::all();return view('admin.pages.youarenotalonecontent.youarenotalonecontent_list',['dataRow'=>$tab]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\YouAreNotAloneContent  $youarenotalonecontent
     * @return \Illuminate\Http\Response
     */
    public function edit(YouAreNotAloneContent $youarenotalonecontent,$id=0)
    {
        $tab=YouAreNotAloneContent::find($id);      
        return view('admin.pages.youarenotalonecontent.youarenotalonecontent_edit',['dataRow'=>$tab,'edit'=>true]);  
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\YouAreNotAloneContent  $youarenotalonecontent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, YouAreNotAloneContent $youarenotalonecontent,$id=0)
    {
        $this->validate($request,[
                
                'section_title'=>'required',
                'section_detail'=>'required',
                'section_link_text'=>'required',
                'section_link_url'=>'required',
                'module_status'=>'required',
        ]);

        $this->SystemAdminLog("You Are Not Alone Content","Update","Edit / Modify");

        
        $tab=YouAreNotAloneContent::find($id);
        
        $tab->section_title=$request->section_title;
        $tab->section_detail=$request->section_detail;
        $tab->section_link_text=$request->section_link_text;
        $tab->section_link_url=$request->section_link_url;
        $tab->module_status=$request->module_status;
        $tab->save();

        return redirect('youarenotalonecontent')->with('status','Updated Successfully !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\YouAreNotAloneContent  $youarenotalonecontent
     * @return \Illuminate\Http\Response
     */
    public function destroy(YouAreNotAloneContent $youarenotalonecontent,$id=0)
    {
        $this->SystemAdminLog("You Are Not Alone Content","Destroy","Delete");

        $tab=YouAreNotAloneContent::find($id);
        $tab->delete();
        return redirect('youarenotalonecontent')->with('status','Deleted Successfully !');}
}
