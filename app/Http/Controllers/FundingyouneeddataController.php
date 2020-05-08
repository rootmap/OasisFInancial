<?php

namespace App\Http\Controllers;

use App\FundingYouNeedData;
use App\AdminLog;
use Illuminate\Http\Request;

class FundingYouNeedDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $moduleName="Funding You Need Data";
    private $sdc;
    public function __construct(){ $this->sdc = new CoreCustomController(); }
    
    public function index(){
        $tab=FundingYouNeedData::all();
        return view('admin.pages.fundingyouneeddata.fundingyouneeddata_list',['dataRow'=>$tab]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){


                   
        return view('admin.pages.fundingyouneeddata.fundingyouneeddata_create');
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
                
                'title'=>'required',
                'detail'=>'required',
                'section_image'=>'required',
                'contact_status'=>'required',
        ]);

        $this->SystemAdminLog("Funding You Need Data","Save New","Create New");

        

        $filename_fundingyouneeddata_2='';
        if ($request->hasFile('section_image')) {
            $img_fundingyouneeddata = $request->file('section_image');
            $upload_fundingyouneeddata = 'upload/fundingyouneeddata';
            $filename_fundingyouneeddata_2 = env('APP_NAME').'_'.time() . '.' . $img_fundingyouneeddata->getClientOriginalExtension();
            $img_fundingyouneeddata->move($upload_fundingyouneeddata, $filename_fundingyouneeddata_2);
        }

                
        $tab=new FundingYouNeedData();
        
        $tab->title=$request->title;
        $tab->detail=$request->detail;
        $tab->section_image=$filename_fundingyouneeddata_2;
        $tab->contact_status=$request->contact_status;
        $tab->save();

        return redirect('fundingyouneeddata')->with('status','Added Successfully !');

    }

    public function ajax(Request $request)
    {
        $this->validate($request,[
                
                'title'=>'required',
                'detail'=>'required',
                'section_image'=>'required',
                'contact_status'=>'required',
        ]);

        $tab=new FundingYouNeedData();
        
        $tab->title=$request->title;
        $tab->detail=$request->detail;
        $tab->section_image=$filename_fundingyouneeddata_2;
        $tab->contact_status=$request->contact_status;
        $tab->save();

        echo json_encode(array("status"=>"success","msg"=>"Added Successfully."));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\FundingYouNeedData  $fundingyouneeddata
     * @return \Illuminate\Http\Response
     */

    private function methodToGetMembersCount($search=""){

        $tab=Customer::select('id','name','address','phone','email','last_invoice_no','created_at')
                     ->where('store_id',$this->sdc->storeID())->orderBy('id','DESC')
                     ->when($search, function ($query) use ($search) {
                        $query->where('id','LIKE','%'.$search.'%');
                            $query->orWhere('title','LIKE','%'.$search.'%');
                            $query->orWhere('detail','LIKE','%'.$search.'%');
                            $query->orWhere('section_image','LIKE','%'.$search.'%');
                            $query->orWhere('contact_status','LIKE','%'.$search.'%');
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
                            $query->orWhere('title','LIKE','%'.$search.'%');
                            $query->orWhere('detail','LIKE','%'.$search.'%');
                            $query->orWhere('section_image','LIKE','%'.$search.'%');
                            $query->orWhere('contact_status','LIKE','%'.$search.'%');
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

    
    public function FundingYouNeedDataQuery($request)
    {
        $FundingYouNeedData_data=FundingYouNeedData::orderBy('id','DESC')->get();

        return $FundingYouNeedData_data;
    }
    
   

    public function ExportExcel(Request $request) 
    {
         $dataDateTimeIns=formatDateTime(date('d-M-Y H:i:s a'));
        $data=array();
        $array_column=array(
                                'ID','Title','Detail','Section Image','Contact Status','Created Date');
        array_push($data, $array_column);
        $inv=$this->FundingYouNeedDataQuery($request);
        foreach($inv as $voi):
            $inv_arry=array(
                                $voi->id,$voi->title,$voi->detail,$voi->section_image,$voi->contact_status,formatDate($voi->created_at));
            array_push($data, $inv_arry);
        endforeach;

        $excelArray=array(
            'report_name'=>'Funding You Need Data Report',
            'report_title'=>'Funding You Need Data Report',
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
                            <th class='text-center' style='font-size:12px;' >Title</th>
                        
                            <th class='text-center' style='font-size:12px;' >Detail</th>
                        
                            <th class='text-center' style='font-size:12px;' >Section Image</th>
                        
                            <th class='text-center' style='font-size:12px;' >Contact Status</th>
                        
                <th class='text-center' style='font-size:12px;'>Created Date</th>
                </tr>
                </thead>
                <tbody>";

                    $inv=$this->FundingYouNeedDataQuery($request);
                    foreach($inv as $voi):
                        $html .="<tr>
                        <td style='font-size:12px;' class='text-center'>".$voi->id."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->title."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->detail."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->section_image."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->contact_status."</td>
                        <td style='font-size:12px; text-align:center;' class='text-center'>".formatDate($voi->created_at)."</td>
                        </tr>";

                    endforeach;


                $html .="</tbody>
                
                </table>


                ";

                $this->sdc->PDFLayout('Funding You Need Data Report',$html);


    }
    public function show(FundingYouNeedData $fundingyouneeddata)
    {
        
        $tab=FundingYouNeedData::all();return view('admin.pages.fundingyouneeddata.fundingyouneeddata_list',['dataRow'=>$tab]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\FundingYouNeedData  $fundingyouneeddata
     * @return \Illuminate\Http\Response
     */
    public function edit(FundingYouNeedData $fundingyouneeddata,$id=0)
    {
        $tab=FundingYouNeedData::find($id);      
        return view('admin.pages.fundingyouneeddata.fundingyouneeddata_edit',['dataRow'=>$tab,'edit'=>true]);  
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\FundingYouNeedData  $fundingyouneeddata
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FundingYouNeedData $fundingyouneeddata,$id=0)
    {
        $this->validate($request,[
                
                'title'=>'required',
                'detail'=>'required',
                'contact_status'=>'required',
        ]);

        $this->SystemAdminLog("Funding You Need Data","Update","Edit / Modify");

        

        $filename_fundingyouneeddata_2=$request->ex_section_image;
        if ($request->hasFile('section_image')) {
            $img_fundingyouneeddata = $request->file('section_image');
            $upload_fundingyouneeddata = 'upload/fundingyouneeddata';
            $filename_fundingyouneeddata_2 = env('APP_NAME').'_'.time() . '.' . $img_fundingyouneeddata->getClientOriginalExtension();
            $img_fundingyouneeddata->move($upload_fundingyouneeddata, $filename_fundingyouneeddata_2);
        }

                
        $tab=FundingYouNeedData::find($id);
        
        $tab->title=$request->title;
        $tab->detail=$request->detail;
        $tab->section_image=$filename_fundingyouneeddata_2;
        $tab->contact_status=$request->contact_status;
        $tab->save();

        return redirect('fundingyouneeddata')->with('status','Updated Successfully !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\FundingYouNeedData  $fundingyouneeddata
     * @return \Illuminate\Http\Response
     */
    public function destroy(FundingYouNeedData $fundingyouneeddata,$id=0)
    {
        $this->SystemAdminLog("Funding You Need Data","Destroy","Delete");

        $tab=FundingYouNeedData::find($id);
        $tab->delete();
        return redirect('fundingyouneeddata')->with('status','Deleted Successfully !');}
}
