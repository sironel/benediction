@extends('layouts.app')
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


   <div class="card text-black  mb-3" style=" max-width: 180%;">
                      <div class="card-header backver">
                         <div class="d-inline-block"> <h5>Liste des prix</h5>  </div>

                          <div class="d-inline-block pull-right">
                            <input type="text" id="myInput" name="cont" placeholder="Recherche" style="color:black;"/>
                          </div>
                      </div>
          <div class="card-body">

                  <table class="table table-striped " style="background: white">
                    <thead class="thead-primary">
                    <tr class="table100-head">

                    <th scope="col">Nom Produit</th>
                    <th scope="col">Famille</th>
                    <th scope="col">Symbole</th>
                    <th scope="col">Prix</th>

                  </tr>
                   </thead>
                   <tbody class="thead-light" id="myTable">

                  @foreach($lprix as $lpr)
                     <tr>

                    <td>{{$lpr->nomproduit}}</td>
                    <td>{{$lpr->nomfamille}}</td>
                    <td>{{$lpr->symboleUnite}}</td>
                    <td>$ {{$lpr->montant}} Gdes</td>

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

</script>


@endSection
