<?php

namespace App\Http\Controllers;
use App\LoaiTin;
use App\TheLoai;
use Illuminate\Http\Request;

class LoaiTinController extends Controller {
	public function getDanhSach() {
		$loaitin = LoaiTin::all();
		return view('admin.loaitin.danhsach', ['loaitin' => $loaitin]);
	}

	public function getThem() {
		$theloai = TheLoai::all();
		return view('admin.loaitin.them', ['theloai' => $theloai]);
	}

	public function postThem(Request $request) {
		$this->validate($request,
			[
				'ten' => 'required|min:3|max:100|unique:LoaiTin,Ten',
				'theloai' => 'required',
			],
			[
				'ten.required' => "Bạn chưa nhập tên loại tin",
				'ten.min' => "Tên loại tin phải từ 3 đến 100 kí tự",
				'ten.max' => "Tên loại tin phải từ 3 đến 100 kí tự",
				'ten.unique' => "Tên loại tin này đã tồn tại",
				'theloai.required' => "Bạn chưa chọn Thể loại",
			]);

		$loaitin = new LoaiTin;
		$loaitin->idTheLoai = $request->theloai;
		$loaitin->Ten = $request->ten;
		$loaitin->TenKhongDau = changeTitle($request->ten);
		$loaitin->save();

		return redirect('admin/loaitin/them')->with('thongbao', 'Thêm mới Loại tin thành công');
	}

	public function getSua($id) {
		$loaitin = LoaiTin::find($id);
		$theloai = TheLoai::all();
		return view('admin.loaitin.sua', ['loaitin' => $loaitin], ['theloai' => $theloai]);
	}

	public function postSua(Request $request, $id) {
		$loaitin = LoaiTin::find($id);
		$this->validate($request,
			[
				'ten' => 'required|min:3|max:100',
				'theloai' => 'required',
			],
			[
				'ten.required' => "Bạn chưa nhập tên loại tin",
				'ten.min' => "Tên loại tin phải từ 3 đến 100 kí tự",
				'ten.max' => "Tên loại tin phải từ 3 đến 100 kí tự",
				'theloai.required' => "Bạn chưa chọn Thể loại",
			]);

		$loaitin->idTheLoai = $request->theloai;
		$loaitin->Ten = $request->ten;
		$loaitin->TenKhongDau = changeTitle($request->ten);
		$loaitin->save();

		return redirect('admin/loaitin/sua/' . $id)->with('thongbao', 'Sửa Loại tin thành công');
	}

	public function getXoa($id) {
		$loaitin = LoaiTin::find($id);
		$loaitin->delete();
		return redirect('admin/loaitin/danhsach')->with('thongbao', 'Đã xóa Loại tin thành công');
	}

}
