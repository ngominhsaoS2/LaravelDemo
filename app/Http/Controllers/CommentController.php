<?php

namespace App\Http\Controllers;
use App\Comment;
use App\TinTuc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller {

	public function getXoa($id, $idTinTuc) {
		$comment = Comment::find($id);
		$comment->delete();
		return redirect('admin/tintuc/sua/' . $idTinTuc)->with('thongbao', 'Đã xóa Comment thành công');
	}

	public function postComment($id, Request $request) {
		$tintuc = TinTuc::find($id);
		$comment = new Comment;
		$comment->idTinTuc = $id;
		$comment->idUser = Auth::user()->id;
		$comment->NoiDung = $request->NoiDung;
		$comment->save();

		return redirect("tintuc/$id/" . $tintuc->TieuDeKhongDau . ".html")->with('thongbao', 'Viết bình luận thành công');
	}

}
