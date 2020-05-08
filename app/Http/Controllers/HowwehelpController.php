<?php

namespace App\Http\Controllers;

use App\HowWeHelp;
use App\AdminLog;
use Illuminate\Http\Request;

class HowWeHelpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $moduleName="How We Help";
    private $sdc;
    public function __construct(){ $this->sdc = new CoreCustomController(); }
    
    public function index(){
        $tabCount=HowWeHelp::count();
        if($tabCount==0)
        {
            return redirect(url('howwehelp/create'));
        }else{

            $tab=HowWeHelp::orderBy('id','DESC')->first();      
        return view('admin.pages.howwehelp.howwehelp_edit',['dataRow'=>$tab,'edit'=>true]); 
        }
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){


        
        $tabCount=HowWeHelp::count();
        if($tabCount==0)
        {            
        return view('admin.pages.howwehelp.howwehelp_create');
            
        }else{

            $tab=HowWeHelp::orderBy('id','DESC')->first();      
        return view('admin.pages.howwehelp.howwehelp_edit',['dataRow'=>$tab,'edit'=>true]); 
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
                
                'block_heading'=>'required',
                'block_detail'=>'required',
                'item_one_icon'=>'required',
                'item_one_detail'=>'required',
                'item_two_icon'=>'required',
                'item_two_detail'=>'required',
                'item_three_icon'=>'required',
                'item_three_detail'=>'required',
                'item_four_icon'=>'required',
                'item_four_detail'=>'required',
                'module_background'=>'required',
                'module_status'=>'required',
        ]);

        $this->SystemAdminLog("How We Help","Save New","Create New");

        

        $filename_howwehelp_2='';
        if ($request->hasFile('item_one_icon')) {
            $img_howwehelp = $request->file('item_one_icon');
            $upload_howwehelp = 'upload/howwehelp';
            $filename_howwehelp_2 = env('APP_NAME').'_'.time() . '.' . $img_howwehelp->getClientOriginalExtension();
            $img_howwehelp->move($upload_howwehelp, $filename_howwehelp_2);
        }

                

        $filename_howwehelp_4='';
        if ($request->hasFile('item_two_icon')) {
            $img_howwehelp = $request->file('item_two_icon');
            $upload_howwehelp = 'upload/howwehelp';
            $filename_howwehelp_4 = env('APP_NAME').'_'.time() . '.' . $img_howwehelp->getClientOriginalExtension();
            $img_howwehelp->move($upload_howwehelp, $filename_howwehelp_4);
        }

                

        $filename_howwehelp_6='';
        if ($request->hasFile('item_three_icon')) {
            $img_howwehelp = $request->file('item_three_icon');
            $upload_howwehelp = 'upload/howwehelp';
            $filename_howwehelp_6 = env('APP_NAME').'_'.time() . '.' . $img_howwehelp->getClientOriginalExtension();
            $img_howwehelp->move($upload_howwehelp, $filename_howwehelp_6);
        }

                

        $filename_howwehelp_8='';
        if ($request->hasFile('item_four_icon')) {
            $img_howwehelp = $request->file('item_four_icon');
            $upload_howwehelp = 'upload/howwehelp';
            $filename_howwehelp_8 = env('APP_NAME').'_'.time() . '.' . $img_howwehelp->getClientOriginalExtension();
            $img_howwehelp->move($upload_howwehelp, $filename_howwehelp_8);
        }

                

        $filename_howwehelp_10='';
        if ($request->hasFile('module_background')) {
            $img_howwehelp = $request->file('module_background');
            $upload_howwehelp = 'upload/howwehelp';
            $filename_howwehelp_10 = env('APP_NAME').'_'.time() . '.' . $img_howwehelp->getClientOriginalExtension();
            $img_howwehelp->move($upload_howwehelp, $filename_howwehelp_10);
        }

                
        $tab=new HowWeHelp();
        
        $tab->block_heading=$request->block_heading;
        $tab->block_detail=$request->block_detail;
        $tab->item_one_icon=$filename_howwehelp_2;
        $tab->item_one_detail=$request->item_one_detail;
        $tab->item_two_icon=$filename_howwehelp_4;
        $tab->item_two_detail=$request->item_two_detail;
        $tab->item_three_icon=$filename_howwehelp_6;
        $tab->item_three_detail=$request->item_three_detail;
        $tab->item_four_icon=$filename_howwehelp_8;
        $tab->item_four_detail=$request->item_four_detail;
        $tab->module_background=$filename_howwehelp_10;
        $tab->module_status=$request->module_status;
        $tab->save();

        return redirect('howwehelp')->with('status','Added Successfully !');

    }

    public function ajax(Request $request)
    {
        $this->validate($request,[
                
                'block_heading'=>'required',
                'block_detail'=>'required',
                'item_one_icon'=>'required',
                'item_one_detail'=>'required',
                'item_two_icon'=>'required',
                'item_two_detail'=>'required',
                'item_three_icon'=>'required',
                'item_three_detail'=>'required',
                'item_four_icon'=>'required',
                'item_four_detail'=>'required',
                'module_background'=>'required',
                'module_status'=>'required',
        ]);

        $tab=new HowWeHelp();
        
        $tab->block_heading=$request->block_heading;
        $tab->block_detail=$request->block_detail;
        $tab->item_one_icon=$filename_howwehelp_2;
        $tab->item_one_detail=$request->item_one_detail;
        $tab->item_two_icon=$filename_howwehelp_4;
        $tab->item_two_detail=$request->item_two_detail;
        $tab->item_three_icon=$filename_howwehelp_6;
        $tab->item_three_detail=$request->item_three_detail;
        $tab->item_four_icon=$filename_howwehelp_8;
        $tab->item_four_detail=$request->item_four_detail;
        $tab->module_background=$filename_howwehelp_10;
        $tab->module_status=$request->module_status;
        $tab->save();

        echo json_encode(array("status"=>"success","msg"=>"Added Successfully."));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\HowWeHelp  $howwehelp
     * @return \Illuminate\Http\Response
     */

    private function methodToGetMembersCount($search=""){

        $tab=Customer::select('id','name','address','phone','email','last_invoice_no','created_at')
                     ->where('store_id',$this->sdc->storeID())->orderBy('id','DESC')
                     ->when($search, function ($query) use ($search) {
                        $query->where('id','LIKE','%'.$search.'%');
                            $query->orWhere('block_heading','LIKE','%'.$search.'%');
                            $query->orWhere('block_detail','LIKE','%'.$search.'%');
                            $query->orWhere('item_one_icon','LIKE','%'.$search.'%');
                            $query->orWhere('item_one_detail','LIKE','%'.$search.'%');
                            $query->orWhere('item_two_icon','LIKE','%'.$search.'%');
                            $query->orWhere('item_two_detail','LIKE','%'.$search.'%');
                            $query->orWhere('item_three_icon','LIKE','%'.$search.'%');
                            $query->orWhere('item_three_detail','LIKE','%'.$search.'%');
                            $query->orWhere('item_four_icon','LIKE','%'.$search.'%');
                            $query->orWhere('item_four_detail','LIKE','%'.$search.'%');
                            $query->orWhere('module_background','LIKE','%'.$search.'%');
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
                            $query->orWhere('block_heading','LIKE','%'.$search.'%');
                            $query->orWhere('block_detail','LIKE','%'.$search.'%');
                            $query->orWhere('item_one_icon','LIKE','%'.$search.'%');
                            $query->orWhere('item_one_detail','LIKE','%'.$search.'%');
                            $query->orWhere('item_two_icon','LIKE','%'.$search.'%');
                            $query->orWhere('item_two_detail','LIKE','%'.$search.'%');
                            $query->orWhere('item_three_icon','LIKE','%'.$search.'%');
                            $query->orWhere('item_three_detail','LIKE','%'.$search.'%');
                            $query->orWhere('item_four_icon','LIKE','%'.$search.'%');
                            $query->orWhere('item_four_detail','LIKE','%'.$search.'%');
                            $query->orWhere('module_background','LIKE','%'.$search.'%');
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

    
    public function HowWeHelpQuery($request)
    {
        $HowWeHelp_data=HowWeHelp::orderBy('id','DESC')->get();

        return $HowWeHelp_data;
    }
    
   

    public function ExportExcel(Request $request) 
    {
         $dataDateTimeIns=formatDateTime(date('d-M-Y H:i:s a'));
        $data=array();
        $array_column=array(
                                'ID','Block Heading','Block Detail','Item One Icon','Item One Detail','Item Two Icon','Item Two Detail','Item Three Icon','Item Three Detail','Item Four Icon','Item Four Detail','Module Background','Module Status','Created Date');
        array_push($data, $array_column);
        $inv=$this->HowWeHelpQuery($request);
        foreach($inv as $voi):
            $inv_arry=array(
                                $voi->id,$voi->block_heading,$voi->block_detail,$voi->item_one_icon,$voi->item_one_detail,$voi->item_two_icon,$voi->item_two_detail,$voi->item_three_icon,$voi->item_three_detail,$voi->item_four_icon,$voi->item_four_detail,$voi->module_background,$voi->module_status,formatDate($voi->created_at));
            array_push($data, $inv_arry);
        endforeach;

        $excelArray=array(
            'report_name'=>'How We Help Report',
            'report_title'=>'How We Help Report',
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
                            <th class='text-center' style='font-size:12px;' >Block Heading</th>
                        
                            <th class='text-center' style='font-size:12px;' >Block Detail</th>
                        
                            <th class='text-center' style='font-size:12px;' >Item One Icon</th>
                        
                            <th class='text-center' style='font-size:12px;' >Item One Detail</th>
                        
                            <th class='text-center' style='font-size:12px;' >Item Two Icon</th>
                        
                            <th class='text-center' style='font-size:12px;' >Item Two Detail</th>
                        
                            <th class='text-center' style='font-size:12px;' >Item Three Icon</th>
                        
                            <th class='text-center' style='font-size:12px;' >Item Three Detail</th>
                        
                            <th class='text-center' style='font-size:12px;' >Item Four Icon</th>
                        
                            <th class='text-center' style='font-size:12px;' >Item Four Detail</th>
                        
                            <th class='text-center' style='font-size:12px;' >Module Background</th>
                        
                            <th class='text-center' style='font-size:12px;' >Module Status</th>
                        
                <th class='text-center' style='font-size:12px;'>Created Date</th>
                </tr>
                </thead>
                <tbody>";

                    $inv=$this->HowWeHelpQuery($request);
                    foreach($inv as $voi):
                        $html .="<tr>
                        <td style='font-size:12px;' class='text-center'>".$voi->id."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->block_heading."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->block_detail."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->item_one_icon."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->item_one_detail."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->item_two_icon."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->item_two_detail."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->item_three_icon."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->item_three_detail."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->item_four_icon."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->item_four_detail."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->module_background."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->module_status."</td>
                        <td style='font-size:12px; text-align:center;' class='text-center'>".formatDate($voi->created_at)."</td>
                        </tr>";

                    endforeach;


                $html .="</tbody>
                
                </table>


                ";

                $this->sdc->PDFLayout('How We Help Report',$html);


    }
    public function show(HowWeHelp $howwehelp)
    {
        
        $tab=HowWeHelp::all();return view('admin.pages.howwehelp.howwehelp_list',['dataRow'=>$tab]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\HowWeHelp  $howwehelp
     * @return \Illuminate\Http\Response
     */
    public function edit(HowWeHelp $howwehelp,$id=0)
    {
        $tab=HowWeHelp::find($id);      
        return view('admin.pages.howwehelp.howwehelp_edit',['dataRow'=>$tab,'edit'=>true]);  
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\HowWeHelp  $howwehelp
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HowWeHelp $howwehelp,$id=0)
    {
        $this->validate($request,[
                
                'block_heading'=>'required',
                'block_detail'=>'required',
                'item_one_detail'=>'required',
                'item_two_detail'=>'required',
                'item_three_detail'=>'required',
                'item_four_detail'=>'required',
                'module_status'=>'required',
        ]);

        $this->SystemAdminLog("How We Help","Update","Edit / Modify");

        

        $filename_howwehelp_2=$request->ex_item_one_icon;
        if ($request->hasFile('item_one_icon')) {
            $img_howwehelp = $request->file('item_one_icon');
            $upload_howwehelp = 'upload/howwehelp';
            $filename_howwehelp_2 = env('APP_NAME').'_'.time() . '.' . $img_howwehelp->getClientOriginalExtension();
            $img_howwehelp->move($upload_howwehelp, $filename_howwehelp_2);
        }

                

        $filename_howwehelp_4=$request->ex_item_two_icon;
        if ($request->hasFile('item_two_icon')) {
            $img_howwehelp = $request->file('item_two_icon');
            $upload_howwehelp = 'upload/howwehelp';
            $filename_howwehelp_4 = env('APP_NAME').'_'.time() . '.' . $img_howwehelp->getClientOriginalExtension();
            $img_howwehelp->move($upload_howwehelp, $filename_howwehelp_4);
        }

                

        $filename_howwehelp_6=$request->ex_item_three_icon;
        if ($request->hasFile('item_three_icon')) {
            $img_howwehelp = $request->file('item_three_icon');
            $upload_howwehelp = 'upload/howwehelp';
            $filename_howwehelp_6 = env('APP_NAME').'_'.time() . '.' . $img_howwehelp->getClientOriginalExtension();
            $img_howwehelp->move($upload_howwehelp, $filename_howwehelp_6);
        }

                

        $filename_howwehelp_8=$request->ex_item_four_icon;
        if ($request->hasFile('item_four_icon')) {
            $img_howwehelp = $request->file('item_four_icon');
            $upload_howwehelp = 'upload/howwehelp';
            $filename_howwehelp_8 = env('APP_NAME').'_'.time() . '.' . $img_howwehelp->getClientOriginalExtension();
            $img_howwehelp->move($upload_howwehelp, $filename_howwehelp_8);
        }

                

        $filename_howwehelp_10=$request->ex_module_background;
        if ($request->hasFile('module_background')) {
            $img_howwehelp = $request->file('module_background');
            $upload_howwehelp = 'upload/howwehelp';
            $filename_howwehelp_10 = env('APP_NAME').'_'.time() . '.' . $img_howwehelp->getClientOriginalExtension();
            $img_howwehelp->move($upload_howwehelp, $filename_howwehelp_10);
        }

                
        $tab=HowWeHelp::find($id);
        
        $tab->block_heading=$request->block_heading;
        $tab->block_detail=$request->block_detail;
        $tab->item_one_icon=$filename_howwehelp_2;
        $tab->item_one_detail=$request->item_one_detail;
        $tab->item_two_icon=$filename_howwehelp_4;
        $tab->item_two_detail=$request->item_two_detail;
        $tab->item_three_icon=$filename_howwehelp_6;
        $tab->item_three_detail=$request->item_three_detail;
        $tab->item_four_icon=$filename_howwehelp_8;
        $tab->item_four_detail=$request->item_four_detail;
        $tab->module_background=$filename_howwehelp_10;
        $tab->module_status=$request->module_status;
        $tab->save();

        return redirect('howwehelp')->with('status','Updated Successfully !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\HowWeHelp  $howwehelp
     * @return \Illuminate\Http\Response
     */
    public function destroy(HowWeHelp $howwehelp,$id=0)
    {
        $this->SystemAdminLog("How We Help","Destroy","Delete");

        $tab=HowWeHelp::find($id);
        $tab->delete();
        return redirect('howwehelp')->with('status','Deleted Successfully !');}
}
