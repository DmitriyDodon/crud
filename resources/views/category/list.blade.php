@extends('layout')

@section('title' , 'Category')

@section('content')

    @if(isset($_SESSION['message']) && $_SESSION['message']['type'] === 'success')
        <div class="alert alert-success" role="alert">
            {{  $_SESSION['message']['text'] }}
        </div>
    @endif

    <div class="conteiner">
        <table class="table table-bordered border-primary">
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Slug</th>
                <th>Created at</th>
                <th>Updated at</th>
                <th>Actions</th>
            </tr>
            @forelse($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->title }}</td>
                    <td>{{ $category->slug }}</td>
                    <td>{{ $category->created_at }} </td>
                    <td>{{ $category->updated_at }} </td>
                    <td>
                        <a href="category/{{ $category->id }}/edit">
                            <img src="https://cdn3.iconfinder.com/data/icons/othericons-3-0/50/pencil-512.png" height="30" width="30">
                        </a>
                        <a href="category/{{ $category->id }}/delete">
                            <img src="https://image.flaticon.com/icons/png/512/61/61848.png" height="30" width="30">
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" align="center">
                        No categories.
                    </td>
                </tr>
            @endforelse
            <tr>
                <td colspan="6" align="center">
                    <a href="category/create">
                        <img src="https://png.pngtree.com/png-vector/20190214/ourmid/pngtree-vector-plus-icon-png-image_515260.jpg" height="30" width="30">
                    </a>
                </td>
            </tr>
        </table>
    </div>
    @unset($_SESSION['message'])
@endsection

