@extends('layouts.content')

@section('view')
    <section class="centered-app">
        <div class="container">
            <div>
                <div class="title">
                    <h1 class="is-size-1">Paper</h1>
                </div>
                <table class="table">
                    <tbody>
                    @foreach($paper as $key => $value)
                        <tr>
                            <td>{{$key}}</td>
                            <td>{{$value}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </section>
@endsection
