
@extends("admin.layout.master")
@section("title","Edit How We Help")
@section("content")
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>How We Help</h1>
      </div>
      <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">Update How We Help</li>
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
            <h3 class="card-title">Edit / Modify How We Help</h3>
        </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form action="{{url('howwehelp/update/'.$dataRow->id)}}" method="post" enctype="multipart/form-data">
          {{csrf_field()}}
          
            <div class="card-body">
                
                <div class="row">
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="block_heading">Block Heading</label>
                        <input type="text" 
                            
                        <?php 
                        if(isset($dataRow->block_heading)){
                            ?>
                            value="{{$dataRow->block_heading}}" 
                            <?php 
                        }
                        ?>
                        
                        class="form-control" placeholder="Enter Block Heading" id="block_heading" name="block_heading">
                      </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="block_detail">Block Detail</label>
                        <textarea class="form-control textareadescription" rows="3"  placeholder="Enter Detail" id="block_detail" name="block_detail"><?php 
                                if(isset($dataRow->block_detail)){
                                    
                                    echo $dataRow->block_detail;
                                    
                                }
                                ?></textarea>
                      </div>
                    </div>
                </div>
                
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Choose Item One Icon</label>
                                    <!-- <label for="customFile">Choose Item One Icon</label> -->
                                    <div class="custom-file">
                                      <input type="file" class="custom-file-input"  id="item_one_icon" name="item_one_icon">
                                      <input type="hidden" value="{{$dataRow->item_one_icon}}" name="ex_item_one_icon" />
                                      <label class="custom-file-label" for="customFile">Choose Item One Icon</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                @if(isset($dataRow->item_one_icon))
                                    @if(!empty($dataRow->item_one_icon))
                                        <img class="img-thumbnail" src="{{url('upload/howwehelp/'.$dataRow->item_one_icon)}}" width="150">
                                    @endif
                                @endif
                            </div>
                        </div>
                <div class="row">
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="item_one_detail">Item One Detail</label>
                        <textarea class="form-control textarea" placeholder="Enter Item One Detail" id="item_one_detail" 
                        name="item_one_detail"><?php 
                        if(isset($dataRow->item_one_detail)){
                            ?>{{$dataRow->item_one_detail}}<?php 
                        }
                        ?></textarea>
                      </div>
                    </div>
                </div>
                
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Choose Item Two Icon</label>
                                    <!-- <label for="customFile">Choose Item Two Icon</label> -->
                                    <div class="custom-file">
                                      <input type="file" class="custom-file-input"  id="item_two_icon" name="item_two_icon">
                                      <input type="hidden" value="{{$dataRow->item_two_icon}}" name="ex_item_two_icon" />
                                      <label class="custom-file-label" for="customFile">Choose Item Two Icon</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                @if(isset($dataRow->item_two_icon))
                                    @if(!empty($dataRow->item_two_icon))
                                        <img class="img-thumbnail" src="{{url('upload/howwehelp/'.$dataRow->item_two_icon)}}" width="150">
                                    @endif
                                @endif
                            </div>
                        </div>
                <div class="row">
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="item_two_detail">Item Two Detail</label>
                        <textarea class="form-control textarea" class="form-control" placeholder="Enter Item Two Detail" id="item_two_detail" 
                        name="item_two_detail"><?php 
                        if(isset($dataRow->item_two_detail)){
                            ?>{{$dataRow->item_two_detail}}<?php 
                        }
                        ?></textarea>
                      </div>
                    </div>
                </div>
                
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Choose Item Three Icon</label>
                                    <!-- <label for="customFile">Choose Item Three Icon</label> -->
                                    <div class="custom-file">
                                      <input type="file" class="custom-file-input"  id="item_three_icon" name="item_three_icon">
                                      <input type="hidden" value="{{$dataRow->item_three_icon}}" name="ex_item_three_icon" />
                                      <label class="custom-file-label" for="customFile">Choose Item Three Icon</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                @if(isset($dataRow->item_three_icon))
                                    @if(!empty($dataRow->item_three_icon))
                                        <img class="img-thumbnail" src="{{url('upload/howwehelp/'.$dataRow->item_three_icon)}}" width="150">
                                    @endif
                                @endif
                            </div>
                        </div>
                <div class="row">
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="item_three_detail">Item Three Detail</label>
                        <textarea class="form-control textarea" class="form-control" placeholder="Enter Item Three Detail" id="item_three_detail" 
                        name="item_three_detail"><?php 
                        if(isset($dataRow->item_three_detail)){
                            ?>{{$dataRow->item_three_detail}}<?php 
                        }
                        ?></textarea>
                      </div>
                    </div>
                </div>
                
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Choose Item Four Icon</label>
                                    <!-- <label for="customFile">Choose Item Four Icon</label> -->
                                    <div class="custom-file">
                                      <input type="file" class="custom-file-input"  id="item_four_icon" name="item_four_icon">
                                      <input type="hidden" value="{{$dataRow->item_four_icon}}" name="ex_item_four_icon" />
                                      <label class="custom-file-label" for="customFile">Choose Item Four Icon</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                @if(isset($dataRow->item_four_icon))
                                    @if(!empty($dataRow->item_four_icon))
                                        <img class="img-thumbnail" src="{{url('upload/howwehelp/'.$dataRow->item_four_icon)}}" width="150">
                                    @endif
                                @endif
                            </div>
                        </div>
                <div class="row">
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="item_four_detail">Item Four Detail</label>
                        <textarea class="form-control textarea" class="form-control" placeholder="Enter Item Four Detail" id="item_four_detail" 
                        name="item_four_detail"><?php 
                        if(isset($dataRow->item_four_detail)){
                            ?>{{$dataRow->item_four_detail}}<?php 
                        }
                        ?></textarea>
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
              <a class="btn btn-danger" href="{{url('howwehelp/edit/'.$dataRow->id)}}">
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
  <link rel="stylesheet" href="{{url('admin/plugins/summernote/summernote-bs4.css')}}">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
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
          height: 50,
          toolbar: [
                    ['font', ['bold', 'italic', 'underline', 'clear']],
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
        
        