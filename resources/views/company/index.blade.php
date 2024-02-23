@extends('layouts.app')
@section('content')
<div id="listing" class="container my-3">
    @if (Auth::user()->can("gate"))
    <a class="btn btn-sm btn-primary mb-4" role="button" hx-get="{{ route('company.create')}}" hx-trigger="click" hx-target="#app" hx-swap="outerHTML" hx-push-url="true">Add Company</a>
    @endif
    <div class="row mb-3">
        <div class="col">
            <input type="search" class="form-control border-top-0 border-left-0 border-right-0 border-bottom-3 rounded-0 search mb-3 shadow-none" id="search" name="search" placeholder="Search..." value="{{ $search ?? '' }}" hx-post="{{ route('com-search')}}" hx-swap="outerHTML" hx-target="#app" hx-vals='{"_token": "{{ csrf_token() }}" }' hx-trigger="input changed delay:500ms, search" />
        </div>
        <div class="col-2 col-sm-3 col-md-2">
            @if (Auth::user()->can("gate"))
            <button class="btn btn-secondary" id="export" style="border-radius: 8px;" type="button" hx-post="{{ route('com-download')}}" hx-swap="none" hx-vals='js:{"_token": "{{ csrf_token() }}", "search": document.querySelector("#search").value }' hx-trigger="click">
                export
            </button>
            @endif
        </div>
    </div>

    <div class="table-responsive">
        <table cellspacing="0" class="table-striped table" width="100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody hx-target="closest tr" hx-swap="outerHTML swap:1s">

                @if (count($companies) <= 0) <tr>
                    <td class="text-success text-center" colspan="8">
                        No Data Available!
                    </td>
                    </tr>
                    @endif
                    @foreach ($companies as $company)
                    <tr>
                        <td>{{ $loop->iteration }}</td>

                        <td>{{ $company->name }}</td>
                        <td>{{ $company->email }}</td>
                        <td>{{ $company->address }}</td>
                        <td>
                            <a class="btn btn-sm btn-success" hx-get="{{ route("company.show", $company->id) }}" hx-swap="outerHTML" hx-target="#app" hx-push-url="true" role="button">
                                view
                            </a>
                            @if (Auth::user()->can("gate"))
                            <a class="btn btn-sm btn-info" hx-get="{{ route("company.edit", $company->id) }}" hx-swap="outerHTML" hx-target="#app" hx-trigger="click" hx-push-url="true">
                                update
                            </a>
                            <form hx-confirm="Are you sure?" hx-post="{{ route("company.destroy", $company->id) }}">
                                @csrf
                                @method("DELETE")
                                <button type="submit" class="btn btn-sm btn-danger" role="button">
                                    delete
                                </button>
                            </form>
                            @endif
                        </td>

                    </tr>
                    @endforeach
            </tbody>
        </table>
    </div>
    {{ $companies->links() }}
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
