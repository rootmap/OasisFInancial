
@extends("admin.layout.master")
@section("title","Edit Structured Settlement Application Form")
@section("content")
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Structured Settlement Application Form</h1>
      </div>
      <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('structuredsettlementapplicationform/list')}}">Datatable </a></li>
              <li class="breadcrumb-item"><a href="{{url('structuredsettlementapplicationform/create')}}">Create New </a></li>
              <li class="breadcrumb-item active">Edit / Modify</li>
            </ol>
      </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            @include("admin.include.msg")
        </div>
    </div>
  </div><!-- /.container-fluid -->
</section>
<section>
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <!-- left column -->
      <div class="col-md-8 offset-2">
        <!-- general form elements -->
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Edit / Modify Structured Settlement Application Form</h3>
            <div class="card-tools">
              <ul class="pagination pagination-sm float-right">
                <li class="page-item">
                    <a class="page-link bg-primary" href="{{url('structuredsettlementapplicationform/create')}}"> 
                        Create 
                        <i class="fas fa-plus"></i>
                    </a>
                </li>
                <li class="page-item">
                    <a class="page-link bg-primary" href="{{url('structuredsettlementapplicationform/list')}}"> 
                        Data 
                        <i class="fas fa-table"></i>
                    </a>
                </li>
                <li class="page-item">
                  <a class="page-link  bg-primary" target="_blank" href="{{url('structuredsettlementapplicationform/export/pdf')}}">
                    <i class="fas fa-file-pdf" data-toggle="tooltip" data-html="true"title="Pdf"></i>
                  </a>
                </li>
                <li class="page-item">
                  <a class="page-link  bg-primary" target="_blank" href="{{url('structuredsettlementapplicationform/export/excel')}}">
                    <i class="fas fa-file-excel" data-toggle="tooltip" data-html="true"title="Excel"></i>
                  </a>
                </li>
              </ul>
            </div>
        </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form action="{{url('structuredsettlementapplicationform/update/'.$dataRow->id)}}" method="post" enctype="multipart/form-data">
          {{csrf_field()}}
          
            <div class="card-body">
                
                <div class="row">
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="first_name">First Name</label>
                        <input type="text" 
                            
                        <?php 
                        if(isset($dataRow->first_name)){
                            ?>
                            value="{{$dataRow->first_name}}" 
                            <?php 
                        }
                        ?>
                        
                        class="form-control" placeholder="Enter First Name" id="first_name" name="first_name">
                      </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="last_name">Last Name</label>
                        <input type="text" 
                            
                        <?php 
                        if(isset($dataRow->last_name)){
                            ?>
                            value="{{$dataRow->last_name}}" 
                            <?php 
                        }
                        ?>
                        
                        class="form-control" placeholder="Enter Last Name" id="last_name" name="last_name">
                      </div>
                    </div>
                </div>
                
        <div class="row">
            <div class="col-sm-12">
              <!-- checkbox -->
              <div class="form-group">
              <label>Are you over the age of 18?</label>
        
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox"  
                                <?php 
                                if($dataRow->are_you_over_the_age_of_18=="Yes"){
                                    ?>
                                    checked="checked" 
                                    <?php 
                                }
                                ?>
                          id="are_you_over_the_age_of_18_0" name="are_you_over_the_age_of_18" value="Yes">
                          <label class="form-check-label">Yes</label>
                        </div>
                
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox"  
                                <?php 
                                if($dataRow->are_you_over_the_age_of_18=="No"){
                                    ?>
                                    checked="checked" 
                                    <?php 
                                }
                                ?>
                          id="are_you_over_the_age_of_18_1" name="are_you_over_the_age_of_18" value="No">
                          <label class="form-check-label">No</label>
                        </div>
                
                    </div>
                </div>
            </div>
            
                <div class="row">
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" 
                            
                        <?php 
                        if(isset($dataRow->address)){
                            ?>
                            value="{{$dataRow->address}}" 
                            <?php 
                        }
                        ?>
                        
                        class="form-control" placeholder="Enter Street Address" id="address" name="address">
                      </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="city">City</label>
                        <input type="text" 
                            
                        <?php 
                        if(isset($dataRow->city)){
                            ?>
                            value="{{$dataRow->city}}" 
                            <?php 
                        }
                        ?>
                        
                        class="form-control" placeholder="Enter Name" id="city" name="city">
                      </div>
                    </div>
                </div>
                
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                  <label>Enter State Name</label>
                                  <select class="form-control select2" style="width: 100%;"  id="state" name="state">
                                    
                                        <option value="">Please Select</option>
                                        @if(count($dataRow_usa_states)>0)
                                            @foreach($dataRow_usa_states as $usa_states)
                                                <option 
                                        @if(isset($dataRow->Active))
                                            @if($dataRow->Active==$usa_states->Active)
                                                selected="selected" 
                                            @endif
                                        @endif 
                                         value="{{$usa_states->Active}}">{{$usa_states->Inactive}}</option>
                                                
                                            @endforeach
                                        @endif
                                        
                                  </select>
                                </div>
                            </div>
                        </div>
                    
                <div class="row">
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="zip_code">ZIP Code</label>
                        <input type="text" 
                            
                        <?php 
                        if(isset($dataRow->zip_code)){
                            ?>
                            value="{{$dataRow->zip_code}}" 
                            <?php 
                        }
                        ?>
                        
                        class="form-control" placeholder="Enter ZIP Code" id="zip_code" name="zip_code">
                      </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="when_did_your_case_settle">When did your case settle</label>
                        <input type="text" 
                            
                        <?php 
                        if(isset($dataRow->when_did_your_case_settle)){
                            ?>
                            value="{{$dataRow->when_did_your_case_settle}}" 
                            <?php 
                        }
                        ?>
                        
                        class="form-control" placeholder="When did your case settle?" id="when_did_your_case_settle" name="when_did_your_case_settle">
                      </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" 
                            
                        <?php 
                        if(isset($dataRow->email)){
                            ?>
                            value="{{$dataRow->email}}" 
                            <?php 
                        }
                        ?>
                        
                        class="form-control" placeholder="Enter Email" id="email" name="email">
                      </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="text" 
                            
                        <?php 
                        if(isset($dataRow->phone)){
                            ?>
                            value="{{$dataRow->phone}}" 
                            <?php 
                        }
                        ?>
                        
                        class="form-control" placeholder="Enter Phone" id="phone" name="phone">
                      </div>
                    </div>
                </div>
                
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                  <label>How often do you receive payments?</label>
                                  <select class="form-control select2" style="width: 100%;"  id="how_often_do_you_receive_payments" name="how_often_do_you_receive_payments">
                                    
        <option value="">Please select</option>
            <option 
                    <?php 
                    if($dataRow->how_often_do_you_receive_payments=="Weekly"){
                        ?>
                        selected="selected" 
                        <?php 
                    }
                    ?> 
            value="Weekly">Weekly</option>
            <option 
                    <?php 
                    if($dataRow->how_often_do_you_receive_payments=="Monthly"){
                        ?>
                        selected="selected" 
                        <?php 
                    }
                    ?> 
            value="Monthly">Monthly</option>
            <option 
                    <?php 
                    if($dataRow->how_often_do_you_receive_payments=="Yearly"){
                        ?>
                        selected="selected" 
                        <?php 
                    }
                    ?> 
            value="Yearly">Yearly</option>
                                  </select>
                                </div>
                            </div>
                        </div>
                    
                <div class="row">
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="name_of_the_company_sending_your_payments">Name of the company sending your payments</label>
                        <input type="text" 
                            
                        <?php 
                        if(isset($dataRow->name_of_the_company_sending_your_payments)){
                            ?>
                            value="{{$dataRow->name_of_the_company_sending_your_payments}}" 
                            <?php 
                        }
                        ?>
                        
                        class="form-control" placeholder="Name of the company sending your payments?" id="name_of_the_company_sending_your_payments" name="name_of_the_company_sending_your_payments">
                      </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="what_was_the_total_amount_of_the_award">What was the total amount of the award</label>
                        <input type="text" 
                            
                        <?php 
                        if(isset($dataRow->what_was_the_total_amount_of_the_award)){
                            ?>
                            value="{{$dataRow->what_was_the_total_amount_of_the_award}}" 
                            <?php 
                        }
                        ?>
                        
                        class="form-control" placeholder="What was the total amount of the award?" id="what_was_the_total_amount_of_the_award" name="what_was_the_total_amount_of_the_award">
                      </div>
                    </div>
                </div>
                
        <div class="row">
            <div class="col-sm-12">
              <!-- radio -->
              <div class="form-group">
              <label>Would you like us to refer your application to a non-affiliated company if we do not process your case ourselves?</label>
        
                        <div class="form-check">
                            <input class="form-check-input" type="radio"  
                                <?php 
                                if($dataRow->refer=="Yes"){
                                    ?>
                                    checked="checked" 
                                    <?php 
                                }
                                ?>
                          id="refer_0" name="refer" value="Yes">
                          <label class="form-check-label">Yes</label>
                        </div>
                
                        <div class="form-check">
                            <input class="form-check-input" type="radio"  
                                <?php 
                                if($dataRow->refer=="No"){
                                    ?>
                                    checked="checked" 
                                    <?php 
                                }
                                ?>
                          id="refer_1" name="refer" value="No">
                          <label class="form-check-label">No</label>
                        </div>
                
                    </div>
                </div>
            </div>
            
        <div class="row">
            <div class="col-sm-12">
              <!-- radio -->
              <div class="form-group">
              <label>Choose Application Status</label>
        
                        <div class="form-check">
                            <input class="form-check-input" type="radio"  
                                <?php 
                                if($dataRow->application_status=="New"){
                                    ?>
                                    checked="checked" 
                                    <?php 
                                }
                                ?>
                          id="application_status_0" name="application_status" value="New">
                          <label class="form-check-label">New</label>
                        </div>
                
                        <div class="form-check">
                            <input class="form-check-input" type="radio"  
                                <?php 
                                if($dataRow->application_status=="Processing"){
                                    ?>
                                    checked="checked" 
                                    <?php 
                                }
                                ?>
                          id="application_status_1" name="application_status" value="Processing">
                          <label class="form-check-label">Processing</label>
                        </div>
                
                        <div class="form-check">
                            <input class="form-check-input" type="radio"  
                                <?php 
                                if($dataRow->application_status=="Close"){
                                    ?>
                                    checked="checked" 
                                    <?php 
                                }
                                ?>
                          id="application_status_2" name="application_status" value="Close">
                          <label class="form-check-label">Close</label>
                        </div>
                
                    </div>
                </div>
            </div>
            
        <div class="row">
            <div class="col-sm-12">
              <!-- radio -->
              <div class="form-group">
              <label>Choose Applicant Verification Status</label>
        
                        <div class="form-check">
                            <input class="form-check-input" type="radio"  
                                <?php 
                                if($dataRow->applicant_verification_status=="Unverified"){
                                    ?>
                                    checked="checked" 
                                    <?php 
                                }
                                ?>
                          id="applicant_verification_status_0" name="applicant_verification_status" value="Unverified">
                          <label class="form-check-label">Unverified</label>
                        </div>
                
                        <div class="form-check">
                            <input class="form-check-input" type="radio"  
                                <?php 
                                if($dataRow->applicant_verification_status=="Verified"){
                                    ?>
                                    checked="checked" 
                                    <?php 
                                }
                                ?>
                          id="applicant_verification_status_1" name="applicant_verification_status" value="Verified">
                          <label class="form-check-label">Verified</label>
                        </div>
                
                    </div>
                </div>
            </div>
                   
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
              <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> 
                Update
              </button>
              <a class="btn btn-danger" href="{{url('structuredsettlementapplicationform/edit/'.$dataRow->id)}}">
                <i class="far fa-times-circle"></i> 
                Reset
              </a>
            </div>
          </form>
        </div>
        <!-- /.card -->

      </div>
      <!--/.col (left) -->
    </div>
    <!-- /.row -->
  </div><!-- /.container-fluid -->
</section>
@endsection
@section("css")
    
    <link rel="stylesheet" href="{{url('admin/plugins/select2/css/select2.min.css')}}">
    
@endsection
        
@section("js")

    <script src="{{url('admin/plugins/select2/js/select2.full.min.js')}}"></script>
    <script>
    $(document).ready(function(){
        $(".select2").select2();
    });
    </script>

@endsection
        