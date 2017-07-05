
@extends('layouts.app')

@section('content')
     
    <div class="container">
	  <div class="jumbotron">
	     <h1>PDF Contents</h1> 
	     <div>

	     	{!! nl2br($text) !!}
	     </div>
	 </div>
 </div>
@endsection