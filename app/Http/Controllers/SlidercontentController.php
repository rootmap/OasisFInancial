<?php

namespace App\Http\Controllers;

use App\SliderContent;
use App\AdminLog;
use Illuminate\Http\Request;

class SliderContentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $moduleName="Slider Content";
    private $sdc;
    public function __construct(){ $this->sdc = new CoreCustomController(); }
    
    public function index(){
        $tabCount=SliderContent::count();
        if($tabCount==0)
        {
            return redirect(url('slidercontent/create'));
        }else{

            $tab=SliderContent::orderBy('id','DESC')->first();      
        return view('admin.pages.slidercontent.slidercontent_edit',['dataRow'=>$tab,'edit'=>true]); 
        }
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){


        
        $tabCount=SliderContent::count();
        if($tabCount==0)
        {            
        return view('admin.pages.slidercontent.slidercontent_create');
            
        }else{

            $tab=SliderContent::orderBy('id','DESC')->first();      
        return view('admin.pages.slidercontent.slidercontent_edit',['dataRow'=>$tab,'edit'=>true]); 
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
                
                'slider_header_with_animation'=>'required',
                'slider_sub_title_with_animation'=>'required',
                'slider_button_top_text'=>'required',
                'button_text'=>'required',
                'rating_image'=>'required',
                'slider_background_image'=>'required',
        ]);

        $this->SystemAdminLog("Slider Content","Save New","Create New");

        

        $filename_slidercontent_4='';
        if ($request->hasFile('rating_image')) {
            $img_slidercontent = $request->file('rating_image');
            $upload_slidercontent = 'upload/slidercontent';
            $filename_slidercontent_4 = env('APP_NAME').'_'.time() . '.' . $img_slidercontent->getClientOriginalExtension();
            $img_slidercontent->move($upload_slidercontent, $filename_slidercontent_4);
        }

                

        $filename_slidercontent_5='';
        if ($request->hasFile('slider_background_image')) {
            $img_slidercontent = $request->file('slider_background_image');
            $upload_slidercontent = 'upload/slidercontent';
            $filename_slidercontent_5 = env('APP_NAME').'_'.time() . '.' . $img_slidercontent->getClientOriginalExtension();
            $img_slidercontent->move($upload_slidercontent, $filename_slidercontent_5);
        }

                
        $tab=new SliderContent();
        
        $tab->slider_header_with_animation=$request->slider_header_with_animation;
        $tab->slider_sub_title_with_animation=$request->slider_sub_title_with_animation;
        $tab->slider_button_top_text=$request->slider_button_top_text;
        $tab->button_text=$request->button_text;
        $tab->rating_image=$filename_slidercontent_4;
        $tab->slider_background_image=$filename_slidercontent_5;
        $tab->save();

        return redirect('slidercontent')->with('status','Added Successfully !');

    }

    public function ajax(Request $request)
    {
        $this->validate($request,[
                
                'slider_header_with_animation'=>'required',
                'slider_sub_title_with_animation'=>'required',
                'slider_button_top_text'=>'required',
                'button_text'=>'required',
                'rating_image'=>'required',
                'slider_background_image'=>'required',
        ]);

        $tab=new SliderContent();
        
        $tab->slider_header_with_animation=$request->slider_header_with_animation;
        $tab->slider_sub_title_with_animation=$request->slider_sub_title_with_animation;
        $tab->slider_button_top_text=$request->slider_button_top_text;
        $tab->button_text=$request->button_text;
        $tab->rating_image=$filename_slidercontent_4;
        $tab->slider_background_image=$filename_slidercontent_5;
        $tab->save();

        echo json_encode(array("status"=>"success","msg"=>"Added Successfully."));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SliderContent  $slidercontent
     * @return \Illuminate\Http\Response
     */

    private function methodToGetMembersCount($search=""){

        $tab=Customer::select('id','name','address','phone','email','last_invoice_no','created_at')
                     ->where('store_id',$this->sdc->storeID())->orderBy('id','DESC')
                     ->when($search, function ($query) use ($search) {
                        $query->where('id','LIKE','%'.$search.'%');
                            $query->orWhere('slider_header_with_animation','LIKE','%'.$search.'%');
                            $query->orWhere('slider_sub_title_with_animation','LIKE','%'.$search.'%');
                            $query->orWhere('slider_button_top_text','LIKE','%'.$search.'%');
                            $query->orWhere('button_text','LIKE','%'.$search.'%');
                            $query->orWhere('rating_image','LIKE','%'.$search.'%');
                            $query->orWhere('slider_background_image','LIKE','%'.$search.'%');
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
                            $query->orWhere('slider_header_with_animation','LIKE','%'.$search.'%');
                            $query->orWhere('slider_sub_title_with_animation','LIKE','%'.$search.'%');
                            $query->orWhere('slider_button_top_text','LIKE','%'.$search.'%');
                            $query->orWhere('button_text','LIKE','%'.$search.'%');
                            $query->orWhere('rating_image','LIKE','%'.$search.'%');
                            $query->orWhere('slider_background_image','LIKE','%'.$search.'%');
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

    
    public function SliderContentQuery($request)
    {
        $SliderContent_data=SliderContent::orderBy('id','DESC')->get();

        return $SliderContent_data;
    }
    
   

    public function ExportExcel(Request $request) 
    {
         $dataDateTimeIns=formatDateTime(date('d-M-Y H:i:s a'));
        $data=array();
        $array_column=array(
                                'ID','Slider Header With Animation','Slider Sub Title With Animation','Slider Button Top Text','Button Text','Rating Image','Slider Background Image','Created Date');
        array_push($data, $array_column);
        $inv=$this->SliderContentQuery($request);
        foreach($inv as $voi):
            $inv_arry=array(
                                $voi->id,$voi->slider_header_with_animation,$voi->slider_sub_title_with_animation,$voi->slider_button_top_text,$voi->button_text,$voi->rating_image,$voi->slider_background_image,formatDate($voi->created_at));
            array_push($data, $inv_arry);
        endforeach;

        $excelArray=array(
            'report_name'=>'Slider Content Report',
            'report_title'=>'Slider Content Report',
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
                            <th class='text-center' style='font-size:12px;' >Slider Header With Animation</th>
                        
                            <th class='text-center' style='font-size:12px;' >Slider Sub Title With Animation</th>
                        
                            <th class='text-center' style='font-size:12px;' >Slider Button Top Text</th>
                        
                            <th class='text-center' style='font-size:12px;' >Button Text</th>
                        
                            <th class='text-center' style='font-size:12px;' >Rating Image</th>
                        
                            <th class='text-center' style='font-size:12px;' >Slider Background Image</th>
                        
                <th class='text-center' style='font-size:12px;'>Created Date</th>
                </tr>
                </thead>
                <tbody>";

                    $inv=$this->SliderContentQuery($request);
                    foreach($inv as $voi):
                        $html .="<tr>
                        <td style='font-size:12px;' class='text-center'>".$voi->id."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->slider_header_with_animation."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->slider_sub_title_with_animation."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->slider_button_top_text."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->button_text."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->rating_image."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->slider_background_image."</td>
                        <td style='font-size:12px; text-align:center;' class='text-center'>".formatDate($voi->created_at)."</td>
                        </tr>";

                    endforeach;


                $html .="</tbody>
                
                </table>


                ";

                $this->sdc->PDFLayout('Slider Content Report',$html);


    }
    public function show(SliderContent $slidercontent)
    {
        
        $tab=SliderContent::all();return view('admin.pages.slidercontent.slidercontent_list',['dataRow'=>$tab]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SliderContent  $slidercontent
     * @return \Illuminate\Http\Response
     */
    public function edit(SliderContent $slidercontent,$id=0)
    {
        $tab=SliderContent::find($id);      
        return view('admin.pages.slidercontent.slidercontent_edit',['dataRow'=>$tab,'edit'=>true]);  
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SliderContent  $slidercontent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SliderContent $slidercontent,$id=0)
    {
        $this->validate($request,[
                
                'slider_header_with_animation'=>'required',
                'slider_sub_title_with_animation'=>'required',
                'slider_button_top_text'=>'required',
                'button_text'=>'required',
        ]);

        $this->SystemAdminLog("Slider Content","Update","Edit / Modify");

        

        $filename_slidercontent_4=$request->ex_rating_image;
        if ($request->hasFile('rating_image')) {
            $img_slidercontent = $request->file('rating_image');
            $upload_slidercontent = 'upload/slidercontent';
            $filename_slidercontent_4 = env('APP_NAME').'_'.time() . '.' . $img_slidercontent->getClientOriginalExtension();
            $img_slidercontent->move($upload_slidercontent, $filename_slidercontent_4);
        }

                

        $filename_slidercontent_5=$request->ex_slider_background_image;
        if ($request->hasFile('slider_background_image')) {
            $img_slidercontent = $request->file('slider_background_image');
            $upload_slidercontent = 'upload/slidercontent';
            $filename_slidercontent_5 = env('APP_NAME').'_'.time() . '.' . $img_slidercontent->getClientOriginalExtension();
            $img_slidercontent->move($upload_slidercontent, $filename_slidercontent_5);
        }

                
        $tab=SliderContent::find($id);
        
        $tab->slider_header_with_animation=$request->slider_header_with_animation;
        $tab->slider_sub_title_with_animation=$request->slider_sub_title_with_animation;
        $tab->slider_button_top_text=$request->slider_button_top_text;
        $tab->button_text=$request->button_text;
        $tab->rating_image=$filename_slidercontent_4;
        $tab->slider_background_image=$filename_slidercontent_5;
        $tab->save();

        return redirect('slidercontent')->with('status','Updated Successfully !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SliderContent  $slidercontent
     * @return \Illuminate\Http\Response
     */
    public function destroy(SliderContent $slidercontent,$id=0)
    {
        $this->SystemAdminLog("Slider Content","Destroy","Delete");

        $tab=SliderContent::find($id);
        $tab->delete();
        return redirect('slidercontent')->with('status','Deleted Successfully !');}
}
