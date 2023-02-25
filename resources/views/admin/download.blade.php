@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            {{-- {{
                $driveService->files->get("1MWVrUOfTqZGYSc1oUjlMIWxROjzFk4uk");

            }} --}}
        
            {{-- @dd($driveService); --}}

                @php 
                    $fileId = '1MWVrUOfTqZGYSc1oUjlMIWxROjzFk4uk';

                    $file = $driveService->files->get($fileId);
                    echo $file->name;

                    $response = $driveService->files->get($fileId, array(
                            'alt' => 'media'
                        ));

                    $content = $response->getBody()->getContents();


                    echo $content;
                    
                @endphp


        </div>
    </div>
</div>
@endsection


@section('script-after')

<script>

    $(function() {

    });
</script>

@endsection