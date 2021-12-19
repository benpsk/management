@extends('layouts.app')

@section('content')
<div class="container my-3">

    <h4 class="my-3">Employee Detail</h4>

    <div class="card">
        <div class="card-body">

            @if($employee == null)
                <div class="row">
                    <div class="col text-center text-success">
                        No Data FOund!
                    </div>
                </div>
            @else
            <div class="row">
                <div class="col">
                    <p>Staff Id</p>
                </div>
                <div class="col">
                    <p>{{ $employee->staff_id }}</p>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <p>Full Name</p>
                </div>
                <div class="col">
                    <p>{{ $employee->first_name . ' '. $employee->last_name }}</p>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <p>Company Name</p>
                </div>
                <div class="col">
                    <p>{{ $employee->company->name }}</p>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <p>Email</p>
                </div>
                <div class="col">
                    <p>{{ $employee->email }}</p>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <p>Department</p>
                </div>
                <div class="col">
                    <p>{{ $employee->department }}</p>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <p>Phone</p>
                </div>
                <div class="col">
                    <p>{{ $employee->phone }}</p>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <p>Address</p>
                </div>
                <div class="col">
                    <p>{{ $employee->address }}</p>
                </div>
            </div>
            @endif
        </div>
    </div>
   
    <a href="{{ route('employee.index') }}" type="button" class="btn btn-primary mt-3">Back</a>

        
</div>
@endsection
