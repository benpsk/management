@extends('layouts.app')
@section('content')
<div id="listing" class="container my-3">
    @if (Auth::user()->can('gate'))
    <a hx-get="{{ route('employee.create')}}" hx-trigger="click" hx-swap="outerHTML" hx-target="#app" hx-push-url="true" class="btn btn-sm btn-primary mb-4" role="button">Add Employee</a>
    @endif
    <div class="row mb-3">
        <div class="col">
            <input type="search" class="form-control border-top-0 border-left-0 border-right-0 border-bottom-3 rounded-0 search mb-3 shadow-none" id="search" name="search" placeholder="Search..." value="{{ $search ?? '' }}" hx-post="{{ route('emp-search')}}" hx-swap="outerHTML" hx-target="#app" hx-vals='{"_token": "{{ csrf_token() }}" }' hx-trigger="input changed delay:500ms, search" />
        </div>
        <div class="col-2 col-sm-3 col-md-2">
            @if (Auth::user()->can("gate"))
            <button class="btn btn-secondary" id="export" style="border-radius: 8px;" type="button" hx-post="{{ route('emp-download')}}" hx-swap="none" hx-vals='js:{"_token": "{{ csrf_token() }}", "search": document.querySelector("#search").value }' hx-trigger="click">
                export
            </button>
            @endif
        </div>
    </div>



    <div class="table-responsive">
        <table class="table table-striped " width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>Staff_id</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Company</th>
                    <th>Department</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody hx-target="closest tr" hx-swap="outerHTML swap:1s">
                @if(count($employees) <= 0) <tr>
                    <td colspan="8" class="text-center text-success">
                        No Data Available!
                    </td>
                    </tr>
                    @endif
                    @foreach ($employees as $employee)
                    <tr>
                        <td>{{ $employee->staff_id }}</td>
                        <td>{{ $employee->first_name . ' ' . $employee->last_name }}</td>
                        <td>{{ $employee->email}}</td>
                        <td>{{ $employee->company->name}}</td>
                        <td>{{ $employee->department}}</td>
                        <td>{{ $employee->phone}}</td>
                        <td>{{ $employee->address}}</td>
                        <td>
                            <a hx-get="{{ route('employee.show',  $employee->id )}}" hx-swap="outerHTML" hx-target="#app" hx-push-url="true" class="btn btn-sm btn-success" role="button">
                                view
                            </a>
                            @if (Auth::user()->can('gate'))
                            <a hx-get="{{ route('employee.edit',  $employee->id )}}" hx-swap="outerHTML" hx-target="#app" hx-push-url="true" class="btn btn-sm btn-info" role="button">
                                update
                            </a>
                            <a hx-delete="{{ route('employee.destroy', $employee->id)}}" hx-vals='js:{"_token": "{{ csrf_token() }}", "_method": "DELETE"}' class="btn btn-sm btn-danger" role="button">
                                delete
                            </a>
                            @endif

                        </td>
                    </tr>
                    @endforeach
            </tbody>
        </table>
    </div>
    {{ $employees->links() }}
</div>
<script>
    document.addEventListener('htmx:afterRequest', function(event) {
        console.log(event);
        // Check if the response content type is JSON
        const contentType = event.detail.xhr.getResponseHeader('Content-Type');
        if (contentType && contentType.includes('application/json')) {
            // Parse the response JSON
            const response = JSON.parse(event.detail.xhr.response);
            console.log(response.file);
            if (response.file) {
                console.log('file exists');
                window.open(response.file, '_blank');
            }
        }
    });
</script>
@endsection


