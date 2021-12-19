@extends('layouts.app')

@section('content')
<div class="container my-3">

    <h4 class="my-3">Update Employee</h4>


    <form action="{{ route('employee.update',  $employee->id )}}" method="POST">
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
            <label for="first_name" class="form-label">First Name</label>
            <input type="text" name="first_name" class="form-control" id="first_name" value="{{$employee->first_name}}" aria-describedby="emailHelp" placeholder="eg. John">
        </div>

        <div class="mb-3">
          <label for="last_name" class="form-label">Last Name</label>
          <input type="text" name="last_name" class="form-control" id="last_name" value="{{$employee->last_name}}" aria-describedby="emailHelp" placeholder="eg. Doe">
        </div>

        <div class="mb-3">
          <label for="email" class="form-label">Email Address</label>
          <input type="email" name="email" class="form-control" id="email" value="{{$employee->email}}" aria-describedby="emailHelp" placeholder="eg. example@example.com">
        </div>

        <div class="mb-3">
          <label for="company" class="form-label">Company</label>
          {{$employee->company_id}}
          <select name="company_id" id="company" class="form-control">
            @foreach($companies as $company)
                <option value="{{ $company->id }}"  <?php if($employee->company_id == $company->id) echo "selected";?> > {{ $company->name}} </option>
            @endforeach
          </select>
        </div>

        <div class="mb-3">
          <label for="department" class="form-label">Department</label>
          <input type="text" name="department" class="form-control" id="department" value="{{$employee->department}}" aria-describedby="emailHelp" placeholder="eg. Science">
        </div>

        <div class="mb-3">
          <label for="phone" class="form-label">Phone</label>
          <input type="number" name="phone" class="form-control" id="phone" value="{{$employee->phone}}" aria-describedby="emailHelp" placeholder="eg. 09123456789">
      </div>

        <div class="mb-3">
          <label for="staff_id" class="form-label">Staff Id</label>
          <input type="text" name="staff_id" class="form-control" id="staff_id" value="{{$employee->staff_id}}" aria-describedby="emailHelp" placeholder="eg. John">
      </div>
        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <input type="text" name="address" class="form-control" id="address" value="{{$employee->address}}" aria-describedby="emailHelp" placeholder="eg. example@example.com">
        </div>
  
        
        <button type="submit" class="btn btn-primary">Submit</button>
        <a type="button" class="btn btn-danger" href="{{ route('employee.index') }}">back</a>

      </form>
        
</div>
@endsection
