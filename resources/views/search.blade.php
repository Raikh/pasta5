@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
                @include('sidebar')
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
			<form method="post" action="/search">
                        	@csrf
	                        <div class="form-group">
				    <input type="text" name="s_string">
		                    <button type="submit" class="btn btn-primary-outline">Search</button>
				</div>
			</form>
		</div>
		
                <div class="card-body">
			<ol>
			@isset($result)
				@foreach ($result as $res)
				<li>
					<a href="{{ route('pasta.show',['pastum'=>$res->hash]) }}">{{ $res->hash }}</a>
				</li>
				@endforeach
			@endisset
			</ol>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
