@extends('admin.layout.index')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Slide
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
                        <th>Tên</th>
                        <th>Nội dung</th>
                        <th>Hình</th>
                        <th>Link</th>
                        <th>Delete</th>
                        <th>Edit</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($listSlide as $item)
                    <tr class="odd gradeX" align="center">
                        <td>{{$item->id}}</td>
                        <td>{{$item->Ten}}</td>
                        <td>{{$item->NoiDung}}</td>
                        <td>
                            <img src="upload/slide/{{$item->Hinh}}" width="180px">
                        </td>
                        <td>{{$item->link}}</td>
                        <td class="center"><i class="fas fa-trash-alt"></i><a href="admin/slide/xoa/{{$item->id}}"> Delete</a></td>
                        <td class="center"><i class="fas fa-edit"></i> <a href="admin/slide/sua/{{$item->id}}">Edit</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
@endsection