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
    .controller('WebcampCtrl', ['$scope', 'Course', 'Schedule', function ($scope, Course, Schedule) {
        $scope.showModal = false;
        $scope.enroll = function (schedule) {
            $scope.showModal = true;
            if (schedule) {
                $scope.enrollSchedule.modifier_id = schedule.modifier_id;
                $scope.enrollSchedule.course_id = schedule.course_id;
                $scope.enrollSchedule.course_name = schedule.course_name;
            }
        };
        $scope.hideModal = function () {
            $scope.showModal = false;
            $scope.$broadcast('closeModal');
        };
        $scope.schedules = {};
        $scope.course = {};
        $scope.enrollSchedule = {
            modifier_id: 0,
            course_id: 0,
            course_name: ""
        };
        function getSchedules() {
            Schedule.schedule({id: $scope.enrollSchedule.course_id}, function (schedules) {
                if (schedules.length) {
                    $scope.schedules = schedules;
                    $scope.enrollSchedule.modifier_id = schedules[0].modifier_id;
                }
            });
        }

        $scope.courseChange = function () {
            console.log("change", $scope.enrollSchedule);
            getSchedules();
        };
        Course.names(function (courses) {
            if (courses.length) {
                $scope.courseNames = courses;
                $scope.enrollSchedule = courses[0];
                getSchedules();
            }
        });

    }])
    .controller('MainCoursesController', ['$rootScope', '$scope', 'Course', function ($rootScope, $scope, Course) {
        $scope.menuitem;
    }])
    .controller('CourseController', ['$rootScope', '$scope', '$routeParams', 'Course', 'Schedule', function ($rootScope, $scope, $routeParams, Course, Schedule) {
        $scope.activeSchedule;
        $scope.organizerReady = false;
        $scope.courseReady = false;
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
            if ($scope.activeSchedule.coursedays) {
                var count = $scope.activeSchedule.durationHours,
                    start = count * dayNum;
                angular.extend($scope.dayLesson, {
                    day: $scope.activeSchedule.coursedays[dayNum],
                    items: $scope.course.lessons.slice(start, start + count),
                    num: dayNum + 1
                });
            }
        };
        Course.get({alias: $routeParams.alias}).$promise.then(function (course) {
            //$scope.course = course;
            $rootScope.description = course.metadesc;
            $scope.courseReady = true;
            course.getLessons().then(function () {
                angular.extend($scope.course, course);
                Schedule.schedule({id: course.id}, function (schedules) {
                    $scope.organizerReady = true;
                    if (schedules) {

                        //$scope.schedules
                        var schdls = _.sortBy(schedules, function (schedule) {
                            schedule.course_name = course.name;
                            schedule.setCourseDays($scope.getLessonCount(schedule));
                            schedule.lessonCount = course.duration / schedule.durationHours | 0;
                            return schedule.begin;
                        });
                        $scope.schedules = schdls;
                        if ($routeParams.active) {
                            $scope.closest = _.find(schedules, {modifier_name: $routeParams.active});
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
            if ($scope.activeSchedule.coursedays) {
                var firstDay = $scope.activeSchedule.coursedays[0];
                if ($scope.activeSchedule.begin) {
                    $scope.setTime(firstDay.getHours(), firstDay.getMinutes());
                    $scope.goToMonth(firstDay.getFullYear(), firstDay.getMonth());
                }
            }
        });
        $rootScope.$on('circleClick', function (e, index) {

            var courseDay = $scope.activeSchedule.coursedays[index];
            if ($scope.activeSchedule.begin) {
                $scope.goToMonth(courseDay.getFullYear(), courseDay.getMonth());
            }
        });

    }])
    .controller('SchedulesController', ['$scope', 'Schedule', 'Utils', function ($scope, Schedule, Utils) {
        $scope.schedules;
        $scope.closest;
        Schedule.query().$promise.then(function (schedules) {
            $scope.schedules = schedules;
            $scope.closest = Utils.getCloses(schedules, 6);

            $scope.groupedSchedules = Utils.groupByMonth(schedules);
            //console.log(schedules, $scope.closest, $scope.groupedSchedules);
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

            if (!this.begin) {
                this.begin = new Date(moment(this.modifier_default_hour, "HH").add(2, 'months').day(this.days[0]));
            }
            this.coursedays = Calendar.getRepeatedDaysIntervals(this.begin, this.days, lessons);
            var courseEnd = this.coursedays[this.coursedays.length - 1];
            this.endDate = new Date(courseEnd).setHours(courseEnd.getHours() + this.durationHours);
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
            return qty;
        };

        Schedule.prototype.isCourseDay = function (day) {
            if (this.begin && angular.isDate(day)) {
                return _.find(this.coursedays, function (cday) {
                    return Calendar.isTheDay(day, cday);
                });
            }
            return false;
        };
        Schedule.prototype.courseDayIndex = function (day) {
            if (this.begin && angular.isDate(day)) {
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
            },
            'names': {
                method: 'GET',
                params: {alias: 'names'},
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
                'weekend': "Выходного дня",
                'express': "Индивидуальные"
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
    .directive('mainSlider', ['$window', '$interval', '$timeout', function ($window, $interval, $timeout) {
        return {
            restrict: 'A',
            link: function (scope, el) {
                var slidesContainer = angular.element(el[0].querySelector('.slides'));
                var slidesItems = angular.element(slidesContainer[0].querySelectorAll('.slide'));
                var controlsContainer = angular.element(el[0].querySelector('.slide-controls'));
                var controlsItems = angular.element(controlsContainer[0].querySelectorAll('.slide-controls__item'));

                var activeSlide = angular.element(slidesContainer[0].querySelector('.slide.active'));

                var activeControl = angular.element(controlsContainer[0].querySelector('.slide-controls__item.active'));
                var activeIndex = +activeControl.attr('data-index');
                var itemsCount = controlsItems.length;
                var width = parseFloat(controlsItems.css('width'));
                angular.element($window).on('resize', setWidth);

                var interval = null;
                var timeout = null;
                var cancelled = false;
                var ms = 3000;

                slidesItems.on('mouseenter', function (e) {
                    stopInterval();
                });
                slidesItems.on('mouseleave', function (e) {
                    launchInterval(ms);
                });

                controlsItems.on('click', function (e) {
                    stopInterval();

                    var hoverIndex = +this.getAttribute('data-index');
                    changeActiveSlide(hoverIndex);
                    changeActiveControl(hoverIndex);
                    activeIndex = hoverIndex;
                    if (timeout != null) {
                        $timeout.cancel(timeout);
                        stopInterval();
                    }
                    timeout = $timeout(function () {
                        launchInterval(ms);
                    }, 3000);
                });

                function activateNext() {
                    var nextIndex = (activeIndex + 1) % itemsCount;
                    changeActiveSlide(nextIndex);
                    changeActiveControl(nextIndex);
                    activeIndex = nextIndex;
                }

                function changeActiveSlide(i) {
                    activeSlide.removeClass('active');
                    activeSlide = slidesItems.eq(i).addClass('active');
                }

                function changeActiveControl(i) {
                    activeControl.removeClass('active');
                    activeControl = controlsItems.eq(i).addClass('active');
                }

                function setUpInterval() {
                    var wWidth = $window.innerWidth;
                    if (wWidth >= 640 && (!interval || cancelled)) {
                        launchInterval(ms);
                    } else if (wWidth < 640 && interval && !cancelled) {
                        stopInterval();
                    }
                }

                function launchInterval(ms, count) {
                    if (!interval) {
                        cancelled = false;
                        interval = $interval(activateNext, ms, count);
                    }
                }

                function stopInterval() {
                    cancelled = $interval.cancel(interval);
                    interval = null;
                }

                function setWidth() {
                    var wWidth = $window.innerWidth;
                    var _width = parseFloat(controlsItems.css('width'));
                    if (wWidth < 800 && _width == width) {
                        removeLastControlsItem();
                        _width = 100 / (itemsCount);
                        controlsItems.css('width', _width + '%');
                    } else if (wWidth > 800 && _width != width) {
                        _width = width;
                        controlsItems.css('width', _width + '%');
                        addLastControlsItem()
                    }
                    setUpInterval();
                }

                function removeLastControlsItem() {
                    itemsCount -= 1;
                    controlsItems.eq(itemsCount).remove();
                }

                function addLastControlsItem() {
                    controlsContainer.append(controlsItems.eq(itemsCount));
                    itemsCount += 1;
                }

                setWidth();

            }
        }
    }])
    .directive('slideSlider', [function () {
        return {
            restrict: 'C',
            link: function (scope, el) {
                var left = angular.element(el[0].querySelector('.slide-slider__left')),
                    right = angular.element(el[0].querySelector('.slide-slider__right')),
                    imgs = angular.element(el[0].querySelectorAll(".slide-slider__content--img")),
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
    }])
    .directive('reviewer', [function () {
        return {
            restrict: 'A',
            link: function (scope, el) {
                scope.activeItem = null;
                el.on('click', function () {
                    var reviewItems = angular.element(document.querySelectorAll('.reviewer'));
                    reviewItems.removeClass('active');
                    var item = angular.element(this);
                    if (scope.activeItem == this) {
                        item.removeClass('active');
                        scope.activeItem = null;
                    } else {
                        item.addClass('active');
                        scope.activeItem = this;
                    }
                });
            }
        }
    }])
    .directive('navToggler', [function () {
        return function (scope, el, atts) {
            var target = angular.element(document.querySelector(atts.navToggler));
            el.on('click', function () {
                target.toggleClass('active');
            });
        }
    }]);