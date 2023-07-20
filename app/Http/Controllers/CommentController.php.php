<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{
    //
    public function addComment(Request $request)
    {
        $validatedData = $request->validate([
            'keterangan_komen' => 'required',
            'id_tiket' => 'required',
        ]);

        $userId = session('user')->idnik;
        $newCommentId = 'CMT' . substr(date('Y'), -2) . date('md') . str_pad(mt_rand(1, 999), 3, '0', STR_PAD_LEFT);
        dd($userId);

        $comment = new Comment();
        $comment->id_komen_tiket = $newCommentId;
        $comment->id_tiket = $request->id_tiket;
        $comment->nik_komen = $userId;
        $comment->datetime = now();
        $comment->keterangan_komen = $validatedData['komen'];
        $comment->save();


        return redirect()->back()->with('success', 'Komentar berhasil ditambahkan');
    }
}
