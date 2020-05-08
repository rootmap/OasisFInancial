
@extends("admin.layout.master")
@section("title","Create New Site Settings")
@section("content")
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Site Settings</h1>
      </div>
      <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">Create New Site Settings</li>
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
            <h3 class="card-title">Create New Site Settings</h3>            
        </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form action="{{url('sitesettings')}}" method="post" enctype="multipart/form-data">
          {{csrf_field()}}
          
            <div class="card-body">
                
                <div class="row">
                    <div class="col-sm-12">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="site_name">Site Name</label>
                        <input type="text" class="form-control" placeholder="Enter Site Name" id="site_name" name="site_name">
                      </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Choose Site Logo</label>
                            <!-- <label for="customFile">Choose Site Logo</label> -->

                            <div class="custom-file">
                              <input type="file" class="custom-file-input"  id="site_logo" name="site_logo">
                              <label class="custom-file-label" for="customFile">Choose Site Logo</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Choose Site Footer Logo</label>
                            <!-- <label for="customFile">Choose Site Footer Logo</label> -->

                            <div class="custom-file">
                              <input type="file" class="custom-file-input"  id="site_footer_logo" name="site_footer_logo">
                              <label class="custom-file-label" for="customFile">Choose Site Footer Logo</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="toll_free_call_text">Toll Free Call Text</label>
                        <input type="text" class="form-control" placeholder="Enter Toll Free Call  Text" id="toll_free_call_text" name="toll_free_call_text">
                      </div>
                    </div>
                    <div class="col-sm-6">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="toll_free_call_number">Toll Free Call Number</label>
                        <input type="text" class="form-control" placeholder="Enter Toll Free Call Number" id="toll_free_call_number" name="toll_free_call_number">
                      </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-6">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="contact_us_email_send">Contact US Email Send</label>
                        <input type="text" class="form-control" placeholder="Enter Contact US Email Send" id="contact_us_email_send" name="contact_us_email_send">
                      </div>
                    </div>

                    <div class="col-sm-6">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="application_notification_admin_email">Application Notification Admin Email</label>
                        <input type="text" class="form-control" placeholder="Enter Application Notification Admin Email" id="application_notification_admin_email" name="application_notification_admin_email">
                      </div>
                    </div>
                </div>
                       
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
              <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Submit</button>
              <a class="btn btn-danger" href="{{url('sitesettings/create')}}"><i class="far fa-times-circle"></i> Reset</a>
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
        