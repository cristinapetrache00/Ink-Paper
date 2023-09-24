<template>
    <div>
        <div class="container">
            <h4 style="margin-top: 50px">Comenzi</h4>
            <button v-if="showData" type="button" class="btn btn-primary" @click="show()">Ascunde</button>
            <button v-else type="button" class="btn btn-primary" @click="show()">Arata</button>
        </div>
        <table v-if="!!dataLoaded && showData" class="table table-striped">
            <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">ID Client</th>
                <th scope="col">Tip</th>
                <th scope="col">Data plasare</th>
                <th scope="col">Data livrare</th>
                <th scope="col">Total comanda</th>
                <th scope="col">Adresa</th>
                <th scope="col">Localitate</th>
                <th scope="col">Judet</th>
                <th scope="col">Status</th>
                <th scope="col">Metoda plata</th>
                <th scope="col">Carti</th>
                <th scope="col">Actiuni</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="comanda in comenzi" :key="comanda.id">
                <th scope="col">{{ comanda.id }}</th>
                <th scope="col">{{ comanda.id_client }}</th>
                <th scope="col">{{ comanda.tip }}</th>
                <th scope="col">{{ comanda.data_plasare }}</th>
                <th scope="col">{{ comanda.data_livrare }}</th>
                <th scope="col">{{ comanda.pret_comanda }}</th>
                <th scope="col">{{ comanda.adresa_livrare }}</th>
                <th scope="col">{{ comanda.oras_livrare }}</th>
                <th scope="col">{{ comanda.judet_livrare }}</th>
                <th scope="col">{{ comanda.status }}</th>
                <th scope="col">{{ comanda.metoda_plata }}</th>
                <th scope="col"><span v-for="carte_comanda in comanda.carti">{{ carte_comanda }}, </span></th>
                <th scope="col">
                    <img :src="'/icons/pen-to-square-solid-1.svg'" alt="Profile SVG" @click="changePopupEdit(comanda)">
                </th>
            </tr>
            </tbody>
        </table>
        <div v-if="popupEdit" class="popup-container">
            <div class="popup-content">
                <form>
                    <div class="mb-3">
                        <label for="comanda" class="form-label">ID comanda </label>
                        <input type="text" class="form-control" id="comanda" v-model="comanda.id">
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <input type="text" class="form-control" id="status" v-model="comanda.status">
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-primary" @click="updateStatus()">Submit</button>
                        <button type="button" class="btn btn-secondary" @click="changePopupEdit()">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import { mapGetters } from 'vuex';
import axios from 'axios';
const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': csrfToken
};
export default {
    name: "CarteTable",
    data() {
        return {
            comenzi: [],
            carti_comenzi: [],
            adminUser: [],
            adminClient: [],
            dataLoaded: false,
            showData: false,
            popupEdit: false,
            comanda: [],
        }
    },
    computed: {
        ...mapGetters(['isAuthenticated']),
    },
    mounted() {
        this.getData();
        this.getComenzi();
        this.getComenziCarti();

        Promise.all([this.getData(), this.getComenzi(), this.getComenziCarti()])
            .then(() => {
                this.checkAdmin();
                this.combineData();
                this.dataLoaded = true;
            });
    },
    methods: {
        async getData() {
            if (this.isAuthenticated) {
                await axios.get('/user', {
                    headers: {
                        'Authorization': 'Bearer ' + this.isAuthenticated
                    }
                })
                    .then(response => {
                        this.adminClient = response.data.client;
                        this.adminUser = response.data.user;
                    })
                    .catch(error => {
                        console.log(error);
                    });
            } else {
                window.location.href = '/autentificare'
            }
        },
        async getComenzi() {
            await axios.get('/admin-comenzi', {
                headers: {
                    'Authorization': 'Bearer ' + this.isAuthenticated
                }
            })
                .then(response => {
                    this.comenzi = response.data;
                })
                .catch(error => {
                    console.log(error);
                });
        },
        async getComenziCarti() {
            await axios.get('/carti-comanda', {
                headers: {
                    'Authorization': 'Bearer ' + this.isAuthenticated
                }
            })
                .then(response => {
                    this.carti_comenzi = response.data;
                })
                .catch(error => {
                    console.log(error);
                });
        },
        checkAdmin() {
            if (this.adminUser.email !== 'inkpaper2023@hotmail.com') {
                alert('Nu aveti acces la aceasta pagina!');
                window.location.href = '/autentificare';
            }
        },
        combineData() {
            this.comenzi.forEach(comanda => {
                comanda.carti = [];
                this.carti_comenzi.forEach(carte_comanda => {
                    if (comanda.id === carte_comanda.id_comanda) {
                        comanda.carti.push(carte_comanda.id_carte);
                    }
                })
            })
        },

        show() {
            this.showData = !this.showData;
        },
        changePopupEdit(comanda) {
            this.comanda = comanda;
            this.popupEdit = !this.popupEdit;
        },

        async updateStatus () {
            await axios.put('/admin-comenzi', {
                    id: this.comanda.id,
                    status: this.comanda.status,
                },
                {
                    headers: {
                        'Authorization': 'Bearer ' + this.isAuthenticated
                    }
                })
                .then(response => {
                    console.log(response);
                })
                .catch(error => {
                    console.log(error);
                });
            this.popupEdit = !this.popupEdit;
        }
    }
}
</script>

<style scoped>
.table {
    width: 100%;
}

.btn-primary {
    display: block;
    background-color: #00A896;
    border: none;
    margin-bottom: 10px;
}

.popup-container {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
}

.popup-content {
    background-color: #fff;
    padding: 20px;
    border-radius: 4px;
}

.container {
    padding-left: 0;
}
</style>
