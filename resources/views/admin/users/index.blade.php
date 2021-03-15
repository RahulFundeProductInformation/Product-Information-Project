@extends('admin.main')
@section('title', 'Products')
@section('content')

<div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
    @include('admin.partials.validate')
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Product List</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body">

            <div class="box-body">
              <table id="prod_table" class="table table-bordered table-striped">
                <thead>
                <tr>

                    <th>ID</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Gender</th>
                    <th>Product Size</th>
                    <th>Color</th>
                    <th>Edit</th>
                    <th>Delete</th>
                    
                </tr>
                </thead>
                <tbody>

                @foreach($products as $prod)
                    <tr>
                    <td>{{$prod->id}}</td>
                    <td>{{$prod->item_number}}</td>
                    <td>{{$prod->price}}</td>
                    <td>{{$prod->gender}}</td>
                    <td>{{$prod->name}}</td>
                    <td>{{$prod->color}}</td>
                    <td>
                      <a href="{{route('admin.users.edit', $prod->item_number)}}" class="btn btn-success">Edit</a>
                    </td>
                    <td>
                    
                    <form action="{{route('admin.users.delete', $prod->item_number)}}" method="post">
                        {{csrf_field()}}
                        {{method_field('DELETE')}}
                          <button type="submit" class="btn btn-danger">Delete</a>
                    </form>
                    </td>
                   
                    </tr>
                @endforeach

                
                </tfoot>
              </table>
            </div>
          <!-- /.box -->
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>

@endsection
@push('style')
      <!-- DataTables -->
  <link rel="stylesheet" href="{{asset('assets/admin')}}/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
@endpush
@push('scripts')
<!-- DataTables -->
<script src="{{asset('assets/admin')}}/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="{{asset('assets/admin')}}/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script>
  $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script>
@endpush