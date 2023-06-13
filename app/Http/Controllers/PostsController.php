<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostsResource;
use App\Http\Resources\PostsShowResource;
use App\Models\posts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum'])->only('store', 'update', 'delete');
        $this->middleware(['pemilikPostinganJualan'])->only('update', 'delete');
    }




    public function index()
    {
        $posts = posts::all();
        // return response()->json(['news' => $posts]);
        return PostsResource::collection($posts);
    }

    public function show($id)
    {
        $post = posts::with('writer')->findOrFail($id);
        return new PostsResource($post);
    }

    public function generateRandomString($length = 20)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required',
            'jenis_barang' => 'required',
            'image' => '',
            'harga' => 'required',
            'rating' => 'required',
            'total_pembelian' => 'required',
            'stock' => 'required',
        ]);

        if ($request->file) {

            $validated = $request->validate([
                'file' => 'mimes:jpeg,png,jpg|max:100000',
            ]);

            $fileName = $this->generateRandomString();
            $extension = $request->file->extension();

            Storage::putFileAs('image', $request->file, $fileName . '.' . $extension);

            $request['image'] = $fileName . '.' . $extension;
            $request['penjual'] = Auth::user()->id;
            $post = posts::create($request->all());
        }

        $request['penjual'] =  Auth::user()->id;

        $post = posts::create([
            'nama_barang'       => $request->input('nama_barang'),
            'jenis_barang'      => $request->input('jenis_barang'),
            'harga'             => $request->input('harga'),
            'rating'            => $request->input('rating'),
            'total_pembelian'   => $request->input('total_pembelian'),
            'stock'             => $request->input('stock'),
            'penjual'           => Auth::user()->id,

        ]);

        return new PostsResource(($post->loadMissing('writer')));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_barang' => 'required|string',
            'jenis_barang' => 'required|string',
            'harga' => 'required|integer',
            'stock' => 'required|string',
        ]);

        $post = posts::findOrFail($id);
        $post->update($request->all());

        return new PostsResource($post->loadMissing('writer'));
    }

    public function delete($id)
    {
        $post = posts::findOrFail($id);
        $post->delete();

        return response()->json([
            'messege' => 'berhasi menghapus postingan jualan',
            'postingan' => $post->nama_barang
        ]);
    }
}
