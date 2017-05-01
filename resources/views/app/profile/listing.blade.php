<div class="editor-area">
    
        	<p class="title">{{ $title }}</p>
       
	
		<ul>
			@foreach( $data as $values )
				<li>{{ $values->name }}</li>
			@endforeach
		</ul>
	</div>
