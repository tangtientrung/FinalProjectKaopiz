@extends('admin.layouts.index')
@section('css')
  <!-- DataTables -->
  <link rel="stylesheet" href="admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
@endsection
@section('content')
<div class="content-wrapper">
		
            <div class="card" >
              	<div class="card-header p-2">
	                <ul class="nav nav-pills">
                    <div id="button">
                    <?php $arr=array();?>
	                	@foreach($category as $c)
	                  	<li class="nav-item" id="{{$c->category_id}}" value="{{$c->category_id}}"><a class="nav-link" data-toggle="tab">{{$c->category_name}}</a></li>
                      <?php array_push($arr, $c->category_id);?>
	                  @endforeach
                    </div>
	                </ul>

            	</div><!-- /.card-header -->
              	<div class="card-body">
                	<div class="tab-content">
                  	<div class="active tab-pane" id="activity"></div>
              	</div>
          	</div>
          	<!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
	        <div class="card">
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Tên danh mục</th>
                    <th>Mô tả</th>
                    <th>Trạng thái</th>
                    <th>Sửa</th>
                    <th>Xóa</th>
                  </tr>
                  </thead>
                  <tbody>
                  
	                  <tr>
	                    <td>a</td>
	                    <td>a</td>
	                    <td>a</td>
	                    <td>a</td>
	                    <td class="center"><i class="fa fa-pencil fa-fw"></i> <a href="#">Sửa</a></td>
                        <td class="center"><a href="#" class="btn btn-danger"><i class="fas fa-trash"></i></a></td>
	                  </tr>
                  
                  </tbody>
                  <tfoot>
                  
                  </tfoot>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->

</div>
@endsection
@section('script')
<!-- DataTables  & Plugins -->
<script src="admin/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="admin/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="admin/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="admin/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="admin/plugins/jszip/jszip.min.js"></script>
<script src="admin/plugins/pdfmake/pdfmake.min.js"></script>
<script src="admin/plugins/pdfmake/vfs_fonts.js"></script>
<script src="admin/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="admin/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="admin/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- Page specific script -->
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>

    <script>
        $(document).ready(function(){
          var str="<?php foreach($arr as $a)
                    {
                      echo($a)." ";
                    }?>";

         var arr=str.split(" ");
         var i;
         /*for(i=arr[0]-1;i<arr.length-1;i++)
         {
            if (yes.clicked == true)
            $("#"+arr[i]).click(function(){
                /*var idTheLoai=$(this).val();
                $.get("admin/ajax/loaitin/"+idTheLoai,function(data){
                    $("#LoaiTin").html(data);
                });*/
                /*alert(i);
            });
            break;
            //alert(arr[i]);
         }*/
         document.getElementById('1').addEventListener('click', function(evt) {
          var target = evt.target;
          /*if (target.id =='1') {
            alert("1");
          } else if (target.id == 2) {
            alert("2");
          } else {
            alert("3");*/
            alert(typeof(target);
          }
        }, false);
         
        
        });
    </script>
         
@endsection