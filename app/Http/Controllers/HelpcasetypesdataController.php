<?php

namespace App\Http\Controllers;

use App\HelpCaseTypesData;
use App\AdminLog;
use Illuminate\Http\Request;

class HelpCaseTypesDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $moduleName="Help Case Types Data";
    private $sdc;
    public function __construct(){ $this->sdc = new CoreCustomController(); }
    
    public function index(){
        $tab=HelpCaseTypesData::all();
        return view('admin.pages.helpcasetypesdata.helpcasetypesdata_list',['dataRow'=>$tab]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){


                   
        return view('admin.pages.helpcasetypesdata.helpcasetypesdata_create');
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
                'section_image'=>'required',
                'module_status'=>'required',
        ]);

        $this->SystemAdminLog("Help Case Types Data","Save New","Create New");

        

        $filename_helpcasetypesdata_2='';
        if ($request->hasFile('section_image')) {
            $img_helpcasetypesdata = $request->file('section_image');
            $upload_helpcasetypesdata = 'upload/helpcasetypesdata';
            $filename_helpcasetypesdata_2 = env('APP_NAME').'_'.time() . '.' . $img_helpcasetypesdata->getClientOriginalExtension();
            $img_helpcasetypesdata->move($upload_helpcasetypesdata, $filename_helpcasetypesdata_2);
        }

                
        $tab=new HelpCaseTypesData();
        
        $tab->section_title=$request->section_title;
        $tab->section_detail=$request->section_detail;
        $tab->section_image=$filename_helpcasetypesdata_2;
        $tab->module_status=$request->module_status;
        $tab->save();

        return redirect('helpcasetypesdata')->with('status','Added Successfully !');

    }

    public function ajax(Request $request)
    {
        $this->validate($request,[
                
                'section_title'=>'required',
                'section_image'=>'required',
                'module_status'=>'required',
        ]);

        $tab=new HelpCaseTypesData();
        
        $tab->section_title=$request->section_title;
        $tab->section_detail=$request->section_detail;
        $tab->section_image=$filename_helpcasetypesdata_2;
        $tab->module_status=$request->module_status;
        $tab->save();

        echo json_encode(array("status"=>"success","msg"=>"Added Successfully."));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\HelpCaseTypesData  $helpcasetypesdata
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

    
    public function HelpCaseTypesDataQuery($request)
    {
        $HelpCaseTypesData_data=HelpCaseTypesData::orderBy('id','DESC')->get();

        return $HelpCaseTypesData_data;
    }
    
   

    public function ExportExcel(Request $request) 
    {
         $dataDateTimeIns=formatDateTime(date('d-M-Y H:i:s a'));
        $data=array();
        $array_column=array(
                                'ID','Section Title','Section Detail','Section Image','Module Status','Created Date');
        array_push($data, $array_column);
        $inv=$this->HelpCaseTypesDataQuery($request);
        foreach($inv as $voi):
            $inv_arry=array(
                                $voi->id,$voi->section_title,$voi->section_detail,$voi->section_image,$voi->module_status,formatDate($voi->created_at));
            array_push($data, $inv_arry);
        endforeach;

        $excelArray=array(
            'report_name'=>'Help Case Types Data Report',
            'report_title'=>'Help Case Types Data Report',
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

                    $inv=$this->HelpCaseTypesDataQuery($request);
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

                $this->sdc->PDFLayout('Help Case Types Data Report',$html);


    }
    public function show(HelpCaseTypesData $helpcasetypesdata)
    {
        
        $tab=HelpCaseTypesData::all();return view('admin.pages.helpcasetypesdata.helpcasetypesdata_list',['dataRow'=>$tab]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\HelpCaseTypesData  $helpcasetypesdata
     * @return \Illuminate\Http\Response
     */
    public function edit(HelpCaseTypesData $helpcasetypesdata,$id=0)
    {
        $tab=HelpCaseTypesData::find($id);      
        return view('admin.pages.helpcasetypesdata.helpcasetypesdata_edit',['dataRow'=>$tab,'edit'=>true]);  
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\HelpCaseTypesData  $helpcasetypesdata
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HelpCaseTypesData $helpcasetypesdata,$id=0)
    {
        $this->validate($request,[
                
                'section_title'=>'required',
                'module_status'=>'required',
        ]);

        $this->SystemAdminLog("Help Case Types Data","Update","Edit / Modify");

        

        $filename_helpcasetypesdata_2=$request->ex_section_image;
        if ($request->hasFile('section_image')) {
            $img_helpcasetypesdata = $request->file('section_image');
            $upload_helpcasetypesdata = 'upload/helpcasetypesdata';
            $filename_helpcasetypesdata_2 = env('APP_NAME').'_'.time() . '.' . $img_helpcasetypesdata->getClientOriginalExtension();
            $img_helpcasetypesdata->move($upload_helpcasetypesdata, $filename_helpcasetypesdata_2);
        }

                
        $tab=HelpCaseTypesData::find($id);
        
        $tab->section_title=$request->section_title;
        $tab->section_detail=$request->section_detail;
        $tab->section_image=$filename_helpcasetypesdata_2;
        $tab->module_status=$request->module_status;
        $tab->save();

        return redirect('helpcasetypesdata')->with('status','Updated Successfully !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\HelpCaseTypesData  $helpcasetypesdata
     * @return \Illuminate\Http\Response
     */
    public function destroy(HelpCaseTypesData $helpcasetypesdata,$id=0)
    {
        $this->SystemAdminLog("Help Case Types Data","Destroy","Delete");

        $tab=HelpCaseTypesData::find($id);
        $tab->delete();
        return redirect('helpcasetypesdata')->with('status','Deleted Successfully !');}
}
