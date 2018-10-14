
function waitAMinuteremplirChampSMS(){
  window.setTimeout("remplirChampSMS()",300);
}



function isNumberKey(evt)
{
  var charCode = (evt.which) ? evt.which : evt.keyCode;
  if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
    return false;
  return true;
}  

function isCP(evt)
{
  var charCode = (evt.which) ? evt.which : evt.keyCode;
  if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
    return false;
  return true;
} 

function clearall(patname)
{
    $('#inputid').val('');
    $('#inputLastName').val(patname);
    $('#inputFirstName').val('');
    $('#txtCreate').html('');
    $('#txtModif').html('');
    $('#inputRue').val('');
    $('#inputTel').val('');
    $('#inputRef').val('');
    $('#inputBat').val('');
    $('#inputTel2').val('');
    $('#inputMail').val('');
    $('#pat_cp').val('');
    $('#inputVille').val('');
    $('#inputMail2').val('');
    $('#inputObs').html('');
    remplirChampSMS();
} 


function remplirChampSMS(){//ici!!
  champCreation = $('#txtCreate').html();
  champModification = $('#txtModif').html();
  champNom = $('#inputLastName').val();
  champRue1 = $('#inputRue').val();
  champRue2 = $('#inputBat').val();
  champCP = $('#pat_cp').val();
  champTel1 = $('#inputTel').val();
  champTelSoin = $('#inputTel').val();





  /*champSoinSoin = panelPriseEnCharge.getComponent('formPriseEnCharge').getComponent('layColSoin').getComponent('col2Soin').getComponent('soinSoin').getValue();
  champDateSoin = panelPriseEnCharge.getComponent('formPriseEnCharge').getComponent('layColSoin').getComponent('col1Soin').getComponent('debSoin').getValue();
  champDateSoin = formatDate(champDateSoin);
  champHeureSoin = panelPriseEnCharge.getComponent('formPriseEnCharge').getComponent('layColSoin').getComponent('col1Soin').getComponent('heureSoin').getValue();
  champefhSoin = panelPriseEnCharge.getComponent('formPriseEnCharge').getComponent('layColSoin').getComponent('col1Soin').getComponent('efhSoin').getValue();
*/
  if (champTelSoin !== ""){champTelSoin = champTelSoin+" "};
  if (champNom !== ""){champNom = champNom+" "};
  if (champRue1 !== ""){champRue1 = champRue1+" "};
  if (champRue2 !== ""){champRue2 = champRue2+" "};
  if (champCP !== ""){champCP = champCP+" "};
  /*if (champHeureSoin != ""){champHeureSoin = champHeureSoin+" "};
  if (champDateSoin != ""){champDateSoin = champDateSoin+" "};
  if (champSoinSoin != ""){champSoinSoin = champSoinSoin+" "};
  if (champefhSoin != ""){champefhSoin = champefhSoin+" "};
  */
  $('#inputsms').html(champTelSoin+champNom+champRue1+champRue2+champCP/*+champSoinSoin+champDateSoin+champHeureSoin+champefhSoin*/);
  
  champSMS = champTelSoin+champNom+champRue1+champRue2+champCP/*+champSoinSoin+champDateSoin+champHeureSoin+champefhSoin*/;

  var longSMS = champSMS.length;
  longSMS = champSMS.length;
  
  /*var numerorSMS;
  var pluriel = "s";
  var pourcent;
  if(longSMS <= longueurUnSMS){
    canPassOneToTwoSMS = true;
    numerorSMS = '1er';
  }
  else if(longSMS > longueurUnSMS){
    if(canPassOneToTwoSMS){
      Ext.MessageBox.show({
        title: 'Deuxi&egrave;me SMS',
        msg: 'Vous commencez un deuxi&egrave;me SMS !!',
        buttons: Ext.MessageBox.OK,
        icon: Ext.MessageBox.WARNING
      });
    }
    canPassOneToTwoSMS = false;
    numerorSMS = '2&egrave;me';
    longSMS = longSMS - longueurUnSMS;
  }
  if(!(longSMS > longueurUnSMS)){
    if (longSMS > (longueurUnSMS - 2)){pluriel="";}
    pourcent = longSMS/longueurUnSMS;
    text = (longueurUnSMS - longSMS)+' caract&egrave;re'+pluriel+' restant'+pluriel+' sur le '+numerorSMS+' SMS';
    progressBarCaracteres.updateProgress(pourcent, text);
    progressText.setValue(longueurUnSMS - longSMS);
  }
  else{
    Ext.MessageBox.show({
      title: 'Deuxi&egrave;me SMS',
      msg: 'Vous commencez un troisi&egrave;me SMS !!',
      buttons: Ext.MessageBox.OK,
      icon: Ext.MessageBox.WARNING
    });   
  }
  lastLongSMS = longSMS;
  loadInfDispo();*/
}


$(document).ready(function(){

$('#inputLastName').keyup(function(event){
  clearall($('#inputLastName').val());
  getPatient($('#inputLastName').val());
});

$('#pat_cp').keypress(function(event){
  if ($('#pat_cp').val().length>4) return false;
  return isNumberKey(event);
});

$('#inputTel').keypress(function(event){
  if ($('#inputTel').val().length>9) return false;
  return isNumberKey(event);
});

$('#pat_date').datepicker(
  {
    startDate: 0,
    language: "fr",
    orientation: "auto left",
    autoclose: true,
    todayHighlight: true,
    beforeShowDay: function (date){
      if (date.getMonth() < (new Date()).getMonth())
        return false;
      if (date.getFullYear() < (new Date()).getFullYear())
        return false;
    }
});

$('#pat_heure').timepicker({minuteStep: 15,showInputs: false,showSeconds: false,showMeridian: false});  

  $("#btnErase").on('click', function(event){
    clearall('');
  })

  $(window).keydown(function(event){
    waitAMinuteremplirChampSMS();
  });



// Suppression d'un patient et de son historique
$("#btnDelPatient").on('click', function(event){
  dataurl="pat_id=" + $('#inputid').val();
  pat_id=$('#inputid').val();
  $.ajax({
      type: "POST",
      url: "php/patients/deleteUnPatient.php",
      data:dataurl,
      dataType: "html",
      success : function(text){
        console.log(text);
     }
  });
  clearall('');
  getLastPatient('A');
  getHistorique(pat_id)
});

// Validation : envoi du SMS
// - enregistrement du patient (ajout / modification)
// - ajout d'une ligne d'historique
// - envoi du sms
$("#btnTest").on('click', function(event){
    dataurl="pat_id=" + $('#inputid').val()+
    "&pat_nom="+ $('#inputLastName').val()+
    "&pat_prenom="+$('#inputFirstName').val()+
    "&pat_rue1="+$('#inputRue').val()+
    "&pat_tel1="+$('#inputTel').val()+
    "&pat_rue2="+$('#inputBat').val()+
    "&pat_tel2="+$('#inputTel2').val()+
    "&pat_cp="+$('#pat_cp').val()+
    "&pat_ville="+$('#inputVille').val()+
    "&pat_observation="+$('#inputObs').val();
    "&pat_sms="+$('#inputsms').html();
   $.ajax({
        type: "POST",
        url: "php/patients/modifyUnPatient.php",
        data:dataurl,
        dataType: "html",
        // dataType: "json",
        success : function(text){
          console.log(text);
       }
    });
  clearall('');
  getLastPatient('A');
  getHistorique(pat_id)

  // var fDate = new Date($('#pat_date').datepicker('getDate'));
  // var day = fDate.getDate()<10?'0'+fDate.getDate():fDate.getDate();
  // var month = fDate.getMonth()+1;
  // month = month<10?'0'+month:month;
  // var pat_date = day + '/' + month + '/' + fDate.getFullYear();
  // getInfirmier($('#pat_cp').val(),$('#pat_heure').data("timepicker").getTime(),pat_date);
});




});

