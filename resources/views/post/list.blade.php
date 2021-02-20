@extends('layout')

@section('title' , 'Post')

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
                <th>Body</th>
                <th>Category id</th>
                <th>Tags</th>
                <th>Created at</th>
                <th>Updated at</th>
                <th>Actions</th>
            </tr>
            @forelse($posts as $post)
                <tr>
                    <td>{{ $post->id }}</td>
                    <td>{{ $post->title }}</td>
                    <td>{{ $post->slug }}</td>
                    <td>{{ $post->body }}</td>
                    <td>{{ $post->category_id }} </td>
                    <td>{{ implode(' ,' , $post->tags->pluck('title')->toArray()) }} </td>
                    <td>{{ $post->created_at }} </td>
                    <td>{{ $post->updated_at }} </td>

                    <td>
                        <a href="post/{{ $post->id }}/edit">
                            <img src="https://cdn3.iconfinder.com/data/icons/othericons-3-0/50/pencil-512.png" height="30" width="30">
                        </a>
                        <a href="post/{{ $post->id }}/delete">
                            <img src="https://image.flaticon.com/icons/png/512/61/61848.png" height="30" width="30">
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" align="center">
                        No posts.
                    </td>
                </tr>
            @endforelse
            <tr>
                <td colspan="9" align="center">
                    <a href="post/create">
                        <img src="https://png.pngtree.com/png-vector/20190214/ourmid/pngtree-vector-plus-icon-png-image_515260.jpg" height="30" width="30">
                    </a>
                </td>
            </tr>
        </table>
    </div>
    @unset($_SESSION['message'])
@endsection

