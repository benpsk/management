@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            {{-- {{ $auth_url }} --}}

            <div class="progress " role="progressbar" aria-label="Success striped example" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                <div class="progress-bar progress-bar-striped bg-success progress-bar-animated bar" ></div>
            </div>
            <a href="{{ $auth_url }}" id="drive">Click Link</a>

                <a href="{{ route('google-drive.download')}}">Download</a>



        </div>
    </div>
</div>
@endsection


@section('script-after')

<script>

    $(function() {


        

        // $(".bar").css("width", "100%");


        let url =  "{{ $auth_url }}"

        if (!url) {

            // let percentage = 0;
            // setInterval(() => {
            //     percentage += 10;
            //     $(".bar").css("width", percentage + "%");
            //     if (percentage == 100) percentage = 0;
            // }, 500);

            fileName = 'default';
            axios.get(`{{ route("google-drive.getFileName")}}`)
            .then(function(response) {
                console.log(response);
                fileName = response.data;
            }).catch(function (error) {
                    console.log(error);
                });

            axios({
                url: `{{ route("google-drive.download") }}`,
                method: 'GET',
                responseType: 'blob', // important
                })
           
                .then(function (response) {
                    console.log(response);

                    const url = window.URL.createObjectURL(new Blob([response.data]));
                    const link = document.createElement('a');
                    link.href = url;
                    link.setAttribute('download', fileName);
                    document.body.appendChild(link);
                    link.click();

                    $(".bar").css("width", "100%")
                    return response.data;

                })
                .catch(function (error) {
                    console.log(error);
                });

        }


    });
</script>

@endsection