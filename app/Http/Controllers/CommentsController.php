<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentResource;
use App\Models\Comments;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Support\Facades\Auth;

class CommentsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum']);
        $this->middleware(['pemilik-comment'])->only('update', 'delete', 'me');
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'posts_id' => 'required|exists:posts,id',
            'users_id' => 'required|exists:users,id',
            'comments_content' => 'required',
        ]);

        $request['user_id'] = Auth::user()->id;
        $comment = Comments::create($request->all());

        return new CommentResource($comment);
    }


    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'comments_content' => 'required',
        ]);

        $comment = Comments::findOrFail($id);
        $comment->update($request->all());

        return new CommentResource($comment);
    }

    public function delete($id)
    {
        $comment = Comments::findOrFail($id);
        $comment->delete();
        $user = Auth::user()->username;

        return response()->json([
            'messege' => 'berhasi menghapus komennya dengan nama',
            'user' => $user,
            'comment_content' => $comment->comments_content
        ]);
    }
}
