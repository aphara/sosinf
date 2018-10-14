 
$(document).ready(function() {
    getLastPatient('A');
});


function getPatient(code){
        var $table = $('#table');
        $table.bootstrapTable('removeAll');

    $.ajax({
        type: "POST",
        url: "php/patients/getPatients.php",
        data: "name=" + code ,
        dataType: "json",
        success : function(text){
          $('#table').bootstrapTable('load',text.res);
        }
    });
}

function getLastPatient(code){
        var $table = $('#table');
        $table.bootstrapTable('removeAll');

    $.ajax({
        type: "POST",
        url: "php/patients/getLastPatients.php",
        data: "name=" + code ,
        dataType: "json",
        success : function(text){
            console.log(text);
          $('#table').bootstrapTable('load',text.res);
        }
    });
}


function getInfirmier(code,hh,dd){
    console.log("test");
    console.log(hh);
    $.ajax({
        type: "POST",
        url: "php/patients/getInfirmiersDispo.php",
        data:"pat_cp=" + code +"&pat_heure2=" + hh + "&pat_date=" + dd,
        dataType: "html",
        success : function(text){
          console.log(text);
          $("#infdispo").html("<option value=''>Veuillez choisir...</option>" + text);
        }
    });
}
function getHistorique(pat_id){
    var $table = $('#tableH');
        $table.bootstrapTable('removeAll');
    $.ajax({
        type: "POST",
        url: "php/patients/getHistoriques.php",
        data:"pat_id=" + pat_id,
        // dataType: "html",
        dataType: "json",
        success : function(text){
           $('#tableH').bootstrapTable('load',text.res);
          // console.log(text.res);
          console.log(text);
       }
    });
}

