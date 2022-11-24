<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\apiModel;
use Storage;

class apiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = apiModel::latest()->get();
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $image_path = $request->file('image')->store('image', 'public');

        $post = apiModel::create([
            'title' => $request->title,
            'price' => $request->price,
            'image' => $image_path,
            'category_id' => $request->category_id
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
        $post = apiModel::whereId($id)->first();

        if($post) {
            return response()->json([
                'success' => true,
                'message' => 'Detail Post!',
                'data'    => $post
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Post Tidak Ditemukan',
                'data'    => ''
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
    public function update($id, Request $request)
    {
        $post = apiModel::findOrFail($id);

        if ($post) {
            // Delete file from storage
            // $file = str_replace('\\', '/', public_path('storage/')).$post->image;
            // unlink($file);

            $post->update([
                'title' => $request->title,
                'price' => $request->price,
                'image' => $request->image,
                'category' =>$request->category
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
        $product=apiModel::find($id);
        if($product){
            // Delete file from storage
            $file = str_replace('\\', '/', public_path('storage/')).$product->image;
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
