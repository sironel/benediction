@extends('layouts.app_adm')

<style type="text/css">

  body > table{
    width: 80%;
}

table{
    border-collapse: collapse;
}
table.list{
    width:100%;
}

td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}
tr:nth-child(even),table.list thead>tr {
    background-color: #dddddd;
}

input[type=text], input[type=number] {
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

input[type=submit]{
    width: 30%;
    background-color: #ddd;
    color: #000;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

form div.form-action-buttons{
    text-align: right;
}

a{
    cursor: pointer;
    text-decoration: underline;
    color: #0000ee;
    margin-right: 4px;
}

label.validation-error{
    color:   red;
    margin-left: 5px;
}

.hide{
    display:none;
}
</style>

<style type="text/css">

     .backver{
        background-color: #4CAF50;
        color: white;
     }



</style>
 <link href="{{ asset('css/layoutCSS.css') }}" rel="stylesheet">

@section('content')



    <div class="container">
        <h4 class="backver p-2">Gestion des Fournisseurs</h4>
    <div class="row">




          <div class="col-md-4">
                <form onsubmit="event.preventDefault();onFormSubmit();" autocomplete="off">
                    <div>
                        <label>Nom*</label><label class="validation-error hide" id="fullNameValidationError">This field is required.</label>
                        <input type="text" name="nomf" id="nomf">
                    </div>
                    <div>
                        <label>Adresse</label>
                        <input type="text" name="adresse" id="adresse">
                    </div>
                    <div>
                        <label>Email</label>
                        <input type="text" name="email" id="email">
                    </div>
                    <div>
                        <label>Telephone</label>
                        <input type="text" name="telephone" id="telephone">
                        <input type="text"  id="ident" style="display: none;" value="">
                    </div>

                    <div  class="form-action-buttons">
                        <span class="pull-left mt-4 ml-4" id="chargement" style="display: none;">
                          <img src="{{asset('images/loading1.gif')}}" width="20">
                        </span>
                        <input class="btn"  type="submit" value="Ajouter">
                    </div>


                </form>
           </div>
               <div class="col-md-8">
                <table class="list" id="employeeList">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Adresse</th>
                            <th>Email</th>
                            <th>Telephone</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($four as $fo)
                            <tr>
                                <td>{{$fo->nomf}}</td>
                                <td>{{$fo->adresse}}</td>
                                <td>{{$fo->email}}</td>
                                <td>{{$fo->telephone}}</td>
                                <td>
                                    <a id="e{{$fo->id}}" onClick="onEdit(this)">Edit</a>
                                    <a id="d{{$fo->id}}" onClick="onDelete(this)">Delete</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
  </div>

</div>



<script src="https://unpkg.com/scrollreveal"></script>
<script type="text/javascript">
const sr = ScrollReveal();
sr.reveal('#employeeList',{
  duration : 1500,
  rotate: { x: 10, y: 20, z: 30 },
  reset: true
});

sr.reveal('.btn',{
  duration : 1500,
  reset: true,
  rotate: { x: 10, y: 20, z: 90 },
  easing: 'cubic-bezier( 0.6, 0.2, 0.1, 1 )',
  delay:500
});

var selectedRow = null;
var obj = null;

function onFormSubmit() {
    if (validate()) {
        var formData = readFormData();
        if (selectedRow == null){
            f_toggle();
            sendData(formData);
            setTimeout(f_toggle, 3000);
            //f_toggle();
        }
        else{
            f_toggle();
            var id= document.getElementById("ident").value;
            updateData(formData, id);
            f_toggle();
        }
        resetForm();
    }
}

function readFormData() {
    var formData = {};
    formData["nomf"] = document.getElementById("nomf").value;
    formData["adresse"] = document.getElementById("adresse").value;
    formData["email"] = document.getElementById("email").value;
    formData["telephone"] = document.getElementById("telephone").value;
    formData["_token"]= "{{ csrf_token() }}";
    return formData;
}

function sendData(data){

  $.ajax({
    type: "POST",
    url: '/fournisseurs',
    data: data,
    success: function() {
      console.log("ok");

      insertNewRecord(data);
    }
  });
}

function updateData(data, id){

  $.ajax({
    type: "PUT",
    url: 'fournisseurs/'+id,
    data: data,
    success: function(data) {
      console.log("ok");
       selectedRow=obj;
      updateRecord(data);
    }
  });
}

function deleteData( id){

  $.ajax({
    type: "DELETE",
    url: 'fournisseurs/'+id,
    data: {_token:"{{csrf_token()}}"},
    success: function(data) {
      console.log("ok");
    }
  });
}


function insertNewRecord(data) {
    var table = document.getElementById("employeeList").getElementsByTagName('tbody')[0];
    var newRow = table.insertRow(table.length);
    cell1 = newRow.insertCell(0);
    cell1.innerHTML = data.nomf;
    cell2 = newRow.insertCell(1);
    cell2.innerHTML = data.adresse;
    cell3 = newRow.insertCell(2);
    cell3.innerHTML = data.email;
    cell4 = newRow.insertCell(3);
    cell4.innerHTML = data.telephone;
    cell4 = newRow.insertCell(4);
    cell4.innerHTML = '<a id="e'+data.id+'" onClick="onEdit(this)">Edit</a><a id="d'+data.id+'" onClick="onDelete(this)">Delete</a>';


}

function resetForm() {
    document.getElementById("nomf").value = "";
    document.getElementById("adresse").value = "";
    document.getElementById("email").value = "";
    document.getElementById("telephone").value = "";
    selectedRow = null;
}

function onEdit(td) {
    selectedRow = td.parentElement.parentElement;

    document.getElementById("nomf").value = selectedRow.cells[0].innerHTML;
    document.getElementById("adresse").value = selectedRow.cells[1].innerHTML;
    document.getElementById("email").value = selectedRow.cells[2].innerHTML;
    document.getElementById("telephone").value = selectedRow.cells[3].innerHTML;
    document.getElementById("ident").value = td.id.substring(1);
   obj =td.parentElement.parentElement;



}

function updateRecord(formData) {

    selectedRow.cells[0].innerHTML = formData.nomf;
    selectedRow.cells[1].innerHTML = formData.adresse;
    selectedRow.cells[2].innerHTML = formData.email;
    selectedRow.cells[3].innerHTML = formData.telephone;
}



function onDelete(td) {
    if (confirm('Voulez-vous vraiment supprimer ce fournisseur?')) {
        deleteData(td.id.substring(1));
        row = td.parentElement.parentElement;
        document.getElementById("employeeList").deleteRow(row.rowIndex);
        resetForm();
    }
}

function validate() {
    isValid = true;
    if (document.getElementById("nomf").value == "") {
        isValid = false;
        document.getElementById("fullNameValidationError").classList.remove("hide");
    } else {
        isValid = true;
        if (!document.getElementById("fullNameValidationError").classList.contains("hide"))
            document.getElementById("fullNameValidationError").classList.add("hide");
    }
    return isValid;
}

function f_toggle() {
  var x = document.getElementById("chargement");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
}

</script>
@endsection
