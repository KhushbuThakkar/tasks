<!DOCTYPE html>
<html>
<head>
  <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.4.4/angular.min.js"></script>
</head>
    <body ng-app="fupApp">
    <div ng-controller="fupController">
    	<input type="text" name="t1"></input>
        <input type="file" id="file1" name="file" multiple
            ng-files="getTheFiles($files)" />
        <input type="button" ng-click="uploadFiles()" value="Upload" />
    </div>
</body>
<script>
    angular.module('fupApp', [])
        .directive('ngFiles', ['$parse', function ($parse) {
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
            console.log($files[0].type);

                angular.forEach($files, function (value, key) {
                    formdata.append(key, value);
                    console.log(key + ' ' + value.name);
                });
            };

            // NOW UPLOAD THE FILES.
            $scope.uploadFiles = function () {
            console.log('uploading files');
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
                    .success(function (d) {
                        alert(d);
                    })
                    .error(function () {
                    });
            }
        });
</script>
</html>