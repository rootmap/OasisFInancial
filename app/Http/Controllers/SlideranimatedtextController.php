<?php

namespace App\Http\Controllers;

use App\SliderAnimatedText;
use App\AdminLog;
use Illuminate\Http\Request;

class SliderAnimatedTextController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $moduleName="Slider Animated Text";
    private $sdc;
    public function __construct(){ $this->sdc = new CoreCustomController(); }
    
    public function index(){
        $tab=SliderAnimatedText::all();
        return view('admin.pages.slideranimatedtext.slideranimatedtext_list',['dataRow'=>$tab]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){


                   
        return view('admin.pages.slideranimatedtext.slideranimatedtext_create');
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
                
                'animation_text'=>'required',
                'animation_status'=>'required',
        ]);

        $this->SystemAdminLog("Slider Animated Text","Save New","Create New");

        
        $tab=new SliderAnimatedText();
        
        $tab->animation_text=$request->animation_text;
        $tab->animation_status=$request->animation_status;
        $tab->save();

        return redirect('slideranimatedtext')->with('status','Added Successfully !');

    }

    public function ajax(Request $request)
    {
        $this->validate($request,[
                
                'animation_text'=>'required',
                'animation_status'=>'required',
        ]);

        $tab=new SliderAnimatedText();
        
        $tab->animation_text=$request->animation_text;
        $tab->animation_status=$request->animation_status;
        $tab->save();

        echo json_encode(array("status"=>"success","msg"=>"Added Successfully."));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SliderAnimatedText  $slideranimatedtext
     * @return \Illuminate\Http\Response
     */

    private function methodToGetMembersCount($search=""){

        $tab=Customer::select('id','name','address','phone','email','last_invoice_no','created_at')
                     ->where('store_id',$this->sdc->storeID())->orderBy('id','DESC')
                     ->when($search, function ($query) use ($search) {
                        $query->where('id','LIKE','%'.$search.'%');
                            $query->orWhere('animation_text','LIKE','%'.$search.'%');
                            $query->orWhere('animation_status','LIKE','%'.$search.'%');
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
                            $query->orWhere('animation_text','LIKE','%'.$search.'%');
                            $query->orWhere('animation_status','LIKE','%'.$search.'%');
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

    
    public function SliderAnimatedTextQuery($request)
    {
        $SliderAnimatedText_data=SliderAnimatedText::orderBy('id','DESC')->get();

        return $SliderAnimatedText_data;
    }
    
   

    public function ExportExcel(Request $request) 
    {
         $dataDateTimeIns=formatDateTime(date('d-M-Y H:i:s a'));
        $data=array();
        $array_column=array(
                                'ID','Animation Text','Animation Status','Created Date');
        array_push($data, $array_column);
        $inv=$this->SliderAnimatedTextQuery($request);
        foreach($inv as $voi):
            $inv_arry=array(
                                $voi->id,$voi->animation_text,$voi->animation_status,formatDate($voi->created_at));
            array_push($data, $inv_arry);
        endforeach;

        $excelArray=array(
            'report_name'=>'Slider Animated Text Report',
            'report_title'=>'Slider Animated Text Report',
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
                            <th class='text-center' style='font-size:12px;' >Animation Text</th>
                        
                            <th class='text-center' style='font-size:12px;' >Animation Status</th>
                        
                <th class='text-center' style='font-size:12px;'>Created Date</th>
                </tr>
                </thead>
                <tbody>";

                    $inv=$this->SliderAnimatedTextQuery($request);
                    foreach($inv as $voi):
                        $html .="<tr>
                        <td style='font-size:12px;' class='text-center'>".$voi->id."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->animation_text."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->animation_status."</td>
                        <td style='font-size:12px; text-align:center;' class='text-center'>".formatDate($voi->created_at)."</td>
                        </tr>";

                    endforeach;


                $html .="</tbody>
                
                </table>


                ";

                $this->sdc->PDFLayout('Slider Animated Text Report',$html);


    }
    public function show(SliderAnimatedText $slideranimatedtext)
    {
        
        $tab=SliderAnimatedText::all();return view('admin.pages.slideranimatedtext.slideranimatedtext_list',['dataRow'=>$tab]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SliderAnimatedText  $slideranimatedtext
     * @return \Illuminate\Http\Response
     */
    public function edit(SliderAnimatedText $slideranimatedtext,$id=0)
    {
        $tab=SliderAnimatedText::find($id);      
        return view('admin.pages.slideranimatedtext.slideranimatedtext_edit',['dataRow'=>$tab,'edit'=>true]);  
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SliderAnimatedText  $slideranimatedtext
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SliderAnimatedText $slideranimatedtext,$id=0)
    {
        $this->validate($request,[
                
                'animation_text'=>'required',
                'animation_status'=>'required',
        ]);

        $this->SystemAdminLog("Slider Animated Text","Update","Edit / Modify");

        
        $tab=SliderAnimatedText::find($id);
        
        $tab->animation_text=$request->animation_text;
        $tab->animation_status=$request->animation_status;
        $tab->save();

        return redirect('slideranimatedtext')->with('status','Updated Successfully !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SliderAnimatedText  $slideranimatedtext
     * @return \Illuminate\Http\Response
     */
    public function destroy(SliderAnimatedText $slideranimatedtext,$id=0)
    {
        $this->SystemAdminLog("Slider Animated Text","Destroy","Delete");

        $tab=SliderAnimatedText::find($id);
        $tab->delete();
        return redirect('slideranimatedtext')->with('status','Deleted Successfully !');}
}
