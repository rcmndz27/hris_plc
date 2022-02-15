// var picker = document.getElementById("dateFrom");

// picker.addEventListener('input', function(e)
// {
//     var vd = new Date(this.value).getUTCDay();
//     var today = new Date();

//     var year = today.getFullYear();
//     var day = today.getDate();
//     var month = today.getMonth() + 1;

//     if (day < 10)
//         day = "0".concat(day);

//     if (month < 10)
//         month = "0".concat(month);

//     var todayformat = year.toString().concat("-", month, "-", day);

//     if([2,3,4,5,6,0].includes(vd))
//     {
//         e.preventDefault();
//         this.value = todayformat;
//         alert('Please select only dates that fall on a Monday!');
//     }
// });

$("#btnAdd").click(function(){
    var date = new Date($("#dateFrom").val());

    // if (date.getDay() != 1)
    // {
    //     alert('Please select only dates that fall on a Monday!');
    //     return;
    // }

    var datelist = GenerateDateList(date);

    $('#date1').html(datelist[0].toLocaleString('default', { month: 'long' }).toString().concat(" ", datelist[0].getDate(), ", ", datelist[0].getFullYear()));
    $('#date2').html(datelist[1].toLocaleString('default', { month: 'long' }).toString().concat(" ", datelist[1].getDate(), ", ", datelist[1].getFullYear()));
    $('#date3').html(datelist[2].toLocaleString('default', { month: 'long' }).toString().concat(" ", datelist[2].getDate(), ", ", datelist[2].getFullYear()));
    $('#date4').html(datelist[3].toLocaleString('default', { month: 'long' }).toString().concat(" ", datelist[3].getDate(), ", ", datelist[3].getFullYear()));
    $('#date5').html(datelist[4].toLocaleString('default', { month: 'long' }).toString().concat(" ", datelist[4].getDate(), ", ", datelist[4].getFullYear()));
    $('#date6').html(datelist[5].toLocaleString('default', { month: 'long' }).toString().concat(" ", datelist[5].getDate(), ", ", datelist[5].getFullYear()));
    $('#date7').html(datelist[6].toLocaleString('default', { month: 'long' }).toString().concat(" ", datelist[6].getDate(), ", ", datelist[6].getFullYear()));

    $('#hrspre1').val("0");
    $('#hrspre2').val("0");
    $('#hrspre3').val("0");
    $('#hrspre4').val("0");
    $('#hrspre5').val("0");
    $('#hrspre6').val("0");
    $('#hrspre7').val("0");

    $('#hrspost1').val("0");
    $('#hrspost2').val("0");
    $('#hrspost3').val("0");
    $('#hrspost4').val("0");
    $('#hrspost5').val("0");
    $('#hrspost6').val("0");
    $('#hrspost7').val("0");
});

Date.prototype.addDays = function(days)
{
    var date = new Date(this.valueOf());
    date.setDate(date.getDate() + days);

    return date;
}

function GenerateDateList(dateval)
{
    return [
        dateval,
        dateval.addDays(1),
        dateval.addDays(2),
        dateval.addDays(3),
        dateval.addDays(4),
        dateval.addDays(5),
        dateval.addDays(6)
    ];
}