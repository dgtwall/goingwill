@extends('layouts.home')

@section('content')
    <!-- 左侧列表开始 -->
    <div class="col-xs-12 col-md-12 col-lg-8">
        @if(Str::isTrue(config('bjyblog.breadcrumb')))
            <div class="row">
                <div class="col-xs-12 col-md-12 col-lg-12 b-breadcrumb">
                    {{ Breadcrumbs::render() }}
                </div>
            </div>
        @endif

        @if(Str::isFalse(config('bjyblog.breadcrumb')) && !empty($tagName))
            <div class="row b-tag-title">
                <div class="col-xs-12 col-md-12 col-lg-12">
                    <h2>{!! translate('others.article_with_tag', ['tag' => $tagName]) !!}</h2>
                </div>
            </div>
        @endif

        @if(Str::isFalse(config('bjyblog.breadcrumb')) && request()->has('wd'))
            <div class="row b-tag-title">
                <div class="col-xs-12 col-md-12 col-lg-12">
                    <h2>{!! translate('others.search_article', ['word' => clean(request()->input('wd'))]) !!}</h2>
                </div>
            </div>
        @endif
    <!-- 循环文章列表开始 -->
        @foreach($books as $k => $v)
            <div class="row b-one-article">
                <h3 class="col-xs-12 col-md-12 col-lg-12">
                    <a class="b-oa-title" href="{{ $v->url }}" target="{{ config('bjyblog.link_target') }}">{{ $v->title }}</a>
                </h3>
                <div class="col-xs-12 col-md-12 col-lg-12 b-date">
                    <ul class="row">
                        <li class="col-xs-5 col-md-3 col-lg-4">
                            <i class="fa fa-user"></i> {{ $v->author }}
                        </li>
                        <li class="col-xs-7 col-md-3 col-lg-3">
                            <i class="fa fa-calendar"></i> {{ $v->created_at }}
                        </li>
                    </ul>
                </div>
                <a class=" b-readall" href="{{ $v->url }}" target="{{ config('bjyblog.link_target') }}">{{ translate('Read More') }}</a>
            </div>
    @endforeach
    <!-- 循环文章列表结束 -->

        <!-- 列表分页开始 -->
        <div class="row">
            <div class="col-xs-12 col-md-12 col-lg-12 b-page text-center">
                {{$books->links('vendor.pagination.bjypage') }}
            </div>
        </div>
        <!-- 列表分页结束 -->
    </div>
    <!-- 左侧列表结束 -->
@endsection
