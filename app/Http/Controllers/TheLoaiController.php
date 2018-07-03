<?php

namespace App\Http\Controllers;
use App\TheLoai;
use Illuminate\Http\Request;

class TheLoaiController extends Controller {
	//
	public function getDanhSach() {
		$theloai = TheLoai::all();
		return view('admin.theloai.danhsach', ['theloai' => $theloai]);
	}

	public function getThem() {
		return view('admin.theloai.them');
	}

	public function postThem(Request $request) {
		$this->validate($request,
			[
				'ten' => 'required|min:3|max:100|unique:TheLoai,Ten',
			],
			[
				'ten.required' => "Bạn chưa nhập tên thể loại",
				'ten.min' => "Tên thể loại phải từ 3 đến 100 kí tự",
				'ten.max' => "Tên thể loại phải từ 3 đến 100 kí tự",
				'ten.unique' => "Tên thể loại này đã tồn tại",
			]);

		$theloai = new TheLoai;
		$theloai->Ten = $request->ten;
		$theloai->TenKhongDau = changeTitle($request->ten);
		$theloai->save();

		return redirect('admin/theloai/them')->with('thongbao', 'Thêm mới Thể loại thành công');
	}

	public function getSua($id) {
		$theloai = TheLoai::find($id);
		return view('admin.theloai.sua', ['theloai' => $theloai]);
	}

	public function postSua(Request $request, $id) {
		$theloai = TheLoai::find($id);
		$this->validate($request,
			[
				'ten' => 'required|min:3|max:100|unique:TheLoai,Ten',
			],
			[
				'ten.required' => "Bạn chưa nhập tên thể loại",
				'ten.min' => "Tên thể loại phải từ 3 đến 100 kí tự",
				'ten.max' => "Tên thể loại phải từ 3 đến 100 kí tự",
				'ten.unique' => "Tên thể loại này đã tồn tại",
			]);

		$theloai->Ten = $request->ten;
		$theloai->TenKhongDau = changeTitle($request->ten);
		$theloai->save();

		return redirect('admin/theloai/sua/' . $id)->with('thongbao', 'Sửa Thể loại thành công');
	}

	public function getXoa($id) {
		$theloai = TheLoai::find($id);
		$theloai->delete();
		return redirect('admin/theloai/danhsach')->with('thongbao', 'Đã xóa Thể loại thành công');
	}

}
