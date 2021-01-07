<template>
    <div class="container">
       <div  class="row">         
       <div  class="col-md-6">         
             
                   <form class="well form-horizontal" v-on:submit.prevent="storeStock">
                     
                             <div class="col-md-4 form-group">
                               <label for="exampleFormControlSelect2">Selectionner Unité *</label>

                                <select  class="form-control" size="5" v-model="stocks.produit_unite_id" name="produit_unite_id" id="produit_unite_id"> 
                                     <option  v-for="(p, index) in up" :key="index" :value="p.id" >{{p.nomproduit + ' / '+ p.nomunite}}</option>                              
                                </select>
                               
                              </div>
                             
                            <div class="form-group">
                            <label class="col-md-4 control-label">Quantite</label>
                            <div class="col-md-4 inputGroupContainer">
                               <div class="input-group"><span class="input-group-addon"><i class="glyphicon glyphicon-home"></i></span><input id="quantite" name="quantite" placeholder="0.0" class="form-control" required="true" value="0.0" type="number" v-model="stocks.quantite"></div>
                            </div>
                         </div>
                        
                     
                       <button class="btn btn-primary" type="button" v-on:click="storeStock">
                           <div v-if="loading" class="spinner-border spinner-border-sm" ></div>
                           <span v-if="loading" class="px-1">En cours</span>
                           <span v-else>{{btext}}</span>
                         </button>
                   </form>
                </div>
                <div class="col-md-6">                  
                      
                         <h4>{{nomp}} : <span class="badge badge-secondary">{{qte_dispo}}</span></h4>
             </div>
             </div>
      
       
       <table class="table table-stripped">
                <thead>
               <tr>
                  <th>/</th>
                    <th>Action</th>
                    <th>Produit</th>
                    <th>Quantite</th>
                </tr>
               </thead>
                <tbody>
                  <tr v-for="stock in lstocks" :key="stock.id">
                   <td> <input type="checkbox" name="" id="check"></td>
                    <td>
                     <button class="btn btn-warning btn-sm" v-on:click="deleteStock(stock)">
                        <div v-if="id=='del'+stock.id" class="spinner-border spinner-border-sm" ></div>
                        <span v-if="id=='del'+stock.id" class="px-1">En cours</span>
                        <span v-else>Delete</span>
                     </button>
                     <button class="btn btn-primary btn-sm" v-on:click="editStock(stock)">
                        <div v-if="id=='edit'+stock.id" class="spinner-border spinner-border-sm" ></div>
                        <span v-if="id=='edit'+stock.id" class="px-1">En cours</span>
                        <span v-else>Edit</span>
                     </button>
                  </td>
                    <td>{{stock.produit_unite_id}}</td>
                    <td>{{stock.quantite}}</td>                                      
                  </tr>
                </tbody>
              </table>

             <!--  <b-table striped hover :items="lstocks"></b-table> -->
               </div>
</template>
<script>

    export default {
      props:['produits'],
       mounted(){
        this.lViewStock();
          this.getStock();
           },
        data:function(){
           return {
              loading:false,
              id:0,
              stock_id :'',
              edit :false,
              btext:'Enregistrer',
              stocks:{produit_unite_id:'', quantite:''},
              lstocks:[],
              up:[],
              qte_dispo :'0.0',
              nomp :'Produit'
           }

        },
         methods: {
            checkForm: function () {
               if (this.stocks.quantite == 0 )
               return false;
               return true;
             },
               getStock:function(){
              let uri='getstocks/';

              Axios.post(uri).then((response)=>{
                 console.log(response.data);
                  this.lstocks=response.data;
              })
           },

           lViewStock:function(){
              this.up= this.produits;
           },

             editStock:function(stock){
              this.edit = true;
              this.btext = 'Modifier';
              this.id='edit'+stock.id;
              this.stock_id = stock.id;
              this.stocks.produit_unite_id = stock.produit_unite_id;
              this.stocks.quantite = stock.quantite;             
               this.id=0;
           },

           storeStock:function(){
               if(!this.edit){
                 let uri='stocks/';
            if(this.checkForm()){
               this.loading = !false;
             
              Axios.put(uri, this.stocks).then((response)=>{
                 console.log(response);
                 this.lstocks.unshift(response.data.data);
                  this.qte_dispo = response.data[5] +' '+ response.data[3];
                 this.nomp = response.data[1];
                 this.loading = !true;
                 this.$toastr.s("Stock enregistré avec succes", "Message Benediction");

              }).catch(error => {
                  this.$toastr.e("Echec de l'opération...", "Message Benediction");
              })
            }
            else
              this.$toastr.s("Il faut remplir certain champ", "Message Benediction");
              }

            else{
               let uri='editstock/'+this.stock_id;
            if(this.checkForm()){
               this.loading = !false;
              Axios.put(uri, this.stocks).then((response)=>{
                 console.log(response);
                     this.getStock();
                   this.loading = !true;
                 this.$toastr.s("Stock modifié avec succes", "Message Benediction");
                  this.edit = false;
                  this.btext = 'Enregistrer';
              }).catch(error => {
                  console.log(error);
                  this.$toastr.e("Echec de la modification...", "Message Benediction");
                          this.edit = false;
                          this.btext = 'Enregistrer';
              })
            }
            else
              this.$toastr.s("Il faut remplir certain champ", "Message Benediction");
              }
            },

           


            retirer:function(stock){
               var index = this.lstocks.indexOf(stock);
               if (index > -1) {
               this.lstocks.splice(index, 1);
            }
          },

           deleteStock:function(stock){
              let uri='delstock/'+stock.id;
              if(confirm('Etes-vous sure...?')){
                 this.id='del'+stock.id;
              Axios.get(uri).then((response)=>{
                 console.log(response.data);
                  this.qte_dispo = response.data[5] +' '+ response.data[3];
                 this.nomp = response.data[1];
                 this.retirer(stock);
                 //this.getstock();
                 this.$toastr.s("stock supprimé avec succes", "Message Benediction");
                  this.id=0;
              })
             }
           }

        }
      }


</script>
