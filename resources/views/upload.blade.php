@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
                @include('sidebar')
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header">PASTA</div>

                <div class="card-body">
			@foreach ( $errors->all() as $error )
				<li>$error</li>
			@endforeach
                    @if ($errors->any())
                        <div class="alert alert-danger" role="alert">
                            Pasta BODY required
                        </div>
                    @endif
		<form method="post" action="/pasta">
			@csrf
			<div class="form-group">
				<textarea name="body" class="col-md-12" rows=16></textarea>
			</div>
			<button type="submit" class="btn btn-primary-outline">Add</button>
			<select name="timer">
				<option value="0" selected>Unlimited</option>
				@foreach ($timers as $tr)
					<option value="{{ $tr->value }}">{{ $tr->name }}</option>
				@endforeach
			</select>
			<select name="ling">
				<option value="0" selected>Text</option>
				@foreach ($langs as $lg)
					<option value="{{ $lg->id }}">{{ $lg->name }}</option>
				@endforeach
			</select>
			<input type="checkbox" name="is_listed" checked>Listed
			@auth 
				<input type="checkbox" name="is_private">Private
			@endauth
		</form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
