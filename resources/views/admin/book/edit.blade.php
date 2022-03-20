@extends('layouts.admin')

@section('title', translate('Edit Book'))

@section('css')
    <link rel="stylesheet" href="{{ asset('statics/editormd/css/editormd.min.css') }}">
    <style>
        #bjy-content{
            z-index: 9999;
        }
    </style>
@endsection

@section('nav', translate('Edit Book'))

@section('content')

    <ul id="myTab" class="nav nav-tabs bar_tabs">
        <li>
            <a href="{{ url('admin/book/index') }}">{{ translate('Book List') }}</a>
        </li>
        <li class="active">
            <a href="{{ url('admin/book/create') }}">{{ translate('Edit Book') }}</a>
        </li>
    </ul>
    <form class="form-horizontal " action="{{ url('admin/book/update', [$book->id]) }}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <table class="table table-striped table-bordered table-hover">
            <tr>
                <th>{{ translate('Title') }}</th>
                <td>
                    <input class="form-control" type="text" name="title" value="{{ $book->title }}">
                </td>
            </tr>
            <tr>
                <th>{{ translate('Author') }}</th>
                <td>
                    <input class="form-control" type="text" name="author" value="{{ $book->author }}">
                </td>
            </tr>
            <tr>
                <th>{{ translate('Content') }}</th>
                <td>
                    <div id="bjy-content">
                        <textarea name="markdown">{{ $book->markdown }}</textarea>
                    </div>
                </td>
            </tr>
            <tr>
                <th></th>
                <td>
                    <input class="btn btn-success" type="submit" value="{{ translate('Submit') }}">
                </td>
            </tr>
        </table>
    </form>

@endsection

@section('js')
    <script src="{{ asset('statics/editormd/editormd.min.js') }}"></script>
    @if(config('app.locale') !== 'zh-CN')
        <script src="{{ asset('statics/editormd/languages/en.js') }}"></script>
    @endif
    <script>
        var testEditor;

        $(function() {
            // You can custom @link base url.
            editormd.urls.atLinkBase = "https://github.com/";

            testEditor = editormd("bjy-content", {
                autoFocus : false,
                width     : "100%",
                height    : 720,
                toc       : true,
                //atLink    : false,    // disable @link
                //emailLink : false,    // disable email address auto link
                todoList  : true,
                placeholder: "{{ translate('Enter book content') }}",
                toolbarAutoFixed: false,
                path      : '{{ asset('/statics/editormd/lib') }}/',
                emoji: true,
                toolbarIcons : ['undo', 'redo', 'bold', 'del', 'italic', 'quote', 'uppercase', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'list-ul', 'list-ol', 'hr', 'link', 'reference-link', 'image', 'code', 'code-block', 'table', 'emoji', 'html-entities', 'watch', 'preview', 'search', 'fullscreen'],
                imageUpload: true,
                imageUploadURL : '{{ url('admin/book/uploadImage') }}',
            });
            $('.bjy-icheck').iCheck({
                checkboxClass: "icheckbox_minimal-blue",
                radioClass: "iradio_minimal-blue",
                increaseArea: "20%"
            });
        });
    </script>

@endsection


