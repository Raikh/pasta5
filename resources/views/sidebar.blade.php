    <div class="card">
        <div class="card-header">Public</div>
        <div class="card-body">
	<ol>
            @foreach ($pastas as $pasta)
                <li><a href="{{ route('pasta.show',['pastum'=>$pasta->hash]) }}">{{ $pasta->hash }} :: {{ $pasta->created_at }}</a></li>
            @endforeach
	</ol>
        </div>

    </div>

    @auth
    <div class="card">
        <div class="card-header">Private</div>

        <div class="card-body">

            @foreach ($pastas_priv as $pasta)
                <a href="{{ route('pasta.show',['pastum'=>$pasta->hash]) }}">{{ $pasta->hash }}</a><br>
            @endforeach

        </div>
	{{ $pastas_priv->links() }}
    </div>
    @endauth
