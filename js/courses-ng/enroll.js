angular.module('Enroll', [])
    .controller('EnrollController', ['$scope', '$filter', '$http', '$httpParamSerializerJQLike',
        function ($scope, $filter, $http, $httpParamSerializerJQLike) {
            $scope.how = ['Google', 'Посоветовали', 'Facebook', 'Другое'];
            $scope.enrollSuccess = false;
            $scope.enrollError = false;
            $scope.showEnrollForm = true;
            $scope.sqlError = false;
            $scope.regexPhone = /\+\d{1,}\(?\d{2,}\)?\d{3}-?\d{2,}/;
            var student = {
                how: $scope.how[0],
                phone: "38"
            };
            $scope.student = angular.copy(student);
            $scope.$on('closeModal', function () {
                $scope.enrollSuccess = false;
                $scope.enrollError = false;
                $scope.showEnrollForm = true;
                $scope.sqlError = false;
            });
            function successCallback(response) {
                ga('send', 'event', 'Регистрация', 'Записаться');
                if (response.data && response.data.sqlError) {
                    $scope.sqlError = true;
                } else {
                    $scope.enrollSuccess = true;
                    $scope.sqlError = false;
                }
                $scope.enrollError = false;
                $scope.showEnrollForm = false;
                console.log(response);
            }

            function errorCallback(response) {
                $scope.enrollSuccess = false;
                $scope.enrollError = true;
                $scope.showEnrollForm = false;
                $scope.sqlError = false;
                console.log(response);
            }

            $scope.postEnroll = function (student, form) {
                form = form || null;
                if (form.$valid) {
                    student.course_id = $scope.enrollSchedule.course_id;
                    student.modifier_id = $scope.enrollSchedule.modifier_id;
                    student.modifier_text = $filter('modifierId')($scope.enrollSchedule.modifier_id);
                    student.hash = student.course_id + "" + student.modifier_id + "" + student.phone;
                    form.$setPristine();
                    form.$setUntouched();

                    $http({
                        method: 'POST',
                        url: '/enroll',
                        data: $httpParamSerializerJQLike(student),
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        }
                    }).then(successCallback, errorCallback);
                }
            };
        }])
    .directive('enrollModal', [function () {
        return {
            restrict: 'E',
            templateUrl: '/ng-views/components/enrollModal.html',
            controller: 'EnrollController',
            link: function (scope, el, arrts) {

            }
        }
    }])