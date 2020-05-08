
@extends("admin.layout.master")
@section("title","Edit Slider Content")
@section("content")
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Slider Content</h1>
      </div>
      <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">Update Slider Content</li>
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
            <h3 class="card-title">Edit / Modify Slider Content</h3>
        </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form action="{{url('slidercontent/update/'.$dataRow->id)}}" method="post" enctype="multipart/form-data">
          {{csrf_field()}}
          
            <div class="card-body">
                
                <div class="row">
                    <div class="col-sm-6">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="slider_header_with_animation">Slider Header With Animation</label>
                        <input type="text" 
                            
                        <?php 
                        if(isset($dataRow->slider_header_with_animation)){
                            ?>
                            value="{{$dataRow->slider_header_with_animation}}" 
                            <?php 
                        }
                        ?>
                        
                        class="form-control" placeholder="Enter Slider Header With Animation" id="slider_header_with_animation" name="slider_header_with_animation">
                      </div>
                    </div>

                    <div class="col-sm-6">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="slider_sub_title_with_animation">Slider Sub Title With Animation</label>
                        <input type="text" 
                            
                        <?php 
                        if(isset($dataRow->slider_sub_title_with_animation)){
                            ?>
                            value="{{$dataRow->slider_sub_title_with_animation}}" 
                            <?php 
                        }
                        ?>
                        
                        class="form-control" placeholder="Enter Slider Sub Title With Animation" id="slider_sub_title_with_animation" name="slider_sub_title_with_animation">
                      </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-6">
                      <!-- text input -->
                      <div class="form-group">
                        <label for="slider_button_top_text">Slider Button Top Text</label>
                        <input type="text" 
                            
                        <?php 
                        if(isset($dataRow->slider_button_top_text)){
                            ?>
                            value="{{$dataRow->slider_button_top_text}}" 
                            <?php 
                        }
                        ?>
                        
                        class="form-control" placeholder="Enter Slider Button Top Text" id="slider_button_top_text" name="slider_button_top_text">
                      </div>
                    </div>

                    <div class="col-sm-6">
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
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Choose Rating Image</label>
                                    <!-- <label for="customFile">Choose Rating Image</label> -->
                                    <div class="custom-file">
                                      <input type="file" class="custom-file-input"  id="rating_image" name="rating_image">
                                      <input type="hidden" value="{{$dataRow->rating_image}}" name="ex_rating_image" />
                                      <label class="custom-file-label" for="customFile">Choose Rating Image</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                @if(isset($dataRow->rating_image))
                                    @if(!empty($dataRow->rating_image))
                                        <img class="img-thumbnail" src="{{url('upload/slidercontent/'.$dataRow->rating_image)}}" width="150">
                                    @endif
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Choose Slider Background Image</label>
                                    <!-- <label for="customFile">Choose Slider Background Image</label> -->
                                    <div class="custom-file">
                                      <input type="file" class="custom-file-input"  id="slider_background_image" name="slider_background_image">
                                      <input type="hidden" value="{{$dataRow->slider_background_image}}" name="ex_slider_background_image" />
                                      <label class="custom-file-label" for="customFile">Choose Slider Background Image</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                @if(isset($dataRow->slider_background_image))
                                    @if(!empty($dataRow->slider_background_image))
                                        <img class="img-thumbnail" src="{{url('upload/slidercontent/'.$dataRow->slider_background_image)}}" width="150">
                                    @endif
                                @endif
                            </div>
                        </div>       
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
              <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> 
                Update
              </button>
              <a class="btn btn-danger" href="{{url('slidercontent/edit/'.$dataRow->id)}}">
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
@section("js")

    <script src="{{url('admin/plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>
    <script>
    $(document).ready(function(){
        bsCustomFileInput.init();
    });
    </script>

@endsection
        