let tab = [['2022-07-24', '2022-07-29'], ['2022-08-10', '2022-08-15']];
let datesForDisable = [];

function convertDate(date) {
    var yyyy = date.getFullYear().toString();
    var mm = (date.getMonth() + 1).toString();
    var dd = date.getDate().toString();

    var mmChars = mm.split('');
    var ddChars = dd.split('');

    return yyyy + '-' + (mmChars[1] ? mm : "0" + mmChars[0]) + '-' + (ddChars[1] ? dd : "0" + ddChars[0]);
}


for (var i = 0; i < tab.length; i++) {
    var start_date = new Date(tab[i][0]);
    console.log(convertDate(start_date));
    var end_date = new Date(tab[i][1]);
    console.log(convertDate(end_date));
    datesForDisable.push(convertDate(start_date));
    while (start_date < end_date) {
        start_date.setDate(start_date.getDate() + 1);
        //start_date.toString()
        datesForDisable.push(convertDate(start_date));
        console.log(start_date);

    }
}
for (var i = 0; i < datesForDisable.length; i++) {

    console.log(datesForDisable[i]);

}
(function ($) {
    $.fn.datepicker.dates["fr"] = {
        days: [
            "dimanche",
            "lundi",
            "mardi",
            "mercredi",
            "jeudi",
            "vendredi",
            "samedi",
        ],
        daysShort: ["dim.", "lun.", "mar.", "mer.", "jeu.", "ven.", "sam."],
        daysMin: ["d", "l", "ma", "me", "j", "v", "s"],
        months: [
            "janvier",
            "février",
            "mars",
            "avril",
            "mai",
            "juin",
            "juillet",
            "août",
            "septembre",
            "octobre",
            "novembre",
            "décembre",
        ],
        monthsShort: [
            "janv.",
            "févr.",
            "mars",
            "avril",
            "mai",
            "juin",
            "juil.",
            "août",
            "sept.",
            "oct.",
            "nov.",
            "déc.",
        ],
        today: "Aujourd'hui",
        monthsTitle: "Mois",
        clear: "Effacer",
        weekStart: 1,
        format: "dd/mm/yyyy",
    };
})(jQuery);

$(".datepicker").datepicker({
    language: "fr",
    autoclose: true,
    todayHighlight: true,
});

$('#start_date').datepicker({
    format: 'yyyy-mm-dd',
    language: 'fr',
    autoclose: true,
    weekStart: 1,
    calendarWeeks: true,
    todayHighlight: true,
    startDate: new Date(),
    //minDate: new Date(),
    datesDisabled: datesForDisable,

})
$('#end_date').datepicker({
    format: 'yyyy-mm-dd',
    language: 'fr',
    autoclose: true,
    weekStart: 1,
    calendarWeeks: true,
    todayHighlight: true,
    startDate: new Date(),
    //minDate: new Date(),
    datesDisabled: datesForDisable,

})
