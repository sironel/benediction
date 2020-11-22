@extends('layouts.app_adm')
@section('css')

   <style type="text/css">

     .backver{
        background-color: #4CAF50;
        color: white;
     }
   </style>
    <link href="{{ asset('css/layoutCSS.css') }}" rel="stylesheet">
@endsection
@section('content')
       <div class="row">

        <div class="col-md-10 infoblock">
            <div class="card p-0">
                <div class="card-header backver">Gestion Article</div>
                <div class="card-body">

                   <div class="row">
                      <div class="col-md-3 infoblock">
                        <div class="card m-0 p-0">
                          <div class="card-body m-1 p-1">
                                <form class="form-inline" method="POST" action="{{ route('familles.store') }}">
                                @csrf
                              <div class="form-group mx-sm-0 mb-2 col-xs-2">

                                <input type="text" style="width: 100px;text-transform: capitalize;" class="form-control" id="fam" placeholder="Famille" >
                              </div>
                              <button type="submit" class="btn btn-primary mb-2" id="b_famille">ok</button>
                            </form>

                             <div class="form-group">
                               <label for="exampleFormControlSelect2">Selectionner Famille*</label>
                                <select  class="form-control" id="famille">
                                    @foreach($familles as $famille)
                                      <option value="{{$famille->id}}">{{$famille->nomfamille}}</option>
                                    @endforeach
                                </select>
                              </div>
                          </div>
                        </div>

                      </div>

                      <div class="col-md-6 infoblock">
                         <div class="card m-0 p-0">
                          <div class="card-body m-1 p-1">
                            <form method="POST" action="{{ route('produits.store') }}">
                                @csrf
                              <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-3 col-form-label">Article*</label>
                                <div class="col-sm-9">
                                  <input type="text" style="text-transform: capitalize;" class="form-control" id="article" placeholder="article">
                                </div>
                              </div>
                              <div class="form-group row">
                                <label for="inputPassword3" class="col-sm-3 col-form-label mr-0 pr-0">Description</label>
                                <div class="col-sm-9">
                                  <input type="text" class="form-control" id="description" placeholder="Description">
                                </div>
                              </div>

                               <div class="form-group row">
                                <div class="col-sm-10">
                                  <button type="submit" class="btn btn-primary" id="b_produit">Inserer</button>
                                   <div id="chargement" style="display: none;">
                                    <img src="{{asset('images/siro_loading.gif')}}" width="20"> Chargement en cours...
                                </div>
                                <div id="uniteshow"></div>

                                </div>
                              </div>
                            </form>
                        </div>
                       </div>
                      </div>
                      <!-- 3e colonne---------------------------------------------------- -->
                      <div class="col-md-3 infoblock">

                        <div class="card m-0 p-0">
                          <div class="card-body m-1 p-1">

                             <div class="form-group">
                               <label for="exampleFormControlSelect2">Selectionner Unité *</label>
                                <select multiple="" class="form-control" size="5" id="unite">
                                   @foreach($unites as $unite)
                                      <option value="{{$unite->id}}">{{$unite->nomUnite}}</option>
                                    @endforeach
                                </select>
                              </div>

                              <div class="form-group row">
                                <label for="montant" class="col-sm-3 col-form-label mr-0 pr-0">Prix</label>
                                <div class="col-sm-9">
                                  <input type="text" class="form-control" id="montant" name="montant" placeholder="0.00">
                                </div>
                              </div>

                          </div>
                        </div>

                      </div>
                   </div>

                   <!-- fin row ---------------------------------------------- -->

                    <div class="row">
                      <br>
                      <div class="col-md-12 infoblock">
                          <div class="card ">
                              <div class="card-header backver pl-3 p-1" id="hlist"> {{$produitCount}} Article(s) enregistré(s)</div>
                              <div class="card-body" style="height: 200px; overflow-x: scroll; width: 100%;">
                                  <div class="table-responsive">
                                   <table class="table table-striped">
                                      <thead>
                                        <tr>


                                          <th scope="col">Article</th>
                                          <th scope="col">Famille</th>
                                          <th scope="col">Action</th>
                                        </tr>
                                      </thead>
                                      <tbody id="list_prod">
                                         @foreach($produits as $produit)
                                          <tr id="ligne{{$produit->id}}">

                                            <td id="nomp{{$produit->id}}">{{$produit->nomproduit}}</td>
                                            <td id="famillep{{$produit->id}}">{{$produit->famille_produit_id}}</td>
                                            <td>
                                             <a class="editModalLink" data-value="{{$produit->id}}" href="# p-1" title="editer article"> <img src="images/edit.png" width="20"> </a>
                                             <a class="imgModalLink" data-value="{{$produit->id}}" href="#" title="upload image"> <img src="images/image.png" width="20"> </a>
                                             <a class="confirmModalLink" data-value="{{$produit->id}}" href="#" title="supprimer article"> <img src="images/del.png" width="20"> </a>

                                          </td>
                                          </tr>
                                         @endforeach

                                      </tbody>
                                    </table>
                                  </div>
                              </div>
                          </div>
                      </div>
                    </div>

                </div>
           </div>
        </div>
     <!-- Colonne 2    ---------------------------------------->
          <div class="col-md-2 infoblock m-0 p-0">
             <div class="card">
                <div class="card-header backver">Aide...</div>
                <div class="card-body aide" style="color:green;">
                    Dans cette fenetre, la possibilite de gerer les articles,
                    <ul>
                      <li>inserer une nouvelle famille d'article</li>
                      <li>inserer un nouvel article</li>
                      <li>modifier et supprimer un article</li>
                      <li>Associer une image à l'article</li>
                    </ul>

                    <hr>

                </div>
             </div>
          </div>
        </div>

<!-- form modal modification  -->

<div class="container">

    <div class="modal fade" id="formulaire">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Modifier cet article :</h4>
            <button type="button" class="close" data-dismiss="modal">
              <span>&times;</span>
            </button>
          </div>
          <div class="modal-body row">
            <form class="col" action="test.php">
              <div class="form-group">
                <label for="article" class="form-control-label">Article</label>
                <input type="text" class="form-control" name ="article" id="articl" placeholder="article">
              </div>
              <div class="form-group">
                <label for="description" class="form-control-label">Description</label>
                <input type="text" class="form-control" name="description" id="descriptio" placeholder="Description">
              </div>
               <div class="form-group">
                 <label for="exampleFormControlSelect2">Selectionner Famille*</label>
                  <select  class="form-control" id="famill">
                      @foreach($familles as $famille)
                        <option value="{{$famille->id}}">{{$famille->nomfamille}}</option>
                      @endforeach
                  </select>
                </div>
              <button type="submit" class="btn btn-primary pull-right" id="b_edit">Modifier</button>
            </form>
          </div>
        </div>
      </div>
    </div>
</div>
<!-- form modal suppression  -->


<div class="modal fade" id="confirmModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-body">
         Voulez-vous vraiment supprimer cet article?
      </div>
      <div class="modal-footer">
      <a href="#" class="btn" id="confirmModalNo">Non</a>
      <a href="#" class="btn btn-primary" id="confirmModalYes">Oui</a>
    </div>
    </div>
  </div>
</div>

<!-- upload image  -->



<!-- Modal  upload------------------------------>
<div id="uploadModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">upload image article</h4>
      </div>
      <div class="modal-body">
        <!-- Form -->
        <form method='post' action='upload' enctype="multipart/form-data">
          Select file : <input type='file' name='file' id='file' class='form-control' ><br>
          <input type='button' class='btn btn-info' value='Upload' id='btn_upload'>
        </form>

        <!-- Preview-->
        <div id='preview'></div>
      </div>

    </div>

  </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
     var somprod = '<?php echo $produitCount; ?>';
     $('#article').click(function(){
        $('.aide').text("Saisie le nom d'un nouvel article.");
      });
     $('#fam').click(function(){
        $('.aide').text("Saisie le nom d'une nouvelle famille d'article.");
      });
     $('#famille').click(function(){
        $('.aide').text("Selectionner une famille pour cet article.");
      });
     $('#unite').click(function(){
        $('.aide').text("Selectionner une ou plusieurs unités de vente pour cet article.");
      });
      $('#description').click(function(){
        $('.aide').text("Saisie une description pour cet article. ");
      });
      $('.imgModalLink').click(function(){
        var id = $(this).data("value");
        $('.aide').text("Upload une image pour l'article ID:"+id+". ");
      });
     $('.confirmModalLink').click(function(){
      var id = $(this).data("value");
        $('.aide').text("Supprimer l'article ID:"+id+". ");
      });
      $('.editModalLink').click(function(){
        var id = $(this).data("value");
        $('.aide').text("Modifier l'article ID:"+id+". ");
      });

// ----------------ajouter famille---------------------------------------

      $("#b_famille").click(function (e) {
        if(($('#fam').val()).length==0){
          alert("il faut saisir une famille d'article");
          return false;
        }
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        e.preventDefault();
        var type = "POST";
        var ajaxurl = '/familles';

        $.ajax({
            type: type,
            url: ajaxurl,
            data: {nomfamille : $('#fam').val()},
            dataType: 'json',
            success: function (data) {
              $('#fam').val('');
               var fa = ' <option value="'+data.id+'">'+data.nomfamille+'</option>';
               $('#famille').prepend(fa);
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });

// ------------------------ Saisie de nouvel article -----------------------

$("#b_produit").click(function (e) {
       if(($('#famille').val()).length==0 || ($('#unite').val()).length==0 || ($('#article').val()).length==0 ){

        alert('Il faut remplir les champs obligatoires.');
        return false ;
      }
      $('#chargement').show();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        e.preventDefault();
        var type = "POST";
        var ajaxurl = '/produits';

        $.ajax({
            type: type,
            url: ajaxurl,
            data: {nomproduit : $('#article').val(),
                   famille_produit_id:  $('#famille').val(),
                   unite_id:  $('#unite').val(),
                   description:  $('#description').val(),
                   photo:  $('#photo').val(),
                   montant:  $('#montant').val()
          },
            dataType: 'json',
            success: function (data1) {
              somprod++;
              $('#hlist').text(somprod +' Article(s) enregistré(s)')
              var ligne = ' <tr><td>'+data1.nomproduit+'</td><td>'+data1.famille_produit_id+'</td><td><a class="editModalLink" data-value="'+data1.id+'" href="# p-1" title="editer article"><img src="images/edit.png" width="20"> </a><a class="imgModalLink" data-value="'+data1.id+'" href="#" title="upload image"> <img src="images/image.png" width="20"> </a><a class="confirmModalLink" data-value="'+data1.id+'" href="#" title="supprimer article"> <img src="images/del.png" width="20"> </a>   </td></tr>';

               $('#list_prod').prepend(ligne);
               $('#article').val('');
               $('#unite').val('');

                $('#chargement').hide();
            },
            error: function (data1) {
                console.log('Error:', data1);
            }
        });
    });


// ------------------------ Modification article -----------------------

$("#b_edit").on("click",  function (e) {
       if(($('#famill').val()).length==0 || ($('#articl').val()).length==0 ){

        alert('Il faut remplir les champs obligatoires.');
        return false ;
      }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        e.preventDefault();
        var type = "PUT";
        var ajaxurl = '/produits/'+id;

        $.ajax({
            type: type,
            url: ajaxurl,
            data: {nomproduit : $('#articl').val(),
                   famille_produit_id:  $('#famill').val(),
                   unite_id:  $('#unite').val(),
                   description:  $('#descriptio').val(),

          },
            dataType: 'json',
            success: function (data1) {
              console.log('success:', data1);
             $('#nomp'+data1.id).text(data1.nomproduit);
             $('#famillep'+data1.id).text(data1.famille_produit_id);
             $('#formulaire').modal('hide');
            },
            error: function (data1) {
                console.log('Error:', data1);
            }
        });
    });

// ---------------------------- edit article -----------------

 $(function(){
    $('form').submit(function(e) {
      e.preventDefault()
      var $form = $(this)
      $.post($form.attr('action'), $form.serialize())
      .done(function(data) {
        $('#html').html(data)
        $('#formulaire').modal('hide')
      })
      .fail(function() {
        alert('ça ne marche pas...')
      })
    })
    $('.modal').on('shown.bs.modal', function(){
      $('input:first').focus()
    })
  })

// ------------- show modal upload et edit---------------
 var id=0;
 $(function(){
    $(document).on("click", "a.imgModalLink" , function (e) {
      id = $(this).data("value");
      $('#uploadModal').modal('show')
    })
    $('.closemodal').click(function() {
      $('#uploadModal').modal('hide')
    })
  })

$(function(){
    $(document).on("click", "a.editModalLink" , function (e) {
       id = $(this).data("value");

        $.ajax(
        {
            url: "/produits/"+id+"/edit",
            type: 'GET',
            dataType: "JSON",
            data: { "_token": "{{ csrf_token() }}",
                      "id": id},
            success: function (data)
            {
               $('#articl').val(data.nomproduit);
                $('#descriptio').val(data.description);
                $('#famill').val(data.famille_produit_id);
                $('#formulaire').modal('show')

            }
        });

    })
    })

    $('.closemodal').click(function() {
      $('.formulaire').modal('hide')
    })


 // -------------------supprimer ------------------------



  $(document).on("click", "a.confirmModalLink" , function (e) {
        e.preventDefault();
         id = $(this).data("value");
        $("#confirmModal").modal("show");
    });

    $("#confirmModalNo").click(function(e) {
        $("#confirmModal").modal("hide");
    });

    $("#confirmModalYes").click(function(e) {

        $.ajax(
        {
            url: "/produits/"+id,
            type: 'DELETE',
            dataType: "JSON",
            data: { "_token": "{{ csrf_token() }}",
                      "id": id},
            success: function (data)
            {
              $('.aide').text("l'article ID:"+data.id+" a été supprimé. ");
              $('#ligne'+data.id).remove();
              $('#hlist').text(data.nbproduit + " Article(s) enregistré(s)");

                $("#confirmModal").modal("hide");
                console.log("it Work");

            }
        });

    });



// --------------upload image------------------------

$('#btn_upload').click(function(e){
  var fd = new FormData();
  jQuery.each(jQuery('#file')[0].files, function(i, file) {
      fd.append('file-'+i, file);
  });


     $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        e.preventDefault();
    // AJAX request
    $.ajax({
      url: '/upload/'+id,
      type: 'post',
      method: 'post',
      data:fd,
      contentType: false,
      processData: false,
      success: function(response){
        if(response != 0){
          // Show image preview
          $('.aide').append("<img src='"+response.photoPath+"' width='50' height='50' style='display: inline-block;'>");
        }else{
          alert('file not uploaded');
        }
      }
    });
  });


///////////////////////CHOIX unite

$('#unite').click(function(){
  $('#uniteshow').text($('#unite option:selected').text()+" ");

});


  });

</script>

@endsection
