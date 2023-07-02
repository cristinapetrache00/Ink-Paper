<template>
    <div>
        <div class="container">
            <h4 style="margin-top: 50px">Categorii</h4>
            <button v-if="showData" type="button" class="btn btn-primary" @click="show()">Ascunde</button>
            <button v-else type="button" class="btn btn-primary" @click="show()">Arata</button>
            <button type="button" class="btn btn-primary" @click="changePopupAdd()">Adauga</button>
        </div>
        <table v-if="!!dataLoaded && showData" class="table table-striped">
            <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nume</th>
                <th scope="col">ID Parinte</th>
                <th scope="col">ID carti</th>
                <th scope="col">Actiuni</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="categorie in categorii" :key="categorie.id">
                <th scope="col">{{ categorie.id }}</th>
                <th scope="col">{{ categorie.nume }}</th>
                <th scope="col">{{ categorie.parent_id }}</th>
                <th scope="col"><span v-for="carte_categorie in categorie.carti">{{ carte_categorie }}, </span></th>
                <th scope="col">
<!--                    <img :src="'/icons/trash-can-solid-1.svg'" alt="Profile SVG" @click="changePopupDelete(categorie)">-->
                    <img :src="'/icons/pen-to-square-solid-1.svg'" alt="Profile SVG" @click="changePopupEdit(categorie)">
                </th>
            </tr>
            </tbody>
        </table>
        <div v-if="popupAdd" class="popup-container">
            <div class="popup-content">
                <form>
                    <div class="mb-3">
                        <label for="nume" class="form-label">Nume</label>
                        <input type="text" class="form-control" id="nume" v-model="categorie.nume">
                    </div>

                    <div class="mb-3">
                        <label for="parent" class="form-label">ID Parinte</label>
                        <input type="text" class="form-control" id="parent" v-model="categorie.parent_id">
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-primary" @click="addCategorie()">Submit</button>
                        <button type="button" class="btn btn-secondary" @click="changePopupAdd()">Close</button>
                    </div>
                </form>
            </div>
        </div>
        <div v-if="popupEdit" class="popup-container">
            <div class="popup-content">
                <form>
                    <div class="mb-3">
                        <label for="nume" class="form-label">Numele categoriei</label>
                        <input type="text" class="form-control" id="nume" v-model="categorie.nume">
                    </div>

                    <div class="mb-3">
                        <label for="parent" class="form-label">ID Carte</label>
                        <input type="text" class="form-control" id="parent" v-model="id">
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-primary" @click="addCarte()">Submit</button>
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
            categorii: [],
            carti_categorii: [],
            adminUser: [],
            adminClient: [],
            dataLoaded: false,
            showData: false,
            popupAdd: false,
            popupEdit: false,
            popupDelete: false,
            categorie: [
                {
                    id: '',
                    nume: '',
                    parent_id: '',
                }
            ],
            id: 0,
        }
    },
    computed: {
        ...mapGetters(['isAuthenticated']),
    },
    mounted() {
        this.getData();
        this.getCategorii();
        this.getCategoriiCarti();

        Promise.all([this.getData(), this.getCategorii(), this.getCategoriiCarti()])
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
        async getCategorii() {
            await axios.get('/categorii', {
                headers: {
                    'Authorization': 'Bearer ' + this.isAuthenticated
                }
            })
                .then(response => {
                    this.categorii = response.data;
                })
                .catch(error => {
                    console.log(error);
                });
        },
        async getCategoriiCarti() {
            await axios.get('/carte-categorie', {
                headers: {
                    'Authorization': 'Bearer ' + this.isAuthenticated
                }
            })
                .then(response => {
                    this.carti_categorii = response.data;
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
            this.categorii.forEach(categorie => {
                categorie.carti = [];
                this.carti_categorii.forEach(carte_categorie => {
                    if (categorie.id === carte_categorie.id_categorie) {
                        categorie.carti.push(carte_categorie.id_carte);
                    }
                })
            })
        },
        show() {
            this.showData = !this.showData;
        },
        changePopupAdd() {
            this.popupAdd = !this.popupAdd;
        },
        changePopupEdit(categorie) {
            this.categorie = categorie;
            this.popupEdit = !this.popupEdit;
        },
        async addCategorie() {
            await axios.post('/categorii', {
                    nume: this.categorie.nume,
                    parent_id: this.categorie.parent_id,
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
            this.popupAdd = !this.popupAdd;
        },
        async addCarte () {
            await axios.post('/carte-categorie', {
                    id_categorie: this.categorie.id,
                    id_carte: this.id,
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
