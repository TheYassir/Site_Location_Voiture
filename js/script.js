


    // $('#datepicker1').on('input',function(e){
    //     $("#text").html($(this).val());
    // });
    $(document).ready(function(){
        var date = new Date();
        
        // console.log(valba);
        $( "#datepicker1" ).change( changeDate1 );
        changeDate1();
        $( "#datepicker2" ).change( changeDate2 );
        changeDate2();
        
        valba = date.getFullYear() + "-" + twoDigit((date.getMonth() + 1)) + "-" + twoDigit(date.getDate()) + "T" + twoDigit(date.getHours()) + ":" + twoDigit(date.getMinutes());
        $("#datepicker1").attr({"min" : valba, "value" : valba})
        // console.log(valba);

        });
   

    // function addDaysToDate(date, days){
    //     var res = new Date(date);
    //     res.setDate(res.getDate() + days);
    //     // console.log(res);
    //     return res;
    // }
    function changeDate1() {
    var valmin = $("#datepicker1").val();
    // console.log(valmin);
    $("#datepicker2").attr({"min" : valmin, "value" : valmin})
    }

    function changeDate2() {
    var valmax = $("#datepicker2").val();
    // console.log(valmax);

    $("#datepicker1").attr({"max" : valmax})
    }

    function twoDigit(n) {
        return (n < 10 ? '0' : '') + n
    }
    // var tmpDate = new Date(valmin); 
    // var annee = tmpDate.getFullYear();
    // var mois = tmpDate.getMonth();
    // var jour = tmpDate.getDate()
    // var heure = tmpDate.getHours()
    // var minute = tmpDate.getMinutes()

        // if ((mois + 2) == 13){
        //     annee = annee + 1;
        //     mois = 1  ;
        //     valmax = annee +"-0"+ (mois) +"-"+ jour +"T"+ heure +":"+ minute;
        //     console.log(annee +"-0"+ (mois) +"-"+ jour +"T"+ heure +":"+ minute);

        // } else {
        //     valmax = annee +"-"+ (mois + 2) +"-"+ jour +"T"+ heure +":"+ minute;
        //     console.log(annee +"-0"+ (mois + 2) +"-"+ jour +"T"+ heure +":"+ minute);

        // }
    // console.log(tmpDate.toLocaleString(addDaysToDate(tmpDate, 30)));
    // $('#datepicker2').attr("min",valmin);
    // p.setAttribute("class", "first_p") ;
    // $('#datepicker2').append('<p class="first_p>Ceci est un paragraphe</p>') ;