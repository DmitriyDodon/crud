@extends('layout')

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
                   value="{{ $_SESSION['data']['title'] ?? $post->title ?? '' }}">
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
                   value="{{ $_SESSION['data']['slug'] ?? $post->slug ?? '' }}">
        </div>
        @if(isset($_SESSION['errors']['body']))
            <div class="alert alert-danger" role="alert">
                @foreach($_SESSION['errors']['body'] as $error)
                    {{ $error }} <br>
                @endforeach
            </div>
        @endif
        <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Body</label>
            <textarea class="form-control" name="body" id="exampleFormControlTextarea1" rows="3">
                {{ $_SESSION['data']['body'] ?? $post->body ?? '' }}
            </textarea>
        </div>

        @if(isset($_SESSION['errors']['category']))
            <div class="alert alert-danger" role="alert">
                @foreach($_SESSION['errors']['category'] as $error)
                    {{ $error }} <br>
                @endforeach
            </div>
        @endif
        <label for="exampleInputEmail1" class="form-label">Categories</label>
        @forelse($categories as $category)
            <div class="form-check">
                <input class="form-check-input" value="{{ $category->id }}" name="category" type="radio"
                       id="flexRadioDefault2"
                        {{$data = $_SESSION['data']['category'] ?? $post->category->id ?? ""}}
                        @if($data == $category->id)
                            checked
                        @endif
                >
                <label class="form-check-label" for="flexRadioDefault2">
                    {{ $category->title }}
                </label>
            </div>
        @empty
            <p>There is no categories to be connected. <a href="/category/create">Add category.</a></p>
        @endforelse

        @if(isset($_SESSION['errors']['tags']))
            <div class="alert alert-danger" role="alert">
                @foreach($_SESSION['errors']['tags'] as $error)
                    {{ $error }} <br>
                @endforeach
            </div>
        @endif
        <label for="exampleInputEmail1" class="form-label">Tags</label>
            @php
                if (isset($_SESSION['data']['tags']) ){
                    foreach ($_SESSION['data']['tags'] as $key => $value){
                        $_SESSION['data']['tags'][$key] = intval($value);
                   }
                }

                if(isset($_SESSION['data']['tags'])){
                    $data = $_SESSION['data']['tags'];
                }else{
                    /** @var $tags_id */
                    $data = $tags_id;
                }
            @endphp

        @forelse($tags as $tag)
            <div class="form-check form-switch">
                <input class="form-check-input" value="{{$tag->id}}" name="tags[]" type="checkbox"
                       id="flexSwitchCheckChecked"
                        @if(is_null($data) || in_array($tag->id , $data)) checked @endif>
                <label class="form-check-label" for="flexSwitchCheckChecked">{{$tag->title}}</label>
            </div>
        @empty
            <p>There is no tags to be connected. <a href="/tag/create">Add tag.</a></p>
        @endforelse


        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    @unset($_SESSION['errors'])
    @unset($_SESSION['data'])
@endsection
