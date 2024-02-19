<div class="container">
  <h4 class="my-3">Company Form</h4>
    <form hx-post="{{ route('company.store')}}">
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
            <label for="cname" class="form-label">Company Name</label>
            <input type="text" name="name" class="form-control" id="cname" aria-describedby="emailHelp" placeholder="eg. ABC Company">
          </div>
        <div class="mb-3">
          <label for="email" class="form-label">Email Address</label>
          <input type="email" name="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="eg. example@example.com">
        </div>

        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <input type="text" name="address" class="form-control" id="address" aria-describedby="emailHelp" placeholder="eg. example@example.com">
        </div>
        
        <button type="submit" class="btn btn-primary">Submit</button>
        <button type="reset" class="btn btn-danger">Reset</button>
      </form>
</div>