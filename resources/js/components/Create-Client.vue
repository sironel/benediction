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
                               <div class="input-group"><span class="input-group-addon" ><i class="glyphicon glyphicon-user"></i></span>
                               <input id="nom" name="nom" placeholder="Nom" class="form-control" required="true" value="" type="text" v-model="clients.nom"></div>
                            </div>
                         </div>

                         <div class="form-group">
                            <label class="col-md-4 control-label">Ville</label>
                            <div class="col-md-8 inputGroupContainer">
                               <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span><input id="ville" name="ville" placeholder="Ville" class="form-control" required="true" value="" type="text" v-model="clients.ville"></div>
                            </div>
                         </div>

                         <div class="form-group">
                            <label class="col-md-4 control-label">Telephone</label>
                            <div class="col-md-8 inputGroupContainer">
                               <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span><input id="telephone" name="telephone" placeholder="Telephone" class="form-control" required="true" value="" type="text" v-model="clients.telephone"></div>
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
                               <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span><input id="prenom" name="prenom" placeholder="Prenom" class="form-control" required="true" value="" type="text" v-model="clients.prenom"></div>
                            </div>
                         </div>
                         <div class="form-group">
                            <label class="col-md-4 control-label">Adresse</label>
                            <div class="col-md-8 inputGroupContainer">
                               <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span><input id="adresse" name="adresse" placeholder="Adresse" class="form-control" required="true" value="" type="text" v-model="clients.adresse"></div>
                            </div>
                         </div>
                          <div class="form-group">
                            <label class="col-md-2 control-label">sexe</label>
                            <input type="radio" name="sexe" value="1" class="ml-2" v-model="clients.sexe"> Masculin
                            <input type="radio" name="sexe" value="0" class="ml-2" v-model="clients.sexe"> Feminin

                         </div>
                        </fieldset>
                         <button class="btn btn-primary" type="submit" v-on:click="storeClient">
                           <div v-if="loading" class="spinner-border spinner-border-sm" ></div>
                           <span v-if="loading" class="px-1">Encours</span>
                           <span v-else>{{btext}}</span>

                         </button>
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
                     <button class="btn btn-warning btn-sm" v-on:click="deleteClient(client)">
                        <div v-if="id=='del'+client.id" class="spinner-border spinner-border-sm" ></div>
                        <span v-if="id=='del'+client.id" class="px-1">En cours</span>
                        <span v-else>Delete</span>
                     </button>
                     <button class="btn btn-primary btn-sm" v-on:click="editClient(client)">
                        <div v-if="id=='edit'+client.id" class="spinner-border spinner-border-sm" ></div>
                        <span v-if="id=='edit'+client.id" class="px-1">En cours</span>
                        <span v-else>Edit</span>
                     </button>

                    </td>
                    <td>{{client.id}}</td>
                    <td>{{client.nom}}</td>
                    <td>{{client.prenom}}</td>
                    <td>{{client.adresse}}</td>
                    <td>{{client.ville}}</td>
                    <td>{{client.telephone}}</td>
                    <td>
                      <span v-if="client.sexe==0">F</span>
                      <span v-else>M</span>
                    </td>
                  </tr>
                </tbody>
              </table>
               </div>
</template>

<script>

    export default {
       mounted(){
          this.getClient();
           },
        data:function(){
           return {
              loading:false,
              id:0,
              client_id :'',
              edit :false,
              btext:'Enregistrer',
              clients:{nom:'', prenom:'', adresse:'', ville:'', telephone:'', sexe:'1'},
              lclients:[]
           }

        },
         methods: {
            checkForm: function () {
               if (this.clients.nom=='' )
               return false;
               return true;
             },
               getClient:function(){
              let uri='getclients/';

              Axios.post(uri).then((response)=>{
                 console.log(response.data);

                 this.lclients=response.data;
              })
           },

             editClient:function(client){
              this.edit = true;
              this.btext = 'Modifier';
               this.id='edit'+client.id;
               this.client_id = client.id;
              this.clients.nom = client.nom;
              this.clients.prenom = client.prenom;
              this.clients.ville = client.ville;
              this.clients.adresse = client.adresse;
              this.clients.telephone = client.telephone;
              this.clients.sexe = client.sexe;
               this.id=0;
           },

           storeClient:function(){
               if(!this.edit){
                 let uri='clients/';
            if(this.checkForm()){
               this.loading = !false;
              Axios.put(uri, this.clients).then((response)=>{
                 console.log(response);
                 this.lclients.push(response.data.data);
                 this.loading = !true;
                 this.$toastr.s("Client enregistré avec succes", "Message Benediction");

              }).catch(error => {
                  this.$toastr.e("Echec de l'opération...", "Message Benediction");
              })
            }
            else
              this.$toastr.s("Il faut remplir certain champ", "Message Benediction");
              }

            else{
               let uri='editclient/'+this.client_id;
            if(this.checkForm()){
               this.loading = !false;
              Axios.put(uri, this.clients).then((response)=>{
                 console.log(response);
                     this.getClient();
                   this.loading = !true;
                 this.$toastr.s("Client modifié avec succes", "Message Benediction");
                  this.edit = false;
                  this.btext = 'Enregistrer';
              }).catch(error => {
                  this.$toastr.e("Echec de la modification...", "Message Benediction");
                          this.edit = false;
                          this.btext = 'Enregistrer';
              })
            }
            else
              this.$toastr.s("Il faut remplir certain champ", "Message Benediction");
              }
            }

           },


            retirer:function(client){
               var index = this.lclients.indexOf(client);
               if (index > -1) {
               this.lclients.splice(index, 1);
            }
          },

           deleteClient:function(client){
              let uri='delclient/'+client.id;
              if(confirm('Etes-vous sure...?')){
                 this.id='del'+client.id;
              Axios.get(uri).then((response)=>{
                 console.log(response.data);
                 this.retirer(client);
                 //this.getClient();
                 this.$toastr.s("Client supprimé avec succes", "Message Benediction");
                  this.id=0;
              })
             }
           }

        }


</script>
