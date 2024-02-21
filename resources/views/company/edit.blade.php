@extends('layouts.app')

@section('content')
<div class="container my-3">

    <h4 class="my-3">Update Company</h4>


    <form hx-post="{{ route('company.update',  $company->id )}}" hx-target="#app" hx-swap="outerHTML">
        @csrf
        @method('put')
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="mb-3">
            <label for="cname" class="form-label">Company Name</label>
            <input type="text" name="name" class="form-control" id="cname" aria-describedby="emailHelp" value="{{ $company->name}}" placeholder="eg. ABC Company" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" name="email" class="form-control" id="email" aria-describedby="emailHelp" value="{{ $company->email}}" placeholder="eg. example@example.com" required>
        </div>

        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <input type="text" name="address" class="form-control" id="address" aria-describedby="emailHelp" value="{{ $company->address}}" placeholder="eg. example@example.com">
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
        <a type="button" class="btn btn-danger" hx-get="{{ route('company.index')}}" hx-target="#app" hx-swap="outerHTML" hx-trigger="click" hx-push-url="true">back</a>

    </form>

</div>
@endsection
