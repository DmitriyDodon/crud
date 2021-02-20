<?php

namespace App\Controller;

use App\Model\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

class CategoryController
{
    public function index()
    {
        $categories = Category::all();
        return view('category/list', compact('categories'));
    }

    public function create()
    {
        $category = new Category();

        return view('category/form', compact('category'));
    }

    public function store()
    {
        $data = request()->all();

        $validator = validator()->make($data,
            [
                'title' => ['filled', 'min:5' , 'unique:categories,title'],
                'slug' => ['filled' , 'min:5' , 'unique:categories,slug'],
            ]);

        $errors = $validator->errors();
        if (count($errors) > 0) {
            $_SESSION['errors'] = $errors->toArray();
            $_SESSION['data'] = $data;

            return new RedirectResponse($_SERVER['HTTP_REFERER']);
        }


        $category = new Category();
        $category->title = $data['title'];
        $category->slug = $data['slug'];
        $category->save();
        $_SESSION['message']['text'] = "New category was created.";
        $_SESSION['message']['type'] = 'success';

        return new RedirectResponse('/category');
    }

    public function edit($id)
    {
        $category = \App\Model\Category::find($id);

        $_SESSION['data']['title'] = $category->title;
        $_SESSION['data']['slug'] = $category->slug;

        return view('category/form');
    }

    public function update($id)
    {
        $category = \App\Model\Category::find($id);

        $data = request()->all();

        $validator = validator()->make($data,
            [
                'title' => ['filled', 'min:5' ,  "unique:categories,title,$id"],
                'slug' => ['filled' , 'min:5' , "unique:categories,slug,$id"],
            ]);

        $errors = $validator->errors();
        if (count($errors) > 0) {
            $_SESSION['errors'] = $errors->toArray();
            $_SESSION['data'] = $data;

            return new RedirectResponse($_SERVER['HTTP_REFERER']);
        }


        $category->title = $data['title'];
        $category->slug = $data['slug'];
        $category->save();

        $_SESSION['message']['text'] = "Category with id = $id was updated.";
        $_SESSION['message']['type'] = 'success';

        return new RedirectResponse('/category');
    }

    public function delete($id)
    {
        $category = \App\Model\Category::find($id);
        $posts = $category->posts;
        $posts->transform(function ($item) {
            $item->tags()->detach();
            return $item->delete();
        });
        $category->delete();
        $_SESSION['message']['text'] = "Category with id = $id was deleted.";
        $_SESSION['message']['type'] = 'success';
        return new RedirectResponse('/category');
    }
}
