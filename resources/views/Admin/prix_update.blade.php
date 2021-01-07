@extends('layouts.app_x')
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('css')

   <style type="text/css">

     .backver{
        background-color: #4CAF50;
        color: white;
     }
   </style>
    <link href="{{ asset('css/layoutCSS.css') }}" rel="stylesheet">

     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/bootstrap3-editable/js/bootstrap-editable.min.js"></script>

@endsection
@section('content')


   <div class="card text-black  mb-3" style=" max-width: 180%;">
                      <div class="card-header backver">
                         <div class="d-inline-block"> <h5>Liste des prix</h5>  </div>

                          <div class="d-inline-block pull-right">
                            <input type="text" id="myInput" name="cont" placeholder="Recherche" style="color:black;" />
                          </div>
                      </div>
          <div class="card-body">

                  <table class="table table-striped " style="background: white">
                    <thead class="thead-primary">
                    <tr class="table100-head">

                    <th scope="col">Nom Produit</th>
                    <th scope="col">Famille</th>
                    <th scope="col">Symbole</th>
                    <th scope="col">Prix en Gdes</th>
                    <th scope="col">Qte Dispo</th>

                  </tr>
                   </thead>
                   <tbody class="thead-light" id="myTable">

                  @foreach($lprix as $lpr)
                     <tr>

                    <td>{{$lpr->produit}}</td>
                    <td>{{$lpr->nomfamille}}</td>
                    <td>{{$lpr->unite}}</td>
                    <td>$<a href="" class="update" data-name="montant" data-type="number" data-pk="{{ $lpr->id }}" data-title="Entrer montant"> {{number_format ($lpr->montant,2)}}</a> Gdes</td>
                    <td>{{$lpr->qte}}</td>
                  </tr>



                      @endforeach
                  </tbody>
                  </table>
              </div>
            </div>
<script type="text/javascript">
  $(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myTable tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});


    $.ajaxSetup({

        headers: {

            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

        }

    });



    $('.update').editable({

           url: '/update-prix',
           type: 'number',
           step: 'any',
           pk: 1,

           name: 'name',

           title: 'Enter name'

    });






</script>


@endSection
