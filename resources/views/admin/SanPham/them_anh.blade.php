@extends('layouts.adminLayout.admin_design')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>General Form</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Loại sản phẩm</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-6">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Form thuộc tính sản phẩm </h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form role="form" enctype="multipart/form-data" method="post" action="{{url('/admin/themanh/'.$chitiet_sp->id_sanpham)}}" name="themthuoctinh" id="themthuoctinh">
                {{csrf_field()}}
                <div class="card-body">
                  <input type="hidden" name="id_sanpham" value="{{$chitiet_sp->id_sanpham}}">
                  
                 <div class="form-group">
                        <label>Sản phẩm :</label>
                        <label style="margin-left: 25%;">{{$chitiet_sp->ten_sanpham}}</label>
                        
                 </div>
                 <div class="form-group">
                        <label>Code :</label>
                        <label style="margin-left: 34%;">{{$chitiet_sp->code_sanpham}}</label>
                        
                 </div>
                 
                 <div class="form-group">
                    <label for="exampleInputFile">Thêm ảnh minh họa sản phẩm</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="anh" name="anh[]">
                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                      </div>
                      <div class="input-group-append">
                        <span class="input-group-text" id="">Upload</span>
                      </div>
                    </div>
                        
                 </div>
                 
                 
                 
                  
                
                  
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Cập nhật</button>
                </div>
              </form>
            </div>
            

           

          </div>
          <!--/.col (left) -->
          <!-- right column -->
          <div class="col-md-6">
            <!-- general form elements disabled -->
            <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table m-0">
                    <thead>
                    <tr>
                      <th>ID ảnh</th>
                      <th>ID sản phẩm</th>
                      <th>Ảnh</th>
                      <th>Tùy chọn</th>
                      
                    </tr>
                    </thead>
                    <tbody>
                      @foreach($anh_sanpham as $anh_sanpham)
                      <tr>
                        <td>{{$anh_sanpham->id}}</td>
                             <td>{{$anh_sanpham->id_sanpham}}</td>
                             <td><img src="{{asset('SanPham/small/'.$anh_sanpham->anh)}}" alt="" style="width: 100px;"></td>
                             <td><a href="{{url('admin/xoaanhsp/'.$anh_sanpham->id)}}" class="badge badge-danger">Xóa</a></td>
                             
                      </tr>
                             
                    @endforeach
                    </tbody>
                  </table>
                </div>
                <!-- /.table-responsive -->
              </div>
            <!-- /.card -->
            <!-- general form elements disabled -->
            
            <!-- /.card -->
          </div>
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
@endsection