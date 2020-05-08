<?php

namespace App\Http\Controllers;

use App\HearAboutUs;
use App\AdminLog;
use Illuminate\Http\Request;

class HearAboutUsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $moduleName="Hear About Us";
    private $sdc;
    public function __construct(){ $this->sdc = new CoreCustomController(); }
    
    public function index(){
        $tab=HearAboutUs::all();
        return view('admin.pages.hearaboutus.hearaboutus_list',['dataRow'=>$tab]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){


                   
        return view('admin.pages.hearaboutus.hearaboutus_create');
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
                
                'name'=>'required',
                'status'=>'required',
        ]);

        $this->SystemAdminLog("Hear About Us","Save New","Create New");

        
        $tab=new HearAboutUs();
        
        $tab->name=$request->name;
        $tab->status=$request->status;
        $tab->save();

        return redirect('hearaboutus')->with('status','Added Successfully !');

    }

    public function ajax(Request $request)
    {
        $this->validate($request,[
                
                'name'=>'required',
                'status'=>'required',
        ]);

        $tab=new HearAboutUs();
        
        $tab->name=$request->name;
        $tab->status=$request->status;
        $tab->save();

        echo json_encode(array("status"=>"success","msg"=>"Added Successfully."));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\HearAboutUs  $hearaboutus
     * @return \Illuminate\Http\Response
     */

    private function methodToGetMembersCount($search=""){

        $tab=Customer::select('id','name','address','phone','email','last_invoice_no','created_at')
                     ->where('store_id',$this->sdc->storeID())->orderBy('id','DESC')
                     ->when($search, function ($query) use ($search) {
                        $query->where('id','LIKE','%'.$search.'%');
                            $query->orWhere('name','LIKE','%'.$search.'%');
                            $query->orWhere('status','LIKE','%'.$search.'%');
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
                            $query->orWhere('name','LIKE','%'.$search.'%');
                            $query->orWhere('status','LIKE','%'.$search.'%');
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

    
    public function HearAboutUsQuery($request)
    {
        $HearAboutUs_data=HearAboutUs::orderBy('id','DESC')->get();

        return $HearAboutUs_data;
    }
    
   

    public function ExportExcel(Request $request) 
    {
         $dataDateTimeIns=formatDateTime(date('d-M-Y H:i:s a'));
        $data=array();
        $array_column=array(
                                'ID','Name','Status','Created Date');
        array_push($data, $array_column);
        $inv=$this->HearAboutUsQuery($request);
        foreach($inv as $voi):
            $inv_arry=array(
                                $voi->id,$voi->name,$voi->status,formatDate($voi->created_at));
            array_push($data, $inv_arry);
        endforeach;

        $excelArray=array(
            'report_name'=>'Hear About Us Report',
            'report_title'=>'Hear About Us Report',
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
                            <th class='text-center' style='font-size:12px;' >Name</th>
                        
                            <th class='text-center' style='font-size:12px;' >Status</th>
                        
                <th class='text-center' style='font-size:12px;'>Created Date</th>
                </tr>
                </thead>
                <tbody>";

                    $inv=$this->HearAboutUsQuery($request);
                    foreach($inv as $voi):
                        $html .="<tr>
                        <td style='font-size:12px;' class='text-center'>".$voi->id."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->name."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->status."</td>
                        <td style='font-size:12px; text-align:center;' class='text-center'>".formatDate($voi->created_at)."</td>
                        </tr>";

                    endforeach;


                $html .="</tbody>
                
                </table>


                ";

                $this->sdc->PDFLayout('Hear About Us Report',$html);


    }
    public function show(HearAboutUs $hearaboutus)
    {
        
        $tab=HearAboutUs::all();return view('admin.pages.hearaboutus.hearaboutus_list',['dataRow'=>$tab]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\HearAboutUs  $hearaboutus
     * @return \Illuminate\Http\Response
     */
    public function edit(HearAboutUs $hearaboutus,$id=0)
    {
        $tab=HearAboutUs::find($id);      
        return view('admin.pages.hearaboutus.hearaboutus_edit',['dataRow'=>$tab,'edit'=>true]);  
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\HearAboutUs  $hearaboutus
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, HearAboutUs $hearaboutus,$id=0)
    {
        $this->validate($request,[
                
                'name'=>'required',
                'status'=>'required',
        ]);

        $this->SystemAdminLog("Hear About Us","Update","Edit / Modify");

        
        $tab=HearAboutUs::find($id);
        
        $tab->name=$request->name;
        $tab->status=$request->status;
        $tab->save();

        return redirect('hearaboutus')->with('status','Updated Successfully !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\HearAboutUs  $hearaboutus
     * @return \Illuminate\Http\Response
     */
    public function destroy(HearAboutUs $hearaboutus,$id=0)
    {
        $this->SystemAdminLog("Hear About Us","Destroy","Delete");

        $tab=HearAboutUs::find($id);
        $tab->delete();
        return redirect('hearaboutus')->with('status','Deleted Successfully !');}
}
