var d = new Date();
var datenow = {
  dd:  d.getDate(),
  mm: d.getMonth(),
  yyyy:  d.getFullYear(),
  day: d.getDay()
}

function dayString(dayval) {
  var dayStr = ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'];
  return dayStr[dayval];
}

function monthString(monthval) {
  var monthStr = ['January','February','March','April','May','June','July','August','September','October','November','December'];
  return monthStr[monthval];
}

function oneFallsOnDay(monthval,yearval) { // returns the box number where day 1 falls
  var dayone = new Date(yearval, monthval, 1);
  return dayone.getDay();
}

function leapYear(year) {
  return ((year % 4 == 0) && (year % 100 != 0)) || (year % 400 == 0);
}

function maxDays(monthval, yearval) {
  if ((leapYear(yearval)) && (monthval==1)) {
    return 29;
  } else {
    var totaldays = [31,28,31,30,31,30,31,31,30,31,30,31];
    return totaldays[monthval];
  }
}

function plotDates(monthval,yearval) {
  //display month and year
  document.getElementById('monthbox').innerHTML = monthString(monthval) + '<br>' + yearval.toString();
  //get 42 boxes
  var boxes = document.getElementsByClassName('datebox');
  var i = oneFallsOnDay(monthval,yearval);
  //initial blank boxes, if any
  for (x=0; x < i; x++) {
    boxes[x].innerHTML = '&nbsp;';
  }
  //fill boxes with dates
  var maxdays = maxDays(monthval, yearval);
  for (x=1; x <= maxdays; x++) {
    boxes[i].innerHTML = x.toString();
    i++
  }
  //fill remaining boxes
  i = oneFallsOnDay(monthval,yearval); //reset
  for (x=maxdays + i; x < 42; x++) {
    boxes[x].innerHTML = '&nbsp;';
  }
}

function adjustMonth(step) {
  datenow.mm += step;
  if (datenow.mm == -1) {
    datenow.mm = 11;
    datenow.yyyy -= 1;
  } else if (datenow.mm == 12) {
    datenow.mm = 0;
    datenow.yyyy += 1;
  }
  //insert code here to controll unexpected year input, maybe set it to default or something
  drawCalendar();
}

function drawCalendar() {
  plotDates(datenow.mm, datenow.yyyy);

  //------------functions below are specific to this application
  addStyleDisabled();
  addLinks();
}


//------------functions below are specific to this application
function addStyleDisabled() {
  var dayval = datenow.dd
  var monthval = datenow.mm;
  var yearval = datenow.yyyy;
  var now = new Date();
  var boxes = document.getElementsByClassName('datebox');
  var i = oneFallsOnDay(monthval,yearval);
  var z = maxDays(monthval,yearval);
  //remove date-disabled class from all boxes
  for (x=0; x < 42; x++) {
    boxes[x].classList.remove('date-disabled');
  }
  //falls on same month
  if ((monthval == now.getMonth()) && (yearval == now.getFullYear())) {
    for (x=i; x < dayval-1; x++) {
      boxes[x].classList.add('date-disabled');
    }
  }
  //falls on months earlier than current
  if (((monthval < now.getMonth()) && (yearval <= now.getFullYear())) || (yearval < now.getFullYear())) {
    for (x=i; x < z+i; x++) {
      boxes[x].classList.add('date-disabled');
    }
  }
}

function addLinks() {
  var monthval = datenow.mm;
  var yearval = datenow.yyyy;
  var i = oneFallsOnDay(monthval,yearval);
  var z = maxDays(monthval,yearval);
  var a;
  var boxes = document.getElementsByClassName('datebox');
  var newmonth = monthval + 1;
  if (newmonth.toString().length == 1) {
    newmonth = '0' + newmonth.toString();
  } else {
    newmonth = newmonth.toString();
  }
  for (x=i; x < z+i; x++) {
    a = boxes[x].innerHTML;
    var d = a;
    if (d.length == 1) {
      d = '0' + a;
    }
    linkdate = yearval.toString() + "-" + newmonth + "-" + d.toString();
    boxes[x].innerHTML = "<a class='linkdate' href=\"javascript:showDate('" + linkdate + "');\">" + a + "</a>";
  }
}

function showDate(d) {
  document.getElementById('sched').value = d;
  document.getElementById('displaySchedDate').innerHTML = 'Deliveries scheduled on ' + d;
  showDeliverSchedule(d);
}