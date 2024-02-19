<div id="listing" class="container my-3">
	@if (Auth::user()->can("gate"))
		<a class="btn btn-sm btn-primary mb-4" role="button"
				hx-get="/company/create"
				hx-trigger="click"
				hx-target="#listing"
				hx-swap="outerHTML"
		>Add Company</a>
	@endif

	<form id="searchForm" method="POST">
		@csrf
		<div class="row mb-3">

			<div class="col">
				<input
					class="form-control border-top-0 border-left-0 border-right-0 border-bottom-3 rounded-0 search mb-3 shadow-none"
					id="search" name="search" placeholder="Search..." type="text" value="<?php echo isset($_POST["search"]) ? $_POST["search"] : ""; ?>">
			</div>
			<div class="col-3 col-sm-6 col-md-3">
				<button class="btn btn-success btn-search" id="btnSearch" style="border-radius: 20px;" type="submit">
					Search
				</button>
				<button class="btn btn-primary" id="all" style="border-radius: 20px;" type="button">
					all
				</button>
				@if (Auth::user()->can("gate"))
					<button class="btn btn-secondary" id="export" style="border-radius: 20px;" type="button">
						export
					</button>
				@endif

			</div>
		</div>
	</form>



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
			<tbody>

				@if (count($companies) <= 0)
					<tr>
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
							<a class="btn btn-sm btn-success" href="{{ route("company.show", $company->id) }}" role="button">
								view
							</a>
							@if (Auth::user()->can("gate"))
								<a class="btn btn-sm btn-info" href="{{ route("company.edit", $company->id) }}" role="button">
									update
								</a>

								<a class="btn btn-sm btn-danger" href="{{ route("company.destroy", $company->id) }}"
									onclick="event.preventDefault();
												document.getElementById('com-delete').submit();"
									role="button">
									delete
								</a>
								<form action="{{ route("company.destroy", $company->id) }}" class="d-none" id="com-delete" method="POST">
									@csrf
									@method("delete")
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
