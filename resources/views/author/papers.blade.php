@extends('layouts.content')

@section('view')
    <section class="centered-app">
        <div class="container">
            <div>
                <div class="title has-text-centered">
                    <h1 class="is-size-1">Papers by {{$author['name'] . " " . $author['surname']}}</h1>
                    <hr>
                </div>
                <table class="table">
                    <thead>
                    <tr>
                        @foreach($papers['columns'] as $column)
                            <th>{{$column}}</th>
                        @endforeach
                    </tr>
                    </thead>
                    <tfoot>
                    </tfoot>
                    <tbody>
                    @foreach($papers['data'] as $paper)
                        <tr>
                            @foreach($paper as $field)
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
