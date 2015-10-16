/**
 * Created by lenka on 10/7/15.
 */
console.log('OLOLO');

function secToMs(sec) {
    return sec * 1000;
}

function minToMs(min) {
    return secToMs(min * 60);
}

function hoursToMs(hours) {
    return minToMs(hours * 60);
}

function daysToMs(days) {
    return hoursToMs(days * 24);
}

function datesArray(startDate, endDate, ms) {
    var dates = [],
        start = +startDate,
        end = +endDate;
    while (start <= end) {
        dates.push(start);
        start += ms;
    }
    return dates;
}
function addToDate(startDate, add) {
    var dst = 0;
    var date = new Date(+startDate + add);
    if (date.getTimezoneOffset() != startDate.getTimezoneOffset()) {
        var dst = date.getTimezoneOffset() - startDate.getTimezoneOffset();
        return addToDate(date, minToMs(dst));
    }
    return date;
}

function getRepeatedDates(start, addMs, count) {
    var dates = [],
        startDate = new Date(start);
    dates.push(startDate);
    while (count > 1) {
        startDate = addToDate(startDate, addMs);
        dates.push(startDate);
        count--;
    }
    return dates;
}

function getRepeatedDaysIntervals(start, intervals, count) {
    var addDays = 0,
        dates = [],
        startDate = new Date(start);
    dates.push(startDate);

    while (dates.length < count) {
        for (var i = 0; i < intervals.length - 1; i++) {
            addDays = daysToMs(intervals[i + 1] - intervals[i]);
            startDate = addToDate(startDate, addDays);
            if (dates.push(startDate) >= count) {
                return dates;
            }
        }
        addDays = daysToMs(7 % intervals[intervals.length - 1] + intervals[0] % 7);
        startDate = addToDate(startDate, addDays);
        dates.push(startDate);
    }
    return dates;
}

function calendarView(days) {
    var calendar = [];
    var daysOffset = (days[0].getDay() || 7) - 1;
    var weeksCount = Math.ceil((days.length + daysOffset) / 7);
    var start = 0;
    for (var i = 0; i < weeksCount; i++) {
        calendar[i] = [];
        for (var j = 0; j < 7; j++) {
            if (daysOffset > start || (start - daysOffset) >= days.length) {
                calendar[i][j] = '';
            } else {
                calendar[i][j] = days[start - daysOffset];
            }
            start++;
        }
    }
    return calendar;
}

msToSec = function (ms) {
    return ms / 1000;
};
msToMin = function (ms) {
    return msToSec(ms) / 60;
};
msToH = function (ms) {
    return msToMin(ms) / 60;
};
msToDay = function (ms) {
    return msToH(ms) / 24;
};

var start = moment('2015-03-01').startOf('month');
var datesInMonth = getRepeatedDates(start, 86400000, 31);
var calendar = calendarView(datesInMonth);