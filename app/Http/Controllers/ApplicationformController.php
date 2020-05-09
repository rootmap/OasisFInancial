<?php

namespace App\Http\Controllers;

use App\ApplicationForm;
use App\AdminLog;
use Illuminate\Http\Request;
use App\usa_states;
use App\CaseType;
                
use App\HearAboutUs;
                

class ApplicationFormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $moduleName="Application Form";
    private $sdc;
    public function __construct(){ $this->sdc = new CoreCustomController(); }
    
    public function index(){
        $tab=ApplicationForm::all();
        return view('admin.pages.applicationform.applicationform_list',['dataRow'=>$tab]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){


        
        $tab_usa_states=usa_states::all();
        $tab_CaseType=CaseType::all();
        $tab_HearAboutUs=HearAboutUs::all();
        $tab_usa_states=usa_states::all();           
        return view('admin.pages.applicationform.applicationform_create',['dataRow_usa_states'=>$tab_usa_states,'dataRow_CaseType'=>$tab_CaseType,'dataRow_HearAboutUs'=>$tab_HearAboutUs,'dataRow_usa_states'=>$tab_usa_states]);
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
                
                'first_name'=>'required',
                'last_name'=>'required',
                'how_much_money_you_need'=>'required',
                'date_of_accident'=>'required',
                'what_state_case'=>'required',
                'case_type_id'=>'required',
                'hear_about_us_id'=>'required',
                'email'=>'required',
                'phone'=>'required',
                'how_should_we_contact'=>'required',
                'address'=>'required',
                'city'=>'required',
                'state'=>'required',
                'zip_code'=>'required',
                'attorney_first_name'=>'required',
                'attorney_last_name'=>'required',
                'law_firm_name'=>'required',
                'law_firm_phone'=>'required',
                'application_status'=>'required',
                'applicant_verification_status'=>'required',
        ]);

        $this->SystemAdminLog("Application Form","Save New","Create New");

        
        $tab_4_usa_states=usa_states::where('id',$request->what_state_case)->first();
        $what_state_case_4_usa_states=$tab_4_usa_states->name;
        $tab_5_CaseType=CaseType::where('id',$request->case_type_id)->first();
        $case_type_id_5_CaseType=$tab_5_CaseType->name;
        $tab_6_HearAboutUs=HearAboutUs::where('id',$request->hear_about_us_id)->first();
        $hear_about_us_id_6_HearAboutUs=$tab_6_HearAboutUs->name;
        $tab_12_usa_states=usa_states::where('id',$request->state)->first();
        $state_12_usa_states=$tab_12_usa_states->name;
        $tab=new ApplicationForm();
        
        $tab->first_name=$request->first_name;
        $tab->last_name=$request->last_name;
        $tab->how_much_money_you_need=$request->how_much_money_you_need;
        $tab->date_of_accident=$request->date_of_accident;
        $tab->what_state_case_name=$what_state_case_4_usa_states;
        $tab->what_state_case=$request->what_state_case;
        $tab->case_type_id_name=$case_type_id_5_CaseType;
        $tab->case_type_id=$request->case_type_id;
        $tab->hear_about_us_id_name=$hear_about_us_id_6_HearAboutUs;
        $tab->hear_about_us_id=$request->hear_about_us_id;
        $tab->email=$request->email;
        $tab->phone=$request->phone;
        $tab->how_should_we_contact=$request->how_should_we_contact;
        $tab->address=$request->address;
        $tab->city=$request->city;
        $tab->state_name=$state_12_usa_states;
        $tab->state=$request->state;
        $tab->zip_code=$request->zip_code;
        $tab->attorney_first_name=$request->attorney_first_name;
        $tab->attorney_last_name=$request->attorney_last_name;
        $tab->law_firm_name=$request->law_firm_name;
        $tab->law_firm_phone=$request->law_firm_phone;
        $tab->application_status=$request->application_status;
        $tab->applicant_verification_status=$request->applicant_verification_status;
        $tab->save();

        return redirect('applicationform')->with('status','Added Successfully !');

    }

    public function ajax(Request $request)
    {
        $this->validate($request,[
                
                'first_name'=>'required',
                'last_name'=>'required',
                'how_much_money_you_need'=>'required',
                'date_of_accident'=>'required',
                'what_state_case'=>'required',
                'case_type_id'=>'required',
                'hear_about_us_id'=>'required',
                'email'=>'required',
                'phone'=>'required',
                'how_should_we_contact'=>'required',
                'address'=>'required',
                'city'=>'required',
                'state'=>'required',
                'zip_code'=>'required',
                'attorney_first_name'=>'required',
                'attorney_last_name'=>'required',
                'law_firm_name'=>'required',
                'law_firm_phone'=>'required',
                'application_status'=>'required',
                'applicant_verification_status'=>'required',
        ]);

        $tab=new ApplicationForm();
        
        $tab->first_name=$request->first_name;
        $tab->last_name=$request->last_name;
        $tab->how_much_money_you_need=$request->how_much_money_you_need;
        $tab->date_of_accident=$request->date_of_accident;
        $tab->what_state_case_name=$what_state_case_4_usa_states;
        $tab->what_state_case=$request->what_state_case;
        $tab->case_type_id_name=$case_type_id_5_CaseType;
        $tab->case_type_id=$request->case_type_id;
        $tab->hear_about_us_id_name=$hear_about_us_id_6_HearAboutUs;
        $tab->hear_about_us_id=$request->hear_about_us_id;
        $tab->email=$request->email;
        $tab->phone=$request->phone;
        $tab->how_should_we_contact=$request->how_should_we_contact;
        $tab->address=$request->address;
        $tab->city=$request->city;
        $tab->state_name=$state_12_usa_states;
        $tab->state=$request->state;
        $tab->zip_code=$request->zip_code;
        $tab->attorney_first_name=$request->attorney_first_name;
        $tab->attorney_last_name=$request->attorney_last_name;
        $tab->law_firm_name=$request->law_firm_name;
        $tab->law_firm_phone=$request->law_firm_phone;
        $tab->application_status=$request->application_status;
        $tab->applicant_verification_status=$request->applicant_verification_status;
        $tab->save();

        echo json_encode(array("status"=>"success","msg"=>"Added Successfully."));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ApplicationForm  $applicationform
     * @return \Illuminate\Http\Response
     */

    private function methodToGetMembersCount($search=""){

        $tab=Customer::select('id','name','address','phone','email','last_invoice_no','created_at')
                     ->where('store_id',$this->sdc->storeID())->orderBy('id','DESC')
                     ->when($search, function ($query) use ($search) {
                        $query->where('id','LIKE','%'.$search.'%');
                            $query->orWhere('first_name','LIKE','%'.$search.'%');
                            $query->orWhere('last_name','LIKE','%'.$search.'%');
                            $query->orWhere('how_much_money_you_need','LIKE','%'.$search.'%');
                            $query->orWhere('date_of_accident','LIKE','%'.$search.'%');
                            $query->orWhere('what_state_case','LIKE','%'.$search.'%');
                            $query->orWhere('case_type_id','LIKE','%'.$search.'%');
                            $query->orWhere('hear_about_us_id','LIKE','%'.$search.'%');
                            $query->orWhere('email','LIKE','%'.$search.'%');
                            $query->orWhere('phone','LIKE','%'.$search.'%');
                            $query->orWhere('how_should_we_contact','LIKE','%'.$search.'%');
                            $query->orWhere('address','LIKE','%'.$search.'%');
                            $query->orWhere('city','LIKE','%'.$search.'%');
                            $query->orWhere('state','LIKE','%'.$search.'%');
                            $query->orWhere('zip_code','LIKE','%'.$search.'%');
                            $query->orWhere('attorney_first_name','LIKE','%'.$search.'%');
                            $query->orWhere('attorney_last_name','LIKE','%'.$search.'%');
                            $query->orWhere('law_firm_name','LIKE','%'.$search.'%');
                            $query->orWhere('law_firm_phone','LIKE','%'.$search.'%');
                            $query->orWhere('application_status','LIKE','%'.$search.'%');
                            $query->orWhere('applicant_verification_status','LIKE','%'.$search.'%');
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
                            $query->orWhere('first_name','LIKE','%'.$search.'%');
                            $query->orWhere('last_name','LIKE','%'.$search.'%');
                            $query->orWhere('how_much_money_you_need','LIKE','%'.$search.'%');
                            $query->orWhere('date_of_accident','LIKE','%'.$search.'%');
                            $query->orWhere('what_state_case','LIKE','%'.$search.'%');
                            $query->orWhere('case_type_id','LIKE','%'.$search.'%');
                            $query->orWhere('hear_about_us_id','LIKE','%'.$search.'%');
                            $query->orWhere('email','LIKE','%'.$search.'%');
                            $query->orWhere('phone','LIKE','%'.$search.'%');
                            $query->orWhere('how_should_we_contact','LIKE','%'.$search.'%');
                            $query->orWhere('address','LIKE','%'.$search.'%');
                            $query->orWhere('city','LIKE','%'.$search.'%');
                            $query->orWhere('state','LIKE','%'.$search.'%');
                            $query->orWhere('zip_code','LIKE','%'.$search.'%');
                            $query->orWhere('attorney_first_name','LIKE','%'.$search.'%');
                            $query->orWhere('attorney_last_name','LIKE','%'.$search.'%');
                            $query->orWhere('law_firm_name','LIKE','%'.$search.'%');
                            $query->orWhere('law_firm_phone','LIKE','%'.$search.'%');
                            $query->orWhere('application_status','LIKE','%'.$search.'%');
                            $query->orWhere('applicant_verification_status','LIKE','%'.$search.'%');
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

    
    public function ApplicationFormQuery($request)
    {
        $ApplicationForm_data=ApplicationForm::orderBy('id','DESC')->get();

        return $ApplicationForm_data;
    }
    
   

    public function ExportExcel(Request $request) 
    {
         $dataDateTimeIns=formatDateTime(date('d-M-Y H:i:s a'));
        $data=array();
        $array_column=array(
                                'ID','First Name','Last Name','How Much Money You Need','Date Of Accident','What State Case','Case Type ID','Hear About US ID','Email','Phone','How should we contact','Address','City','State','ZIP Code','Attorney First Name','Attorney Last Name','Law Firm Name','Law Firm Phone','Application Status','Applicant Verification Status','Created Date');
        array_push($data, $array_column);
        $inv=$this->ApplicationFormQuery($request);
        foreach($inv as $voi):
            $inv_arry=array(
                                $voi->id,$voi->first_name,$voi->last_name,$voi->how_much_money_you_need,$voi->date_of_accident,$voi->what_state_case,$voi->case_type_id,$voi->hear_about_us_id,$voi->email,$voi->phone,$voi->how_should_we_contact,$voi->address,$voi->city,$voi->state,$voi->zip_code,$voi->attorney_first_name,$voi->attorney_last_name,$voi->law_firm_name,$voi->law_firm_phone,$voi->application_status,$voi->applicant_verification_status,formatDate($voi->created_at));
            array_push($data, $inv_arry);
        endforeach;

        $excelArray=array(
            'report_name'=>'Application Form Report',
            'report_title'=>'Application Form Report',
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
                            <th class='text-center' style='font-size:12px;' >First Name</th>
                        
                            <th class='text-center' style='font-size:12px;' >Last Name</th>
                        
                            <th class='text-center' style='font-size:12px;' >How Much Money You Need</th>
                        
                            <th class='text-center' style='font-size:12px;' >Date Of Accident</th>
                        
                            <th class='text-center' style='font-size:12px;' >What State Case</th>
                        
                            <th class='text-center' style='font-size:12px;' >Case Type ID</th>
                        
                            <th class='text-center' style='font-size:12px;' >Hear About US ID</th>
                        
                            <th class='text-center' style='font-size:12px;' >Email</th>
                        
                            <th class='text-center' style='font-size:12px;' >Phone</th>
                        
                            <th class='text-center' style='font-size:12px;' >How should we contact</th>
                        
                            <th class='text-center' style='font-size:12px;' >Address</th>
                        
                            <th class='text-center' style='font-size:12px;' >City</th>
                        
                            <th class='text-center' style='font-size:12px;' >State</th>
                        
                            <th class='text-center' style='font-size:12px;' >ZIP Code</th>
                        
                            <th class='text-center' style='font-size:12px;' >Attorney First Name</th>
                        
                            <th class='text-center' style='font-size:12px;' >Attorney Last Name</th>
                        
                            <th class='text-center' style='font-size:12px;' >Law Firm Name</th>
                        
                            <th class='text-center' style='font-size:12px;' >Law Firm Phone</th>
                        
                            <th class='text-center' style='font-size:12px;' >Application Status</th>
                        
                            <th class='text-center' style='font-size:12px;' >Applicant Verification Status</th>
                        
                <th class='text-center' style='font-size:12px;'>Created Date</th>
                </tr>
                </thead>
                <tbody>";

                    $inv=$this->ApplicationFormQuery($request);
                    foreach($inv as $voi):
                        $html .="<tr>
                        <td style='font-size:12px;' class='text-center'>".$voi->id."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->first_name."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->last_name."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->how_much_money_you_need."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->date_of_accident."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->what_state_case."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->case_type_id."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->hear_about_us_id."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->email."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->phone."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->how_should_we_contact."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->address."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->city."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->state."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->zip_code."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->attorney_first_name."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->attorney_last_name."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->law_firm_name."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->law_firm_phone."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->application_status."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->applicant_verification_status."</td>
                        <td style='font-size:12px; text-align:center;' class='text-center'>".formatDate($voi->created_at)."</td>
                        </tr>";

                    endforeach;


                $html .="</tbody>
                
                </table>


                ";

                $this->sdc->PDFLayout('Application Form Report',$html);


    }
    public function show(ApplicationForm $applicationform)
    {
        
        $tab=ApplicationForm::all();return view('admin.pages.applicationform.applicationform_list',['dataRow'=>$tab]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ApplicationForm  $applicationform
     * @return \Illuminate\Http\Response
     */
    public function edit(ApplicationForm $applicationform,$id=0)
    {
        $tab=ApplicationForm::find($id); 
        $tab_usa_states=usa_states::all();
        $tab_CaseType=CaseType::all();
        $tab_HearAboutUs=HearAboutUs::all();
        $tab_usa_states=usa_states::all();     
        return view('admin.pages.applicationform.applicationform_edit',['dataRow_usa_states'=>$tab_usa_states,'dataRow_CaseType'=>$tab_CaseType,'dataRow_HearAboutUs'=>$tab_HearAboutUs,'dataRow_usa_states'=>$tab_usa_states,'dataRow'=>$tab,'edit'=>true]);  
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ApplicationForm  $applicationform
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ApplicationForm $applicationform,$id=0)
    {
        $this->validate($request,[
                
                'first_name'=>'required',
                'last_name'=>'required',
                'how_much_money_you_need'=>'required',
                'date_of_accident'=>'required',
                'what_state_case'=>'required',
                'case_type_id'=>'required',
                'hear_about_us_id'=>'required',
                'email'=>'required',
                'phone'=>'required',
                'how_should_we_contact'=>'required',
                'address'=>'required',
                'city'=>'required',
                'state'=>'required',
                'zip_code'=>'required',
                'attorney_first_name'=>'required',
                'attorney_last_name'=>'required',
                'law_firm_name'=>'required',
                'law_firm_phone'=>'required',
                'application_status'=>'required',
                'applicant_verification_status'=>'required',
        ]);

        $this->SystemAdminLog("Application Form","Update","Edit / Modify");

        
        $tab_4_usa_states=usa_states::where('id',$request->what_state_case)->first();
        $what_state_case_4_usa_states=$tab_4_usa_states->name;
        $tab_5_CaseType=CaseType::where('id',$request->case_type_id)->first();
        $case_type_id_5_CaseType=$tab_5_CaseType->name;
        $tab_6_HearAboutUs=HearAboutUs::where('id',$request->hear_about_us_id)->first();
        $hear_about_us_id_6_HearAboutUs=$tab_6_HearAboutUs->name;
        $tab_12_usa_states=usa_states::where('id',$request->state)->first();
        $state_12_usa_states=$tab_12_usa_states->name;
        $tab=ApplicationForm::find($id);
        
        $tab->first_name=$request->first_name;
        $tab->last_name=$request->last_name;
        $tab->how_much_money_you_need=$request->how_much_money_you_need;
        $tab->date_of_accident=$request->date_of_accident;
        $tab->what_state_case_name=$what_state_case_4_usa_states;
        $tab->what_state_case=$request->what_state_case;
        $tab->case_type_id_name=$case_type_id_5_CaseType;
        $tab->case_type_id=$request->case_type_id;
        $tab->hear_about_us_id_name=$hear_about_us_id_6_HearAboutUs;
        $tab->hear_about_us_id=$request->hear_about_us_id;
        $tab->email=$request->email;
        $tab->phone=$request->phone;
        $tab->how_should_we_contact=$request->how_should_we_contact;
        $tab->address=$request->address;
        $tab->city=$request->city;
        $tab->state_name=$state_12_usa_states;
        $tab->state=$request->state;
        $tab->zip_code=$request->zip_code;
        $tab->attorney_first_name=$request->attorney_first_name;
        $tab->attorney_last_name=$request->attorney_last_name;
        $tab->law_firm_name=$request->law_firm_name;
        $tab->law_firm_phone=$request->law_firm_phone;
        $tab->application_status=$request->application_status;
        $tab->applicant_verification_status=$request->applicant_verification_status;
        $tab->save();

        return redirect('applicationform')->with('status','Updated Successfully !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ApplicationForm  $applicationform
     * @return \Illuminate\Http\Response
     */
    public function destroy(ApplicationForm $applicationform,$id=0)
    {
        $this->SystemAdminLog("Application Form","Destroy","Delete");

        $tab=ApplicationForm::find($id);
        $tab->delete();
        return redirect('applicationform')->with('status','Deleted Successfully !');}
}
