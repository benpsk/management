@extends('layouts.app')

@section('content')
<div class="container my-3">

    @if (Auth::user()->can('gate'))

        <a href="{{ route('company.create')}}" class="btn btn-sm btn-primary mb-4" role="button">Add Company</a>
    @endif
    

    <form id="searchForm" method="POST">
        @csrf
        <div class="row mb-3">

            <div class="col">
                <input type="text" name="search" id="search" value="<?php echo isset($_POST['search']) ? $_POST['search'] : '' ?>" class="form-control border-top-0 border-left-0 border-right-0 border-bottom-3 mb-3 shadow-none rounded-0 search"  placeholder="Search..." >
            </div>
            <div class="col-3 col-sm-6 col-md-3">
                <button type="submit" id="btnSearch" class="btn btn-success btn-search"  style="border-radius: 20px;">
                    Search
                </button>
                <button type="button" id="all" class="btn btn-primary" style="border-radius: 20px;">
                    all
                </button>
                @if (Auth::user()->can('gate'))

                <button type="button" id="export" class="btn btn-secondary" style="border-radius: 20px;">
                    export
                </button>
                @endif

            </div>
        </div>
    </form>



    <div class="table-responsive">
        <table class="table table-striped " width="100%" cellspacing="0" >
            <thead>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

                @if(count($companies) <= 0)
                    <tr>
                        <td colspan="8" class="text-center text-success">
                            No Data Available!
                        </td>
                    </tr>
                @endif 
                @foreach ($companies as $company)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        
                        <td>{{ $company->name}}</td>
                        <td>{{ $company->email}}</td>
                        <td>{{ $company->address}}</td>
                        <td>
                            <a href="{{ route('company.show',  $company->id )}}" class="btn btn-sm btn-success" role="button">
                                view
                            </a>
                            @if (Auth::user()->can('gate'))

                                <a href="{{ route('company.edit',  $company->id )}}" class="btn btn-sm btn-info" role="button">
                                    update
                                </a>

                                <a href="{{ route('company.destroy', $company->id)}}" class="btn btn-sm btn-danger" role="button"
                                    onclick="event.preventDefault();
                                                    document.getElementById('com-delete').submit();">
                                    delete
                                </a>
                                <form id="com-delete" action="{{ route('company.destroy', $company->id)}}" method="POST" class="d-none">
                                    @csrf
                                    @method('delete')
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
@endsection

@section('script-after')

<script>

    $(function() {
        $('#all').click(function(e) {
            window.location.href = '/home';
        });

        $('#export').click(function(e) {
            e.preventDefault();
            document.getElementById("searchForm").action =  "{{ route('com-download')}}";
            $('#searchForm').submit();

        })

        $('#btnSearch').click(function(e) {
            e.preventDefault();
            document.getElementById("searchForm").action =  "{{ route('com-search')}}";
            $('#searchForm').submit();
        })


        Echo.channel(`company`)
    .listen('CompanyCreated', (e) => {
        console.log(e);
    });
    console.log('hello');
    });
</script>

@endsection
