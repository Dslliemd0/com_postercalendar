/*!
postercalendar.js - jan. 2021
*/

// define today's date and define month names by language
let today = new Date();
let language = $('html')[0].lang;
let months;

switch (language) {
    case 'lv-lv':
        months = ["Janvāris","Februāris","Marts","Aprīlis",
        "Maijs","Jūnijs","Jūlijs","Augusts","Septembris",
        "Oktobris","Novembris","Decembris"];
        break;
    case 'en-gb':
    default:
        months = ["January","February","March","April",
                "May","June","July","August","September",
                "October","November","December"];
}

// render calendar navigation and content
function renderCalendar(currentDate, currentMonth, currentYear) {
    let finishedHTML = getNavigation(currentMonth, currentYear);
    $('#pc-head').html(finishedHTML);
    renderDateContent();
}

// get calendar navigation (String format) based on month
function getNavigation(month, year) {
    resultHTML = `<button id="prev_date" type="button">prev</button>` +
                `<h2>${months[month - 1]} of ${year}</h2>` +
                `<button id="next_date" type="button">next</button><br />` +
                getDateRange();            
    return resultHTML;
}

// get date quenue depending by month
function getDateRange() {
    let date = new Date(today);

    let y = date.getFullYear(), m = date.getMonth();
    let lastDay = new Date(y, m + 1, 0);

    collectedDates = "";
    for (let i = 1; i <= lastDay.getDate(); i++) {
        if (i == date.getDate()) {
            collectedDates += `<span class="date-item" data-date="${String(i).padStart(2, '0')}-` +
                                `${String(date.getMonth() + 1).padStart(2, '0')}-${date.getFullYear()}` + 
                                `"><span style="color: red;">${i}</span></span>`;
        } else {
            collectedDates += `<span class="date-item" data-date="${String(i).padStart(2, '0')}-` +
                                `${String(date.getMonth() + 1).padStart(2, '0')}-${date.getFullYear()}` + 
                                `">${i}</span>`;
        }
    }
    return collectedDates;
}

// render current day content
function renderDateContent() {
    let year = today.getFullYear();
    let month = String(today.getMonth() + 1).padStart(2, '0');
    let day = String(today.getDate()).padStart(2, '0');

    $.ajax({
        url: `index.php?option=com_postercalendar&view=posters&date=${year}-${month}-${day}`,
        type: 'post',
        dataType: 'html',
        success: function(response){
            $('.pc-content').html(response);
        }
    });
}

// convert string format date to array and set current date
function getDateFromString(fullDate) {
    let dateArray = fullDate.split("-");
    return Number(dateArray[0]);
}

const animateOnLoad = (item) => {
    item.css('opacity', '0');
    item.animate({
        opacity: 1
    }, 400);
}

const animateRightFlow = (item) => {
    item.css('position', 'relative');
    item.animate({
        left: '+=100',
        opacity: 0
    }, 200, function () {
        renderCalendar(today.getDate(), today.getMonth() + 1, today.getFullYear());
        item.css('left', '-100px');
        setTimeout(function() {
            item.animate({
                left: '+=100',
                opacity: 1,
            });
        }, 200);
    });
}

const animateLeftFlow = (item) => {
    item.css('position', 'relative');
    item.animate({
        left: '-=100',
        opacity: 0
    }, 200, function () {
        renderCalendar(today.getDate(), today.getMonth() + 1, today.getFullYear());
        item.css('left', '100px');
        setTimeout(function() {
            item.animate({
                left: '-=100',
                opacity: 1,
            });
        }, 200);
    });
}

// on page load render calendar and today's day content
$(document).ready(function() {
    animateOnLoad($('.pc-content'));
    renderCalendar(today.getDate(), today.getMonth() + 1, today.getFullYear());
});

// on button id=prev_date click set previous month and first date of this month and render calendar
$(document).on('click', 'button#prev_date', function(e) {
    today.setMonth(today.getMonth() - 1);
    today.setDate(1);
    animateRightFlow($('.pc-content'));
});

// on button id=next_date click set next month and first date of this month and render calendar
$(document).on('click', 'button#next_date', function(e) {
    today.setMonth(today.getMonth() + 1);
    today.setDate(1);
    animateLeftFlow($('.pc-content'));
});

// on click of date number set this date and render calendar based by this current day
$(document).on('click', 'span.date-item', function(e) {
    let targetDate = getDateFromString($(e.target).attr("data-date"));

    if (targetDate > today.getDate()) {
        today.setDate(targetDate);
        animateLeftFlow($('.pc-content'));
    } else if (targetDate < today.getDate()) {
        today.setDate(targetDate);
        animateRightFlow($('.pc-content'));
    } else {
        renderCalendar(today.getDate(), today.getMonth() + 1, today.getFullYear());
    }
})