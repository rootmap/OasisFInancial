<?php

namespace App\Http\Controllers;

use App\SiteSettings;
use App\AdminLog;
use Illuminate\Http\Request;

class SiteSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $moduleName="Site Settings";
    private $sdc;
    public function __construct(){ $this->sdc = new CoreCustomController(); }
    
    public function index(){
        $tabCount=SiteSettings::count();
        if($tabCount==0)
        {
            return redirect(url('sitesettings/create'));
        }else{

            $tab=SiteSettings::orderBy('id','DESC')->first();      
        return view('admin.pages.sitesettings.sitesettings_edit',['dataRow'=>$tab,'edit'=>true]); 
        }
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){


        
        $tabCount=SiteSettings::count();
        if($tabCount==0)
        {            
        return view('admin.pages.sitesettings.sitesettings_create');
            
        }else{

            $tab=SiteSettings::orderBy('id','DESC')->first();      
        return view('admin.pages.sitesettings.sitesettings_edit',['dataRow'=>$tab,'edit'=>true]); 
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
                
                'site_name'=>'required',
                'site_logo'=>'required',
                'site_footer_logo'=>'required',
                'toll_free_call_text'=>'required',
                'toll_free_call_number'=>'required',
                'contact_us_email_send'=>'required',
                'application_notification_admin_email'=>'required',
        ]);

        $this->SystemAdminLog("Site Settings","Save New","Create New");

        

        $filename_sitesettings_1='';
        if ($request->hasFile('site_logo')) {
            $img_sitesettings = $request->file('site_logo');
            $upload_sitesettings = 'upload/sitesettings';
            $filename_sitesettings_1 = env('APP_NAME').'_'.time() . '.' . $img_sitesettings->getClientOriginalExtension();
            $img_sitesettings->move($upload_sitesettings, $filename_sitesettings_1);
        }

                

        $filename_sitesettings_2='';
        if ($request->hasFile('site_footer_logo')) {
            $img_sitesettings = $request->file('site_footer_logo');
            $upload_sitesettings = 'upload/sitesettings';
            $filename_sitesettings_2 = env('APP_NAME').'_'.time() . '.' . $img_sitesettings->getClientOriginalExtension();
            $img_sitesettings->move($upload_sitesettings, $filename_sitesettings_2);
        }

                
        $tab=new SiteSettings();
        
        $tab->site_name=$request->site_name;
        $tab->site_logo=$filename_sitesettings_1;
        $tab->site_footer_logo=$filename_sitesettings_2;
        $tab->toll_free_call_text=$request->toll_free_call_text;
        $tab->toll_free_call_number=$request->toll_free_call_number;
        $tab->contact_us_email_send=$request->contact_us_email_send;
        $tab->application_notification_admin_email=$request->application_notification_admin_email;
        $tab->save();

        return redirect('sitesettings')->with('status','Added Successfully !');

    }

    public function ajax(Request $request)
    {
        $this->validate($request,[
                
                'site_name'=>'required',
                'site_logo'=>'required',
                'site_footer_logo'=>'required',
                'toll_free_call_text'=>'required',
                'toll_free_call_number'=>'required',
                'contact_us_email_send'=>'required',
                'application_notification_admin_email'=>'required',
        ]);

        $tab=new SiteSettings();
        
        $tab->site_name=$request->site_name;
        $tab->site_logo=$filename_sitesettings_1;
        $tab->site_footer_logo=$filename_sitesettings_2;
        $tab->toll_free_call_text=$request->toll_free_call_text;
        $tab->toll_free_call_number=$request->toll_free_call_number;
        $tab->contact_us_email_send=$request->contact_us_email_send;
        $tab->application_notification_admin_email=$request->application_notification_admin_email;
        $tab->save();

        echo json_encode(array("status"=>"success","msg"=>"Added Successfully."));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SiteSettings  $sitesettings
     * @return \Illuminate\Http\Response
     */

    private function methodToGetMembersCount($search=""){

        $tab=Customer::select('id','name','address','phone','email','last_invoice_no','created_at')
                     ->where('store_id',$this->sdc->storeID())->orderBy('id','DESC')
                     ->when($search, function ($query) use ($search) {
                        $query->where('id','LIKE','%'.$search.'%');
                            $query->orWhere('site_name','LIKE','%'.$search.'%');
                            $query->orWhere('site_logo','LIKE','%'.$search.'%');
                            $query->orWhere('site_footer_logo','LIKE','%'.$search.'%');
                            $query->orWhere('toll_free_call_text','LIKE','%'.$search.'%');
                            $query->orWhere('toll_free_call_number','LIKE','%'.$search.'%');
                            $query->orWhere('contact_us_email_send','LIKE','%'.$search.'%');
                            $query->orWhere('application_notification_admin_email','LIKE','%'.$search.'%');
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
                            $query->orWhere('site_name','LIKE','%'.$search.'%');
                            $query->orWhere('site_logo','LIKE','%'.$search.'%');
                            $query->orWhere('site_footer_logo','LIKE','%'.$search.'%');
                            $query->orWhere('toll_free_call_text','LIKE','%'.$search.'%');
                            $query->orWhere('toll_free_call_number','LIKE','%'.$search.'%');
                            $query->orWhere('contact_us_email_send','LIKE','%'.$search.'%');
                            $query->orWhere('application_notification_admin_email','LIKE','%'.$search.'%');
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

    
    public function SiteSettingsQuery($request)
    {
        $SiteSettings_data=SiteSettings::orderBy('id','DESC')->get();

        return $SiteSettings_data;
    }
    
   

    public function ExportExcel(Request $request) 
    {
         $dataDateTimeIns=formatDateTime(date('d-M-Y H:i:s a'));
        $data=array();
        $array_column=array(
                                'ID','Site Name','Site Logo','Site Footer Logo','Toll Free Call Text','Toll Free Call Number','Contact US Email Send','Application Notification Admin Email','Created Date');
        array_push($data, $array_column);
        $inv=$this->SiteSettingsQuery($request);
        foreach($inv as $voi):
            $inv_arry=array(
                                $voi->id,$voi->site_name,$voi->site_logo,$voi->site_footer_logo,$voi->toll_free_call_text,$voi->toll_free_call_number,$voi->contact_us_email_send,$voi->application_notification_admin_email,formatDate($voi->created_at));
            array_push($data, $inv_arry);
        endforeach;

        $excelArray=array(
            'report_name'=>'Site Settings Report',
            'report_title'=>'Site Settings Report',
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
                            <th class='text-center' style='font-size:12px;' >Site Name</th>
                        
                            <th class='text-center' style='font-size:12px;' >Site Logo</th>
                        
                            <th class='text-center' style='font-size:12px;' >Site Footer Logo</th>
                        
                            <th class='text-center' style='font-size:12px;' >Toll Free Call Text</th>
                        
                            <th class='text-center' style='font-size:12px;' >Toll Free Call Number</th>
                        
                            <th class='text-center' style='font-size:12px;' >Contact US Email Send</th>
                        
                            <th class='text-center' style='font-size:12px;' >Application Notification Admin Email</th>
                        
                <th class='text-center' style='font-size:12px;'>Created Date</th>
                </tr>
                </thead>
                <tbody>";

                    $inv=$this->SiteSettingsQuery($request);
                    foreach($inv as $voi):
                        $html .="<tr>
                        <td style='font-size:12px;' class='text-center'>".$voi->id."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->site_name."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->site_logo."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->site_footer_logo."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->toll_free_call_text."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->toll_free_call_number."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->contact_us_email_send."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->application_notification_admin_email."</td>
                        <td style='font-size:12px; text-align:center;' class='text-center'>".formatDate($voi->created_at)."</td>
                        </tr>";

                    endforeach;


                $html .="</tbody>
                
                </table>


                ";

                $this->sdc->PDFLayout('Site Settings Report',$html);


    }
    public function show(SiteSettings $sitesettings)
    {
        
        $tab=SiteSettings::all();return view('admin.pages.sitesettings.sitesettings_list',['dataRow'=>$tab]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SiteSettings  $sitesettings
     * @return \Illuminate\Http\Response
     */
    public function edit(SiteSettings $sitesettings,$id=0)
    {
        $tab=SiteSettings::find($id);      
        return view('admin.pages.sitesettings.sitesettings_edit',['dataRow'=>$tab,'edit'=>true]);  
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SiteSettings  $sitesettings
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SiteSettings $sitesettings,$id=0)
    {
        $this->validate($request,[
                
                'site_name'=>'required',
                'toll_free_call_text'=>'required',
                'toll_free_call_number'=>'required',
                'contact_us_email_send'=>'required',
                'application_notification_admin_email'=>'required',
        ]);

        $this->SystemAdminLog("Site Settings","Update","Edit / Modify");

        

        $filename_sitesettings_1=$request->ex_site_logo;
        if ($request->hasFile('site_logo')) {
            $img_sitesettings = $request->file('site_logo');
            $upload_sitesettings = 'upload/sitesettings';
            $filename_sitesettings_1 = env('APP_NAME').'_'.time() . '.' . $img_sitesettings->getClientOriginalExtension();
            $img_sitesettings->move($upload_sitesettings, $filename_sitesettings_1);
        }

                

        $filename_sitesettings_2=$request->ex_site_footer_logo;
        if ($request->hasFile('site_footer_logo')) {
            $img_sitesettings = $request->file('site_footer_logo');
            $upload_sitesettings = 'upload/sitesettings';
            $filename_sitesettings_2 = env('APP_NAME').'_'.time() . '.' . $img_sitesettings->getClientOriginalExtension();
            $img_sitesettings->move($upload_sitesettings, $filename_sitesettings_2);
        }

                
        $tab=SiteSettings::find($id);
        
        $tab->site_name=$request->site_name;
        $tab->site_logo=$filename_sitesettings_1;
        $tab->site_footer_logo=$filename_sitesettings_2;
        $tab->toll_free_call_text=$request->toll_free_call_text;
        $tab->toll_free_call_number=$request->toll_free_call_number;
        $tab->contact_us_email_send=$request->contact_us_email_send;
        $tab->application_notification_admin_email=$request->application_notification_admin_email;
        $tab->save();

        return redirect('sitesettings')->with('status','Updated Successfully !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SiteSettings  $sitesettings
     * @return \Illuminate\Http\Response
     */
    public function destroy(SiteSettings $sitesettings,$id=0)
    {
        $this->SystemAdminLog("Site Settings","Destroy","Delete");

        $tab=SiteSettings::find($id);
        $tab->delete();
        return redirect('sitesettings')->with('status','Deleted Successfully !');}
}
