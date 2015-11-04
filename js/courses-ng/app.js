/**
 * Created by lenka on 9/30/15.
 */
angular.module('Courses', ['ngSanitize', 'ngResource', 'ngRoute', 'Utils', 'Calendar', 'Clock', 'Timeline', 'Enroll'])
    .config(['$routeProvider', '$locationProvider', function ($routeProvider, $locationProvider) {

        $routeProvider

            // route for the home page
            .when('/', {
                templateUrl: function () {
                    return '/ng-views' + location.pathname + 'index.html';
                },
                controller: 'MainCoursesController'
            })
            .when('/:alias', {
                templateUrl: '/ng-views/courses/course.html',
                controller: 'CourseController'
            })
            .otherwise({
                redirectTo: '/'
            });
        $locationProvider.html5Mode(true);
    }])
    .controller('WebcampCtrl', ['$scope', 'Course', function ($scope, Course) {
        $scope.showModal = false;
        $scope.enroll = function (course) {
            $scope.showModal = true;
        };
        $scope.hideModal = function () {
            $scope.showModal = false;
        };
        $scope.schedules = {};
        $scope.course = {};
        $scope.enrollSchedule = {
            modifier_id: 0,
            course_id: 0,
        };
        console.log($scope);
    }])
    .controller('MainCoursesController', ['$scope', 'Course', function ($scope, Course) {
        $scope.menuitem;
    }])
    .controller('CourseController', ['$scope', '$routeParams', 'Course', 'Schedule', function ($scope, $routeParams, Course, Schedule) {
        $scope.activeSchedule;
        $scope.predicate = 'begin';
        $scope.reverse = false;
        $scope.activateSchedule = function (schedule) {
            $scope.activeSchedule = schedule;
            $scope.activeTab = $scope.activeSchedule.modifier_name;
            $scope.enrollSchedule.modifier_id = $scope.activeSchedule.modifier_id;
            $scope.getDayLesson(0);
            $scope.$broadcast('activateSchedule');
        };
        $scope.dayLesson = {};
        $scope.isActiveTab = function (tab) {
            return tab == $scope.activeTab;
        };
        $scope.getLessonCount = function (schedule) {
            return $scope.course.duration / schedule.durationHours | 0;
        };
        $scope.getDayLesson = function (dayNum) {
            var count = $scope.activeSchedule.durationHours,
                start = count * dayNum;
            angular.extend($scope.dayLesson, {
                day: $scope.activeSchedule.coursedays[dayNum],
                items: $scope.course.lessons.slice(start, start + count),
                num: dayNum + 1
            });
        };
        Course.get({alias: $routeParams.alias}, function (course) {
            //$scope.course = course;
            course.getLessons().then(function () {
                angular.extend($scope.course, course);
            Schedule.schedule({id: course.id}, function (schedules) {
                if (schedules) {
                    //$scope.schedules
                    var schdls = _.sortBy(schedules, function (schedule) {
                        schedule.course_name = course.name;
                        schedule.setCourseDays($scope.getLessonCount(schedule));
                        schedule.lessonCount = course.duration / schedule.durationHours | 0;
                        return schedule.begin;
                    });
                    angular.extend($scope.schedules, schdls);
                    if ($routeParams.active) {
                        $scope.closest = _.findWhere(schedules, {modifier_name: $routeParams.active});
                    } else {
                        $scope.closest = $scope.schedules[0];
                    }
                    $scope.activateSchedule($scope.closest);
                }
            });
            });
            $scope.enrollSchedule.course_id = course.id;
            $scope.enrollSchedule.course_name = course.name;
        });
    }])
    .controller('CoursesController', ['$scope', 'Course', function ($scope, Course) {
        $scope.courses;
        Course.query().$promise.then(function (courses) {
            $scope.courses = courses;
            console.log(courses);
        });

        $scope.predicate = 'track';
        $scope.reverse = false;
        $scope.order = function (predicate) {
            $scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;
            $scope.predicate = predicate;
        };
    }])
    .controller('CourseCalendarCtrl', ['$rootScope', '$scope', 'Calendar', function ($rootScope, $scope, Calendar) {
        $scope.theDayClasses = function (day) {
            var classes = [];
            if (Calendar.isTheDay(day, $scope.today)) {
                classes.push('is__today');
            }
            if (Calendar.isTheDay(day, $scope.dayLesson.day)) {
                classes.push('course__calendar--daylesson');
            }
            if (day.getDay && (day.getDay() == 0 || day.getDay() == 6)) {
                classes.push('calendar__day--weekend');
            }
            var courseDay = $scope.activeSchedule && $scope.activeSchedule.isCourseDay(day);
            if (courseDay) {
                classes.push('course__calendar--' + $scope.activeSchedule.modifier_name);
            }
            return classes.join(' ');
        };
        $scope.showDay = function (day) {
            var courseDayIndex = $scope.activeSchedule && $scope.activeSchedule.courseDayIndex(day);
            $scope.getDayLesson(courseDayIndex);
            $rootScope.$broadcast('dayClick', courseDayIndex);
        };
        $scope.$on('activateSchedule', function () {
            var firstDay = $scope.activeSchedule.coursedays[0];
            $scope.setTime(firstDay.getHours(), firstDay.getMinutes());
            $scope.goToMonth(firstDay.getFullYear(), firstDay.getMonth());
        });
        $rootScope.$on('circleClick', function (e, index) {
            var courseDay = $scope.activeSchedule.coursedays[index];
            $scope.goToMonth(courseDay.getFullYear(), courseDay.getMonth());
        });

    }])
    .controller('SchedulesController', ['$scope', 'Schedule', 'Utils', function ($scope, Schedule, Utils) {
        $scope.schedules;
        $scope.closest;
        Schedule.query().$promise.then(function (schedules) {
            $scope.schedules = schedules;
            $scope.closest = Utils.getCloses(schedules, 6);

            $scope.groupedSchedules = Utils.groupByMonth(schedules);
            console.log(schedules, $scope.closest, $scope.groupedSchedules);
        });


        $scope.predicate = 'begin';
        $scope.reverse = false;
        $scope.order = function (predicate) {
            $scope.reverse = ($scope.predicate === predicate) ? !$scope.reverse : false;
            $scope.predicate = predicate;
        };
    }])
    .controller('InstructorsController', ['$scope', '$http', function ($scope, $http) {
        $scope.instructors = '';
        $http.get('/api/instructors').then(function (res) {
            $scope.instructors = res.data;
            console.log(res.data);
        });
    }])
    .controller('ReviewsController', ['$scope', '$window', '$timeout', '$q', function ($scope, $window, $timeout, $q) {
        $scope.reviews = {};
        var deferred = $q.defer();
        $scope.fbPromise = deferred.promise;
        $scope.reviewsShown = false;
        $scope.showReviews = function () {
            $scope.reviewsShown = !$scope.reviewsShown;
        };
        $window.fbAsyncInit = function () {
            FB.init({
                appId: '890216487659774',
                xfbml: true,
                version: 'v2.4'
            });
            FB.api(
                '/217557725110551/ratings',
                'GET',
                {access_token: "CAAMppa2FKP4BAGQucHlc2RpYnNbRM06l5W3hHwhLMTNZAaSgdhqZBryzcZAvm9s7VcVD7ZA4tvRsqNGSPQEgbVQdht7m8jKRB6pVavuDWgnW0qtZAsVocw9tWIsi1l4dMgtLenWmDSK4NSJoCYv5DF67ZCbWPhUGJVELo7tzbCf1A2JmzWHhLllLdZBR7fQQVIZD"},
                function (response) {
                    if (response && !response.error) {
                        $timeout(function () {
                            angular.extend($scope.reviews, response.data);
                        });
                    }
                    else {
                        console.dir(response.error);
                    }
                }
            );
            if (FB) {
                deferred.resolve(FB);
            } else {
                deferred.reject('FB is no available');
            }
        };
    }])
    .factory('Schedule', ['$resource', 'Calendar', function ($resource, Calendar) {
        var Schedule = $resource('/api/schedule/:id', {id: '@id'}, {
            'schedule': {
                method: 'GET',
                params: {id: '@id'},
                isArray: true
            }
        });
        Schedule.prototype.setCourseDays = function (lessons) {
            if (this.begin) {
                this.coursedays = Calendar.getRepeatedDaysIntervals(this.begin, this.days, lessons);
                var courseEnd = this.coursedays[this.coursedays.length - 1];
                this.endDate = new Date(courseEnd).setHours(courseEnd.getHours() + this.durationHours);
            }
        };
        Schedule.prototype.getEndTime = function () {
            return this.begin + Calendar.hoursToMs(this.durationHours);
        };
        Schedule.prototype.addToBegin = function (time, qty, startDate) {
            var add = Calendar[time + 'ToMs'](qty),
                startDate = startDate || this.begin;
            if (startDate) {
                return Calendar.addToDate(new Date(startDate), add);
            }
            return false;
        };

        Schedule.prototype.isCourseDay = function (day) {
            if (this.coursedays && angular.isDate(day)) {
                return _.find(this.coursedays, function (cday) {
                    return Calendar.isTheDay(day, cday);
                });
            }
            return false;
        };
        Schedule.prototype.courseDayIndex = function (day) {
            if (this.coursedays && angular.isDate(day)) {
                return _.findIndex(this.coursedays, function (cday) {
                    return Calendar.isTheDay(day, cday);
                });
            }
            return false;
        };
        return Schedule;
    }])
    .factory('Course', ['$resource', '$http', function ($resource, $http) {
        var Course = $resource('/api/courses/:alias', {alias: '@alias'}, {
            'course': {
                method: 'GET',
                params: {alias: '@alias'},
                isArray: true
            }
        });
        Course.enroll = function (course) {
            console.log('enroll');
        };
        Course.prototype.getLessons = function () {
            var self = this;
            return $http.get('/api/lessons/' + this.id).then(function (res) {
                self.lessons = res.data;
            });
        };
        return Course;
    }])
    .filter('modifier', function () {
        return function (input) {
            input = input || '';
            var modifiersDict = {
                'default': "Вечерний в рабочие дни",
                'morning': "Утренний в рабочие дни",
                'weekend': "Выходного дня"
            };
            return modifiersDict[input];
        };
    })
    .filter('onDay', function () {
        return function (input) {
            input = input || '';
            return input.replace("а", "у");
        };
    })
    .filter('split', function () {
        return function (input, delimeter) {
            input = input || '';
            return input.split(delimeter);
        };
    })
    .directive('imgFetch', ['$timeout', function ($timeout) {
        return function (scope, el, attrs) {
            attrs.$observe('imgFetch', function (val) {
                scope.fbPromise.then(function (FB) {
                    FB.api(
                        '/' + val + '/picture',
                        'GET',
                        {
                            height: 100,
                            width: 100,
                            access_token: "CAAMppa2FKP4BAGQucHlc2RpYnNbRM06l5W3hHwhLMTNZAaSgdhqZBryzcZAvm9s7VcVD7ZA4tvRsqNGSPQEgbVQdht7m8jKRB6pVavuDWgnW0qtZAsVocw9tWIsi1l4dMgtLenWmDSK4NSJoCYv5DF67ZCbWPhUGJVELo7tzbCf1A2JmzWHhLllLdZBR7fQQVIZD"
                        },
                        function (response) {
                            if (response && !response.error) {
                                $timeout(function () {
                                    el.append('<img src="' + response.data.url + '" alt=""/>');
                                });
                            }
                            else {
                                console.dir(response.error);
                            }
                        }
                    );
                }, function (reason) {
                    console.log('Failed: ' + reason);
                });
            });
        }
    }])
    .directive('slideSlider', [function () {
        return {
            restrict: 'C',
            link: function (scope, el) {
                var left = angular.element(el[0].querySelector('.slide-slider__left')),
                    right = angular.element(el[0].querySelector('.slide-slider__right')),
                    imgs = el.find('img'),
                    counter = 0;

                left.on('click', function () {
                    imgs.eq(counter).css('z-index', 0);
                    counter = (counter + 1) % imgs.length;
                    imgs.eq(counter).css('z-index', counter + 1);
                });
                right.on('click', function () {
                    imgs.eq(counter).css('z-index', 0);
                    counter = (imgs.length - 1 + counter) % imgs.length;
                    imgs.eq(counter).css('z-index', counter + 1);
                });
            }
        }
    }]);