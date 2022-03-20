@extends('layouts.admin')

@section('title', translate('Add Book'))

@section('css')
    <link rel="stylesheet" href="{{ asset('statics/editormd/css/editormd.min.css') }}">
    <style>
        #bjy-content{
            z-index: 1000;
        }
    </style>
@endsection

@section('nav', translate('Add Book'))

@section('content')


    <ul id="myTab" class="nav nav-tabs bar_tabs">
        <li>
            <a href="{{ url('admin/book/index') }}">{{ translate('Book List') }}</a>
        </li>
        <li class="active">
            <a href="{{ url('admin/book/create') }}">{{ translate('Add Book') }}</a>
        </li>
    </ul>
    <form class="form-horizontal " action="{{ url('admin/book/store') }}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <table class="table table-striped table-bordered table-hover">
            <tr>
                <th>{{ translate('Title') }}</th>
                <td>
                    <input class="form-control" type="text" name="title" value="{{ old('title') }}">
                </td>
            </tr>
            <tr>
                <th>{{ translate('Author') }}</th>
                <td>
                    <input class="form-control" type="text" name="author" value="@if(empty(old('author'))){{ $author }}@else{{ old('author') }}@endif">
                </td>
            </tr>
            <tr>
                <th>{{ translate('Content') }}</th>
                <td>
                    <div id="bjy-content">
                        <textarea name="markdown">{{ old('markdown') }}</textarea>
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
                placeholder: "{{ translate('Enter article content') }}",
                toolbarAutoFixed: false,
                path      : '{{ asset('/statics/editormd/lib') }}/',
                emoji: true,
                toolbarIcons : ['undo', 'redo', 'bold', 'del', 'italic', 'quote', 'uppercase', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'list-ul', 'list-ol', 'hr', 'link', 'reference-link', 'image', 'code', 'code-block', 'table', 'emoji', 'html-entities', 'watch', 'preview', 'search', 'fullscreen'],
                imageUpload: true,
                imageUploadURL : '{{ url('admin/article/uploadImage') }}',
            });
        });

        // 添加标签
        $('.js-add-tag').click(function () {
            var postData = {
                name: $('.bjy-tag-name').val()
            }
            $.ajax({
                type: 'POST',
                url: '{{ url('admin/tag/store') }}',
                dataType: 'json',
                data: postData,
                success: function (response) {
                    var redioStr = response.name+'<input class="bjy-icheck" type="checkbox" name="tag_ids[]" value="'+response.id+'" checked="checked"> &emsp;';
                    $('.fa-plus-square').before(redioStr);
                    $('.bjy-icheck').iCheck({
                        checkboxClass: "icheckbox_minimal-blue",
                        radioClass: "iradio_minimal-blue",
                        increaseArea: "20%"
                    });
                    $('#bjy-tag-modal').modal('hide');
                },
                error: function (response) {
                    $.each(response.responseJSON.errors, function (k, v) {
                        alert(v);
                    })
                }
            })
        })
    </script>

@endsection


