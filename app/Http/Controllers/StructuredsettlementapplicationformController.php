<?php

namespace App\Http\Controllers;

use App\StructuredSettlementApplicationForm;
use App\AdminLog;
use Illuminate\Http\Request;
use App\usa_states;
                

class StructuredSettlementApplicationFormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $moduleName="Structured Settlement Application Form";
    private $sdc;
    public function __construct(){ $this->sdc = new CoreCustomController(); }
    
    public function index(){
        $tab=StructuredSettlementApplicationForm::all();
        return view('admin.pages.structuredsettlementapplicationform.structuredsettlementapplicationform_list',['dataRow'=>$tab]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){


        
        $tab_usa_states=usa_states::all();           
        return view('admin.pages.structuredsettlementapplicationform.structuredsettlementapplicationform_create',['dataRow_usa_states'=>$tab_usa_states]);
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
                'address'=>'required',
                'city'=>'required',
                'state'=>'required',
                'zip_code'=>'required',
                'when_did_your_case_settle'=>'required',
                'email'=>'required',
                'phone'=>'required',
                'how_often_do_you_receive_payments'=>'required',
                'name_of_the_company_sending_your_payments'=>'required',
                'what_was_the_total_amount_of_the_award'=>'required',
                'how_much_do_you_receive_in_each_payment'=>'required',
                'how_much_do_you_need_now'=>'required',
                'refer'=>'required',
                'application_status'=>'required',
                'applicant_verification_status'=>'required',
        ]);

        $this->SystemAdminLog("Structured Settlement Application Form","Save New","Create New");

        
        $tab_5_usa_states=usa_states::where('id',$request->state)->first();
        $state_5_usa_states=$tab_5_usa_states->Inactive;
        $tab=new StructuredSettlementApplicationForm();
        
        $tab->first_name=$request->first_name;
        $tab->last_name=$request->last_name;
        $tab->are_you_over_the_age_of_18=$request->are_you_over_the_age_of_18;
        $tab->address=$request->address;
        $tab->city=$request->city;
        $tab->state_Inactive=$state_5_usa_states;
        $tab->state=$request->state;
        $tab->zip_code=$request->zip_code;
        $tab->when_did_your_case_settle=$request->when_did_your_case_settle;
        $tab->email=$request->email;
        $tab->phone=$request->phone;
        $tab->how_often_do_you_receive_payments=$request->how_often_do_you_receive_payments;
        $tab->name_of_the_company_sending_your_payments=$request->name_of_the_company_sending_your_payments;
        $tab->what_was_the_total_amount_of_the_award=$request->what_was_the_total_amount_of_the_award;
        $tab->how_much_do_you_receive_in_each_payment=$request->how_much_do_you_receive_in_each_payment;
        $tab->how_much_do_you_need_now=$request->how_much_do_you_need_now;
        $tab->refer=$request->refer;
        $tab->application_status=$request->application_status;
        $tab->applicant_verification_status=$request->applicant_verification_status;
        $tab->save();

        return redirect('structuredsettlementapplicationform')->with('status','Added Successfully !');

    }

    public function ajax(Request $request)
    {
        $this->validate($request,[
                
                'first_name'=>'required',
                'last_name'=>'required',
                'address'=>'required',
                'city'=>'required',
                'state'=>'required',
                'zip_code'=>'required',
                'when_did_your_case_settle'=>'required',
                'email'=>'required',
                'phone'=>'required',
                'how_often_do_you_receive_payments'=>'required',
                'name_of_the_company_sending_your_payments'=>'required',
                'what_was_the_total_amount_of_the_award'=>'required',
                'how_much_do_you_receive_in_each_payment'=>'required',
                'how_much_do_you_need_now'=>'required',
                'refer'=>'required',
                'application_status'=>'required',
                'applicant_verification_status'=>'required',
        ]);

        $tab=new StructuredSettlementApplicationForm();
        
        $tab->first_name=$request->first_name;
        $tab->last_name=$request->last_name;
        $tab->are_you_over_the_age_of_18=$request->are_you_over_the_age_of_18;
        $tab->address=$request->address;
        $tab->city=$request->city;
        $tab->state_Inactive=$state_5_usa_states;
        $tab->state=$request->state;
        $tab->zip_code=$request->zip_code;
        $tab->when_did_your_case_settle=$request->when_did_your_case_settle;
        $tab->email=$request->email;
        $tab->phone=$request->phone;
        $tab->how_often_do_you_receive_payments=$request->how_often_do_you_receive_payments;
        $tab->name_of_the_company_sending_your_payments=$request->name_of_the_company_sending_your_payments;
        $tab->what_was_the_total_amount_of_the_award=$request->what_was_the_total_amount_of_the_award;
        $tab->how_much_do_you_receive_in_each_payment=$request->how_much_do_you_receive_in_each_payment;
        $tab->how_much_do_you_need_now=$request->how_much_do_you_need_now;
        $tab->refer=$request->refer;
        $tab->application_status=$request->application_status;
        $tab->applicant_verification_status=$request->applicant_verification_status;
        $tab->save();

        echo json_encode(array("status"=>"success","msg"=>"Added Successfully."));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\StructuredSettlementApplicationForm  $structuredsettlementapplicationform
     * @return \Illuminate\Http\Response
     */

    private function methodToGetMembersCount($search=""){

        $tab=Customer::select('id','name','address','phone','email','last_invoice_no','created_at')
                     ->where('store_id',$this->sdc->storeID())->orderBy('id','DESC')
                     ->when($search, function ($query) use ($search) {
                        $query->where('id','LIKE','%'.$search.'%');
                            $query->orWhere('first_name','LIKE','%'.$search.'%');
                            $query->orWhere('last_name','LIKE','%'.$search.'%');
                            $query->orWhere('are_you_over_the_age_of_18','LIKE','%'.$search.'%');
                            $query->orWhere('address','LIKE','%'.$search.'%');
                            $query->orWhere('city','LIKE','%'.$search.'%');
                            $query->orWhere('state','LIKE','%'.$search.'%');
                            $query->orWhere('zip_code','LIKE','%'.$search.'%');
                            $query->orWhere('when_did_your_case_settle','LIKE','%'.$search.'%');
                            $query->orWhere('email','LIKE','%'.$search.'%');
                            $query->orWhere('phone','LIKE','%'.$search.'%');
                            $query->orWhere('how_often_do_you_receive_payments','LIKE','%'.$search.'%');
                            $query->orWhere('name_of_the_company_sending_your_payments','LIKE','%'.$search.'%');
                            $query->orWhere('what_was_the_total_amount_of_the_award','LIKE','%'.$search.'%');
                            $query->orWhere('how_much_do_you_receive_in_each_payment','LIKE','%'.$search.'%');
                            $query->orWhere('how_much_do_you_need_now','LIKE','%'.$search.'%');
                            $query->orWhere('refer','LIKE','%'.$search.'%');
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
                            $query->orWhere('are_you_over_the_age_of_18','LIKE','%'.$search.'%');
                            $query->orWhere('address','LIKE','%'.$search.'%');
                            $query->orWhere('city','LIKE','%'.$search.'%');
                            $query->orWhere('state','LIKE','%'.$search.'%');
                            $query->orWhere('zip_code','LIKE','%'.$search.'%');
                            $query->orWhere('when_did_your_case_settle','LIKE','%'.$search.'%');
                            $query->orWhere('email','LIKE','%'.$search.'%');
                            $query->orWhere('phone','LIKE','%'.$search.'%');
                            $query->orWhere('how_often_do_you_receive_payments','LIKE','%'.$search.'%');
                            $query->orWhere('name_of_the_company_sending_your_payments','LIKE','%'.$search.'%');
                            $query->orWhere('what_was_the_total_amount_of_the_award','LIKE','%'.$search.'%');
                            $query->orWhere('how_much_do_you_receive_in_each_payment','LIKE','%'.$search.'%');
                            $query->orWhere('how_much_do_you_need_now','LIKE','%'.$search.'%');
                            $query->orWhere('refer','LIKE','%'.$search.'%');
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

    
    public function StructuredSettlementApplicationFormQuery($request)
    {
        $StructuredSettlementApplicationForm_data=StructuredSettlementApplicationForm::orderBy('id','DESC')->get();

        return $StructuredSettlementApplicationForm_data;
    }
    
   

    public function ExportExcel(Request $request) 
    {
         $dataDateTimeIns=formatDateTime(date('d-M-Y H:i:s a'));
        $data=array();
        $array_column=array(
                                'ID','First Name','Last Name','Are you over the age of 18','Address','City','State','ZIP Code','When did your case settle','Email','Phone','How often do you receive payments','Name of the company sending your payments','What was the total amount of the award','How much do you receive in each payment','How much do you need now','Refer','Application Status','Applicant Verification Status','Created Date');
        array_push($data, $array_column);
        $inv=$this->StructuredSettlementApplicationFormQuery($request);
        foreach($inv as $voi):
            $inv_arry=array(
                                $voi->id,$voi->first_name,$voi->last_name,$voi->are_you_over_the_age_of_18,$voi->address,$voi->city,$voi->state,$voi->zip_code,$voi->when_did_your_case_settle,$voi->email,$voi->phone,$voi->how_often_do_you_receive_payments,$voi->name_of_the_company_sending_your_payments,$voi->what_was_the_total_amount_of_the_award,$voi->how_much_do_you_receive_in_each_payment,$voi->how_much_do_you_need_now,$voi->refer,$voi->application_status,$voi->applicant_verification_status,formatDate($voi->created_at));
            array_push($data, $inv_arry);
        endforeach;

        $excelArray=array(
            'report_name'=>'Structured Settlement Application Form Report',
            'report_title'=>'Structured Settlement Application Form Report',
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
                        
                            <th class='text-center' style='font-size:12px;' >Are you over the age of 18</th>
                        
                            <th class='text-center' style='font-size:12px;' >Address</th>
                        
                            <th class='text-center' style='font-size:12px;' >City</th>
                        
                            <th class='text-center' style='font-size:12px;' >State</th>
                        
                            <th class='text-center' style='font-size:12px;' >ZIP Code</th>
                        
                            <th class='text-center' style='font-size:12px;' >When did your case settle</th>
                        
                            <th class='text-center' style='font-size:12px;' >Email</th>
                        
                            <th class='text-center' style='font-size:12px;' >Phone</th>
                        
                            <th class='text-center' style='font-size:12px;' >How often do you receive payments</th>
                        
                            <th class='text-center' style='font-size:12px;' >Name of the company sending your payments</th>
                        
                            <th class='text-center' style='font-size:12px;' >What was the total amount of the award</th>
                        
                            <th class='text-center' style='font-size:12px;' >How much do you receive in each payment</th>
                        
                            <th class='text-center' style='font-size:12px;' >How much do you need now</th>
                        
                            <th class='text-center' style='font-size:12px;' >Refer</th>
                        
                            <th class='text-center' style='font-size:12px;' >Application Status</th>
                        
                            <th class='text-center' style='font-size:12px;' >Applicant Verification Status</th>
                        
                <th class='text-center' style='font-size:12px;'>Created Date</th>
                </tr>
                </thead>
                <tbody>";

                    $inv=$this->StructuredSettlementApplicationFormQuery($request);
                    foreach($inv as $voi):
                        $html .="<tr>
                        <td style='font-size:12px;' class='text-center'>".$voi->id."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->first_name."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->last_name."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->are_you_over_the_age_of_18."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->address."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->city."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->state."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->zip_code."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->when_did_your_case_settle."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->email."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->phone."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->how_often_do_you_receive_payments."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->name_of_the_company_sending_your_payments."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->what_was_the_total_amount_of_the_award."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->how_much_do_you_receive_in_each_payment."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->how_much_do_you_need_now."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->refer."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->application_status."</td>
                        <td style='font-size:12px;' class='text-center'>".$voi->applicant_verification_status."</td>
                        <td style='font-size:12px; text-align:center;' class='text-center'>".formatDate($voi->created_at)."</td>
                        </tr>";

                    endforeach;


                $html .="</tbody>
                
                </table>


                ";

                $this->sdc->PDFLayout('Structured Settlement Application Form Report',$html);


    }
    public function show(StructuredSettlementApplicationForm $structuredsettlementapplicationform)
    {
        
        $tab=StructuredSettlementApplicationForm::all();return view('admin.pages.structuredsettlementapplicationform.structuredsettlementapplicationform_list',['dataRow'=>$tab]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\StructuredSettlementApplicationForm  $structuredsettlementapplicationform
     * @return \Illuminate\Http\Response
     */
    public function edit(StructuredSettlementApplicationForm $structuredsettlementapplicationform,$id=0)
    {
        $tab=StructuredSettlementApplicationForm::find($id); 
        $tab_usa_states=usa_states::all();     
        return view('admin.pages.structuredsettlementapplicationform.structuredsettlementapplicationform_edit',['dataRow_usa_states'=>$tab_usa_states,'dataRow'=>$tab,'edit'=>true]);  
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\StructuredSettlementApplicationForm  $structuredsettlementapplicationform
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StructuredSettlementApplicationForm $structuredsettlementapplicationform,$id=0)
    {
        $this->validate($request,[
                
                'first_name'=>'required',
                'last_name'=>'required',
                'address'=>'required',
                'city'=>'required',
                'state'=>'required',
                'zip_code'=>'required',
                'when_did_your_case_settle'=>'required',
                'email'=>'required',
                'phone'=>'required',
                'how_often_do_you_receive_payments'=>'required',
                'name_of_the_company_sending_your_payments'=>'required',
                'what_was_the_total_amount_of_the_award'=>'required',
                'how_much_do_you_receive_in_each_payment'=>'required',
                'how_much_do_you_need_now'=>'required',
                'refer'=>'required',
                'application_status'=>'required',
                'applicant_verification_status'=>'required',
        ]);

        $this->SystemAdminLog("Structured Settlement Application Form","Update","Edit / Modify");

        
        $tab_5_usa_states=usa_states::where('id',$request->state)->first();
        $state_5_usa_states=$tab_5_usa_states->Inactive;
        $tab=StructuredSettlementApplicationForm::find($id);
        
        $tab->first_name=$request->first_name;
        $tab->last_name=$request->last_name;
        $tab->are_you_over_the_age_of_18=$request->are_you_over_the_age_of_18;
        $tab->address=$request->address;
        $tab->city=$request->city;
        $tab->state_Inactive=$state_5_usa_states;
        $tab->state=$request->state;
        $tab->zip_code=$request->zip_code;
        $tab->when_did_your_case_settle=$request->when_did_your_case_settle;
        $tab->email=$request->email;
        $tab->phone=$request->phone;
        $tab->how_often_do_you_receive_payments=$request->how_often_do_you_receive_payments;
        $tab->name_of_the_company_sending_your_payments=$request->name_of_the_company_sending_your_payments;
        $tab->what_was_the_total_amount_of_the_award=$request->what_was_the_total_amount_of_the_award;
        $tab->how_much_do_you_receive_in_each_payment=$request->how_much_do_you_receive_in_each_payment;
        $tab->how_much_do_you_need_now=$request->how_much_do_you_need_now;
        $tab->refer=$request->refer;
        $tab->application_status=$request->application_status;
        $tab->applicant_verification_status=$request->applicant_verification_status;
        $tab->save();

        return redirect('structuredsettlementapplicationform')->with('status','Updated Successfully !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\StructuredSettlementApplicationForm  $structuredsettlementapplicationform
     * @return \Illuminate\Http\Response
     */
    public function destroy(StructuredSettlementApplicationForm $structuredsettlementapplicationform,$id=0)
    {
        $this->SystemAdminLog("Structured Settlement Application Form","Destroy","Delete");

        $tab=StructuredSettlementApplicationForm::find($id);
        $tab->delete();
        return redirect('structuredsettlementapplicationform')->with('status','Deleted Successfully !');}
}
