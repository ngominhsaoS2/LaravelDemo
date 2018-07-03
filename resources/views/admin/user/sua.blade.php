@extends('admin.layout.index')

@section('content')
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">User
                    <small>Sửa {{$user->name}}</small>
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

                <form action="admin/user/sua/{{$user->id}}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="_token" value="{{csrf_token()}}" />
                    <div class="form-group">
                        <label>Tên</label>
                        <input class="form-control" name="name" placeholder="Nhập tên user" value="{{$user->name}}" />
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input class="form-control" type="email" name="email" placeholder="Nhập email user" value="{{$user->email}}" readonly="" />
                    </div>
                    <div class="form-group">
                        <input type="checkbox" name="changePassword" id="changePassword">
                        <label>Change password</label>
                        <input class="form-control password" type="password" name="password" placeholder="Nhập password user" disabled="" />
                    </div>
                    <div class="form-group">
                        <label>Confirm password</label>
                        <input class="form-control password" type="password" name="confirmPassword" placeholder="Nhập lại password user" disabled="" />
                    </div>
                    <div class="form-group">
                        <label>Quyền người dùng</label>
                        <label class="radio-inline">
                            @if($user->quyen == 0)
                                <input type="radio" name="quyen" value="0" checked="" /> Thường
                            @else
                                <input type="radio" name="quyen" value="0" /> Thường
                            @endif

                        </label>
                        <label class="radio-inline">
                            @if($user->quyen == 1)
                                <input type="radio" name="quyen" value="1" checked="" /> Admin
                            @else
                                <input type="radio" name="quyen" value="1" /> Admin
                            @endif
                        </label>
                    </div>
                    <button type="submit" class="btn btn-default">Sửa</button>
                    <button type="reset" class="btn btn-default">Làm mới</button>
                </form>
            </div>
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
@endsection

@section('script')
    <script>
        $(document).ready(function(){
            $('#changePassword').change(function(){
                if($(this).is(":checked")){
                    $(".password").removeAttr('disabled');
                }
                else{
                    $(".password").attr('disabled', '');
                }
            });
        });
    </script>
@endsection


