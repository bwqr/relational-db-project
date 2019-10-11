@extends('layouts.content')

@section('view')
    <section class="centered-app">
        <div class="container">
            <div>
                <div class="title has-text-centered">
                    <h1 class="is-size-1">Authors by their ranks</h1>
                    <hr>
                </div>
                <table class="table">
                    <thead>
                    <tr>
                        @foreach($authors['columns'] as $column)
                            <th>{{$column}}</th>
                        @endforeach
                    </tr>
                    </thead>
                    <tfoot>
                    </tfoot>
                    <tbody>
                    @foreach($authors['data'] as $author)
                        <tr>
                            @foreach($author as $field)
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
