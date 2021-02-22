@extends('layout')
{{--@dd()--}}
@section('content')
    <form method="POST">
        @if(isset($_SESSION['errors']['title']))
            <div class="alert alert-danger" role="alert">
                @foreach($_SESSION['errors']['title'] as $error)
                    {{ $error }} <br>
                @endforeach
            </div>
        @endif

        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Title</label>
            <input type="text" class="form-control" id="exampleInputEmail1" name="title" aria-describedby="emailHelp"
                   value="{{ $_SESSION['data']['title'] ?? $tag->title ?? '' }} "
            >
        </div>

        @if(isset($_SESSION['errors']['slug']))
            <div class="alert alert-danger" role="alert">
                @foreach($_SESSION['errors']['slug'] as $error)
                    {{ $error }} <br>
                @endforeach
            </div>
        @endif


        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Slug</label>
            <input type="text" class="form-control" id="exampleInputEmail1" name="slug" aria-describedby="emailHelp"
                   value="{{ $_SESSION['data']['slug'] ?? $tag->slug ?? '' }} "
            >
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    @unset($_SESSION['errors'])
    @unset($_SESSION['data'])
@endsection
