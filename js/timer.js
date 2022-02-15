function checkTime(i)
{
    if (i < 10) { i = "0" + i; }
    return i;
}

function startTime()
{
    var today = new Date();
    var h = today.getHours();
    var m = today.getMinutes();
    var s = today.getSeconds();
    // add a zero in front of numbers<10
    var ampm = h >= 12 ? 'PM' : 'AM';

    h = h % 12;
    h = h ? h : 12;
    m = checkTime(m);
    s = checkTime(s);
    document.getElementById('time').innerHTML = h + " : " + m + " : " + s + " " + ampm;
    t = setTimeout(function () {
        startTime()
    }, 500);
        }

startTime();