/**
 * Created by lenka on 9/30/15.
 */
angular.module('Courses', ['angular-lodash', 'ngResource', 'ngRoute', 'Utils', 'Calendar', 'Clock', 'Timeline'])
    .config(['$routeProvider', '$locationProvider', function ($routeProvider, $locationProvider) {

        $routeProvider

            // route for the home page
            .when('/', {
                templateUrl: '/ng-views/courses/index.html',
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
        $scope.showModal = true;
        $scope.enroll = function (course) {
            $scope.showModal = true;
            Course.enroll(course);
        };
        $scope.hideModal = function () {
            $scope.showModal = false;
        }
    }])
    .controller('MainCoursesController', ['$scope', 'Course', function ($scope, Course) {
        $scope.menuitem;
        console.log($scope.menuitem);
    }])
    .controller('CourseController', ['$scope', '$routeParams', 'Course', 'Schedule', function ($scope, $routeParams, Course, Schedule) {
        $scope.activeSchedule;
        $scope.predicate = 'begin';
        $scope.reverse = false;
        $scope.activateSchedule = function (schedule) {
            $scope.activeSchedule = schedule;
            $scope.activeTab = $scope.activeSchedule.modifier_name;
            $scope.$broadcast('activateSchedule');
        };
        $scope.isActiveTab = function (tab) {
            return tab == $scope.activeTab;
        };
        $scope.getLessonCount = function (schedule) {
            return $scope.course.duration / schedule.durationHours | 0;
        };
        Course.get({alias: $routeParams.alias}, function (course) {
            $scope.course = course;
            Schedule.schedule({id: course.id}, function (schedules) {
                if (schedules) {

                    $scope.schedules = _.sortBy(schedules, function (schedule) {
                        schedule.setCourseDays($scope.getLessonCount(schedule));
                        schedule.lessonCount = $scope.course.duration / schedule.durationHours | 0;
                        return schedule.begin;
                    });
                    $scope.closest = $scope.schedules[0];
                    $scope.activateSchedule($scope.closest);
                }
            });
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
    .controller('CourseCalendarCtrl', ['$scope', 'Calendar', function ($scope, Calendar) {
        $scope.isTheDay = function (day) {
            var classes = [];
            if (Calendar.isTheDay(day, $scope.today)) {
                classes.push('is__today');
            }
            if (day.getDay && (day.getDay() == 0 || day.getDay() == 6)) {
                classes.push('calendar__day--weekend');
            }
            if ($scope.activeSchedule && $scope.activeSchedule.isCourseDay(day)) {
                classes.push('course__calendar--' + $scope.activeSchedule.modifier_name);
            }
            return classes.join(' ');
        };
        $scope.showDay = function (day) {
            console.log(day);
        };
        $scope.$on('activateSchedule', function () {
            var firstDay = $scope.activeSchedule.coursedays[0];
            $scope.setTime(firstDay.getHours(), firstDay.getMinutes());
            $scope.goToMonth(firstDay.getFullYear(), firstDay.getMonth());
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
                this.endDate = courseEnd.setHours(courseEnd.getHours() + this.durationHours);
            }
        };
        Schedule.prototype.getEndTime = function () {
            return this.begin + Calendar.hoursToMs(this.durationHours);
        };
        Schedule.prototype.isCourseDay = function (day) {
            if (this.coursedays && angular.isDate(day)) {
                return _.find(this.coursedays, function (cday) {
                    return Calendar.isTheDay(day, cday);
                });
            }
            return false;
        };
        return Schedule;
    }])
    .factory('Course', ['$resource', function ($resource) {
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
    .directive('enrollModal', [function () {
        return {
            restrict: 'E',
            templateUrl: '/ng-views/components/enrollModal.html',
            link: function (scope, el, arrts) {

            }
        }
    }]);