<template>
	<b-card class="mb-2" header="Informations Commande ">
			<b-card-body>
				<form>
    				  <div class="row">
    					  <div class="col-md-6 col-md-offset-3  justify-content-center" style="margin: auto">

					  <div class="form-group ">
					    <label for="exampleInputEmail1">Discount</label>
					    <input type="number" class="form-control w-25" id="discount" name="discount" placeholder="0%">				    
					  </div> 
					  <div class="form-group">
					    <label for="exampleInputEmail1">Taxe</label>
					    <input type="number" class="form-control w-25" id="taxe" name="taxe"  placeholder="0%">					   
					  </div>
					   <div class="form-check" >
					    <input type="checkbox" class="form-check-input" v-on:click="Ajouter_credit" id="credit" name="credit">
					    <label class="form-check-label" for="exampleCheck1">Credit</label>
					  </div>
					  <div class="form-group" v-if="credit" >
					    <label for="exampleInputPassword1">Delai Paiement</label>
					    <input type="number" class="form-control w-25" id="delaiPaiement" name="delaiPaiement" placeholder="0 jour" >
					  </div> 
					  <div class="form-group">
					    <label for="exampleInputPassword1">Date Commande</label>
					    <input type="date" class="form-control w-50"  id="dateCommande" name="dateCommande" v-model="datedujour">
					  </div>
					  <div class="form-check">
					    <input type="checkbox" class="form-check-input" id="exampleCheck1">
					    <label class="form-check-label" for="exampleCheck1">Check me out</label>
					  </div>
					  <button type="submit" class="btn btn-primary">Submit</button>
					  </div>
					  </div>
					</form>
	</b-card-body>
		<b-button variant="primary"> Suivant</b-button>
	</b-card>
</template>
<script >

export default{
		mounted(){},
	 data:function(){
           return {
           		
           		datedujour:new Date().toISOString().substr(0, 10),
           		credit: false
           		
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
        	
        Ajouter_credit:function(){
        		this.credit = !this.credit;        		
        			
        		}
        }


}
</script>
