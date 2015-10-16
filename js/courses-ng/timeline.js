/**
 * Created by lenka on 10/14/15.
 */
angular.module('Timeline', [])
    .service('Timeline', [function () {

    }])
    .directive('timeline', ['$compile', function ($compile) {
        return {
            restrict: 'E',
            templateUrl: '/ng-views/components/timeline.html',
            link: function (scope, el, attrs) {
                // Create x2js instance with default config
                var x2js = new X2JS();

                var svg = el.find('svg'),
                    svgEl = svg[0],
                    points = +attrs.points,
                    width = svgEl.clientWidth,
                    stroke = '#797e83',
                    strokeW = 1,
                    fill = 'none',
                    r = 5,
                    x = 5,
                    y = 10,
                    lw = (width - points * r * 2) / (points - 1) | 0,
                    circles = [],
                    lines = [];

                for (var i = 0; i < points; i++) {
                    var cx = x + (lw + r * 2) * i,
                        x1 = cx + r,
                        x2 = x1 + lw;
                    var circle = {
                            _cx: cx,
                            _cy: y,
                            _r: r,
                            _stroke: stroke,
                            '_stroke-width': strokeW,
                            _fill: fill,
                            _class: 'timeline__circle',
                            _index: i
                        },
                        line = {
                            _x1: x1,
                            _y1: y,
                            _x2: x2,
                            _y2: y,
                            _stroke: stroke,
                            '_stroke-width': strokeW
                        };

                    circles.push(circle);
                    if (i < points - 1) {
                        lines.push(line);
                    }
                }

                // JSON to XML string
                var xmlDocStr = x2js.json2xml_str(
                    {
                        circle: circles,
                        line: lines
                    }
                );
                svg.on('click', function (e) {
                    if (e.target.nodeName == "circle") {
                        var index = e.target.getAttribute('index'),
                            courseDay = scope.activeSchedule.coursedays[index];
                        console.log(courseDay);
                    }
                });
                svg.html(xmlDocStr);
                $compile(angular.element(svg))(scope);
            },
        }
    }]);