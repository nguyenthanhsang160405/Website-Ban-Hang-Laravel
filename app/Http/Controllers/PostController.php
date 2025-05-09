<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        // Query Builder
        // $post = DB::select("SELECT * FROM posts WHERE  id = :id",[
        // 'id' => 1
        // ]);

        $post = DB::table('posts')
        ->where('id', ">" ,100)
        ->orWhere('id' ,"<" , 10)
        // ->select('concont')
        ->orderBy('created_at','desc')
        ->get();

        dd($post);
    }

    public function rangePost(){

        $post = DB::table('posts')
        ->avg('id'); // get id avg
        // ->sum('id'); tính tổng tất cả các id nó lấy được
        // ->count() // get all row
        // ->max('id'); // get id max
        // ->min('id'); // get id min
        // ->oldest('id'); // get id oldest
        // ->latest('id'); // get id latest
        // ->find(1); // get id = 1
        // ->whereBetween('id',[1,4])
        // ->whereNotNull('created_at')
        // ->firstOrFail();
        dd($post);
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }
    public function insert()
    {   
        $post = DB::table('posts')
        ->insert([
            'concont'=> 'Bài viết 7',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        dd($post);
    }
    public function updatekhac($id){
        $post = DB::table('posts')
        ->where('id', $id)
        ->update([
            'concont'=> 'Bài viết Đã được update '.$id.'',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        dd($post);
    }
    public function deletekhac($id){
        $post = DB::table('posts')
        ->where('id', $id)
        ->delete();
        dd($post);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}
