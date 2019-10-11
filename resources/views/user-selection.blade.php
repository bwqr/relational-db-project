@extends('layouts.app')

@section('header')
    <section id="install-db" class="section centered-app">
        <div class="container">
            <div class="">
                <div class="title has-text-centered">
                    <h1 class="is-size-1">Select User Role</h1>
                </div>
                <div class="columns action">
                    <form v-on:submit="setRole" method="post" action="/user-selection">

                        <div class="mdc-select">
                            <i class="mdc-select__dropdown-icon"></i>
                            <select class="mdc-select__native-control" name="role" required v-model="role">
                                <option value="" disabled selected></option>
                                <option value="admin">
                                    Admin
                                </option>
                                <option value="user">
                                    User
                                </option>
                            </select>
                            <label class="mdc-floating-label">User Role</label>
                            <div class="mdc-line-ripple"></div>
                        </div>

                        <button class="foo-button mdc-button" type="submit">GO</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
