/*!
postercalendar.js - jan. 2021
*/

// define today's date and define month names by language
let today = new Date();
let language = $('html')[0].lang;
let months;
let todaysDate = new Date(today);

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
    if (language == 'lv-lv') {
        monthTitle = `<h2>${year}. gada ${months[month - 1]}</h2>`;
    } else {
        monthTitle = `<h2>${months[month - 1]} of ${year}</h2>`;
    }
    resultHTML = `<div class="pc-month-title"><i id="prev_date" class="fa fa-chevron-left"></i>` +
                monthTitle +
                `<i id="next_date" class="fa fa-chevron-right"></i></div><div class="date-range">` +
                getDateRange() + `</div>`;
    return resultHTML;
}

// get date quenue depending by month
function getDateRange() {
    let date = new Date(today);

    let y = date.getFullYear(), m = date.getMonth();
    let lastDay = new Date(y, m + 1, 0);

    collectedDates = "";
    for (let i = 1; i <= lastDay.getDate(); i++) {
        
        let currentDate = String(i).padStart(2, '0');
        let currentMonth = String(date.getMonth() + 1).padStart(2, '0');
        let currentYear = date.getFullYear();

        if (todaysDate.getDate() == i && todaysDate.getMonth() == date.getMonth() &&
            todaysDate.getYear() == date.getYear()) {
            collectedDates += `<span class="date-item date-today" data-date="${currentDate}-` +
                                `${currentMonth}-${currentYear}">${i}</span>`;
        } else if (date.getDate() == i) {
            collectedDates += `<span class="date-item active" data-date="${currentDate}-` +
                                `${currentMonth}-${currentYear}">${i}</span>`;
        } else {
            collectedDates += `<span class="date-item" data-date="${currentDate}-` +
                                `${currentMonth}-${currentYear}">${i}</span>`;
        }
    }
    return collectedDates;
}

// function createDateItem(content, elementType, parentElement, classes) {
//     let dateItem = parentElement.createElement(elementType);
//     if (typeof(classes) !== 'undefined') {
//         for (let i = 3; i < arguments.length; i++) {
//             dateItem.classList.add(arguments[i]);
//         }
//     }
//     dateItem.innerHTML = content;
// }

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
$(document).on('click', 'i#prev_date', function(e) {
    today.setMonth(today.getMonth() - 1);
    today.setDate(1);
    animateRightFlow($('.pc-content'));
});

// on button id=next_date click set next month and first date of this month and render calendar
$(document).on('click', 'i#next_date', function(e) {
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



function initImagePopup(elem){
    // check for mouse click, add event listener on document
    document.addEventListener('click', function (e) {
        // check if click target is img of the elem - elem is image container
        if (!e.target.matches('.img-title')) return;
        else{

            var image = e.target.previousElementSibling; // get current clicked image

            const img = new Image();
            img.src = image.src;

            // create new popup image with all attributes for clicked images and offsets of the clicked image
            var popupImage = document.createElement("img"); 
            popupImage.setAttribute('src', img.src);
            popupImage.style.opacity = "1";
            popupImage.style.left = "50%";
            popupImage.style.top = "50%";
            popupImage.style.transform = "translate(-50%, -50%)";
            
            if (((img.width / img.height) * (window.innerHeight * 0.9)) > (window.innerWidth * 0.9)) {
                popupImage.style.width = window.innerWidth * 0.9 + "px";
                popupImage.style.height = ((img.height / img.width) * (window.innerWidth * 0.9))+"px";
            } else {
                popupImage.style.height = window.innerHeight * 0.9+"px";
                popupImage.style.width = ((img.width / img.height) * (window.innerHeight * 0.9))+"px";
            }

            console.log(image.offsetLeft);
            console.log(image.offsetTop+40+"px");
            popupImage.classList.add('popup-image');

            // creating popup image container
            var popupContainer = document.createElement("div"); 
            popupContainer.classList.add('popup-container');
            
            // creating popup image background
            var popUpBackground = document.createElement("div"); 
            popUpBackground.classList.add('popup-background');

            // append all created elements to the popupContainer then on the document.body
            popupContainer.appendChild(popUpBackground);
            popupContainer.appendChild(popupImage);
            document.body.appendChild(popupContainer);

            // call function popup image to create new dimensions for popup image and make the effect
            popupImageFunction();


            // resize function, so that popup image have responsive ability
            var wait;
            window.onresize = function(){
                clearTimeout(wait);
                wait = setTimeout(popupImageFunction, 100);
            };

            // close popup image on clicking on the background
            popUpBackground.addEventListener('click', function (e) {
            popupImage.style.opacity = "0";
                closePopUpImage();
            });


            function popupImageFunction(){
                // wait few miliseconds (10) and change style of the popup image and make it popup
                // waiting is for animation to work, yulu can disable it and check what is happening when it's not there
                setTimeout(function(){      
                    // I created this part very simple, but you can do it much better by calculating height and width of the screen,
                    // image dimensions.. so that popup image can be placed much better
                    popUpBackground.classList.add('active-background');
                    
                    
                               
                }, 10);
            }

            // function for closing popup image, first it will be return to the place where 
            // it started then it will be removed totaly (deleted) after animation is over, in our case 300ms
            function closePopUpImage(){
                popUpBackground.classList.remove('active-background');
                setTimeout(function(){      
                    popupContainer.remove();
                }, 300);
            }
            
        }
    });
}

// Start popup image function
initImagePopup(".pc-content") // elem = image container