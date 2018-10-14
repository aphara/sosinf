
/***************************************************************************************************
LES LOTS
***************************************************************************************************/

$('#validAdd').on('click', function(event){
   var txtadress=$('#address').val();
    var txtzipcode=$('#zipcode').val();
    var txtcity=$('#city').val();
    if(txtadress=='')txtadress='27 rue Eugène Derrien';
    if(txtzipcode=='')txtzipcode='94 400';
    if(txtcity=='')txtcity='VITRY SUR SEINE';
   insertNewData(Number($('#id').val()),$('#name').val(),Number($('#quotepart').val()),$('#mail').val(),txtadress,txtzipcode,txtcity,$('#phone').val())
})

$('#validEdit').on('click', function(event){
    var txtadress=$('#address').val();
    var txtzipcode=$('#zipcode').val();
    var txtcity=$('#city').val();
    if(txtadress=='')txtadress='27 rue Eugène Derrien';
    if(txtzipcode=='')txtzipcode='94 400';
    if(txtcity=='')txtcity='VITRY SUR SEINE';
   updateData(Number($('#id').val()),$('#name').val(),Number($('#quotepart').val()),$('#mail').val(),txtadress,txtzipcode,txtcity,$('#phone').val())
})



$('#validAddFact').on('click', function(event){
    var dateSelected = $('#datetimepicker1').datepicker('getDate');
    insertNewDataFact(Number($('#invoiceid').val()),dateSelected,Number(($('#invoiceamount').val()).replace(/[^\d.]/g, '')),
        $('#invoicedesignation').val(),
        $('#invoicetype').val(),
        $('input[name="invoicelog"]:checked').val())
})


var $table = $('#tablelots'),
$tableSaisies = $('#tablesaisies'),
$tablebudget = $('#tablebudget'),
$button = $('#button');

window.editEvents = {
    'click .command-edit': function (e, value, row) {
        $('#id').val(row.id);
        $('#name').val(row.name);
        $('#quotepart').val(row.quotepart);
        $('#mail').val(row.mail);
        $('#address').val(row.address);
        $('#zipcode').val(row.zipcode);
        $('#city').val(row.city);
        $('#phone').val(row.phone);
        $('#validAdd').hide();
        $('#validEdit').show();
    },
    'click .command-editInvoice': function (e, value, row) {
        $('#invoiceid').val(row.id);
        $('#invoiceamount').val(row.invoiceDate);
        $('#invoiceamount').val(row.amount);
        $('#invoicedesignation').val(row.designation);
        $('#invoicetype').val(row.type);
        $('#invoicelog').val(row.log);
    },
      'click .command-editBudget': function (e, value, row) {
        $('#budgetid').val(row.budgetid);
        $('#budgetamount').val(row.amount);
        $('#budgetdes').val(row.designation);
        $('#budgetcategory').val(row.category);
        $('#budgetyear').val(row.budgetyear);
        $('#validAddBudget').hide();
        $('#validEditBudget').show();
    },
    'click .command-log': function (e, value, row) {
        var newlog='achat';
        if(row.log=='achat')
            newlog='banque';
        updateInvoice(Number(row.id),row.invoiceDate,Number(row.amount),row.designation,row.type,newlog);
    },
    'click .command-remove': function (e, value, row) {
        deleteData(row.id,'batch')
    },
   'click .command-removeInvoice': function (e, value, row) {
        $('#iddel').val(row.id);
    },
   'click .command-removeBudget': function (e, value, row) {
        $('#iddel').val(row.budgetid);
    },
};

    $("#validRemoveInvoice").click(function(){
        deleteDataInvoice($('#iddel').val(),'invoice')
    });

    


    function nameFormatter(value, row) {
        var icon = row.id % 2 === 0 ? 'glyphicon-star' : 'glyphicon-star-empty'
        return '<i class="glyphicon ' + icon + '"></i> ' + value;
    }
    function priceFormatter(value) {
        return((parseFloat(value, 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1 ") + ' €').toString());
    }

    function dateFormatter(value) {
        // 16777215 == ffffff in decimal
        var fDate = new Date(value);
        var day = fDate.getDate()<10?'0'+fDate.getDate():fDate.getDate();
        var month = fDate.getMonth()+1;
        month = month<10?'0'+month:month;
        return day + '/' + month + '/' + fDate.getFullYear();
    }

    function logFormatter(value,row) {
        if(row.log=='achat')
            return "<button type=\"button\" class=\"btn btn-xs btn-block command-log\" data-row-id=\"" + row.id + "\" style='background-color:#fafafa'><span data-toggle=\"tooltip\" title=\"Journal d'achat\" class=\"fas fa-shopping-cart fa-lg fa-w\"></span></button> ";
    
        return "<button type=\"button\" class=\"btn btn-xs btn-block command-log\" data-row-id=\"" + row.id + "\" style='background-color:#fafafa'><span data-toggle=\"tooltip\" title=\"Journal de banque\" class=\"fas fa-university fa-lg fa-w\"></span></button> ";
    }
    
    function editFormatter(value,row) {
        return "<button type=\"button\" class=\"btn btn-xs btn-block btn-primary command-edit\" data-toggle=\"modal\" data-target=\"#addModalLots\" data-row-id=\"" + row.id + "\"><span data-toggle=\"tooltip\" title=\"Editer un lot\" class=\"glyphicon glyphicon-pencil\"></span></button> ";
    }
   function editInvoiceFormatter(value,row) {
        return "<button type=\"button\" class=\"btn btn-xs btn-block btn-primary command-editInvoice\" data-toggle=\"modal\" data-target=\"#addModalSaisies\" data-row-id=\"" + row.id + "\"><span data-toggle=\"tooltip\" title=\"Editer un lot\" class=\"glyphicon glyphicon-pencil\"></span></button> ";
    }
   function editBudgetFormatter(value,row) {
        return "<button type=\"button\" class=\"btn btn-xs btn-block btn-primary command-editBudget\" data-toggle=\"modal\" data-target=\"#addModalBudget\" data-row-id=\"" + row.id + "\"><span data-toggle=\"tooltip\" title=\"Editer...\" class=\"glyphicon glyphicon-pencil\"></span></button> ";
    }
    function removeFormatter(value,row) {
        return "<button type=\"button\" class=\"btn btn-xs btn-block btn-danger command-remove\" data-row-id=\"" + row.id + "\"><span data-toggle=\"tooltip\" title=\"Supprimer un lot\" class=\"fas fa-trash fa-lg fa-w\"></span></button> ";
    }
    function removeInvoiceFormatter(value,row) {
        return "<button type=\"button\" class=\"btn btn-xs btn-block btn-danger command-removeInvoice\" data-toggle=\"modal\" data-target=\"#modalConfirm\" data-row-id=\"" + row.id + "\"><span data-toggle=\"tooltip\" title=\"Supprimer une facture\" class=\"fas fa-trash fa-lg fa-w\"></span></button> ";
    }
   function removeBudgetFormatter(value,row) {
        return "<button type=\"button\" class=\"btn btn-xs btn-block btn-danger command-removeBudget\" data-toggle=\"modal\" data-target=\"#modalConfirm\" data-row-id=\"" + row.id + "\"><span data-toggle=\"tooltip\" title=\"Supprimer la ligne\" class=\"fas fa-trash fa-lg fa-w\"></span></button> ";
    }
    

    function getDatas(src){
        ajaxCall('get', null,null, src).then(function(data) {
            $table.bootstrapTable('load', data,src);
        }).catch(function(err){
            alert(JSON.stringify(err));
        });
    }
    
    function getDatasInvoice(src){
        ajaxCall('get', null,null, "invoice").then(function(data) {
            $tableSaisies.bootstrapTable('load', data,src);
        }).catch(function(err){
            alert(JSON.stringify(err));
        });
    }

    function getOneData(id,src){
        ajaxCall('get', id,null,src).then(function(data) {
            $table.bootstrapTable('load', data);
        }).catch(function(err){
            alert(JSON.stringify(err));
        });    
    }

    function insertNewData(id, name, quotepart,mail,address,zipcode,city,phone){
        var datas = {
        'id' : id,
        'name' : name,
        'quotepart' : quotepart,
        'mail' : mail,
        'address':address,
        'zipcode':zipcode,
        'city':city,
        'phone':phone
        }
        ajaxCall('post', null, datas,'batch').then(function(){
            ajaxCall('get',null,null,'batch').then(function(data) {
                $table.bootstrapTable('load', data);
            });
        }).catch(function(err){
            alert(JSON.stringify(err));
        });
    }
    function insertNewDataFact(id, invoiceDate, amount,designation,type,log){
        var datas = {
        'id' : id,
        'invoiceDate' : invoiceDate,
        'amount' : amount,
        'designation' : designation,
        'type' : type,
        'log' : log
        }
        ajaxCall('post', null, datas,'invoice').then(function(){
            ajaxCall('get',null,null,'invoice').then(function(data) {
                $tableSaisies.bootstrapTable('load', data);
            });
        }).catch(function(err){
            alert(JSON.stringify(err));
        });
    }

    function updateInvoice(id, invoiceDate, amount,designation,type,log){
        var datas = {
        'id' : id,
        'invoiceDate' : invoiceDate,
        'amount' : amount,
        'designation' : designation,
        'type' : type,
        'log' : log
        }
        ajaxCall('put', id, datas,'invoice').then(function(){
            ajaxCall('get',null,null,'invoice').then(function(data) {
                $tableSaisies.bootstrapTable('load', data);
            });
        }).catch(function(err){
            alert(JSON.stringify(err));
        });
    }

    function deleteData(id,src){
        ajaxCall('delete', id,null,src).then(function(){
            ajaxCall('get',null,null,src).then(function(data) {
                $table.bootstrapTable('load', data);
            });
        }).catch(function(err){
            alert(JSON.stringify(err));
        });   
    }
    function deleteDataInvoice(id,src){
        ajaxCall('delete', id,null,src).then(function(){
            ajaxCall('get',null,null,src).then(function(data) {
                $tableSaisies.bootstrapTable('load', data);
            });
        }).catch(function(err){
            alert(JSON.stringify(err));
        });   
    }
    function updateData(id, name, quotepart,mail,address,zipcode,city,phone){
        var datas = {
        'id' : id,
        'name' : name,
        'quotepart' : quotepart,
        'mail' : mail,
        'address':address,
        'zipcode':zipcode,
        'city':city,
        'phone':phone
       }
        ajaxCall('put', id, datas,'batch').then(function(){
            ajaxCall('get',null,null,'batch').then(function(data) {
                $table.bootstrapTable('load', data);
            });
        }).catch(function(err){
            alert(JSON.stringify(err));
        });
    }
/***********************************
BUDGET
************************************/
    function getBudgetDatas(){
        ajaxCall('get', null, null, 'budget').then(function(data) {
            $tablebudget.bootstrapTable('load', data,'budget');
        }).catch(function(err){
            alert(JSON.stringify(err));
        });
    }
    $('#validAddBudget').on('click', function(event){
        var date = new Date();
        var txtyear=$('#budgetyear').val();
        if(txtyear=='')txtyear=date.getFullYear();
        insertNewDataBudget(Number(txtyear),Number($('#budgetamount').val()),$('#budgetdes').val(),$('#budgetcategory').val())
    })
    $('#validEditBudget').on('click', function(event){
       updateDataBudget(Number($('#budgetid').val()),Number($('#budgetyear').val()),Number($('#budgetamount').val()),$('#budgetdes').val(),$('#budgetcategory').val())
    })


    $("#validRemoveBudget").on('click', function(event){
        alert($('#iddel').val());
        deleteDataBudget($('#iddel').val(),'budget')
    })

   function deleteDataBudget(id,src){
        ajaxCall('delete', id,null,src).then(function(){
            ajaxCall('get',null,null,src).then(function(data) {
                $tablebudget.bootstrapTable('load', data);
            });
        }).catch(function(err){
            alert(JSON.stringify(err));
        });   
    }


    function insertNewDataBudget(budgetyear, amount,designation,category){
        var datas = {
        'budgetyear' : budgetyear,
        'amount' : amount,
        'designation' : designation,
        'category' : category
        }
        ajaxCall('post', null, datas,'budget').then(function(){
            ajaxCall('get',null,null,'budget').then(function(data) {
                $tablebudget.bootstrapTable('load', data);
            });
        }).catch(function(err){
            alert(JSON.stringify(err)); 
        });
    }
    function updateDataBudget(id, budgetyear, amount,designation,category){
        alert(budgetyear);
        var datas = {
            'budgetid' : id,
            'budgetyear' : budgetyear,
            'amount' : amount,
            'designation' : designation,
            'category' : category
        }
        ajaxCall('put', id, datas,'budget').then(function(){
            ajaxCall('get',null,null,'budget').then(function(data) {
                $tablebudget.bootstrapTable('load', data);
            });
        }).catch(function(err){
            alert(JSON.stringify(err)); 
        });
    }
/***********************************
EDITION
************************************/  
function getAppel(){
    ajaxCall('get', (new Date()).getFullYear(),null,'budget').then(function(databudget) {
        $tablebudget.bootstrapTable('load', databudget);
        ajaxCall('get', null,null, 'batch').then(function(data) {
            var date = new Date();
            var months = ["janvier", "février", "mars", "avril", "mai", "juin", "juillet", "août", "septembre", "octobre", "novembre", "décembre"];
            utc= date.getDate()+' '+months[date.getMonth()]+' '+date.getFullYear();
            utc2= (date.getDate()+7)+' '+months[date.getMonth()]+' '+date.getFullYear();
            var htmlappel="";
            var diventete="<div id='htpg'><div class='imglogo'/><div class='txtlogo'><b>Conseil Syndical du Noyer au Grand Claude</b></br>27 rue Eugène Derrien, pavillon 20</br>94 400 VITRY SUR SEINE</div></br></br></br></div>";
            var divdate="<div id='dateappel'><b>Copropriété du Noyer au Grand Claude</b></br>Exercice du 01/01/"+(new Date()).getFullYear()+" au 31/12/"+(new Date()).getFullYear()+"</br>Vitry sur Seine, le "+utc+"</div>";
            for (d in data){
            var valTotal=0;
                htmlappel+=diventete+divdate;
                htmlappel+="<div id='infocopro'><b>Copropriétaire du lot N°: "+data[d].id+"</b></br>";
                htmlappel+=data[d].name+"</br>";
                htmlappel+=data[d].address+"</br>";
                htmlappel+="Pavillon " + data[d].id+"</br>";
                htmlappel+=data[d].zipcode+" "+data[d].city+"</br></div>";
                htmlappel+="<div class='titledoc'>APPEL DE FONDS</div>";
                htmlappel+="<div id='titleappel'>Exigible le 24 mars 2018</div>";
                htmlappel+="<div class='recap'><div><div class='col-sm-12 tblTop'>Détail des sommes demandées</div>";
                htmlappel+="<div class='col-sm-6 tblTopNiv2'>&nbsp</div><div class='col-sm-2 tblTopNiv2'>Montant global</div><div class='col-sm-2 tblTopNiv2'>Tantième</div><div class='col-sm-2 tblTopNiv2'>Montant</div>";
                htmlcg="<div class='col-sm-12 tblTopNiv3'>Charges générales</div>";
                htmlaf="<div class='col-sm-12 tblTopNiv3'>Appel de fond pour travaux</div>";
                for (b in databudget){
                    var valcopro=(databudget[b].amount*data[d].quotepart)/1000;
                    valcopro=Math.round(valcopro*100)/100;
                    valTotal+=valcopro;
                    txtVC=priceFormatter(valcopro);
                    if(databudget[b].category=='Charges générales')
                        htmlcg+="<div class='col-sm-6 tblTopNiv4'>"+databudget[b].designation+"</div><div class='col-sm-2 tblcontent tblR'>"+priceFormatter(databudget[b].amount)+"</div><div class='col-sm-2 tblcontent tblC'>"+data[d].quotepart+"</div><div class='col-sm-2 tblcontent tblR'>"+txtVC+"</div>";
                    else
                        htmlaf+="<div class='col-sm-6 tblTopNiv4'>"+databudget[b].designation+"</div><div class='col-sm-2 tblcontent tblR'>"+priceFormatter(databudget[b].amount)+"</div><div class='col-sm-2 tblcontent tblC'>"+data[d].quotepart+"</div><div class='col-sm-2 tblcontent tblR'>"+txtVC+"</div>";
                }
                htmlappel+=htmlcg+htmlaf;
                htmlappel+="<div class='col-sm-10 tblTopNiv3 tblR tblT'>Total de l'échéance</div><div class='col-sm-2 tblTopNiv3 tblR tblT'>"+priceFormatter(valTotal)+"</div></div>";
                htmlappel+="</div>";
                htmlappel+="<div class='paiment'><u><b>Vos possibilités de paiement</u>&nbsp;:</b></div>";
                htmlappel+="<div class='chq'><b>Par chèque : </b>&nbspà l'ordre de SDC du Noyer au Grand Claude.";
                htmlappel+="&nbsp;Possibilité de régler en 3 fois, il est alors <b>&nbspindispensable&nbsp</b> de donner 3 chèques qui seront encaissés en mars, juin et septembre.";
                htmlappel+="</div>";
                htmlappel+="<div class='chq'><b>Par virement : </b></div>";
                htmlappel+="<div class='txtchq'>SDC du Noyer au Grand Claude</div>";
                htmlappel+="<div class='txtchq'>IBAN (International Bank Account Number)</div>";
                htmlappel+="<div class='txtchq'>FR76 1020 7001 0422 2156 6367 891</div>";
                htmlappel+="<div class='sig'>Le Syndic<br>M. MAICHE</div>";
                htmlappel+="<div class='footnotes'>M. MAICHE Cyrille - 27 rue Eugène Derrien, pavillon 20 - 94400 VITRY SUR SEINE - tél : 06.27.72.68.71</div>";
            }
            $("#budget").hide(600);
            $("#boxprint").html(htmlappel);
            $("#sectionprint").show();
        }).catch(function(err){
            alert(JSON.stringify(err));
        });
    }).catch(function(err){
        alert(JSON.stringify(err));
    });
}
/***********************************
GENERIQUE
************************************/

