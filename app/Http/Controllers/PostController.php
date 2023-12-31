<?php

namespace App\Http\Controllers;

use App\Http\Requests\Post\CommentRequest;
use App\Http\Requests\Post\RepostRequest;
use App\Http\Requests\Post\StoreRequest;
use App\Http\Resources\Comment\CommentResource;
use App\Http\Resources\Post\PostResource;
use App\Models\Comment;
use App\Models\LikedPost;
use App\Models\Post;
use App\Models\PostImage;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::where('user_id', auth()->id())->withCount('repostedByPost')->get();
        $likedPostIds = LikedPost::where('user_id', auth()->id())->get('post_id')->pluck('post_id')->toArray();
        foreach ($posts as $post) {
            if (in_array($post->id, $likedPostIds)) {
                $post->is_liked = true;
            }
        }
        return PostResource::collection($posts);
    }

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
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => $e->getMessage(),
            ]);
        }

        return new PostResource($post);
    }

    public function repost(RepostRequest $repostRequest, Post $post)
    {
        $data = $repostRequest->validated();
        $data['user_id'] = auth()->id();
        $data['reposted_id'] = $post->id;
        Post::create($data);

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

    public function toggleLike(Post $post)
    {
        $res = auth()->user()->likedPosts()->toggle($post->id);
        $data['is_liked'] = count($res['attached']) > 0;
        $data['likes_count'] = $post->likedUsers()->count();
        return $data;
    }

    public function comment(CommentRequest $commentRequest, Post $post)
    {
        $data = $commentRequest->validated();
        $data['post_id'] = $post->id;
        $data['user_id'] = auth()->id();

        $comment = Comment::create($data);

        return new CommentResource($comment);

    }

    public function commentList(Post $post)
    {
        $comments = $post->comments()->latest()->get();
        return CommentResource::collection($comments);
    }
}
