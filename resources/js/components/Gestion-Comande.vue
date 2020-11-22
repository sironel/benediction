<template>
   <div class="row">
        <div class="col-md-12 text-center"><h2>Gestion de Commande</h2></div>
        <div class="col-md-6">
          <div class="card">
            <div class="card-header"><h3>Produit disponible</h3></div>
            <div class="card-body">
              <table class="table table-stripped">

                <thead>


                  <tr>
                  <th>ch</th>
                    <th>Produit</th>
                    <th>Prix</th>
                    <th><i class="fas fa-shopping-cart"></i></th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(prod) in produits" :key="prod.nom">
                   <td> <input type="checkbox" name="" id="check"></td>
                    <td>{{prod.nom}}</td>
                    <td>{{prod.prix}}</td>
                    <td> <button class="btn btn-success" v-on:click="commander(prod)"><i class="fas fa-shopping-cart"></i> Commander</button></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <!-- --------col 2--------- -->
        <div class="col-md-6">
          <div class="card">
             <div class="card-header"><h3>Produit commander</h3></div>
             <div class="card-body">

                <table class="table table-stripped">

                <thead>


                  <tr>
                  <th>/</th>
                    <th>Produit</th>
                    <th>Qte</th>
                    <th>Prix</th>
                    <th>ret</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="pan in panier" :key="pan.nom">
                   <td class=""> <input type="checkbox" name="" id="check"></td>
                    <td>{{pan.nom}}</td>
                    <td>{{pan.qte}}</td>
                    <td>{{pan.prix}}</td>
                    <td><button class="btn btn-warning" v-on:click="retirer(pan)"><i class="fas fa-trash-alt"></i> Laisser</button></td>
                  </tr>
                </tbody>
              </table>
              <div>
                <h5 class="jumbotron">Montant total commande: {{total}}</h5>
              </div>
             </div>
          </div>
        </div>
      </div>
</template>

<script>
    export default {
        data:function(){
          return {
              message:'bonjour tout le monde',
              produits:[{nom:'pois',qte:0, prix:120},{nom:'lait', qte:0, prix:130},{nom:'mais', qte:0, prix:140},{nom:'Riz', qte:0, prix:150}],
              panier:[],
              total:0
          }
        },  
      methods:{
        commander:function(prod){
          if(!this.checkexistObj(prod)){
          this.panier.push(prod);
          prod.qte=1;
        }else
          prod.qte+=1;
          this.total+= prod.prix;
        },
   
        retirer:function(pan){
          if(pan.qte<2){
          var index = this.panier.indexOf(pan);
            if (index > -1) {
              this.panier.splice(index, 1);
              this.total-= pan.prix;
            }
          }
            else{
               pan.qte-=1;
               this.total-= pan.prix;
            }
        },

       checkexistObj:function (obj) {
            var i;
            for (i = 0; i < this.panier.length; i++) {
                if (this.panier[i] === obj) {
                    return true;
					}
            }
            return false;
        }
      }
       
    }
</script>

