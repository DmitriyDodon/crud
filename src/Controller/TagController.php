<?php

namespace App\Controller;

use App\Model\Tag;
use Illuminate\Http\RedirectResponse;

class TagController
{
    public function index()
    {
        $tags = Tag::all();
        return view('tag/list', compact('tags'));
    }

    public function create()
    {
        $tag = new Tag();

        return view('tag/form', compact('tag'));
    }

    public function store()
    {
        $data = request()->all();


        $validator = validator()->make($data,
            [
                'title' => ['filled', 'min:5' , 'unique:tags,title'],
                'slug' => ['filled' , 'min:5' , 'unique:tags,slug'],
            ]);

        $errors = $validator->errors();
        if (count($errors) > 0) {
            $_SESSION['errors'] = $errors->toArray();
            $_SESSION['data'] = $data;

            return new RedirectResponse($_SERVER['HTTP_REFERER']);
        }


        $tag = new Tag();
        $tag->title = $data['title'];
        $tag->slug = $data['slug'];
        $tag->save();

        $_SESSION['message']['text'] = "New tag was created.";
        $_SESSION['message']['type'] = 'success';
        return new RedirectResponse('/tag');
    }

    public function edit($id)
    {
        $tag = \App\Model\Tag::find($id);

        $_SESSION['data']['title'] = $tag->title;
        $_SESSION['data']['slug'] = $tag->slug;

        return view('tag/form');
    }

    public function update($id)
    {
        $tag = \App\Model\Tag::find($id);

        $data = request()->all();


        $validator = validator()->make($data,
            [
                'title' => ['filled', 'min:5' ,  "unique:tags,title,$id"],
                'slug' => ['filled' , 'min:5' , "unique:tags,slug,$id"],
            ]);

        $errors = $validator->errors();
        if (count($errors) > 0) {
            $_SESSION['errors'] = $errors->toArray();
            $_SESSION['data'] = $data;

            return new RedirectResponse($_SERVER['HTTP_REFERER']);
        }


        $tag->title = $data['title'];
        $tag->slug = $data['slug'];
        $tag->save();

        $_SESSION['message']['text'] = "Tag with id = $id was updated.";
        $_SESSION['message']['type'] = 'success';

        return new RedirectResponse('/tag');
    }

    public function delete($id)
    {
        $tag = \App\Model\Tag::find($id);
        $tag->posts()->detach();
        $tag->delete();
        $_SESSION['message']['text'] = "Tag with id = $id was deleted.";
        $_SESSION['message']['type'] = 'success';
        return new RedirectResponse('/tag');
    }
}
