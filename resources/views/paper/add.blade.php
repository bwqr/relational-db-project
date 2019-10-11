@extends('layouts.content')

@section('view')
    <section class="centered-app">
        <div class="container">
            <div class="">
                <div class="title">
                    <h1 class="is-size-3 has-text-centered">Create Paper</h1>
                </div>
                <form action="/paper/add" method="post" id="paper-post">
                    <div class="mdc-text-field">
                        <input type="text" id="title" name="title" class="mdc-text-field__input" required>
                        <label class="mdc-floating-label" for="title">Title</label>
                        <div class="mdc-line-ripple"></div>
                    </div>
                    <div class="mdc-text-field">
                        <input type="number" id="result" name="result" class="mdc-text-field__input" required>
                        <label class="mdc-floating-label" for="result">Result</label>
                        <div class="mdc-line-ripple"></div>
                    </div>

                    <div class="subtitle">
                        <hr>
                        <h3 class="is-size-5">Authors</h3>
                    </div>
                    @foreach($authors as $author)
                        <div class="level">
                            <div class="mdc-form-field">
                                <div class="mdc-checkbox">
                                    <input type="checkbox"
                                           class="mdc-checkbox__native-control"
                                           id="author-{{$author['id']}}" name="author_{{$author['id']}}"/>
                                    <div class="mdc-checkbox__background">
                                        <svg class="mdc-checkbox__checkmark"
                                             viewBox="0 0 24 24">
                                            <path class="mdc-checkbox__checkmark-path"
                                                  fill="none"
                                                  d="M1.73,12.91 8.1,19.28 22.79,4.59"/>
                                        </svg>
                                        <div class="mdc-checkbox__mixedmark"></div>
                                    </div>
                                </div>
                                <label for="author-{{$author['id']}}">{{$author['name']}} {{$author['surname']}}</label>
                            </div>
                        </div>
                    @endforeach

                    <div class="subtitle">
                        <hr>
                        <h3 class="is-size-5">Topics</h3>
                    </div>
                    @foreach($topics as $topic)
                        <div class="level">
                            <div class="mdc-form-field">
                                <div class="mdc-checkbox">
                                    <input type="checkbox"
                                           class="mdc-checkbox__native-control"
                                           id="topic-{{$topic['id']}}" name="topic_{{$topic['id']}}"/>
                                    <div class="mdc-checkbox__background">
                                        <svg class="mdc-checkbox__checkmark"
                                             viewBox="0 0 24 24">
                                            <path class="mdc-checkbox__checkmark-path"
                                                  fill="none"
                                                  d="M1.73,12.91 8.1,19.28 22.79,4.59"/>
                                        </svg>
                                        <div class="mdc-checkbox__mixedmark"></div>
                                    </div>
                                </div>
                                <label for="topic-{{$topic['id']}}">{{$topic['name']}}</label>
                            </div>
                        </div>
                    @endforeach
                    <hr>
                    <div class="mdc-text-field mdc-text-field--textarea">
                        <textarea id="textarea" class="mdc-text-field__input" rows="8" cols="40" name="abstract"
                                  required></textarea>
                        <div class="mdc-notched-outline">
                            <div class="mdc-notched-outline__leading"></div>
                            <div class="mdc-notched-outline__notch">
                                <label for="textarea" class="mdc-floating-label">Abstract</label>
                            </div>
                            <div class="mdc-notched-outline__trailing"></div>
                        </div>
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

@section('scripts')
    <script>
    </script>
@endsection
