@extends('layouts.content')

@section('view')
    <section class="centered-app">
        <div class="container">
            <div class="">
                <div class="title">
                    <h1 class="is-size-3 has-text-centered">Edit Topic</h1>
                </div>
                <form action="/topic/edit/{{$topic['id']}}" method="post">
                    <div class="mdc-text-field">
                        <input type="text" id="name" name="name" value="{{$topic['name']}}"
                               class="mdc-text-field__input" required>
                        <label class="mdc-floating-label" for="name">Name</label>
                        <div class="mdc-line-ripple"></div>
                    </div>
                    <button class="mdc-fab mdc-fab--extended add-btn" type="submit">
                        <span class="material-icons mdc-fab__icon">save</span>
                        <span class="mdc-fab__label">Save</span>
                    </button>
                </form>
            </div>
        </div>
    </section>
@endsection
