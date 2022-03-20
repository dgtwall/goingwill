@extends('layouts.home')

@section('title', $book->title)

@section('content')
    <!-- 左侧文章开始 -->
    <div class="col-xs-12 col-md-12 col-lg-8">
        @if(Str::isTrue(config('bjyblog.breadcrumb')))
            <div class="row">
                <div class="col-xs-12 col-md-12 col-lg-12 b-breadcrumb">
                    {{ Breadcrumbs::render() }}
                </div>
            </div>
        @endif

        <div class="row b-article">
            @if(auth()->guard('admin')->check())
                <a class="fa fa-edit b-edit-icon" href="{{ url('admin/book/edit', [$book->id]) }}"></a>
            @endif
            <h1 class="col-xs-12 col-md-12 col-lg-12 b-title">{{ $book->title }}</h1>
            <div class="col-xs-12 col-md-12 col-lg-12">
                <ul class="row b-metadata">
                    <li class="col-xs-5 col-md-3 col-lg-4"><i class="fa fa-user"></i> {{ $book->author }}</li>
                    <li class="col-xs-7 col-md-3 col-lg-3"><i class="fa fa-calendar"></i> {{ $book->created_at }}</li>
                </ul>
            </div>
            <div class="col-xs-12 col-md-12 col-lg-12 b-content-word">
                <div class="js-content">{!! $book->html !!}</div>
                <p class="b-h-20"></p>
                <p class="b-copyright">
                    {!! htmlspecialchars_decode(config('bjyblog.copyright_word')) !!}
                </p>
                <div class="b-share-plugin">
                    @if(config('bjyblog.social_share.select_plugin') === 'sharejs')
                        <div id="b-share-js"></div>
                    @else
                        <div id="b-js-socials"></div>
                    @endif
                </div>
                <ul class="b-prev-next">
                    <li class="b-prev">
                         {{ translate('Previous Book') }}：
                        @if(is_null($prev))
                            <span>{{ translate('No More Book') }}</span>
                        @else
                            <a href="{{ $prev->url }}">{{ $prev->title }}</a>
                        @endif

                    </li>
                    <li class="b-next">
                        {{ translate('Next Book') }}：
                        @if(is_null($next))
                            <span>{{ translate('No More Book') }}</span>
                        @else
                            <a href="{{ $next->url }}">{{ $next->title }}</a>
                        @endif
                    </li>
                </ul>
            </div>
        </div>
        </div>
    <!-- 左侧文章结束 -->
@endsection

@section('js')
    <script>
        $('pre').addClass('line-numbers');
        $('.js-content a').attr('target', "{{ config('bjyblog.link_target') }}")
        translate = {
            pleaseLoginToComment: "{{ translate('Please login to comment') }}",
            pleaseLoginToReply: "{{ translate('Please login to reply') }}",
            emailForNotifications: "{{ translate('Email for notifications') }}",
            pleaseLogin: "{{ translate('Please login') }}",
            reply: "{{ translate('Reply') }}"
        }
        $.each($('.js-content img'), function (k, v) {
            $(v).wrap(function(){
                return "<a class='js-fluidbox' href='"+$(v).attr('src')+"'></a>"
            });
        })
        emojify.run(document.querySelector('.js-content'));
        $('.js-fluidbox').fluidbox();
        $('#b-share-js').share(sharejsConfig);
        $('#b-js-socials').jsSocials(jsSocialsConfig)
    </script>
    <script src="{{ asset('statics/layer-2.4/layer.js') }}"></script>
@endsection
