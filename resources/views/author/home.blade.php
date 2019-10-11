@extends('layouts.content')

@section('view')
    <section class="centered-app">
        <div class="container">
            <div>
                <div class="title has-text-centered">
                    <h1 class="is-size-1">Authors</h1>
                    <hr>
                </div>
                <div class="subtitle">
                    <a href="/author/ranks">
                        <button class="mdc-fab mdc-fab--extended">
                            <span class="material-icons mdc-fab__icon">star</span>
                            <span class="mdc-fab__label">Ranks</span>
                        </button>
                    </a>
                </div>
                <table class="table">
                    <thead>
                    <tr>
                        @foreach($authors['columns'] as $column)
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
                    @foreach($authors['data'] as $author)
                        <tr>
                            @foreach($author as $field)
                                <td><a href="/author/author/{{$author['id']}}">{{$field}}</a></td>
                            @endforeach
                            <td>
                                <a href="/author/co-authors/{{$author['id']}}">
                                    <button class="mdc-button">
                                        <span class="mdc-button__label">Co-Authors</span>
                                    </button>
                                </a>
                            </td>
                            <td>
                                <a href="/author/papers/{{$author['id']}}">
                                    <button class="mdc-button">
                                        <span class="mdc-button__label">Papers</span>
                                    </button>
                                </a>
                            </td>
                            <td v-if="role == 'admin'">
                                <a href="/author/edit/{{$author['id']}}">
                                    <button class="mdc-button">
                                        <span class="mdc-button__label">Edit</span>
                                    </button>
                                </a>
                            </td>
                            <td v-if="role == 'admin'">
                                <a href="/author/delete/{{$author['id']}}">
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

        <a href="/author/add" v-if="role == 'admin'">
            <button class="mdc-fab mdc-fab--extended add-btn">
                <span class="material-icons mdc-fab__icon">add</span>
                <span class="mdc-fab__label">Create</span>
            </button>
        </a>
    </section>
@endsection
