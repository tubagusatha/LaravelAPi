<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {


        return [
            'id' => $this->id,
            'nama_barang' => $this->nama_barang,
            'image' => $this->image,
            'harga' => $this->harga,
            'jenis_barang' => $this->jenis_barang,
            'rating' => $this->rating,
            'created_at' => date_format($this->created_at, "Y/M/D H:i"),
            'writer' => $this->writer['username'],
            'total_comment' => $this->comments->count(),
            'komentar' => CommentResource::collection($this->comments),
            'total_pembelian' => $this->total_pembelian,
            'stock' => $this->stock,
        ];
    }
}
