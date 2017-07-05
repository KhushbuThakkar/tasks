@extends('layouts.app')

@section('content')
    <div ng-app="fupApp">
    <div id='alertBox'></div>
     <div class="container">
      <div class="">
         <h2>Image editing</h1> 
        
            <div ng-controller="fupController">
                <div class="col-md-12">
                    Select an image file: <input type="file" id="fileInput" ng-files="getTheFiles($files)"/>
                </div>
                <div class="cropArea col-md-6" style="background: #E4E4E4;overflow: hidden;width:500px;height:350px;">
        	    	<img-crop image="myImage" result-image="myCroppedImage"></img-crop>
        	  	</div>
        	  	<div class="col-md-6">
                    Cropped Image:
            	  	<img ng-src="<%myCroppedImage%>" />
                </div>
                <div class="col-md-12">
                    <input type="button" ng-click="uploadFiles()" value="Upload" />
                </div>

            </div>
     </div>
 </div>
</div>

<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/ng-img-crop/0.3.2/ng-img-crop.css">
<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.4.4/angular.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ng-img-crop/0.3.2/ng-img-crop.js"></script>
<script>
    angular.module('fupApp', ['ngImgCrop'],function($interpolateProvider) {
        $interpolateProvider.startSymbol('<%');
        $interpolateProvider.endSymbol('%>');
			}).directive('ngFiles', ['$parse', function ($parse) {
            function fn_link(scope, element, attrs) {
                var onChange = $parse(attrs.ngFiles);
                element.on('change', function (event) {
                    onChange(scope, { $files: event.target.files });
                });
            };
                return {
                link: fn_link
            }
        } ])
        .controller('fupController', function ($scope, $http) {
            var formdata = new FormData();
            $scope.getTheFiles = function ($files) {
            console.log($files);
            $scope.fileName=$files[0].name;

                angular.forEach($files, function (value, key) {
                    formdata.append(key, value);
                    console.log(key + ' ' + value.name);
                });
            };

			//RESIZE and CROP
	        $scope.myImage='';
	        $scope.myCroppedImage='';

	        var handleFileSelect=function(evt) {
	          var file=evt.currentTarget.files[0];
	          var reader = new FileReader();
	          reader.onload = function (evt) {
	            $scope.$apply(function($scope){
	              $scope.myImage=evt.target.result;
	              
	            });
	          };
	          reader.readAsDataURL(file);
	        };
	        angular.element(document.querySelector('#fileInput')).on('change',handleFileSelect);

	        

            // NOW UPLOAD THE FILES.
            $scope.uploadFiles = function () {
            	console.log($scope.myCroppedImage);
	            formdata.append('image',dataURItoBlob($scope.myCroppedImage));
	            formdata.append('ext',$scope.fileName.split('.').pop());
	            console.log('uploading files',dataURItoBlob($scope.myCroppedImage));
                var request = {
                    method: 'POST',
                    url: '/api/upload/',
                    data: formdata,
                    headers: {
                        'Content-Type': undefined
                    }
                };

                // SEND THE FILES.
                $http(request)
                    .success(function (response) {
                        console.log(response.message);
                        var myEl = angular.element( document.querySelector( '#alertBox' ) );
                        myEl.append(`<div class="alert alert-success">
                          <strong>Success!</strong> `+response.message+`
                        </div>`);     
                        
                    })
                    .error(function ( response ) {
                        console.log(response.message);
                        var myEl = angular.element( document.querySelector( '#alertBox' ) );
                        myEl.append(`<div class="alert alert-danger">
                          <strong>Success!</strong> `+response.message+`
                        </div>`);    
                    });
            }


			function dataURItoBlob(dataURI) {
				    // convert base64/URLEncoded data component to raw binary data held in a string
				    var byteString;
				    if (dataURI.split(',')[0].indexOf('base64') >= 0)
				        byteString = atob(dataURI.split(',')[1]);
				    else
				        byteString = unescape(dataURI.split(',')[1]);

				    // separate out the mime component
				    var mimeString = dataURI.split(',')[0].split(':')[1].split(';')[0];

				    // write the bytes of the string to a typed array
				    var ia = new Uint8Array(byteString.length);
				    for (var i = 0; i < byteString.length; i++) {
				        ia[i] = byteString.charCodeAt(i);
				    }
				    console.log(mimeString,'mimeString');
				    return new Blob([ia], {type:mimeString});
		}
        });
</script>
@endsection