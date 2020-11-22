@extends('layouts.app_adm')
<style type="text/css">

     .backver{
        background-color: #4CAF50;
        color: white;
     }
  .mystyle{
        background-color: #4CAF50;
        color: white;
     }
.scroll{
  max-height: 300px;
  max-width:  300px;
  overflow: scroll;
}
table {
  display: block;
    max-height: 200px;
    overflow-y: auto;
  //overflow: scroll;
  //overflow: auto;
}

</style>
 <link href="{{ asset('css/layoutCSS.css') }}" rel="stylesheet">

@section('content')

<!-- <div class="container"> -->
        <h4 class="backver p-2">Gestion des Achats</h4>
    <div class="row">
          <div class="col-md-4 mb-2">

              <div class="card p-2">

                    <div>
                        <label><h4>Fournisseurs</h4></label>
                        <input type="text" id="myInput" onkeyup="search_table('employeeList','myInput')" style="color:black;" placeholder=" Recherche..." name="cont"/>
                    </div>
                    <table class="table table-striped list" id="employeeList">
                    <thead>
                        <tr >
                            <th>Fournisseur</th>
                            <th>Telephone</th>
                        </tr>
                    </thead>
                    <tbody id="fourni">
                        @foreach($four as $fo)
                            <tr onclick="selectligne(this)" id="{{$fo->id}}">
                                <td>{{$fo->nomf}}</td>
                                <td>{{$fo->telephone}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

           </div>

        </div>



           <div class="col-md-4">
                  <div class="card p-2 ">
                    <div>
                        <label><h5>Produits Unités</h5></label>
                         <input type="text" id="myInpu" style="color:black;" onkeyup="search_table('puList','myInpu')"placeholder=" Recherche..." name="cont"/>
                    </div>
                   <table class="table table-striped list "  id="puList">
                    <thead>
                        <tr>
                            <th>Produit / Unité</th>

                        </tr>
                    </thead>
                    <tbody id="produit">
                        @foreach($produ as $pu)
                            <tr onclick="selectligne(this)" id="{{$pu->id}}">
                                <td>({{$pu->nomfamille}}) {{$pu->nomproduit}} / {{$pu->nomUnite}}</td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>

           </div>
          </div>


           <div class="col-md-4 ">
                   <div class="card p-2">

                    <div>
                        <label><h5>Achat</h5></label>

                    </div>
                <form onsubmit="event.preventDefault();onFormSubmit();" autocomplete="off">
                   <div>
                        <label>Quantité</label>
                        <input type="number" name="quantite" onkeypress="return onlyNumberKey(event)"  id="quantite" placeholder="0.00" lang="nb" step="any" class="two-decimals">

                    </div>

                    <div>
                        <label>Prix* </label>
                        <input type="number" onkeypress="return onlyNumberKey(event)" step="0.5" placeholder="0.00" lang="nb" name="prix" id="prix">
                    </div>
                    <div>
                        <label>Frais</label>
                        <input type="number" onkeypress="return onlyNumberKey(event)" step="0.5"  name="frais" id="frais" placeholder="0.00" lang="nb">
                    </div>

                    <div>
                        <label>Profit</label>
                        <input type="number" step="0.5" onkeypress="return onlyNumberKey(event)"  name="profit" id="profit" placeholder="0.00" lang="nb">
                    </div>
                    <div>

                        <label>Livré</label>
                        <input type="checkbox" name="livre" id="livre" onclick="myFunction()">

                    </div>
                    <div  class="form-action-buttons">
                        <input class="btn btn-primary"  type="submit" value="Ajouter" placeholder="0.00" lang="nb">
                    </div>
              </form>

           </div>
          </div>
        </div>
        <div class="row">
            <div>
                        <label><h5>Produits Achetés</h5></label>
                         <input type="text" id="buyInput" style="color:black;" onkeyup="search_table('achatList','buyInput')"placeholder=" Recherche..." name="cont"/>
                    </div>
                   <table class="table table-striped list "  id="achatList">
                    <thead>
                        <tr>
                            <th>Quantite</th>
                            <th>Unite</th>
                            <th>Produit</th>
                            <th>Prix</th>
                            <th>Frais</th>
                            <th>Profit</th>
                            <th>Livré</th>
                            <th>Date</th>

                        </tr>
                    </thead>
                    <tbody id="achat">
                        @foreach($achats as $achat)
                            <tr onclick="selectligne(this)" id="{{$achat->id}}">
                                <td>{{$achat->quantite}}</td>
                                <td>{{$achat->unite}}</td>
                                <td>{{$achat->produit}}</td>
                                <td>{{$achat->prix}}</td>
                                <td>{{$achat->frais}}</td>
                                <td>{{$achat->profit}}</td>
                                <td>{{$achat->livre}}</td>
                                <td>{{$achat->date_achat}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

        </div>

    <script type="text/javascript">

function search_table(tableid,inputid){
  // Declare variables
  var input, filter, table, tr, td, i;
  input = document.getElementById(inputid);
  filter = input.value.toUpperCase();
  table = document.getElementById(tableid);
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td") ;
    for(j=0 ; j<td.length ; j++)
    {
      let tdata = td[j] ;
      if (tdata) {
        if (tdata.innerHTML.toUpperCase().indexOf(filter) > -1) {
          tr[i].style.display = "";
          break ;
        } else {
          tr[i].style.display = "none";
        }
      }
    }
  }
}


var fournisseur_id, produituniteid;
var livre = false;

function selectligne(tr){
 var tab = document.getElementById(tr.id).parentNode.id;
 if (tab == 'fourni')
  fournisseur_id = tr.id;
else
  produituniteid = tr.id;
   tr.style.background = '#4CAF50';
   tr.style.color= 'white';
   var rows=getSiblings(tr);
   rows.forEach(element =>element.style.color = '');
   rows.forEach(element =>element.style.background = '');
}

var getSiblings = function (elem) {
    var siblings = [];
    var sibling = elem.parentNode.firstChild;
    var skipMe = elem;
    for ( ; sibling; sibling = sibling.nextSibling )
       if ( sibling.nodeType == 1 && sibling != elem )
          siblings.push( sibling );
    return siblings;
}

 function onlyNumberKey(evt) {

        // Only ASCII charactar in that range allowed
        var ASCIICode = (evt.which) ? evt.which : evt.keyCode
        if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
            return false;
        return true;
    }

    function myFunction()
    {
      var checkBox = document.getElementById("livre");
      if (checkBox.checked == true)
         livre = true;
       else
         livre = false;
     }

    </script>




@endsection
