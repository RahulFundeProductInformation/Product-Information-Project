@extends('admin.main')
@section('title', 'Product Create')
@section('content')

<div class="content-wrapper">


       
 
    <!-- Main content -->
    <section class="content">
      @include('admin.partials.validate')


      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Product Create</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
          
        <form action="{{route('admin.users.store')}}" method="post" enctype="multipart/form-data">
        {{csrf_field()}}
        {{method_field('POST')}}
              <div class="box-body">

                <div class="form-group">
                  <label for="xmlfile">Select File</label>
                  <input type="file" name="xmlfile" class="form-control" id="xmlfile">
                </div>
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Import File</button>
              </div>
            </form>
        </div>
        <!-- /.box-footer-->
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>

@endsection