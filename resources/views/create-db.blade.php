@extends('layouts.app')
@section('styles')
    <style>
    </style>
@endsection

@section('header')
    <section id="install-db" class="section centered-app">
        <div class="container">
            <div class="">
                <div class="title has-text-centered">
                    <h1 class="is-size-1">Install Database</h1>
                </div>
                <div class="columns action">
                    <form method="post" action="/install">
                        <div class="level">
                            <div class="mdc-text-field">
                                <input type="text" id="user" name="user" class="mdc-text-field__input" required>
                                <label class="mdc-floating-label" for=user">User</label>
                                <div class="mdc-line-ripple"></div>
                            </div>
                        </div>
                        <div class="level">
                            <div class="mdc-text-field">
                                <input type="password" id="pass" name="pass" class="mdc-text-field__input" required>
                                <label class="mdc-floating-label" for="pass">Paswword</label>
                                <div class="mdc-line-ripple"></div>
                            </div>
                        </div>

                        <button class="mdc-button mdc-button--raised" type="submit">INSTALL</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
