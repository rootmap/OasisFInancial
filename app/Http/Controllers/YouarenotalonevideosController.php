<?php

namespace App\Http\Controllers;

use App\YouAreNotAloneVideos;
use App\AdminLog;
use Illuminate\Http\Request;

class YouAreNotAloneVideosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $moduleName="You Are Not Alone Videos";
    private $sdc;
    public function __construct(){ $this->sdc = new CoreCustomController(); }
    
    public function index(){
        $tab=YouAreNotAloneVideos::all();
        return view('admin.pages.youarenotalonevideos.youarenotalonevideos_list',['dataRow'=>$tab]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){


                   
        return view('admin.pages.youarenotalonevideos.youarenotalonevideos_create');
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
                
                'feedback_user_name'=>'required',
                'from_location'=>'required',
                'section_detail'=>'required',
                'play_video_text'=>'required',
                'video_background_image'=>'required',
                'youtube_video_link'=>'required',
                'module_status'=>'required',
        ]);

        $this->SystemAdminLog("You Are Not Alone Videos","Save New","Create New");

        

        $filename_youarenotalonevideos_4='';
        if ($request->hasFile('video_background_image')) {
            $img_youarenotalonevideos = $request->file('video_background_image');
            $upload_youarenotalonevideos = 'upload/youarenotalonevideos';
            $filename_youarenotalonevideos_4 = env('APP_NAME').'_'.time() . '.' . $img_youarenotalonevideos->getClientOriginalExtension();
            $img_youarenotalonevideos->move($upload_youarenotalonevideos, $filename_youarenotalonevideos_4);
        }

                
        $tab=new YouAreNotAloneVideos();
        
        $tab->feedback_user_name=$request->feedback_user_name;
        $tab->from_location=$request->from_location;
        $tab->section_detail=$request->section_detail;
        $tab->play_video_text=$request->play_video_text;
        $tab->video_background_image=$filename_youarenotalonevideos_4;
        $tab->youtube_video_link=$request->youtube_video_link;
        $tab->module_status=$request->module_status;
        $tab->save();

        return redirect('youarenotalonevideos')->with('status','Added Successfully !');

    }

    public function ajax(Request $request)
    {
        $this->validate($request,[
                
                'feedback_user_name'=>'required',
                'from_location'=>'required',
                'section_detail'=>'required',
                'play_video_text'=>'required',
                'video_background_image'=>'required',
                'youtube_video_link'=>'required',
                'module_status'=>'required',
        ]);

        $tab=new YouAreNotAloneVideos();
        
        $tab->feedback_user_name=$request->feedback_user_name;
        $tab->from_location=$request->from_location;
        $tab->section_detail=$request->section_detail;
        $tab->play_video_text=$request->play_video_text;
        $tab->video_background_image=$filename_youarenotalonevideos_4;
        $tab->youtube_video_link=$request->youtube_video_link;
        $tab->module_status=$request->module_status;
        $tab->save();

        echo json_encode(array("status"=>"success","msg"=>"Added Successfully."));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\YouAreNotAloneVideos  $youarenotalonevideos
     * @return \Illuminate\Http\Response
     */

    private function methodToGetMembersCount($search=""){

        $tab=Customer::select('id','name','address','phone','email','last_invoice_no','created_at')
                     ->where('store_id',$this->sdc->storeID())->orderBy('id','DESC')
                     ->when($search, function ($query) use ($search) {
                        $query->where('id','LIKE','%'.$search.'%');
                            $query->orWhere('feedback_user_name','LIKE','%'.$search.'%');
                            $query->orWhere('from_location','LIKE','%'.$search.'%');
                            $query->orWhere('section_detail','LIKE','%'.$search.'%');
                            $query->orWhere('play_video_text','LIKE','%'.$search.'%');
                            $query->orWhere('video_background_image','LIKE','%'.$search.'%');
                            $query->orWhere('youtube_video_link','LIKE','%'.$search.'%');
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
                            $query->orWhere('feedback_user_name','LIKE','%'.$search.'%');
                            $query->orWhere('from_location','LIKE','%'.$search.'%');
                            $query->orWhere('section_detail','LIKE','%'.$search.'%');
                            $query->orWhere('play_video_text','LIKE','%'.$search.'%');
                            $query->orWhere('video_background_image','LIKE','%'.$search.'%');
                            $query->orWhere('youtube_video_link','LIKE','%'.$search.'%');
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

    
    public function YouAreNotAloneVideosQuery($request)
    {
        $YouAreNotAloneVideos_data=YouAreNotAloneVideos::orderBy('id','DESC')->get();

        return $YouAreNotAloneVideos_data;
    }
    
   

    public function ExportExcel(Request $request) 
    {
         $dataDateTimeIns=formatDateTime(date('d-M-Y H:i:s a'));
        $data=array();
        $array_column=array(
                                'ID','Feedback User Name','From Location','Section Detail','Play Video Text','Video Background Image','Youtube Video Link','Module Status','Created Date');
        array_push($data, $array_column);
        $inv=$this->YouAreNotAloneVideosQuery($request);
        foreach($inv as $voi):
            $inv_arry=array(
                                $voi->id,$voi->feedback_user_name,$voi->from_location,$voi->section_detail,$voi->play_video_text,$voi->video_background_image,$voi->youtube_video_link,$voi->module_status,formatDate($voi->created_at));
            array_push($data, $inv_arry);
        endforeach;

        $excelArray=array(
            'report_name'=>'You Are Not Alone Videos Report',
            'report_title'=>'You Are Not Alone Videos Report',
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
                            <th class='text-center' style='font-size:12px;' >Feedback User Name</th>
                        
                            <th class='text-center' style='font-size:12px;' >From Location</th>
                        
                            <th class='text-center' style='font-size:12px;' >Section Detail</th>
                        
                            <th class='text-center' style='font-size:12px;' >Play Video Text</th>
                        
                            <th class='text-center' style='font-size:12px;' >Video Background Image</th>
                        
                            <th class='text-center' style='font-size:12px;' >Youtube Video Link</th>
                        
                            <th class='text-center' style='font-size:12px;' >Module Status</th>
                        
                <th class='text-center' style='font-size:12px;'>Created Date</th>
                </tr>
                </thead>
                <tbody>";

                    $inv=$this->YouAreNotAloneVideosQuery($request);
                    foreach($inv as $voi):
                        $html .="<tr>
                        <td style='font-size:12px;' class='text-center'>".$voi->id."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->feedback_user_name."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->from_location."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->section_detail."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->play_video_text."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->video_background_image."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->youtube_video_link."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->module_status."</td>
                        <td style='font-size:12px; text-align:center;' class='text-center'>".formatDate($voi->created_at)."</td>
                        </tr>";

                    endforeach;


                $html .="</tbody>
                
                </table>


                ";

                $this->sdc->PDFLayout('You Are Not Alone Videos Report',$html);


    }
    public function show(YouAreNotAloneVideos $youarenotalonevideos)
    {
        
        $tab=YouAreNotAloneVideos::all();return view('admin.pages.youarenotalonevideos.youarenotalonevideos_list',['dataRow'=>$tab]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\YouAreNotAloneVideos  $youarenotalonevideos
     * @return \Illuminate\Http\Response
     */
    public function edit(YouAreNotAloneVideos $youarenotalonevideos,$id=0)
    {
        $tab=YouAreNotAloneVideos::find($id);      
        return view('admin.pages.youarenotalonevideos.youarenotalonevideos_edit',['dataRow'=>$tab,'edit'=>true]);  
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\YouAreNotAloneVideos  $youarenotalonevideos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, YouAreNotAloneVideos $youarenotalonevideos,$id=0)
    {
        $this->validate($request,[
                
                'feedback_user_name'=>'required',
                'from_location'=>'required',
                'section_detail'=>'required',
                'play_video_text'=>'required',
                'youtube_video_link'=>'required',
                'module_status'=>'required',
        ]);

        $this->SystemAdminLog("You Are Not Alone Videos","Update","Edit / Modify");

        

        $filename_youarenotalonevideos_4=$request->ex_video_background_image;
        if ($request->hasFile('video_background_image')) {
            $img_youarenotalonevideos = $request->file('video_background_image');
            $upload_youarenotalonevideos = 'upload/youarenotalonevideos';
            $filename_youarenotalonevideos_4 = env('APP_NAME').'_'.time() . '.' . $img_youarenotalonevideos->getClientOriginalExtension();
            $img_youarenotalonevideos->move($upload_youarenotalonevideos, $filename_youarenotalonevideos_4);
        }

                
        $tab=YouAreNotAloneVideos::find($id);
        
        $tab->feedback_user_name=$request->feedback_user_name;
        $tab->from_location=$request->from_location;
        $tab->section_detail=$request->section_detail;
        $tab->play_video_text=$request->play_video_text;
        $tab->video_background_image=$filename_youarenotalonevideos_4;
        $tab->youtube_video_link=$request->youtube_video_link;
        $tab->module_status=$request->module_status;
        $tab->save();

        return redirect('youarenotalonevideos')->with('status','Updated Successfully !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\YouAreNotAloneVideos  $youarenotalonevideos
     * @return \Illuminate\Http\Response
     */
    public function destroy(YouAreNotAloneVideos $youarenotalonevideos,$id=0)
    {
        $this->SystemAdminLog("You Are Not Alone Videos","Destroy","Delete");

        $tab=YouAreNotAloneVideos::find($id);
        $tab->delete();
        return redirect('youarenotalonevideos')->with('status','Deleted Successfully !');}
}
