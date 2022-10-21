///
$(document).ready(function() {

    $(".table-ponts").DataTable({
        autoWidth: true,
        ordering: true,
        order: [
            [1, 'asc']
        ],
        language: { 'url': 'vendors/datatables/French.json' },
        pageLength: nbpnt,
        columnDefs: [
            { "visible": false, "targets": 0 },
            { "visible": true, "targets": 1 },
            // { "visible": false, "targets": 6 },
            //  { "visible": false, "targets": 1 },
            { "visible": false, "targets": 7 },	
            { "visible": false, "targets": 9 },
        ],
        createdRow: function(row, data, dataIndex) {
            if (data[6] == 0) {
                $(row).css({ "background-color": "#eeeeee" });
            }
        },
        dom: 'Bfrtip',
        buttons: [{ extend: 'copyHtml5', text: 'Copier', titleAttr: 'Copier le contenu du tableau' },
            { extend: 'csv', text: 'CSV', titleAttr: 'Télécharger le tableau au format CSV' },
            { extend: 'excel', text: 'Excel', titleAttr: 'Télécharger le tableau au format Excel' },
            { extend: 'pdf', text: 'PDF', titleAttr: 'Télécharger le tableau au format PDF' },
            { extend: 'print', text: 'Imprimer', titleAttr: 'Imprimer le tableau' }
        ],
    });


    $(".table-chargeurs").DataTable({
        autoWidth: true,
        ordering: false,
        language: { 'url': 'vendors/datatables/French.json' },
        pageLength: nbchg,
        columnDefs: [
            { "visible": false, "targets": 0 },
            { "visible": false, "targets": 4 },
            { "visible": false, "targets": 5 },
        ],
         drawCallback: function (settings) {
            var api = this.api();
            var rows = api.rows({ page: 'current' }).nodes();
            var last = null;
 
            api
                .column(5, { page: 'current' })
                .data()
                .each(function (group, i) {
                    if (last !== group) {
                        $(rows)
                            .eq(i)
                            .before('<tr style="background-color: #ddd !important;"><td colspan="6">PONT&nbsp;&nbsp;:&nbsp;&nbsp;' + group + '</td></tr>');
 
                        last = group;
                    }
                });
        },
        createdRow: function(row, data, dataIndex) {
            if (data[1] == 'JOUR') {
                $(row).css({ "background-color": "#dddd33" });
            }
        },

    });
    loadselect('PROPIETAIRE', 'Get_structure_model', '.form-ponts select[name="strc"]', 0);
    loadselect('CHARGEUR', 'Get_chargeur_model', '.form-ponts select[name="char"]', 0);
    // loadselect('ANNEE','Get_annee_model','.form-ponts select[name="annee"]',0,0);

    Champ('checkbox', '.form-ponts', 'cafe', cafe, '', 0);

    // Champ('checkbox','.form-ponts','cajou',cajou,'',0);
    Champ('checkbox', '.form-ponts', 'autres', autres, '', 0);

});


$('.form-ponts').on('click', '#submit-ponts', function(e) {

    e.preventDefault();

    trigerponts();
});
//*/

function trigerponts() {

    var datedebut = $('.form-ponts input[name="dateD"]').val();
    var datefin = $('.form-ponts input[name="dateF"]').val();
    var strc = $('.form-ponts select[name="strc"]').val();
    var char = $('.form-ponts select[name="char"]').val();
    var pont = ponts;
    var userid = userid;
    var cafe = ($('.form-ponts input[name="cafe"]').is(":checked") ? 1 : 0);
    var autres = ($('.form-ponts input[name="autres"]').is(":checked") ? 1 : 0);
    loadponts(datedebut, datefin, userid, cafe, autres, strc,char);
}


// liste des chargeurs 
function loadponts(datedebut, datefin, userid, cafe, autres, strc, char) {
    
    var debut = datedebut;
    var fin = datefin;
    var date = new Date(fin);
    showloader();

    $.ajax({

        url: './models/Get_user_fac_model.php ',
        type: 'POST',
        data: '&debut=' + debut + '&fin=' + fin + '&pont=' + pont + '&cafe=' + cafe + '&user_id=' + userid + /*'&cajou='+cajou+*/ '&autres=' + autres + '&strc=' + strc + '&char=' + char,
        dataType: 'json',
        success: function(response) {

            hideloader();


            $('.table-ponts').DataTable().clear().draw(false);

            if (response[0] == 1)
                mssg(lang, 29, response);
            else if (response[0] == 0) {

                var resume;
                var tickets = parseInt(response[3].replaceAll(" "), 10);
                resume = "Pour la période du&nbsp;<b>" + debut + "&nbsp;au&nbsp;" + fin + "</b>,&nbsp;";
                resume += "il y a&nbsp;<b>" + ((response[3] != 0) ? response[3] : "aucune") + "&nbsp;ticket" + ((tickets > 1) ? "s" : "") + "</b>,&nbsp;";
                resume += "correspondant" + ((tickets > 1) ? "s" : "") + " à un montant total de&nbsp;<b>" + response[4] + "&nbsp;FCFA</b>.";
                resume += ((response[5] > 0) ? "&nbsp;Par ailleurs, &nbsp;<b>" + response[5] + "&nbsp;</b>pont" + ((response[5] > 1) ? "s" : "") + " sur&nbsp;<b>" + response[1] + "</b>" : "");
                resume += ((response[5] > 0) ? "&nbsp;n" + ((response[5] > 1) ? "'ont" : "'a") + " pas de compte d'utilisateur." : "");
                $('#resultat').html(resume);

                (response[10]==1)?('&cafe=1'+'&autres=0'):('&cafe=0'+'&autres=1');
                var j = 5;
                var mois = ["janvier", "fevrier", "mars", "avril", "mai", "juin", "juillet", "aout", "septembre", "octobre", "novembre", "decembre"];


                for (var i = 0; i < response[1]; i++) {

        $('.table-ponts').DataTable().row.add([
                        response[j + 1], //IDENTIFIANT 0
                        '<label>' + ((response[j+11]==0)?'P':'C') + '</label>', //TYPES
                        response[j + 2], //STRUCTURE 1
                        mois[response[j + 3]-1], //MOIS 2
                        response[j + 4], //ANNEE 3
                        '<label>' + (( response[j + 5] == 1) ? 'CAFE CACAO' : 'AUTRES PRODUITS') + '</label>', //PRODUIT 4
                        response[j + 6], //PONT 5
                        response[j + 7], //NBT 7
                        response[j + 8], //COUT 8
                        response[j + 9], //ID_PONT 9
                        //response[j+6],//COMPTE
                        '<a class="btn btn-danger " style="color: white;" title="Télécharger le PDF de la facture" href="models/load_facture.php?userid=' + response[j + 1] + '&debut=' + debut + '&fin=' + fin + '&cafe=' +((response[j+5]==1)?cafe=1:cafe=0)+ '&autres=' +((response[j+5]==2)?autres=1:autres=0)+'&char=' + response[j+11]+'&mois=' + response[j+3]+'&annee=' + response[j+4]+'" target="_blank" ><i class="mdi mdi-file-pdf "></i></a>',
                        '<button class="btn btn-info button-chargeurs" name="' + debut + '_' + fin + '_' + response[j + 1] + '_' + response[j + 5] /*cafe*/ + '_'+ response[j + 11] +'_' + response[j+3] +'_' + response[j+4] +'"title="Voir le détails des tickets par chargeur" style="color: white;"><i class="mdi mdi-magnify-plus"></i></button>',
                        ((response[j + 10]) == null) ? '<span style="color: red;"><i class="mdi mdi-cancel"></i>NON TRANSMIS</span>' : '<span style="color: green;"><i class="mdi mdi-check-all"></i>' + response[j + 10] + '<span>' // SEND MAIL 10
                    ]).columns.adjust().draw(false);

                    j += response[2];
                }

            }

        },
        error: function(jqXHR, status, error) {
            hideloader();
            mssg(lang, 7, error);

        }
    }); //end ajax

}



$('.table-ponts').on('click', '.button-chargeurs', function() {

    var tr = $(this).closest('tr');
    var id = $(this).prop('name').split("_");

    if (id == id) {
        showloader();

        $.ajax({

            url: './models/Get_chargeurs_model.php',
            type: 'POST',
            data: '&debut=' + id[0] + '&fin=' + id[1] + '&user_id=' + id[2] + ((id[3] == 1) ? '&cafe=1' + '&autres=0' : '&cafe=0' + '&autres=1')+'&char='+id[4] +'&pont='+'&mois='+id[5]+'&annee='+id[6],
            dataType: 'json',
            success: function(response) {
                hideloader();

                $('.table-chargeurs').DataTable().clear().draw(false);
                
                if (response[0] == 0) {
                    var j = 2;
                    for (var i = 0; i < response[1]; i++) {
                        $('.table-chargeurs').DataTable().row.add([
                            response[j + 1], //IDENTIFIANT
                            response[j + 2], //NOM
                            response[j + 3], //NBT
                            response[j + 4], //COUT
                            response[j + 5], //ID_PONT
                            response[j + 6], //NOM_DU_PONT
                            '<a class="btn btn-danger " style="color: white;" title="Télécharger le PDF des tickets" href="models/load_tickets.php?chrg=' + response[j + 1] + '&debut=' + id[0] + '&fin=' + id[1] + ((id[3] == 1) ? '&cafe=1' + '&autres=0' : '&cafe=0' + '&autres=1') + '&user_id=' + id[2]+'&mois='+id[5]+'&annee='+id[6]+'&pont='+response[j+5]+'" target="_blank" ><i class="mdi mdi-file-pdf "></i></a>' + '&nbsp &nbsp &nbsp' +
                            '<a class="btn btn-success" style="color: white;" title="Extraire les demandes au format CSV afin de les traiter dans Excell" href="models/load_csv.php?chrg=' + response[j + 1] + '&debut=' + id[0] + '&fin=' + id[1] + ((id[3] == 1) ? '&cafe=1' + '&autres=0' : '&cafe=0' + '&autres=1') +'&user_id=' + id[2]+'&mois='+id[5]+'&annee='+id[6]+'&pont='+response[j+5]+'" target="_blank" ><i class="mdi mdi-file-excel"></i></a>'
                        ]).columns.adjust().draw(false);

                        j += response[2];

                    }

                    $('#chargeursModal').modal('show');

                }


            }, //SUCCESS
            error: function(jqXHR, status, error) {
                    hideloader();
                    mssg(lang, 9, error);

                } //ERROR

        }); //AJAX
    }

});



$('.table-chargeurs').on('click', '.button-chargeurs', function() {

    var tr = $(this).closest('tr');
    var id = $(this).prop('name');

    if (id == id) {
        showloader();

        $.ajax({

            url: './models/Get_chargeurs_model.php',
            type: 'POST',
            data: 'id=' + id,
            dataType: 'json',
            success: function(response) {
                var formulaire = '.form-request-applicant-details';

                hideloader();

                if (response[0] == 0) {

                    $(formulaire + ' input[name="identifiant"]').val(response[3]); //identifiant
                    $(formulaire + ' input[name="nom"]').val(response[4]); //nom
                    $(formulaire + ' input[name="blocked"]').val(response[5]); //blocked
                    $(formulaire + ' input[name="ville"]').val(response[6]); //ville
                    $(formulaire + ' input[name="commune"]').val(response[7]); //commune
                    $(formulaire + ' input[name="adresse_geo"]').val(response[8]); //adresse_geo
                    $(formulaire + ' input[name="NUM_CC"]').val(response[9]); //NUM_CC
                    $(formulaire + ' input[name="TELEPHONE"]').val(response[10]); //TELEPHONE
                    $(formulaire + ' input[name="EMAIL"]').val(response[11]); //EMAIL
                    $(formulaire + ' input[name="BP"]').val(response[12]); //BP
                    console.log(response[4]);

                    $('#chargeursModal').modal('show');

                } else {

                    mssg(lang, 8, response[0]);

                }


            }, //SUCCESS
            error: function(jqXHR, status, error) {
                    hideloader();
                    mssg(lang, 9, error);
                } //ERROR
        }); //AJAX
    }

});

///fonction qui permet de telecharger via url le fichier txt
function download(filename, url, type = 'text/plain') {
    var link = document.createElement("a");
    link.href = window.URL.createObjectURL(new Blob([url], { type }));
    link.setAttribute('href', 'data:text/plain;charset=utf-8,' + encodeURIComponent(url));
    link.setAttribute('download', filename);
    document.body.appendChild(link);
    link.click();
    
}
//
// function downloadURL(url,name){
// 	var link = document.createElement("a");
// 	link.dowload = name;
// 	link.href =url;
// 	link.click();
// }
// function onStartedDownload(id){
// 	console.log(`Started downloading:${id}`);
// }
// function onFailed(error){
// 	console.log(`Dowload failed: ${error}`);
// }

$('.form-ponts').on('click', '#submit-text', function(e) {

    e.preventDefault();
    var datedebut = $('.form-ponts input[name="dateD"]').val();
    var datefin = $('.form-ponts input[name="dateF"]').val();
    var strc = $('.form-ponts select[name="strc"]').val();
    var pont = ponts;
    var userid = userid;
    var cafe = ($('.form-ponts input[name="cafe"]').is(":checked") ? 1 : 0);
    var autres = ($('.form-ponts input[name="autres"]').is(":checked") ? 1 : 0);
    $.ajax({

        url: './models/txt_model.php',
        type: 'POST',
        data: '&debut=' + datedebut + '&fin=' + datefin + '&pont=' + pont + '&cafe=' + cafe + /*'&user_id='+userid+*/ '&autres=' + autres + '&strc=' + strc,
        dataType: 'json',
        success: function(response) {
            hideloader()
            if (response[0] == 0) {
                window.open('models/texte/facturation.txt');
                
            }
            
        }, //SUCCESS
        error: function(jqXHR, status, error) {
            hideloader();
            mssg(lang, 9, error);

        }
    });
});

