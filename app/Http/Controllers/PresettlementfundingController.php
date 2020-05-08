<?php

namespace App\Http\Controllers;

use App\PreSettlementFunding;
use App\AdminLog;
use Illuminate\Http\Request;

class PreSettlementFundingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $moduleName="Pre Settlement Funding";
    private $sdc;
    public function __construct(){ $this->sdc = new CoreCustomController(); }
    
    public function index(){
        $tabCount=PreSettlementFunding::count();
        if($tabCount==0)
        {
            return redirect(url('presettlementfunding/create'));
        }else{

            $tab=PreSettlementFunding::orderBy('id','DESC')->first();      
        return view('admin.pages.presettlementfunding.presettlementfunding_edit',['dataRow'=>$tab,'edit'=>true]); 
        }
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){


        
        $tabCount=PreSettlementFunding::count();
        if($tabCount==0)
        {            
        return view('admin.pages.presettlementfunding.presettlementfunding_create');
            
        }else{

            $tab=PreSettlementFunding::orderBy('id','DESC')->first();      
        return view('admin.pages.presettlementfunding.presettlementfunding_edit',['dataRow'=>$tab,'edit'=>true]); 
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
                'icon_one'=>'required',
                'icon_two'=>'required',
                'icon_three'=>'required',
                'icon_one_detail'=>'required',
                'icon_two_detail'=>'required',
                'icon_three_detail'=>'required',
                'button_text'=>'required',
                'button_url'=>'required',
                'module_status'=>'required',
        ]);

        $this->SystemAdminLog("Pre Settlement Funding","Save New","Create New");

        

        $filename_presettlementfunding_2='';
        if ($request->hasFile('icon_one')) {
            $img_presettlementfunding = $request->file('icon_one');
            $upload_presettlementfunding = 'upload/presettlementfunding';
            $filename_presettlementfunding_2 = env('APP_NAME').'_'.time() . '.' . $img_presettlementfunding->getClientOriginalExtension();
            $img_presettlementfunding->move($upload_presettlementfunding, $filename_presettlementfunding_2);
        }

                

        $filename_presettlementfunding_3='';
        if ($request->hasFile('icon_two')) {
            $img_presettlementfunding = $request->file('icon_two');
            $upload_presettlementfunding = 'upload/presettlementfunding';
            $filename_presettlementfunding_3 = env('APP_NAME').'_'.time() . '.' . $img_presettlementfunding->getClientOriginalExtension();
            $img_presettlementfunding->move($upload_presettlementfunding, $filename_presettlementfunding_3);
        }

                

        $filename_presettlementfunding_4='';
        if ($request->hasFile('icon_three')) {
            $img_presettlementfunding = $request->file('icon_three');
            $upload_presettlementfunding = 'upload/presettlementfunding';
            $filename_presettlementfunding_4 = env('APP_NAME').'_'.time() . '.' . $img_presettlementfunding->getClientOriginalExtension();
            $img_presettlementfunding->move($upload_presettlementfunding, $filename_presettlementfunding_4);
        }

                
        $tab=new PreSettlementFunding();
        
        $tab->section_title=$request->section_title;
        $tab->section_detail=$request->section_detail;
        $tab->icon_one=$filename_presettlementfunding_2;
        $tab->icon_two=$filename_presettlementfunding_3;
        $tab->icon_three=$filename_presettlementfunding_4;
        $tab->icon_one_detail=$request->icon_one_detail;
        $tab->icon_two_detail=$request->icon_two_detail;
        $tab->icon_three_detail=$request->icon_three_detail;
        $tab->button_text=$request->button_text;
        $tab->button_url=$request->button_url;
        $tab->module_status=$request->module_status;
        $tab->save();

        return redirect('presettlementfunding')->with('status','Added Successfully !');

    }

    public function ajax(Request $request)
    {
        $this->validate($request,[
                
                'section_title'=>'required',
                'section_detail'=>'required',
                'icon_one'=>'required',
                'icon_two'=>'required',
                'icon_three'=>'required',
                'icon_one_detail'=>'required',
                'icon_two_detail'=>'required',
                'icon_three_detail'=>'required',
                'button_text'=>'required',
                'button_url'=>'required',
                'module_status'=>'required',
        ]);

        $tab=new PreSettlementFunding();
        
        $tab->section_title=$request->section_title;
        $tab->section_detail=$request->section_detail;
        $tab->icon_one=$filename_presettlementfunding_2;
        $tab->icon_two=$filename_presettlementfunding_3;
        $tab->icon_three=$filename_presettlementfunding_4;
        $tab->icon_one_detail=$request->icon_one_detail;
        $tab->icon_two_detail=$request->icon_two_detail;
        $tab->icon_three_detail=$request->icon_three_detail;
        $tab->button_text=$request->button_text;
        $tab->button_url=$request->button_url;
        $tab->module_status=$request->module_status;
        $tab->save();

        echo json_encode(array("status"=>"success","msg"=>"Added Successfully."));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\PreSettlementFunding  $presettlementfunding
     * @return \Illuminate\Http\Response
     */

    private function methodToGetMembersCount($search=""){

        $tab=Customer::select('id','name','address','phone','email','last_invoice_no','created_at')
                     ->where('store_id',$this->sdc->storeID())->orderBy('id','DESC')
                     ->when($search, function ($query) use ($search) {
                        $query->where('id','LIKE','%'.$search.'%');
                            $query->orWhere('section_title','LIKE','%'.$search.'%');
                            $query->orWhere('section_detail','LIKE','%'.$search.'%');
                            $query->orWhere('icon_one','LIKE','%'.$search.'%');
                            $query->orWhere('icon_two','LIKE','%'.$search.'%');
                            $query->orWhere('icon_three','LIKE','%'.$search.'%');
                            $query->orWhere('icon_one_detail','LIKE','%'.$search.'%');
                            $query->orWhere('icon_two_detail','LIKE','%'.$search.'%');
                            $query->orWhere('icon_three_detail','LIKE','%'.$search.'%');
                            $query->orWhere('button_text','LIKE','%'.$search.'%');
                            $query->orWhere('button_url','LIKE','%'.$search.'%');
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
                            $query->orWhere('icon_one','LIKE','%'.$search.'%');
                            $query->orWhere('icon_two','LIKE','%'.$search.'%');
                            $query->orWhere('icon_three','LIKE','%'.$search.'%');
                            $query->orWhere('icon_one_detail','LIKE','%'.$search.'%');
                            $query->orWhere('icon_two_detail','LIKE','%'.$search.'%');
                            $query->orWhere('icon_three_detail','LIKE','%'.$search.'%');
                            $query->orWhere('button_text','LIKE','%'.$search.'%');
                            $query->orWhere('button_url','LIKE','%'.$search.'%');
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

    
    public function PreSettlementFundingQuery($request)
    {
        $PreSettlementFunding_data=PreSettlementFunding::orderBy('id','DESC')->get();

        return $PreSettlementFunding_data;
    }
    
   

    public function ExportExcel(Request $request) 
    {
         $dataDateTimeIns=formatDateTime(date('d-M-Y H:i:s a'));
        $data=array();
        $array_column=array(
                                'ID','Section Title','Section Detail','Icon One','Icon Two','Icon Three','Icon One Detail','Icon Two Detail','Icon Three Detail','Button Text','Button Url','Module Status','Created Date');
        array_push($data, $array_column);
        $inv=$this->PreSettlementFundingQuery($request);
        foreach($inv as $voi):
            $inv_arry=array(
                                $voi->id,$voi->section_title,$voi->section_detail,$voi->icon_one,$voi->icon_two,$voi->icon_three,$voi->icon_one_detail,$voi->icon_two_detail,$voi->icon_three_detail,$voi->button_text,$voi->button_url,$voi->module_status,formatDate($voi->created_at));
            array_push($data, $inv_arry);
        endforeach;

        $excelArray=array(
            'report_name'=>'Pre Settlement Funding Report',
            'report_title'=>'Pre Settlement Funding Report',
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
                        
                            <th class='text-center' style='font-size:12px;' >Icon One</th>
                        
                            <th class='text-center' style='font-size:12px;' >Icon Two</th>
                        
                            <th class='text-center' style='font-size:12px;' >Icon Three</th>
                        
                            <th class='text-center' style='font-size:12px;' >Icon One Detail</th>
                        
                            <th class='text-center' style='font-size:12px;' >Icon Two Detail</th>
                        
                            <th class='text-center' style='font-size:12px;' >Icon Three Detail</th>
                        
                            <th class='text-center' style='font-size:12px;' >Button Text</th>
                        
                            <th class='text-center' style='font-size:12px;' >Button Url</th>
                        
                            <th class='text-center' style='font-size:12px;' >Module Status</th>
                        
                <th class='text-center' style='font-size:12px;'>Created Date</th>
                </tr>
                </thead>
                <tbody>";

                    $inv=$this->PreSettlementFundingQuery($request);
                    foreach($inv as $voi):
                        $html .="<tr>
                        <td style='font-size:12px;' class='text-center'>".$voi->id."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->section_title."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->section_detail."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->icon_one."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->icon_two."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->icon_three."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->icon_one_detail."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->icon_two_detail."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->icon_three_detail."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->button_text."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->button_url."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->module_status."</td>
                        <td style='font-size:12px; text-align:center;' class='text-center'>".formatDate($voi->created_at)."</td>
                        </tr>";

                    endforeach;


                $html .="</tbody>
                
                </table>


                ";

                $this->sdc->PDFLayout('Pre Settlement Funding Report',$html);


    }
    public function show(PreSettlementFunding $presettlementfunding)
    {
        
        $tab=PreSettlementFunding::all();return view('admin.pages.presettlementfunding.presettlementfunding_list',['dataRow'=>$tab]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\PreSettlementFunding  $presettlementfunding
     * @return \Illuminate\Http\Response
     */
    public function edit(PreSettlementFunding $presettlementfunding,$id=0)
    {
        $tab=PreSettlementFunding::find($id);      
        return view('admin.pages.presettlementfunding.presettlementfunding_edit',['dataRow'=>$tab,'edit'=>true]);  
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PreSettlementFunding  $presettlementfunding
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PreSettlementFunding $presettlementfunding,$id=0)
    {
        $this->validate($request,[
                
                'section_title'=>'required',
                'section_detail'=>'required',
                'icon_one_detail'=>'required',
                'icon_two_detail'=>'required',
                'icon_three_detail'=>'required',
                'button_text'=>'required',
                'button_url'=>'required',
                'module_status'=>'required',
        ]);

        $this->SystemAdminLog("Pre Settlement Funding","Update","Edit / Modify");

        

        $filename_presettlementfunding_2=$request->ex_icon_one;
        if ($request->hasFile('icon_one')) {
            $img_presettlementfunding = $request->file('icon_one');
            $upload_presettlementfunding = 'upload/presettlementfunding';
            $filename_presettlementfunding_2 = env('APP_NAME').'_'.time() . '.' . $img_presettlementfunding->getClientOriginalExtension();
            $img_presettlementfunding->move($upload_presettlementfunding, $filename_presettlementfunding_2);
        }

                

        $filename_presettlementfunding_3=$request->ex_icon_two;
        if ($request->hasFile('icon_two')) {
            $img_presettlementfunding = $request->file('icon_two');
            $upload_presettlementfunding = 'upload/presettlementfunding';
            $filename_presettlementfunding_3 = env('APP_NAME').'_'.time() . '.' . $img_presettlementfunding->getClientOriginalExtension();
            $img_presettlementfunding->move($upload_presettlementfunding, $filename_presettlementfunding_3);
        }

                

        $filename_presettlementfunding_4=$request->ex_icon_three;
        if ($request->hasFile('icon_three')) {
            $img_presettlementfunding = $request->file('icon_three');
            $upload_presettlementfunding = 'upload/presettlementfunding';
            $filename_presettlementfunding_4 = env('APP_NAME').'_'.time() . '.' . $img_presettlementfunding->getClientOriginalExtension();
            $img_presettlementfunding->move($upload_presettlementfunding, $filename_presettlementfunding_4);
        }

                
        $tab=PreSettlementFunding::find($id);
        
        $tab->section_title=$request->section_title;
        $tab->section_detail=$request->section_detail;
        $tab->icon_one=$filename_presettlementfunding_2;
        $tab->icon_two=$filename_presettlementfunding_3;
        $tab->icon_three=$filename_presettlementfunding_4;
        $tab->icon_one_detail=$request->icon_one_detail;
        $tab->icon_two_detail=$request->icon_two_detail;
        $tab->icon_three_detail=$request->icon_three_detail;
        $tab->button_text=$request->button_text;
        $tab->button_url=$request->button_url;
        $tab->module_status=$request->module_status;
        $tab->save();

        return redirect('presettlementfunding')->with('status','Updated Successfully !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\PreSettlementFunding  $presettlementfunding
     * @return \Illuminate\Http\Response
     */
    public function destroy(PreSettlementFunding $presettlementfunding,$id=0)
    {
        $this->SystemAdminLog("Pre Settlement Funding","Destroy","Delete");

        $tab=PreSettlementFunding::find($id);
        $tab->delete();
        return redirect('presettlementfunding')->with('status','Deleted Successfully !');}
}
