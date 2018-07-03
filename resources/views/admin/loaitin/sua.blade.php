@extends('admin.layout.index')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Loại tin
                    <small>{{$loaitin->Ten}}</small>
                </h1>
            </div>
            <!-- /.col-lg-12 -->
            <div class="col-lg-7" style="padding-bottom:120px">
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
                <form action="admin/loaitin/sua/{{$loaitin->id}}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="_token" value="{{csrf_token()}}" />
                    <div class="form-group">
                        <label>Thể loại</label>
                        <select class="form-control" name="theloai">
                            <option value="">-- Chọn --</option>
                            @foreach($theloai as $tl)
                                @if($tl->id == $loaitin->idTheLoai)
                                    <option value="{{$tl->id}}" selected>{{$tl->Ten}}</option>
                                @else
                                    <option value="{{$tl->id}}">{{$tl->Ten}}</option>
                                @endif

                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Tên loại tin</label>
                        <input class="form-control" name="ten" placeholder="Nhập tên loại tin" value="{{$loaitin->Ten}}" />
                    </div>
                    <button type="submit" class="btn btn-default">Sửa</button>
                    <button type="reset" class="btn btn-default">Làm lại</button>
                    <form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
@endsection