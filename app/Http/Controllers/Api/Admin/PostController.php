<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\Uploader;
use App\Models\Post;

class PostController extends Controller
{
    public function delete($slug)
    {
        $post = Post::where('slug', $slug)
            ->first();

        if (!$post) {
            return $this->error(__('errors.not-founded'), 404);
        }

        Uploader::deleteAttachment($post->image);
        $post->delete();

        return $this->success([
            'message' => __('success.deleted')
        ]);
    }
}
