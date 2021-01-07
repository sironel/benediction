<template>
   <div class="row">
        <div class="col-md-12 text-center"><h4>Gestion de Commande</h4></div>
        <div class="col-md-6">
          <div class="card">
            <div class="card-header">
               <b-row>
                <b-col><h4><i class="fas fa-cubes"></i> Stock</h4></b-col>
                <b-col>
               <b-form-group
                  label="Filter"
                  label-for="filter-input"
                  label-cols-sm="3"
                  label-align-sm="right"
                  label-size="sm"
                  class="mb-0"
                >
                  <b-input-group size="sm">
                    <b-form-input
                      id="filter-input"
                      v-model="filter"
                      type="search"
                      placeholder="Type to Search"
                    ></b-form-input>

                    <b-input-group-append>
                      <b-button :disabled="!filter" @click="filter = ''">Clear</b-button>
                    </b-input-group-append>
                  </b-input-group>
                </b-form-group></b-col>
              </b-row>



            </div>
            <div class="card-body">


                <b-table fixed :filter="filter"  sticky-header="400px" head-variant="dark" responsive hover :items="items" :fields="fields">
                  <template v-slot:cell(action)="data">
                    <b-button variant="success" size="sm" @click="commander(data.item)" title="Ajouter"><i class="fas fa-shopping-cart" ></i></b-button>
                  </template>
                   <template v-slot:cell(qteunite)="data" >
                      {{data.item.qte}} {{data.item.unite}}
                    </template>
                    <!-- <template v-slot:cell(montant)="data" >
                      $.{{data.item.qte}} Gdes
                    </template> -->

                </b-table>

            </div>
          </div>
        </div>
        <!-- --------col 2--------- -->
        <div class="col-md-6">
          <div class="card">
             <div class="card-header">
               <b-row>
              <b-col md="4"><h3><i class="fas fa-shopping-cart" ></i> Panier</h3></b-col>
              <b-col class="text-right" md="8"><h5>Total: {{Number(total).toLocaleString('en-US', {minimumFractionDigits: 2, style: 'decimal',style:'currency', currency: 'GRD'})}}</h5></b-col>

            </b-row>

            </div>
             <div class="card-body">

                 <b-table responsive sticky-header="400px" head-variant="dark" striped hover :items="panier" :fields="fields1">
                  <template v-slot:cell(action)="data">
                    <b-button variant="warning" size="sm" @click="retirer(data.item)" title="retirer"><i class="fas fa-trash-alt" ></i></b-button>
                  </template>
                  <template v-slot:cell(qteunite)="data" >
                      {{data.item.qte}} {{data.item.unite}}
                    </template>
                </b-table>


              <div>

              </div>
             </div>
          </div>
        </div>
      </div>
</template>

<script>
    export default {
      props:['articles'],
        data:function(){
          return {
              fields:[

                {key:'produit', label:'Produit'},
                {key:'montant', label:'Montant',
                formatter: (montant, key, item) => {
                  return Number(item.montant).toLocaleString('en-US', {minimumFractionDigits: 2, style: 'decimal',style:'currency', currency: 'GRD'})
                 }

              },
                {key:'qteunite', label:'Qté',sortable:true},
                {key:'action', label:'Action'}

              ],
              items:this.articles,
              fields1:[

                {key:'produit', label:'Produit'},
                {key:'qteunite', label:'Qté',sortable:true},
                {key:'montant', label:'Montant',sortable:true,
                formatter: (montant, key, item) => {
                  return Number(item.montant).toLocaleString('en-US', {minimumFractionDigits: 2, style: 'decimal',style:'currency', currency: 'GRD'})
                 }
              },
                {key:'action', label:'Action'}

              ],
               filter: null,
               filterOn: [],
              panier:[],
              total:0
          }
        },
      methods:{
        commander:function(prod){
          if(!this.checkexistObj(prod))
             this.panier.push(prod);
        else
         this.$toastr.e("Cet article est deja dans le panier", "Message Benediction");
          this.total+= prod.montant*prod.qte;
        },

        retirer:function(pan){
          var index = this.panier.indexOf(pan);
            if (index > -1) {
              this.panier.splice(index, 1);
              this.total-= pan.montant*pan.qte;
            }
        },

       checkexistObj:function (obj) {
            var i;
            for (i = 0; i < this.panier.length; i++) {
                if (this.panier[i] === obj)
                    return true;
            }
            return false;
        }
      }

    }
</script>

