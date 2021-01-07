
<template>

<div>
  <b-tabs content-class="mt-3">
    <b-tab title="Client" active>
    	<div class="card">
    		<div class="card-header">
    			Informations Client
    		</div>
    		<div class="card-body">
    			<label>Selectionner un client</label>
    			<select  class="form-control" size="5" v-model="clients.client_id" name="client_id" id="client_id">
                         <option  v-for="(c, index) in clients" :key="index" :value="c.id" >{{c.nom + '  '+ c.prenom}}</option>
                  </select>
    				 <div class="form-check">
					    <input type="checkbox" class="form-check-input" v-on:click="Ajouter_client">
					    <label class="form-check-label" for="exampleCheck1">Ajouter un nouveau client</label>
					  </div>
    			<div class="panel" v-if="client_add">
    				<create-client ></create-client>
    			</div>
    		</div>
    	</div>
    </b-tab>
<!-- ************************************Info Commande**************** -->
    <b-tab title="Commande">
    		<commande></commande>
    </b-tab>
<!-- ****************** details commande************** -->
    <b-tab title="Details" >
    	 <gestion-comande :articles="articles" ></gestion-comande>
    </b-tab>
    <!-- **************************facture ************************* -->
    <b-tab title="Facture"><p>I'm a disabled tab!</p></b-tab>
  </b-tabs>
</div>

</template>
<script >

export default{
	props:['produits', 'clients'],
	mounted(){},
	 data:function(){
           return {
           		client_add: false,
           		datedujour:new Date().toISOString().substr(0, 10),
           		credit: false,
           		client_id:'',
           		articles :this.produits
              // loading:false,
              // id:0,
              // stock_id :'',
              // edit :false,
              // btext:'Enregistrer',
              // stocks:{produit_unite_id:'', quantite:''},
              // lstocks:[],
              // up:[],
              // qte_dispo :'0.0',
              // nomp :'Produit'
           }

        },
        methods:{
        	Ajouter_client:function(){
        		this.client_add = !this.client_add;

        		},

        Ajouter_credit:function(){
        		this.credit = !this.credit;

        		}
        }


}
</script>
