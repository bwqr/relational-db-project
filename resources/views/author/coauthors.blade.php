@extends('layouts.content')

@section('view')
    <section class="centered-app">
        <div class="container">
            <div>
                <div class="title has-text-centered">
                    <h1 class="is-size-1">Co-Authors by {{$author['name'] . " " . $author['surname']}}</h1>
                    <hr>
                </div>
                <table class="table">
                    <thead>
                    <tr>
                        @foreach($coauthors['columns'] as $column)
                            <th>{{$column}}</th>
                        @endforeach
                    </tr>
                    </thead>
                    <tfoot>
                    </tfoot>
                    <tbody>
                    @foreach($coauthors['data'] as $coauthor)
                        <tr>
                            @foreach($coauthor as $field)
                                <td>{{$field}}</td>
                            @endforeach
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
@endsection
