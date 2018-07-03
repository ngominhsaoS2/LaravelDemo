<?php

namespace App\Http\Controllers;

use App\LoaiTin;
use App\Slide;
use App\TheLoai;
use App\TinTuc;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller {
	//
	function __construct() {
		$theloai = TheLoai::all();
		$slide = Slide::all();
		view()->share('theloai', $theloai);
		view()->share('slide', $slide);

		if (Auth::check()) {
			view()->share('nguoidung', Auth::user());
		}

	}

	function trangchu() {
		return view('pages.trangchu');
	}

	function lienhe() {
		return view('pages.lienhe');
	}

	function loaitin($id) {
		$loaitin = LoaiTin::find($id);
		$tintuc = TinTuc::where('idLoaiTin', $id)->paginate(5);
		return view('pages.loaitin', ['loaitin' => $loaitin, 'tintuc' => $tintuc]);
	}

	function tintuc($id) {
		$tintuc = TinTuc::find($id);
		$tinnoibat = TinTuc::where('NoiBat', 1)->take(4)->get();
		$tinlienquan = TinTuc::where('idLoaiTin', $tintuc->idLoaiTin)->take(4)->get();
		return view('pages.tintuc', ['tintuc' => $tintuc, 'tinnoibat' => $tinnoibat, 'tinlienquan' => $tinlienquan]);
	}

	function getDangnhap() {
		return view('pages.dangnhap');
	}

	function postDangnhap(Request $request) {
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
			return redirect('trangchu');
		} else {
			return redirect('dangnhap')->with('thongbao', 'Bạn đã nhập sai tên hoặc sai mật khẩu');
		}

	}

	function getDangxuat() {
		Auth::logout();
		return redirect('trangchu');
	}

	function getNguoidung() {
		$user = Auth::user();
		return view('pages.nguoidung', ['user' => $user]);
	}

	function postNguoidung(Request $request) {
		$this->validate($request,
			[
				'name' => 'required|min:3',
			],
			[
				'name.required' => "Bạn chưa nhập tên người dùng",
				'name.min' => "Tên người dùng phải có ít nhất 3 kí tự",
			]);

		$user = Auth::user();
		$user->name = $request->name;

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
		return redirect('nguoidung')->with('thongbao', 'Sửa User thành công');
	}

	function getDangky() {
		return view('pages.dangky');
	}

	function postDangky(Request $request) {
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
		$user->quyen = 0;
		$user->password = bcrypt($request->password);
		$user->save();

		return redirect('dangky')->with('thongbao', 'Chúc mừng bạn đã đăng ký thành công');
	}

	function getTimKiem(Request $request) {
		$tukhoa = $request->get('tukhoa');
		$tintuc = TinTuc::where('TieuDe', 'like', '%' . $tukhoa . '%')->orWhere('TomTat', 'like', '%' . $tukhoa . '%')->orWhere('NoiDung', 'like', '%' . $tukhoa . '%')->paginate(10);
		return view('pages.timkiem', ['tukhoa' => $tukhoa, 'tintuc' => $tintuc]);
	}

}
