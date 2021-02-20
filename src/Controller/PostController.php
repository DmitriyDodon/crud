<?php

namespace App\Controller;

use App\Model\Category;
use App\Model\Post;
use App\Model\Tag;
use Illuminate\Http\RedirectResponse;

class PostController
{
    public function index()
    {
        $posts = Post::all();
        return view('post/list', compact('posts'));
    }

    public function create()
    {
        $tags = Tag::all();
        $categories = Category::all();
        return view('post/form', compact('tags', 'categories'));
    }

    public function store()
    {
        $data = request()->all();


        $validator = validator()->make($data,
            [
                'title' => ['filled', 'min:5', "unique:categories,title"],
                'slug' => ['filled', 'min:5', "unique:categories,slug"],
                'body' => ['filled', 'min:10'],
                'category' => ['required', 'numeric'],
                'tags' => ['required']
            ]);

        $errors = $validator->errors();
        if (count($errors) > 0) {
            $_SESSION['errors'] = $errors->toArray();
            $_SESSION['data'] = $data;

            return new RedirectResponse($_SERVER['HTTP_REFERER']);
        }


        $post = new Post();
        $post->title = $data['title'];
        $post->slug = $data['slug'];
        $post->body = trim($data['body']);
        $post->category_id = $data['category'];
        $post->save();
        $post->tags()->attach($data['tags']);

        $_SESSION['message']['text'] = "Post was created.";
        $_SESSION['message']['type'] = 'success';

        return new RedirectResponse('/post');
    }

    public function edit($id)
    {
        $post = \App\Model\Post::find($id);
        $tags = Tag::all();
        $categories = Category::all();

        $_SESSION['data']['title'] = $post->title;
        $_SESSION['data']['slug'] = $post->slug;
        $_SESSION['data']['body'] = $post->body;
        $_SESSION['data']['category'] = $post->category;
        $_SESSION['data']['tags'] = $post->tags->pluck('id')->toArray();

        return view('post/form', compact('tags', 'categories'));
    }

    public function update($id)
    {
        $post = \App\Model\Post::find($id);

        $data = request()->all();

        $validator = validator()->make($data,
            [
                'title' => ['filled', 'min:5', "unique:posts,title,$id"],
                'slug' => ['filled', 'min:5', "unique:posts,slug,$id"],
                'body' => ['filled', 'min:10'],
                'category' => ['required', 'numeric'],
                'tags' => ['required']
            ]);

        $errors = $validator->errors();
        if (count($errors) > 0) {
            $_SESSION['errors'] = $errors->toArray();
            $_SESSION['data'] = $data;

            return new RedirectResponse($_SERVER['HTTP_REFERER']);
        }


        $post->title = $data['title'];
        $post->slug = $data['slug'];
        $post->body = $data['body'];
        $post->category_id = $data['category'];
        $post->save();
        $post->tags()->detach();
        $post->tags()->attach($data['tags']);

        $_SESSION['message']['text'] = "post with id = $id was updated.";
        $_SESSION['message']['type'] = 'success';

        return new RedirectResponse('/post');
    }

    public function delete($id)
    {
        $post = \App\Model\Post::find($id);
        $post->tags()->detach();
        $post->delete();

        $_SESSION['message']['text'] = "post with id = $id was deleted.";
        $_SESSION['message']['type'] = 'success';
        return new RedirectResponse('/post');
    }
}
