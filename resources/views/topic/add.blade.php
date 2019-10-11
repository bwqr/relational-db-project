@extends('layouts.content')

@section('view')
    <section class="centered-app">
        <div class="container">
            <div class="">
                <div class="title">
                    <h1 class="is-size-3 has-text-centered">Create Topic</h1>
                </div>
                <form action="/topic/add" method="post">
                    <div class="mdc-text-field">
                        <input type="text" id="name" name="name" class="mdc-text-field__input" required autofocus>
                        <label class="mdc-floating-label" for="name">Name</label>
                        <div class="mdc-line-ripple"></div>
                    </div>
                    <button class="mdc-fab mdc-fab--extended add-btn" type="submit">
                        <span class="material-icons mdc-fab__icon">add</span>
                        <span class="mdc-fab__label">Create</span>
                    </button>
                </form>
            </div>
        </div>
    </section>
@endsection
