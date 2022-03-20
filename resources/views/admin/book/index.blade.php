@extends('layouts.admin')

@section('title', translate('Book List'))

@section('nav', translate('Book List'))

@section('content')
    <ul id="myTab" class="nav nav-tabs bar_tabs">
        <li class="active">
            <a href="{{ url('admin/book/index') }}">{{ translate('Book List') }}</a>
        </li>
        <li>
            <a href="{{ url('admin/book/create') }}">{{ translate('Add Book') }}</a>
        </li>
    </ul>
    <table class="table table-striped table-bordered table-hover">
        <tr>
            <th>Id</th>
            <th>{{ translate('Title') }}</th>
            <th>{{ translate('Status') }}</th>
            <th>{{ translate('Created_at') }}</th>
            <th>{{ translate('Handle') }}</th>
        </tr>
        @foreach($books as $k => $v)
            <tr>
                <td>{{ $v->id }}</td>
                <td>
                    <a href="{{ url('book', [$v->id]) }}" target="_blank">{{ $v->title }}</a>
                </td>
                <td>
                    @if(is_null($v->deleted_at))
                        √
                    @else
                        ×
                    @endif
                </td>
                <td>{{ $v->created_at }}</td>
                <td>
                    <a href="{{ url('admin/book/edit', [$v->id]) }}">{{ translate('Edit') }}</a>
                    |
                    @if($v->trashed())
                        <a href="javascript:if(confirm('{{ translate('Restore') }}?'))location.href='{{ url('admin/book/restore', [$v->id]) }}'">{{ translate('Restore') }}</a>
                        |
                        <a href="javascript:if(confirm('{{ translate('Force Delete') }}?'))location.href='{{ url('admin/book/forceDelete', [$v->id]) }}'">{{ translate('Force Delete') }}</a>
                    @else
                        <a href="javascript:if(confirm('{{ translate('Delete') }}?'))location.href='{{ url('admin/book/destroy', [$v->id]) }}'">{{ translate('Delete') }}</a>
                    @endif
                </td>
            </tr>
        @endforeach
    </table>
    <div class="text-center">
        {{ $books->links('vendor.pagination.bjypage') }}
    </div>

@endsection
