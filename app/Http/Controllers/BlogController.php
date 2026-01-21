<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BlogController extends Controller
{
    public function blogs()
    {
        $posts = DB::table('wp_posts')->where('post_status', 'publish')->where('post_type', 'post')->get();
        $recommendedPosts = DB::table('wp_posts')->join('wp_postmeta', 'wp_posts.ID', '=', 'wp_postmeta.post_id')
            ->where('wp_postmeta.meta_key', 'recommended')
            ->where('wp_postmeta.meta_value', 'LIKE', '%s:3:"yes"%') // Check serialized value
            //->where('wp_postmeta.meta_value', 'Yes') // Only get posts where recommended is checked
            ->where('wp_posts.post_status', 'publish')->where('wp_posts.post_type', 'post')->select('wp_posts.*')->get();
        $breadcrumbs = [
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Blogs']
        ];
        return view('public.blogs', ['blogPosts' => $posts, 'recPosts' => $recommendedPosts, 'breadcrumbs' => $breadcrumbs]);
    }

    public function blogDetails($slug)
    {
        $post = DB::table('wp_posts')->where('post_name', $slug)->where('post_status', 'publish')->where('post_type', 'post')->first();
        if (!$post) {
            abort(404);
        }
        $breadcrumbs = [
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Blogs', 'url' => route('blogs')],
            ['label' => $post->post_title]
        ];
        return view('public.blogDetails', compact('post', 'breadcrumbs'));
    }
}
