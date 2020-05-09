@extends('site.layout.master')
@section('title','Structured Settlement Application &amp; Information')
@section('content')
    <div id="content-wrap">
        <div id="page-content">
            <div class="page-header d-flex align-items-center" style="background-image: url({{asset('mod/images/Playing-catch-up-with-his-contacts-648781382_5388x4528.jpeg')}});">
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <h1 class="text-center text-white"> It's already your money — <br /> Receive a fair value now</h1>
                        </div>
                    </div>
                </div>
            </div>
        <div class="container">
            <div class="row justify-content-center pt-5 pb-4 pt-md-6 pb-md-5">
                <div class="col-md-10 ">
                        <p class="p1"><span class="s1">If your case has already settled and you are receiving payments over time, Oasis Structure Settlements™ may be able to help if you need money sooner. Use this form, or call us at <a href="tel:877.333.6680">(877) 333-6680</a></span><span class="s2">, and we can connect you with a structured settlement funding specialist</span><span class="s1">.</span></p>
                    <div class="bg-md-white shadow on-md py-md-3 pl-md-6 pr-md-5 mt-4">
                        <div class='gf_browser_gecko gform_wrapper' id='gform_wrapper_11'>
                                <div id='gf_11' class='gform_anchor' tabindex='-1'></div>
                            <form method='post' enctype='multipart/form-data' id='gform_1' action='/#gf_1'>
                                    
                                <div class="col-md-12">
                                    <div class='gform_heading'>
                                        <h3 class='gform_title'>Advantage Lending Structured Settlements™ Funding</h3> <span class='gform_description'></span>
                                    </div>
                                    <div class="row pb-3">
                                        <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
                                            <strong>All fields required</strong>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 col-xs-12 col-sm-12 col-lg-6">
                                            <div class="form-group">
                                                <label class="gfield_label" for="exampleFirstInput1">Name<span class='gfield_required'>*</span></label>
                                                <input type="text" class="form-control" autocomplete="off" id="exampleFirstInput1">
                                                <label class="gfield_label" for="exampleFirstInput1">First</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-xs-12 col-sm-12 col-lg-6">
                                            <div class="form-group">
                                                <label class="gfield_label" for="exampleLastInput1"></label>
                                                <input type="text" class="form-control" autocomplete="off" id="exampleLastInput1">
                                                <label class="gfield_label" for="exampleLastInput1">Last</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
                                            <div class="form-group">
                                                <div class="form-check form-check-inline">
                                                       <input class="form-check-input" name="" type="checkbox" id="exampleAgeInput1" value="option1">
                                                        <label class="gfield_label" for="exampleAgeInput1">Are you over the age of 18?<span class='gfield_required'>*</span></label>
                                                     </div>
                                                      <small><p class="gfield_description" id="exampleAgeInput1">(We cannot purchase structured settlements of minors.)</p></small>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
                                            <div class="form-group">
                                                 <label class="gfield_label" for="exampleAddress">Address<span class='gfield_required'>*</span></label>
                                                        <input class="form-control" name="" type="text" id="exampleAddress">
                                                        <label class="gfield_label" for="exampleAddress">Street Address</label>
                                             </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4 col-xs-12 col-sm-12 col-lg-4">
                                            <div class="form-group">
                                                <label class="gfield_label" for="exampleCity"></label>
                                                <input type="tel" class="form-control" autocomplete="off" id="exampleCity">
                                                <label class="gfield_label" for="exampleCity">City</label>
                                            </div>
                                        </div>
                                    
                                        <div class="col-md-4 col-xs-12 col-sm-12 col-lg-4">
                                            <div class="form-group">
                                                <label class="gfield_label" for="exampleFormControlInput1"></label>
                                                    <select class="form-control" id="address_stateInput" >
                                                        <option>Select One</option>
                                                        <option>2</option>
                                                        <option>3</option>
                                                        <option>4</option>
                                                        <option>5</option>
                                                    </select>
                                                    <label class="gfield_label" for="exampleFormControlInput1">State</label>
                                            </div>
                                            
                                        </div>

                                        <div class="col-md-4 col-xs-12 col-sm-12 col-lg-4">
                                            <div class="form-group">
                                                <label class="gfield_label" for="exampleZipCode"></label>
                                                <input type="text" class="form-control" autocomplete="off" id="exampleZipCode">
                                                <label class="gfield_label" for="exampleZipCode">ZIP Code</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 col-xs-12 col-sm-12 col-lg-4">
                                            <div class="form-group">
                                                <label class="gfield_label" for="exampleFormCase">When did your case settle?<span class='gfield_required'>*</span></label>
                                                <input type="tel" class="form-control" autocomplete="off" id="exampleFormCase">
                                                
                                                <div class="date"></div>
                                            </div>
                                            <small><p class="decipration">(If the case has not yet settled or settled within the past 30 days or so, it’s NOT a structured settlement.)</p></small>
                                        </div>
                                        <div class="col-md-4 col-xs-12 col-sm-12 col-lg-4">
                                            <div class="form-group">
                                                <label class="gfield_label" for="exampleFormControlEmail">Email<span class='gfield_required'>*</span></label>
                                                <input type="text" class="form-control" autocomplete="off" id="exampleFormControlEmail">
                                                
                                            </div>
                                        </div>
                                        <div class="col-md-4 col-xs-12 col-sm-12 col-lg-4">
                                            <div class="form-group">
                                                <label class="gfield_label" for="exampleFormControlPhone">Phone<span class='gfield_required'>*</span></label>
                                                <input type="text" class="form-control" autocomplete="off" id="exampleFormControlPhone">
                                            </div>
                                            <small>
                                                <p class="description">By providing your phone number on this application, you consent to receive autodialed informational phone calls to the number you provided to Oasis about the status of your application or related funding.</p>
                                            </small>
                                        </div>
                                    </div>

                                    

                                   <div class="row">
                                        <div class="col-md-6 col-xs-12 col-sm-12 col-lg-6">
                                            <div class="form-group">
                                                <label class="gfield_label" for="exampleFormControlPayment">How often do you receive payments?<span>*</span></label>
                                                    <select class="form-control" id="exampleFormControlPayment" >
                                                        <option>Select One</option>
                                                        <option>2</option>
                                                        <option>3</option>
                                                        <option>4</option>
                                                        <option>5</option>
                                                    </select>
                                                    <small><p class="decipration">(If payments are not received over some period of time, it’s NOT a structured settlement.)</p></small>
                                            </div>
                                            
                                        </div>
                                        <div class="col-md-6 col-xs-12 col-sm-12 col-lg-6">
                                            <div class="form-group">
                                                <label class="gfield_label" for="examplePayment2">Name of the company sending your payments?</label>
                                                <input type="text" class="form-control" autocomplete="off" id="examplePayment2">
                                                    <small>
                                                        <p class="decipration">(If there is no insurance company making payments to you, then it’s NOT a structured settlement.)</p>
                                                    </small>
                                            </div>
                                        </div>
                                    </div>

                                    
                                   <div class="row">
                                    <div class="col-md-6 col-xs-12 col-sm-12 col-lg-6">
                                        <div class="form-group">
                                            
                                            <label class="gfield_label" for="exampleFormControlAmount">What was the total amount of the award?*</label>
                                            <input type="text" class="form-control" autocomplete="off" id="exampleFormControlAmount">
                                        </div>
                                        
                                    </div>
                                    <div class="col-md-6 col-xs-12 col-sm-12 col-lg-6">
                                        <div class="form-group">
                                            <label class="gfield_label" for="exampleFormControlAmount2">
                                                How much do you receive in each payment?*</label>
                                            <input type="text" class="form-control" autocomplete="off" id="exampleFormControlAmount2">
                                        </div>
                                    </div>
                                </div>

            
                                    <div class="row">
                                      
                                        <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
                                            <div class="form-group">
                                                <label class="gfield_label" for="exampleFormControlNeed">How much do you need now?<span>*</span></label>
                                                <input type="text" class="form-control" autocomplete="off" id="exampleFormControlNeed">
                                                  
                                            </div>
                                            
                                                <p class="decipration">
                                                    Please be aware that not all structured settlements meet our purchase criteria. In those instances where we may not purchase your settlement, we work with group of non-affiliated companies that may be able to provide you a quote and purchase your settlement. By submitting this application, you acknowledge that Oasis, consistent with its 
                                                    <a href="#">Privacy Policy</a>, may refer your application to a non-affiliated company. For further information, including how to opt out, visit our <a href="#">Privacy Policy</a>.</p>
                                                    <p class="decipration"> Would you like us to refer your application to a non-affiliated company if we do not process your case ourselves?*</p>

                                                    <div class="ginput_container ginput_container_radio">
                                                        <ul class="gfield_radio" id="input_11_24">
                                                            <li class="gchoice_0">
                                                                <input name="input_24" type="radio" value="Yes" id="choice_1">
                                                                <label for="choice_11_24_0" id="label_1">Yes</label>
                                                            </li>
                                                            <li class="gchoice_1">
                                                                <input name="input_24" type="radio" value="No" id="choice_2">
                                                            <label for="choice_2" id="label_1">No</label>
                                                        </li>
                                                    </ul>
                                                </div>
                                            
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
                                            <button type="submit" class="gform_button button">
                                                Continue
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                                
                        </div> 
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
