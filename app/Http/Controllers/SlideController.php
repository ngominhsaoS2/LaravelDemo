<?php

namespace App\Http\Controllers;
use App\Slide;
use Illuminate\Http\Request;

class SlideController extends Controller {
	//
	public function getDanhSach() {
		$listSlide = Slide::orderby('id', 'DESC')->get();
		return view('admin.slide.danhsach', ['listSlide' => $listSlide]);
	}

	public function getThem() {
		return view('admin.slide.them');
	}

	public function postThem(Request $request) {
		$this->validate($request,
			[
				'Ten' => 'required',
				'NoiDung' => 'required',
				'link' => 'required',
			],
			[
				'Ten.required' => "Bạn chưa nhập Tên",
				'NoiDung.required' => "Bạn chưa nhập Nội dung",
				'link.required' => "Bạn chưa nhập link",
			]);

		$slide = new Slide;
		$slide->Ten = $request->Ten;
		$slide->NoiDung = $request->NoiDung;

		if ($request->has('link')) {
			$slide->link = $request->link;
		}

		if ($request->hasFile('Hinh')) {
			$file = $request->file('Hinh');
			$duoi = $file->getClientOriginalExtension();

			if ($duoi != "jpg" && $duoi != 'png' && $duoi != 'jpeg') {
				return redirect('admin/slide/them')->with('loi', 'Bạn chỉ được chọn file ảnh');
			}
			$name = $file->getClientOriginalName();
			$hinh = str_random(4) . "_" . $name;
			while (file_exists("upload/slide/" . $hinh)) {
				$hinh = str_random(4) . "_" . $name;
			}
			$file->move("upload/slide", $hinh);
			$slide->Hinh = $hinh;
		} else {
			$slide->Hinh = "";
		}

		$slide->save();
		return redirect('admin/slide/them')->with('thongbao', 'Thêm mới Slide thành công');

	}

	public function getSua($id) {
		$slide = Slide::find($id);
		return view('admin.slide.sua', ['slide' => $slide]);
	}

	public function postSua(Request $request, $id) {
		$this->validate($request,
			[
				'Ten' => 'required',
				'NoiDung' => 'required',
				'link' => 'required',
			],
			[
				'Ten.required' => "Bạn chưa nhập Tên",
				'NoiDung.required' => "Bạn chưa nhập Nội dung",
				'link.required' => "Bạn chưa nhập link",
			]);

		$slide = Slide::find($id);
		$slide->Ten = $request->Ten;
		$slide->NoiDung = $request->NoiDung;

		if ($request->has('link')) {
			$slide->link = $request->link;
		}

		if ($request->hasFile('Hinh')) {
			$file = $request->file('Hinh');
			$duoi = $file->getClientOriginalExtension();

			if ($duoi != "jpg" && $duoi != 'png' && $duoi != 'jpeg') {
				return redirect('admin/slide/them')->with('loi', 'Bạn chỉ được chọn file ảnh');
			}
			$name = $file->getClientOriginalName();
			$hinh = str_random(4) . "_" . $name;
			while (file_exists("upload/slide/" . $hinh)) {
				$hinh = str_random(4) . "_" . $name;
			}
			// unlink("upload/slide/" . $slide->Hinh);
			$file->move("upload/slide", $hinh);
			$slide->Hinh = $hinh;
		}

		$slide->save();
		return redirect('admin/slide/sua/' . $id)->with('thongbao', 'Sửa Slide thành công');
	}

	public function getXoa($id) {
		$slide = Slide::find($id);
		$slide->delete();
		return redirect('admin/slide/danhsach')->with('thongbao', 'Xóa Slide thành công');
	}

}
