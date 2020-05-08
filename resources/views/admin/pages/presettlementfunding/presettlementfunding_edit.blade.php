
@extends("admin.layout.master")
@section("title","Edit Pre Settlement Funding")
@section("content")
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Pre Settlement Funding</h1>
      </div>
      <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">Update Pre Settlement Funding</li>
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
            <h3 class="card-title">Edit / Modify Pre Settlement Funding</h3>
        </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form action="{{url('presettlementfunding/update/'.$dataRow->id)}}" method="post" enctype="multipart/form-data">
          {{csrf_field()}}
          
            <div class="card-body">
                
                <div class="row">
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="section_title">Section Title</label>
                        <input type="text" 
                            
                        <?php 
                        if(isset($dataRow->section_title)){
                            ?>
                            value="{{$dataRow->section_title}}" 
                            <?php 
                        }
                        ?>
                        
                        class="form-control" placeholder="Enter Section Title" id="section_title" name="section_title">
                      </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="section_detail">Section Detail</label>
                        <textarea class="form-control textarea" rows="3"  placeholder="Enter Section Detail" id="section_detail" name="section_detail"><?php 
                                if(isset($dataRow->section_detail)){
                                    
                                    echo $dataRow->section_detail;
                                    
                                }
                                ?></textarea>
                      </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Choose Icon One</label>
                            <!-- <label for="customFile">Choose Icon One</label> -->
                            <div class="custom-file">
                              <input type="file" class="custom-file-input"  id="icon_one" name="icon_one">
                              <input type="hidden" value="{{$dataRow->icon_one}}" name="ex_icon_one" />
                              <label class="custom-file-label" for="customFile">Choose Icon One</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        @if(isset($dataRow->icon_one))
                            @if(!empty($dataRow->icon_one))
                                <img class="img-thumbnail" src="{{url('upload/presettlementfunding/'.$dataRow->icon_one)}}" width="150">
                            @endif
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="icon_one_detail">Icon One Detail</label>
                        <textarea class="form-control textarea" rows="3"  placeholder="Enter One Detail" id="icon_one_detail" name="icon_one_detail"><?php 
                                if(isset($dataRow->icon_one_detail)){
                                    
                                    echo $dataRow->icon_one_detail;
                                    
                                }
                                ?></textarea>
                      </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Choose Icon Two</label>
                            <!-- <label for="customFile">Choose Icon Two</label> -->
                            <div class="custom-file">
                              <input type="file" class="custom-file-input"  id="icon_two" name="icon_two">
                              <input type="hidden" value="{{$dataRow->icon_two}}" name="ex_icon_two" />
                              <label class="custom-file-label" for="customFile">Choose Icon Two</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        @if(isset($dataRow->icon_two))
                            @if(!empty($dataRow->icon_two))
                                <img class="img-thumbnail" src="{{url('upload/presettlementfunding/'.$dataRow->icon_two)}}" width="150">
                            @endif
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="icon_two_detail">Icon Two Detail</label>
                        <textarea class="form-control textarea" rows="3"  placeholder="Enter Two Detail" id="icon_two_detail" name="icon_two_detail"><?php 
                                if(isset($dataRow->icon_two_detail)){
                                    
                                    echo $dataRow->icon_two_detail;
                                    
                                }
                                ?></textarea>
                      </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Choose Icon Three</label>
                            <!-- <label for="customFile">Choose Icon Three</label> -->
                            <div class="custom-file">
                              <input type="file" class="custom-file-input"  id="icon_three" name="icon_three">
                              <input type="hidden" value="{{$dataRow->icon_three}}" name="ex_icon_three" />
                              <label class="custom-file-label" for="customFile">Choose Icon Three</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        @if(isset($dataRow->icon_three))
                            @if(!empty($dataRow->icon_three))
                                <img class="img-thumbnail" src="{{url('upload/presettlementfunding/'.$dataRow->icon_three)}}" width="150">
                            @endif
                        @endif
                    </div>
                </div>
                
                
                
                
                <div class="row">
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="icon_three_detail">Icon Three Detail</label>
                        <textarea class="form-control textarea" rows="3"  placeholder="Enter Three Detail" id="icon_three_detail" name="icon_three_detail"><?php 
                                if(isset($dataRow->icon_three_detail)){
                                    
                                    echo $dataRow->icon_three_detail;
                                    
                                }
                                ?></textarea>
                      </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="button_text">Button Text</label>
                        <input type="text" 
                            
                        <?php 
                        if(isset($dataRow->button_text)){
                            ?>
                            value="{{$dataRow->button_text}}" 
                            <?php 
                        }
                        ?>
                        
                        class="form-control" placeholder="Enter Button Text" id="button_text" name="button_text">
                      </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="button_url">Button Url</label>
                        <input type="text" 
                            
                        <?php 
                        if(isset($dataRow->button_url)){
                            ?>
                            value="{{$dataRow->button_url}}" 
                            <?php 
                        }
                        ?>
                        
                        class="form-control" placeholder="Enter Button Url" id="button_url" name="button_url">
                      </div>
                    </div>
                </div>
                
        <div class="row">
            <div class="col-sm-12">
              <!-- radio -->
              <div class="form-group">
              <label>Choose Module Status</label>
        
                        <div class="form-check">
                            <input class="form-check-input" type="radio"  
                                <?php 
                                if($dataRow->module_status=="Active"){
                                    ?>
                                    checked="checked" 
                                    <?php 
                                }
                                ?>
                          id="module_status_0" name="module_status" value="Active">
                          <label class="form-check-label">Active</label>
                        </div>
                
                        <div class="form-check">
                            <input class="form-check-input" type="radio"  
                                <?php 
                                if($dataRow->module_status=="Inactive"){
                                    ?>
                                    checked="checked" 
                                    <?php 
                                }
                                ?>
                          id="module_status_1" name="module_status" value="Inactive">
                          <label class="form-check-label">Inactive</label>
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
              <a class="btn btn-danger" href="{{url('presettlementfunding/edit/'.$dataRow->id)}}">
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
@section('css')
    <link rel="stylesheet" href="{{url('admin/plugins/summernote/summernote-bs4.css')}}">
@endsection
@section("js")

    <script src="{{url('admin/plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>
    <script>
    $(document).ready(function(){
        bsCustomFileInput.init();
    });
    </script>

    <script src="{{url('admin/plugins/summernote/summernote-bs4.min.js')}}"></script>
    <script>
      $(function () {
        // Summernote
        $('.textarea').summernote({
          height: 150,
          toolbar: [
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['insert', ['link', 'hr']],
                    ['view', ['fullscreen', 'codeview']],
                  ],
        });

        $('.textareadescription').summernote({
          height: 100,
          toolbar: [
                    
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['view', ['fullscreen', 'codeview']],
                  ],
        });
      });
    </script>

@endsection
        