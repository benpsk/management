<div id="listing" class="container my-3">
    @if (Auth::user()->can('gate'))

        <a href="{{ route('employee.create')}}" class="btn btn-sm btn-primary mb-4" role="button">Add Employee</a>
    @endif

        <form method="POST" id="searchForm">
            @csrf
            <div class="row mb-3">

                <div class="col">
                    <input type="text" name="search" value="<?php echo isset($_POST['search']) ? $_POST['search'] : '' ?>" class="form-control border-top-0 border-left-0 border-right-0 border-bottom-3 mb-3 shadow-none rounded-0 search"  placeholder="Search..." >
                </div>

                <div class="col-3 col-sm-6 col-md-3">
                    <button type="submit" id="btnSearch" class="btn btn-success btn-search"  style="border-radius: 20px;">
                        search
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
            <tbody id="showData">
                @if(count($employees) <= 0)
                    <tr>
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
                        <a href="{{ route('employee.show',  $employee->id )}}" class="btn btn-sm btn-success" role="button">
                            view
                        </a>

                        @if (Auth::user()->can('gate'))
                            <a href="{{ route('employee.edit',  $employee->id )}}" class="btn btn-sm btn-info" role="button">
                                update
                            </a>
                            <a href="{{ route('employee.destroy', $employee->id)}}" class="btn btn-sm btn-danger" role="button"
                                onclick="event.preventDefault();
                                                document.getElementById('emp-delete').submit();">
                                delete
                            </a>
                            <form id="emp-delete" action="{{ route('employee.destroy', $employee->id)}}" method="POST" class="d-none">
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
    {{ $employees->links() }}
</div>
