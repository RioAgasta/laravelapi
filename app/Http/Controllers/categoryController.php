<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\apiModel;
use App\Models\categoryModel;

class categoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = categoryModel::get();
        return response([
            'success' => true,
            'message' => 'List Semua Posts',
            'data' => $posts
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $image_path = $request->file('category_image')->store('image', 'public');

        $post = categoryModel::create([
            'category_name' => $request->category_name,
            'category_image' => $image_path,
        ]);

        if($post){
            return response()->json([
                'success' => true,
                'message' => 'Post Berhasil Disimpan!',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Post Gagal Disimpan!',
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $posts = categoryModel::whereId($id)->get()->load(['apiModel']);

        if($posts){
            return response()->json([
                'success' => true,
                'message' => 'Details Post!',
                'data' => $posts
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Post tidak ditemukan',
                'data' => ''
            ], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $post = categoryModel::findOrFail($id);

        if ($post) {
            // Delete file from storage
            // $file = str_replace('\\', '/', public_path('storage/')).$post->image;
            // unlink($file);

            $post->update([
                'category_name' => $request->category_name,
                'category_image' => $request->category_image,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Post Telah di update',
                'data'    => $post
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Post Tidak Ditemukan!'
        ], 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product=categoryModel::find($id);
        if($product){
            // Delete file from storage
            $file = str_replace('\\', '/', public_path('storage/')).$product->category_image;
            unlink($file);
            $product->delete();

            return response()->json([
                'message'=>'product berhasil dihapus',
                'code'=>200
            ]);
        } else {
            return response()->json([
                'message'=>'product dengan id:$id tidak tersedia',
                'code'=>400
            ]);
        }
    }
}
