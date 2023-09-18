<?php

namespace App\Http\Controllers;

use App\Http\Requests\Post\StoreRequest;
use App\Http\Resources\Post\PostResource;
use App\Models\Post;
use App\Models\PostImage;
use Illuminate\Support\Facades\DB;
class PostController extends Controller
{
    public function store(StoreRequest $storeRequest)
    {
        try {
            DB::beginTransaction();
            $data = $storeRequest->validated();
            $imageId = $data['image_id'];
            unset($data['image_id']);
            $data['user_id'] = auth()->id();
            $post = Post::create($data);
            $this->processImage($imageId, $post);
            PostImage::clearStorage();
            DB::commit();;
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
               'error' => $e->getMessage(),
            ]);
        }

        return new PostResource($post);
    }

    /**
     * @param mixed $imageId
     * @return void
     */
    public function processImage(mixed $imageId, Post $post): void
    {
        if (isset($imageId)) {
            $image = PostImage::find($imageId);
            $image->update([
                'is_active' => true,
                'post_id' => $post->id
            ]);
        }
    }
}
