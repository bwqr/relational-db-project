@extends('layouts.content')

@section('view')
    <section class="centered-app">
        <div class="container">
            <div>
                <div class="title has-text-centered">
                    <h1 class="is-size-1">Topics</h1>
                    <hr>
                </div>
                <table class="table">
                    <thead>
                    <tr>
                        @foreach($topics['columns'] as $column)
                            <th>{{$column}}</th>
                        @endforeach
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tfoot>
                    </tfoot>
                    <tbody>
                    @foreach($topics['data'] as $topic)
                        <tr>
                            @foreach($topic as $field)
                                <td><a href="/topic/topic/{{$topic['id']}}">{{$field}}</a></td>
                            @endforeach
                            <td>
                                <a href="/topic/papers/{{$topic['id']}}">
                                    <button class="mdc-button">
                                        <span class="mdc-button__label">Papers</span>
                                    </button>
                                </a>
                            </td>
                            <td>
                                <a href="/topic/sota/{{$topic['id']}}">
                                    <button class="mdc-button">
                                        <span class="mdc-button__label">Sota</span>
                                    </button>
                                </a>
                            </td>
                            <td v-if="role == 'admin'">
                                <a href="/topic/edit/{{$topic['id']}}">
                                    <button class="mdc-button">
                                        <span class="mdc-button__label">Edit</span>
                                    </button>
                                </a>
                            </td>
                            <td v-if="role == 'admin'">
                                <a href="/topic/delete/{{$topic['id']}}">
                                    <button class="mdc-button">
                                        <span class="mdc-button__label is-danger">Delete</span>
                                    </button>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <a href="/topic/add" v-if="role == 'admin'">
            <button class="mdc-fab mdc-fab--extended add-btn">
                <span class="material-icons mdc-fab__icon">add</span>
                <span class="mdc-fab__label">Create</span>
            </button>
        </a>
    </section>
@endsection
