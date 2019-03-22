$(document).ready(function() {
  var dataTable = $('#table_proposition').DataTable( {
    "processing": true,
    "serverSide": true,
    "language": {
      "sProcessing": "Traitement en cours ...",
      "sLengthMenu": "Afficher _MENU_ lignes",
      "sZeroRecords": "Aucun résultat trouvé",
      "sEmptyTable": "Aucune donnée disponible",
      "sInfo": "Lignes _START_ à _END_ sur _TOTAL_",
      "sInfoEmpty": "Aucune ligne affichée",
      "sInfoFiltered": "(Filtrer un maximum de_MAX_)",
      "sInfoPostFix": "",
      "sSearch": "Chercher:",
      "sUrl": "",
      "sInfoThousands": ",",
      "sLoadingRecords": "Chargement...",
      "oPaginate": {
        "sFirst": "Premier", "sLast": "Dernier", "sNext": "Suivant", "sPrevious": "Précédent"
      },
      "oAria": {
        "sSortAscending": ": Trier par ordre croissant", "sSortDescending": ": Trier par ordre décroissant"
      }
    } ,
    "ajax":{
      url :"proposition_data.php", // json datasource
      type: "post",  // method  , by default get
      dataFilter: function(reps) {
        console.log(reps);
        return reps;
      },
      error:function(err){
        console.log(err);
      },
      error: function(){  // error handling
        $(".table_proposition-error").html("");
        $("#table_proposition").append('<tbody class="table_proposition-error"><tr><th colspan="3">Pas de données trouvées sur le serveur</th></tr></tbody>');
        $("#table_proposition_processing").css("display","none");

      }
    }
  } );
} );
