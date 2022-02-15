$('#home-calendar').datepicker({
    language: 'en',
    minHours: 8,
    maxHours: 16,
    inline: 'true'
})

var calendarDate = document.getElementsByClassName("datepicker--cell-day");

for (var i = 0; i < calendarDate.length; i++) {
    calendarDate[i].addEventListener('click', function(){
    document.getElementById("submit-leave").style.display = "block";
    });
};