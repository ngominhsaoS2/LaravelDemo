@extends('admin.layout.index')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Tin tức
                    <small>{{$tintuc->TieuDe}}</small>
                </h1>
            </div>
            <!-- /.col-lg-12 -->
            <div class="col-lg-8" style="padding-bottom:120px">
                @if(count($errors) > 0)
                <div class="alert alert-danger">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    @foreach($errors->all() as $err)
                    {{$err}}<br />
                    @endforeach
                </div>
                @endif

                @if(session('thongbao'))
                <div class="alert alert-success alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Success!</strong> {{session('thongbao')}}
                </div>
                @endif()

                <form action="admin/tintuc/sua/{{$tintuc->id}}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" name="_token" value="{{csrf_token()}}" />
                    <div class="form-group">
                        <label>Thể loại</label>
                        <select class="form-control" name="TheLoai" id="theLoai">
                            <option value="">-- Chọn--</option>
                            @foreach($theloai as $tl)
                                @if($tintuc->loaitin->theloai->id == $tl->id)
                                    <option value="{{$tl->id}}" selected>{{$tl->Ten}}</option>
                                @else
                                    <option value="{{$tl->id}}">{{$tl->Ten}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Loại tin</label>
                        <select class="form-control" name="LoaiTin" id="loaiTin">
                            <option value="">-- Chọn--</option>
                            @foreach($loaitin as $lt)
                            @if($tintuc->loaitin->id == $lt->id)
                                    <option value="{{$lt->id}}" selected>{{$lt->Ten}}</option>
                                @else
                                    <option value="{{$lt->id}}">{{$lt->Ten}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Tiêu đề</label>
                        <input class="form-control" name="TieuDe" placeholder="Nhập tiêu đề" value="{{$tintuc->TieuDe}}" />
                    </div>
                    <div class="form-group">
                        <label>Tóm tắt</label>
                        <textarea id="demo" class="form-control ckeditor" name="TomTat" rows="3">
                            {{$tintuc->TomTat}}
                        </textarea>
                    </div>
                    <div class="form-group">
                        <label>Nội dung</label>
                        <textarea id="demo" class="form-control ckeditor" name="NoiDung" rows="3" >
                            {{$tintuc->NoiDung}}
                        </textarea>
                    </div>
                    <div class="form-group">
                        <label>Hình ảnh</label>
                        <p>
                            <img src="upload/tintuc/{{$tintuc->Hinh}}" width="400px" />
                        </p>
                        <input class="form-control" type="file" name="Hinh" />
                    </div>
                    <div class="form-group">
                        <label>Nổi bật</label>
                        <label class="radio-inline">
                            <input name="NoiBat" value="0" type="radio"
                                @<?php if ($tintuc->NoiBat == 0): ?>
                                    {{"checked"}}
                                <?php endif?>
                            />Không
                        </label>
                        <label class="radio-inline">
                            <input name="NoiBat" value="1" type="radio"
                                @<?php if ($tintuc->NoiBat == 1): ?>
                                    {{"checked"}}
                                <?php endif?>
                            />Có
                        </label>
                    </div>
                    <button type="submit" class="btn btn-default">Sửa</button>
                    <button type="reset" class="btn btn-default">Làm mới</button>
                    <form>
                    </div>
                </div>
                <!-- /.row -->

                <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Comment
                    <small>Danh sách</small>
                </h1>
            </div>
            <!-- /.col-lg-12 -->
            @if(count($errors) > 0)
            <div class="alert alert-danger">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                @foreach($errors->all() as $err)
                {{$err}}<br />
                @endforeach
            </div>
            @endif

            @if(session('thongbao'))
            <div class="alert alert-success alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <strong>Success!</strong> {{session('thongbao')}}
            </div>
            @endif()
            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                <thead>
                    <tr align="center">
                        <th>ID</th>
                        <th>Người dùng</th>
                        <th>Nội dung</th>
                        <th>Ngày đăng</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tintuc->comment as $cm)
                    <tr class="odd gradeX" align="center">
                        <td>{{$cm->id}}</td>
                        <td>{{$cm->user->name}}</td>
                        <td>{{$cm->NoiDung}}</td>
                        <td>{{$cm->created_at}}</td>
                        <td class="center"><i class="fas fa-trash-alt"></i><a href="admin/comment/xoa/{{$cm->id}}/{{$tintuc->id}}"> Delete</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
            </div>
            <!-- /.container-fluid -->
        </div>
        @endsection

        @section('script')
        <script>
            $(document).ready(function(){
                $('#theLoai').change(function(){
                    var idTheLoai = $(this).val();
                    $.get("admin/ajax/loaitin/" + idTheLoai, function(data){
                        $("#loaiTin").html(data);
                    });
                });
            });
        </script>
        @endsection
