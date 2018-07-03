<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller {

	public function getDanhSach() {
		$listUser = User::orderby('id', 'DESC')->get();
		return view('admin.user.danhsach', ['listUser' => $listUser]);
	}

	public function getThem() {
		return view('admin.user.them');
	}

	public function postThem(Request $request) {
		$this->validate($request,
			[
				'name' => 'required|min:3',
				'email' => 'required|email|unique:users,email',
				'password' => 'required|min:3|max:32',
				'confirmPassword' => 'required|same:password',
			],
			[
				'name.required' => "Bạn chưa nhập tên người dùng",
				'name.min' => "Tên người dùng phải có ít nhất 3 kí tự",
				'email.required' => "Bạn chưa nhập email người dùng",
				'email.email' => "Bạn chưa nhập đúng định dạng email",
				'email.unique' => "Email đã tồn tại",
				'password.required' => "Bạn chưa nhập password",
				'password.min' => "Password phải có ít nhất 3 kí tự",
				'password.max' => "Password chỉ có tối đa 32 kí tự",
				'confirmPassword.required' => "Bạn phải xác nhận lại password",
				'confirmPassword.same' => "Password nhập lại chưa khớp",

			]);

		$user = new User;
		$user->name = $request->name;
		$user->email = $request->email;
		$user->quyen = $request->quyen;
		$user->password = bcrypt($request->password);
		$user->save();

		return redirect('admin/user/them')->with('thongbao', 'Thêm mới User thành công');
	}

	public function getSua($id) {
		$user = User::find($id);
		return view('admin.user.sua', ['user' => $user]);
	}

	public function postSua(Request $request, $id) {
		$this->validate($request,
			[
				'name' => 'required|min:3',
			],
			[
				'name.required' => "Bạn chưa nhập tên người dùng",
				'name.min' => "Tên người dùng phải có ít nhất 3 kí tự",
			]);

		$user = User::find($id);
		$user->name = $request->name;
		$user->quyen = $request->quyen;

		if ($request->changePassword == "on") {
			$this->validate($request,
				[
					'password' => 'required|min:3|max:32',
					'confirmPassword' => 'required|same:password',
				],
				[
					'password.required' => "Bạn chưa nhập password",
					'password.min' => "Password phải có ít nhất 3 kí tự",
					'password.max' => "Password chỉ có tối đa 32 kí tự",
					'confirmPassword.required' => "Bạn phải xác nhận lại password",
					'confirmPassword.same' => "Password nhập lại chưa khớp",
				]);
			$user->password = bcrypt($request->password);
		}

		$user->save();
		return redirect('admin/user/sua/' . $id)->with('thongbao', 'Sửa User thành công');
	}

	public function getXoa($id) {
		$user = User::find($id);
		$user->delete();
		return redirect('admin/user/danhsach')->with('thongbao', 'Xóa User thành công');
	}

	public function getDangNhapAdmin() {
		return view('admin.login');
	}

	public function postDangNhapAdmin(Request $request) {
		$this->validate($request,
			[
				'email' => 'required',
				'password' => 'required|min:3|max:32',
			],
			[
				'email.required' => "Bạn chưa nhập email",
				'password.required' => "Bạn chưa nhập password",
				'password.min' => "Password không được ít hơn 3 kí tự",
				'password.max' => "Password không được nhiều hơn 32 kí tự",
			]);

		if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
			return redirect('admin/theloai/danhsach');
		} else {
			return redirect('admin/dangnhap')->with('thongbao', 'Bạn đã nhập sai tên hoặc sai mật khẩu');
		}

	}

	public function getDangXuatAdmin() {
		Auth::logout();
		return redirect('admin/dangnhap');
	}

}
