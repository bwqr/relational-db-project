@extends('layouts.header', [
    'menus' => [
            ['name' => 'Author', 'link' => '/author'],
            ['name' => 'Paper', 'link' => '/paper'],
            ['name' => 'Topic', 'link' => '/topic'],
        ],
    ])

@section('content')
    <section class="view">
        @yield('view')
    </section>
@endsection
