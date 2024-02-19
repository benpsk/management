@extends('layouts.app')
@section('content')
<div hx-get="{{ route("company.index") }}"
    hx-trigger="load"
    hx-swap="outerHTML"
>
</div>
@endsection
