@extends('layouts.master')

@section('title')
    Create Article
@endsection

@section('content')
    <h2>{{ $title }}</h2>
    @if($auth)
        <h1>Logged in</h1>
    @endif
    <form action="/articles/create?id=12" method="post">
        <input type="text" name="title" placeholder="Title">
        <input type="submit" value="Create">
    </form>
@endsection