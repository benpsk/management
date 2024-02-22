@extends('layouts.app')
@section('content')
<div class="container mb-5">
    <h4 class="my-3">Employee Form</h4>
    <form hx-post="{{ route('employee.store')}}" enctype="multipart/form-data" hx-target="#app" hx-swap="outerHTML" hx-push-url="true">
        @csrf
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
            <label for="first_name" class="form-label">First Name</label>
            <input type="text" name="first_name" class="form-control" id="first_name" aria-describedby="emailHelp" placeholder="eg. John" onkeyup="this.setCustomValidity('')" hx-on:htmx:validation:validate="if(this.value == '') { this.setCustomValidity('Please enter the first name'); }">
        </div>

        <div class="mb-3">
            <label for="last_name" class="form-label">Last Name</label>
            <input type="text" name="last_name" class="form-control" id="last_name" aria-describedby="emailHelp" placeholder="eg. Doe" onkeyup="this.setCustomValidity('')" hx-on:htmx:validation:validate="if(this.value == '') { this.setCustomValidity('Please enter the last name'); }">
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" name="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="eg. example@example.com" onkeyup="this.setCustomValidity('')" hx-on:htmx:validation:validate="if(this.value == '') { this.setCustomValidity('Please enter the email addres'); }">
        </div>

        <div class="mb-3">
            <label for="company" class="form-label">Company</label>
            <select name="company_id" id="company" class="form-control">
                @foreach($companies as $company)
                <option value="{{ $company->id }}"> {{ $company->name}} </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="department" class="form-label">Department</label>
            <input type="text" name="department" class="form-control" id="department" aria-describedby="emailHelp" placeholder="eg. Science">
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="number" name="phone" class="form-control" id="phone" aria-describedby="emailHelp" placeholder="eg. 09123456789">
        </div>

        <div class="mb-3">
            <label for="staff_id" class="form-label">Staff Id</label>
            <input type="text" name="staff_id" class="form-control" id="staff_id" aria-describedby="emailHelp" placeholder="eg. John">
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <input type="text" name="address" class="form-control" id="address" aria-describedby="emailHelp" placeholder="eg. example@example.com">
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
        <button type="reset" class="btn btn-danger">Reset</button>
        <button hx-get="{{ route('employee.index')}}" hx-trigger="click" hx-swap="outerHTML" hx-target="#app" hx-push-url="true" class="btn btn-secondary">
            Back
        </button>
    </form>

</div>
@endsection
