<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\DetaiOrder;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($idPage)
    {
        //
        $comments = Comment::with([
            'product',
            'user'
        ])
        ->paginate(20,['*'],'comment',$idPage);

        $data = [
            'comments' => $comments->reverse()->values(),
            'idPage' => $idPage,
            'totalPage' => $comments->lastPage(),
        ];

        return view('admin.listcomment', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $products = Product::all();

        $users = User::all();

        $data = [
            'products' => $products,
            'users' => $users,
        ];

        return view('admin.addcomment',$data);
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate(
            ['comment'=> 'required'],
            ['comment.required' =>'Bình luận không được để trống']
        );
        $comment = $request->comment;
        $id_user = Auth::user()->id;
        $id_product = $request->product_id;
        $id_detail_order = $request->id_detail_order;
        Comment::create([
            'comments' => $comment, 
            'product_id' => $id_product,
            'user_id' => $id_user
        ]);

        $detail = DetaiOrder::find($id_detail_order);

        $detail->check_comment = 1;

        $detail->save();

        return redirect('/product/'.$id_product);
        
    }
    public function createAdmin(Request $request){

        $request->validate([
            'content' => 'required',
        ],[
            'content.required' => 'Nội dung bình luận không được để trống',
        ]);

        Comment::create([
            'comments' => $request->content,
            'product_id' => $request->product_id,
            'user_id' => $request->user_id,
        ]);

        return redirect('/listcomment/1')->with('success','Thêm bình luận thành công');

    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comment $comment)
    {
        //
        $data = [
            'comment' => $comment
        ];
        return  view('admin.editcomment',$data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        //
        $request->validate([
            'content' => 'required',
        ],[
            'content.required' => 'Nội dung bình luận không được để trống',
        ]);

        $comment->comments = $request->content;

        $comment->save();

        return redirect('/comment/edit/'.$comment->id)->with('tb','Sửa bình luận thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment,$idPage = 1)
    {
        //
        $comment->delete();

        return redirect('/listcomment/'.$idPage)->with('success','Xóa bình luận thành công');
    }
}
