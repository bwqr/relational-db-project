@extends('layouts.content')

@section('view')
    <section class="centered-app">
        <div class="container">
            <div>
                <div class="title has-text-centered">
                    <h1 class="is-size-1">Papers</h1>
                    <hr>
                </div>
                <div>
                    <div class="level">
                        <form action="/paper/search" method="get">
                            <div class="level-item">
                                <div class="level-left">
                                    <div class="mdc-text-field">
                                        <input type="text" id="my-text-field" class="mdc-text-field__input" name="keyword">
                                        <label class="mdc-floating-label" for="my-text-field">Search by keyword</label>
                                        <div class="mdc-line-ripple"></div>
                                    </div>
                                </div>
                                <div class="level-right">
                                    <button class="mdc-icon-button material-icons">search</button>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
                <table class="table">
                    <thead>
                    <tr>
                        @foreach($papers['columns'] as $column)
                            <th>{{$column}}</th>
                        @endforeach
                        <th></th>
                    </tr>
                    </thead>
                    <tfoot>
                    </tfoot>
                    <tbody>
                    @foreach($papers['data'] as $paper)
                        <tr>
                            @foreach($paper as $field)
                                <td><a href="/paper/paper/{{$paper['id']}}">{{$field}}</a></td>
                            @endforeach
                            <td v-if="role == 'admin'">
                                <a href="/paper/edit/{{$paper['id']}}">
                                    <button class="mdc-button">
                                        <span class="mdc-button__label">Edit</span>
                                    </button>
                                </a>
                            </td>
                            <td v-if="role == 'admin'">
                                <a href="/paper/delete/{{$paper['id']}}">
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

        <a href="/paper/add" v-if="role == 'admin'">
            <button class="mdc-fab mdc-fab--extended add-btn">
                <span class="material-icons mdc-fab__icon">add</span>
                <span class="mdc-fab__label">Create</span>
            </button>
        </a>
    </section>
@endsection
