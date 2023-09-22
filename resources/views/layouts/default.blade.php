<?php $lang = session()->get('locale'); if ($lang == null){$lang = 'ru';}  ?>
<html lang="{{$lang}}"><head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('css/normalize.css')}}">
    <link rel="stylesheet" href="{{asset('css/style.min.css')}}">
    <link rel="icon" type="image/x-icon" href="{{asset('LogoAII.ico')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}" >
     <title>@yield('title')</title>
    @yield('alternate')
    <meta name="description" content="@yield('description')">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

    <script src="{{asset('js/ui.js')}}"></script>
    <script src="{{asset('js/filter.js')}}"></script>
    <script src="{{asset('js/pagination.js')}}"></script>
    <script type="text/javascript" >
        (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
            m[i].l=1*new Date();
            for (var j = 0; j < document.scripts.length; j++) {if (document.scripts[j].src === r) { return; }}
            k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
        (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

        ym(94768554, "init", {
            clickmap:true,
            trackLinks:true,
            accurateTrackBounce:true,
            webvisor:true
        });
    </script>
    <noscript><div><img src="https://mc.yandex.ru/watch/94768554" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
</head>

<body>
<div class="background"></div>

<div class="main-container">
<?php      use Carbon\Carbon; Carbon::now(session()->get('timezone'));  ?>

  @yield('leftbar')
  @yield('content')


</div>



</body></html>
