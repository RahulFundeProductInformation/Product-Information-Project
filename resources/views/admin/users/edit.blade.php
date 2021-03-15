@extends('admin.main')
@section('title', 'Product Editing')
@section('content')

<div class="content-wrapper">


       
 
    <!-- Main content -->
    <section class="content">
      @include('admin.partials.validate')
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">{{$prodInfo[0]->item_number}} Editing</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">
                  <form action="{{route('admin.users.update',$prodInfo[0]->item_number)}}" method="post">
        {{csrf_field()}}
        {{method_field('PUT')}}
              <div class="box-body">
              <div class="form-group">
                  <label for="item_number">Product Number</label>
                  <input type="text" name="item_number" value="{{$prodInfo[0]->item_number}}" class="form-control" id="item_number" readonly="readonly">
                </div>
                <div class="form-group">
                  <label for="price">Product Price</label>
                  <input type="text" name="price" value="{{$prodInfo[0]->price}}"  class="form-control" id="price">
                </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Update</button>
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