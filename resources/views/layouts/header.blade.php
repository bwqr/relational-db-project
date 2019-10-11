@extends('layouts.app')
@section('header')
<header class="mdc-top-app-bar app-bar" id="app-bar">
    <div class="mdc-top-app-bar__row">
        <section class="mdc-top-app-bar__section mdc-top-app-bar__section--align-start">
            <a href="#" class="demo-menu material-icons mdc-top-app-bar__navigation-icon">menu</a>
            <span class="mdc-top-app-bar__title">@{{ role }}</span>
        </section>
        <section class="mdc-top-app-bar__section mdc-top-app-bar__section--align-end" role="toolbar">
            <a href="/"><button class="mdc-button has-text-white">Change User</button></a>
        </section>
    </div>
</header>
<aside class="mdc-drawer mdc-drawer--dismissible mdc-top-app-bar--fixed-adjust">
    <div class="mdc-drawer__content">
        <div class="mdc-list">
            @foreach($menus as $menu)
                <a class="mdc-list-item mdc-list-item--activated" href="{{$menu['link']}}" aria-current="page">
{{--                    <i class="material-icons mdc-list-item__graphic" aria-hidden="true"></i>--}}
                    <span class="mdc-list-item__text">{{$menu['name']}}</span>
                </a>
            @endforeach
        </div>
    </div>
</aside>

<div class="mdc-drawer-app-content mdc-top-app-bar--fixed-adjust">
    <main class="main-content" id="main-content">
        @yield('content')
    </main>
</div>
@endsection
