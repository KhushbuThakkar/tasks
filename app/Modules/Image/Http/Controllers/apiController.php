<?php

namespace App\Modules\Image\Http\Controllers;

//use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use App\Http\Controllers\Controller;
//use Input;
use Validator;
use Redirect;
use Request;
use Response;
use Session;

class apiController extends Controller
{
    public function upload() {
  // getting all of the post data
		  $files= Input::all();
		  //dd($files);
		  $file=$files['image'];
		  $file = array('image' => $files['image']);
		  // setting up rules
		  $rules = array('image' => 'required',); //mimes:jpeg,bmp,png and for max size max:10000
		  // doing the validation, passing post data, rules and the messages
		  $validator = Validator::make($file, $rules);
		  if ($validator->fails()) {
		    // send back to the page with the input data and errors
		    //return Redirect::to('upload')->withInput()->withErrors($validator);
		    echo 'strange';
	      	return Response::json(array('message' => 'Not an image.', 'success' => '0'));

		  }
		  else {
		    // checking file is valid.
		    if (Input::all()['image']->isValid()) {
		      $destinationPath = 'uploads'; // upload path
		      $extension = Input::all()['ext'];// getting image extension
		      //$extension = Input::all()[0]->getmimeType(); // getting image extension
		      $extension='jpg';
		      $fileName = rand(11111,99999).'.'.$extension; // renameing image
		      Input::all()['image']->move($destinationPath, $fileName); // uploading file to given path
		      return Response::json(array('message' => 'uploaded successfully', 'success' => '1'));
		    }
		    else {
		      // sending back with error message.
  		      return Response::json(array('message' => 'Not Valid', 'success' => '0'));


		    }
		  }
	}
}


