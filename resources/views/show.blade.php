@extends('layouts.app')

@section('addons')
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.15.10/styles/default.min.css">
	<script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.15.10/highlight.min.js"></script>
	<script>hljs.initHighlightingOnLoad();</script>
@endsection

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
			@isset($result[0]->body)
				<pre style="overflow:auto; white-space: pre-wrap">
				<code 
				@isset($lang)
				     class="{{ $lang }}"
				@endisset
				>{{ $result[0]->body }}</code>
				</pre>
				
			@else
				ACCESS DENIED
			@endisset
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
