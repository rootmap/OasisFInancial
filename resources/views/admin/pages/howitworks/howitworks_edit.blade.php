
@extends("admin.layout.master")
@section("title","Edit How It Works")
@section("content")
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>How It Works</h1>
      </div>
      <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">Update How It Works</li>
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
            <h3 class="card-title">Edit / Modify How It Works</h3>
        </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form action="{{url('howitworks/update/'.$dataRow->id)}}" method="post" enctype="multipart/form-data">
          {{csrf_field()}}
          
            <div class="card-body">
                
                <div class="row">
                    <div class="col-sm-6">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="page_title">Page Title</label>
                        <input type="text" 
                            
                        <?php 
                        if(isset($dataRow->page_title)){
                            ?>
                            value="{{$dataRow->page_title}}" 
                            <?php 
                        }
                        ?>
                        
                        class="form-control" placeholder="Enter Page Title" id="page_title" name="page_title">
                      </div>
                    </div>

                    <div class="col-sm-6">
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
                    <div class="col-sm-6">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="section_footer_link_text">Section Footer Link Text</label>
                        <input type="text" 
                            
                        <?php 
                        if(isset($dataRow->section_footer_link_text)){
                            ?>
                            value="{{$dataRow->section_footer_link_text}}" 
                            <?php 
                        }
                        ?>
                        
                        class="form-control" placeholder="Enter Section Footer Link Text" id="section_footer_link_text" name="section_footer_link_text">
                      </div>
                    </div>

                    <div class="col-sm-6">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="section_footer_link_url">Section Footer Link URL</label>
                        <input type="text" 
                            
                        <?php 
                        if(isset($dataRow->section_footer_link_url)){
                            ?>
                            value="{{$dataRow->section_footer_link_url}}" 
                            <?php 
                        }
                        ?>
                        
                        class="form-control" placeholder="Enter Section Footer Link URL" id="section_footer_link_url" name="section_footer_link_url">
                      </div>
                    </div>
                </div>
                
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Choose Page Background</label>
                                    <!-- <label for="customFile">Choose Page Background</label> -->
                                    <div class="custom-file">
                                      <input type="file" class="custom-file-input"  id="page_background" name="page_background">
                                      <input type="hidden" value="{{$dataRow->page_background}}" name="ex_page_background" />
                                      <label class="custom-file-label" for="customFile">Choose Page Background</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                @if(isset($dataRow->page_background))
                                    @if(!empty($dataRow->page_background))
                                        <img class="img-thumbnail" src="{{url('upload/howitworks/'.$dataRow->page_background)}}" width="150">
                                    @endif
                                @endif
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
              <a class="btn btn-danger" href="{{url('howitworks/edit/'.$dataRow->id)}}">
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
          height: 80,
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
        