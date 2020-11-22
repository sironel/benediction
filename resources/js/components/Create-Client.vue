<template>
    <div class="container">

       
       <table class="table table-striped">
          <tbody>
             <tr>
                <td colspan="1">
                   <form class="well form-horizontal" v-on:submit.prevent="storeClient">
                      <fieldset>
                         <div class="form-group">
                            <label class="col-md-4 control-label">Nom</label>
                            <div class="col-md-8 inputGroupContainer">
                               <div class="input-group"><span class="input-group-addon" ><i class="glyphicon glyphicon-user"></i></span><input id="nom" name="nom" placeholder="Full Name" class="form-control" required="true" value="" type="text" v-model="clients.nom"></div>
                            </div>
                         </div>
                        
                         <div class="form-group">
                            <label class="col-md-4 control-label">Ville</label>
                            <div class="col-md-8 inputGroupContainer">
                               <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span><input id="ville" name="ville" placeholder="Address Line 2" class="form-control" required="true" value="" type="text" v-model="clients.ville"></div>
                            </div>
                         </div>
                         
                         <div class="form-group">
                            <label class="col-md-4 control-label">Telephone</label>
                            <div class="col-md-8 inputGroupContainer">
                               <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span><input id="telephone" name="telephone" placeholder="State/Province/Region" class="form-control" required="true" value="" type="text" v-model="clients.telephone"></div>
                            </div>
                         </div>                     
                                             
                         
                      </fieldset>
                   </form>
                </td>
                <td colspan="1">
                   <form class="well form-horizontal" >
                      <fieldset>
                          <div class="form-group">
                            <label class="col-md-4 control-label">Prenom</label>
                            <div class="col-md-8 inputGroupContainer">
                               <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span><input id="prenom" name="prenom" placeholder="Address Line 1" class="form-control" required="true" value="" type="text" v-model="clients.prenom"></div>
                            </div>
                         </div>
                         <div class="form-group">
                            <label class="col-md-4 control-label">Adresse</label>
                            <div class="col-md-8 inputGroupContainer">
                               <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span><input id="adresse" name="adresse" placeholder="City" class="form-control" required="true" value="" type="text" v-model="clients.adresse"></div>
                            </div>
                         </div>
                          <div class="form-group">
                            <label class="col-md-2 control-label">sexe</label>
                            <input type="radio" name="sexe" value="1" class="ml-2" checked="checked" v-model="clients.sexe"> Masculin
                             <input type="radio" name="sexe" value="0" class="ml-2" v-model="clients.sexe"> Feminin
                           
                         </div>                
                        </fieldset>
                         <button class="btn btn-primary" type="submit" v-on:click="storeClient">Enregistrer</button>
                   </form>
                </td>
             </tr>
             
          </tbody>
       </table>
       
       <table class="table table-stripped">

                <thead>


               <tr>
                  <th>/</th>
                    <th>Action</th>
                    <th>Id</th>
                    <th>Nom</th>
                    <th>Prenom</th>
                    <th>Adresse</th>
                    <th>Ville</th>
                    <th>Telephone</th>
                    <th>Sexe</th>
                  </tr>
               </thead>
                <tbody>
                  <tr v-for="client in lclients" :key="client.id">
                   <td> <input type="checkbox" name="" id="check"></td>
                    <td>
                     <button class="btn btn-warning btn-sm" v-on:click="deleteClient(client.id)">Delete</button>
                     <button class="btn btn-primary btn-sm">Update</button>
                    </td>
                    <td>{{client.id}}</td>
                    <td>{{client.nom}}</td>
                    <td>{{client.prenom}}</td>
                    <td>{{client.adresse}}</td>
                    <td>{{client.ville}}</td>
                    <td>{{client.telephone}}</td>
                    <td>{{client.sexe}}</td>
                    <!-- <td> <button v-on:click="commander(prod)">Commander</button></td> -->
                  </tr>
                </tbody>
              </table>
               </div>
</template>

<script>

    export default {
       mounted(){this.getClient();},
        data:function(){
           return {
              clients:{nom:'', prenom:'', adresse:'', ville:'', telephone:'', sexe:1},
              lclients:[]
           }
       
        },
         methods: {
           storeClient:function(){
              let uri='clients/';
              
              Axios.put(uri, this.clients).then((response)=>{
                 console.log(response);
                 this.lclients.push(response.data);
              })

           },
           getClient:function(){
              let uri='getclients/';
              
              Axios.post(uri).then((response)=>{
                 console.log(response.data);
                 
                 this.lclients=response.data;
              })  
           },
           deleteClient:function(id){
              let uri='delclient/'+id;
              if(confirm('Etes-vous sure...?')){
              Axios.get(uri).then((response)=>{
                 console.log(response.data);
                 
                 this.getClient();
              }) 
             } 
           }
        }
        
    }
</script>
