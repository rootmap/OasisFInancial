
@extends("admin.layout.master")
@section("title","Create New You Are Not Alone Videos")
@section("content")
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>You Are Not Alone Videos</h1>
      </div>
      <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{url('youarenotalonevideos/list')}}">You Are Not Alone Videos Data</a></li>
              <li class="breadcrumb-item active">Create New You Are Not Alone Videos</li>
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
            <h3 class="card-title">Create New You Are Not Alone Videos</h3>
            <div class="card-tools">
              <ul class="pagination pagination-sm float-right">
                <li class="page-item"><a class="page-link bg-primary" href="{{url('youarenotalonevideos/list')}}"> Data <i class="fas fa-table"></i></a></li>
                <li class="page-item">
                  <a class="page-link  bg-primary" target="_blank" href="{{url('youarenotalonevideos/export/pdf')}}">
                    <i class="fas fa-file-pdf" data-toggle="tooltip" data-html="true"title="Pdf"></i>
                  </a>
                </li>
                <li class="page-item">
                  <a class="page-link  bg-primary" target="_blank" href="{{url('youarenotalonevideos/export/excel')}}">
                    <i class="fas fa-file-excel" data-toggle="tooltip" data-html="true"title="Excel"></i>
                  </a>
                </li>
              </ul>
            </div>            
        </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form action="{{url('youarenotalonevideos')}}" method="post" enctype="multipart/form-data">
          {{csrf_field()}}
          
            <div class="card-body">
                
                <div class="row">
                    <div class="col-sm-6">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="feedback_user_name">Feedback User Name</label>
                        <input type="text" class="form-control" placeholder="Enter Feedback User Name" id="feedback_user_name" name="feedback_user_name">
                      </div>
                    </div>

                    <div class="col-sm-6">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="from_location">From Location</label>
                        <input type="text" class="form-control" placeholder="Enter From Location" id="from_location" name="from_location">
                      </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="section_detail">Section Detail</label>
                        <textarea class="form-control" rows="3"  placeholder="Enter Section Detail" id="section_detail" name="section_detail"></textarea>
                      </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-6">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="play_video_text">Play Video Text</label>
                        <input type="text" class="form-control" placeholder="Enter Play Video Text" id="play_video_text" name="play_video_text">
                      </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Choose Background Image</label>
                            <!-- <label for="customFile">Choose Background Image</label> -->

                            <div class="custom-file">
                              <input type="file" class="custom-file-input"  id="video_background_image" name="video_background_image">
                              <label class="custom-file-label" for="customFile">Choose Background Image</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="youtube_video_link">Youtube Video Link</label>
                        <input type="text" class="form-control" placeholder="Ener Youtube Video Link" id="youtube_video_link" name="youtube_video_link">
                      </div>
                    </div>

                    <div class="col-sm-6">
                      <!-- radio -->
                      <div class="form-group">
                      <label>Choose Module Status</label>
                
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" 
                                  id="module_status_0" name="module_status" value="Active">
                                  <label class="form-check-label">Active</label>
                                </div>
                        
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" 
                                  id="module_status_1" name="module_status" value="Inactive">
                                  <label class="form-check-label">Inactive</label>
                                </div>
                        
                            </div>
                        </div>
                    </div>
                   
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
              <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Submit</button>
              <a class="btn btn-danger" href="{{url('youarenotalonevideos/create')}}"><i class="far fa-times-circle"></i> Reset</a>
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
@section("js")

    <script src="{{url('admin/plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>
    <script>
    $(document).ready(function(){
        bsCustomFileInput.init();
    });
    </script>

@endsection
        