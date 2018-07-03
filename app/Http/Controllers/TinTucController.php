<?php

namespace App\Http\Controllers;
use App\LoaiTin;
use App\TheLoai;
use App\TinTuc;
use Illuminate\Http\Request;

class TinTucController extends Controller {
	//
	public function getDanhSach() {
		$tintuc = TinTuc::orderby('id', 'DESC')->get();
		return view('admin.tintuc.danhsach', ['tintuc' => $tintuc]);
	}

	public function getThem() {
		$theloai = TheLoai::all();
		$loaitin = LoaiTin::all();
		return view('admin.tintuc.them', ['theloai' => $theloai, 'loaitin' => $loaitin]);
	}

	public function postThem(Request $request) {
		$this->validate($request,
			[
				'LoaiTin' => 'required',
				'TieuDe' => 'required|min:3|unique:TinTuc,TieuDe',
				'TomTat' => 'required',
				'NoiDung' => 'required',
			],
			[
				'LoaiTin.required' => "Bạn chưa chọn Loại tin",
				'TieuDe.required' => "Bạn chưa nhập Tiêu đề",
				'TieuDe.min' => "Tiêu đề phải có ít nhất 3 kí tụ",
				'TieuDe.unique' => "Tên Tiêu đề này đã tồn tại",
				'TomTat.required' => "Bạn chưa nhập Tóm tắt",
				'NoiDung.required' => "Bạn chưa nhập Nội dung",
			]);

		$tintuc = new TinTuc;
		$tintuc->TieuDe = $request->TieuDe;
		$tintuc->TieuDeKhongDau = changeTitle($request->TieuDe);
		$tintuc->TomTat = $request->TomTat;
		$tintuc->NoiDung = $request->NoiDung;
		$tintuc->NoiBat = $request->NoiBat;
		$tintuc->idLoaiTin = $request->LoaiTin;
		$tintuc->SoLuotXem = 0;

		if ($request->hasFile('Hinh')) {
			$file = $request->file('Hinh');
			$duoi = $file->getClientOriginalExtension();

			if ($duoi != "jpg" && $duoi != 'png' && $duoi != 'jpeg') {
				return redirect('admin/tintuc/them')->with('loi', 'Bạn chỉ được chọn file ảnh');
			}
			$name = $file->getClientOriginalName();
			$hinh = str_random(4) . "_" . $name;
			while (file_exists("upload/tintuc/" . $hinh)) {
				$hinh = str_random(4) . "_" . $name;
			}
			$file->move("upload/tintuc", $hinh);
			$tintuc->Hinh = $hinh;
		} else {
			$tintuc->Hinh = "";
		}

		$tintuc->save();

		return redirect('admin/tintuc/them')->with('thongbao', 'Thêm mới Tin tức thành công');
	}

	public function getSua($id) {
		$theloai = TheLoai::all();
		$loaitin = LoaiTin::all();
		$tintuc = TinTuc::find($id);
		return view('admin.tintuc.sua', ['tintuc' => $tintuc, 'loaitin' => $loaitin, 'theloai' => $theloai]);
	}

	public function postSua(Request $request, $id) {
		$tintuc = TinTuc::find($id);
		$this->validate($request,
			[
				'LoaiTin' => 'required',
				'TieuDe' => 'required|min:3',
				'TomTat' => 'required',
				'NoiDung' => 'required',
			],
			[
				'LoaiTin.required' => "Bạn chưa chọn Loại tin",
				'TieuDe.required' => "Bạn chưa nhập Tiêu đề",
				'TieuDe.min' => "Tiêu đề phải có ít nhất 3 kí tụ",
				'TomTat.required' => "Bạn chưa nhập Tóm tắt",
				'NoiDung.required' => "Bạn chưa nhập Nội dung",
			]);

		$tintuc->TieuDe = $request->TieuDe;
		$tintuc->TieuDeKhongDau = changeTitle($request->TieuDe);
		$tintuc->TomTat = $request->TomTat;
		$tintuc->NoiDung = $request->NoiDung;
		$tintuc->NoiBat = $request->NoiBat;
		$tintuc->idLoaiTin = $request->LoaiTin;

		if ($request->hasFile('Hinh')) {
			$file = $request->file('Hinh');
			$duoi = $file->getClientOriginalExtension();

			if ($duoi != "jpg" && $duoi != 'png' && $duoi != 'jpeg') {
				return redirect('admin/tintuc/them')->with('loi', 'Bạn chỉ được chọn file ảnh');
			}
			$name = $file->getClientOriginalName();
			$hinh = str_random(4) . "_" . $name;
			while (file_exists("uploat/tintuc/" . $hinh)) {
				$hinh = str_random(4) . "_" . $name;
			}
			$file->move("upload/tintuc", $hinh);

			if ($tintuc->Hinh != "") {
				unlink("upload/tintuc/" . $tintuc->Hinh);
			}

			$tintuc->Hinh = $hinh;
		}

		$tintuc->save();

		return redirect('admin/tintuc/sua/' . $tintuc->id)->with('thongbao', 'Sửa Tin tức thành công');
	}

	public function getXoa($id) {
		$tintuc = TinTuc::find($id);
		$tintuc->delete();
		return redirect('admin/tintuc/danhsach')->with('thongbao', 'Xóa Tin tức thành công');
	}

}
