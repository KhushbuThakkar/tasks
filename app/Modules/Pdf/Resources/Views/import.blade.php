@extends('layouts.app')

@section('content')
      
      
  <div class="container">
  <div class="jumbotron">
    <h1>PDF importer</h1>
    <?php
         echo Form::open(array('url' => '/pdf/upload','files'=>'true'));
		         
		         echo Form::file('pdf');
		         echo Form::submit('Upload File');
		         echo Form::close();
      ?>
  </div>
  
</div>
 
@endsection