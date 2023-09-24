<template>
    <div>
        <div class="container">
            <h4 style="margin-top: 50px">Carti</h4>
            <button v-if="showData" type="button" class="btn btn-primary" @click="show()">Ascunde</button>
            <button v-else type="button" class="btn btn-primary" @click="show()">Arata</button>
            <button type="button" class="btn btn-primary" @click="changePopupAdd()">Adauga</button>
        </div>
        <table v-if="!!dataLoaded && showData" class="table table-striped">
            <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Titlu</th>
                <th scope="col">Autor</th>
                <th scope="col">Imagine</th>
                <th scope="col">ISBN</th>
                <th scope="col">Editura</th>
                <th scope="col">Pret</th>
                <th scope="col">An aparitie</th>
                <th scope="col">Numar pagini</th>
                <th scope="col">Tip coperta</th>
                <th scope="col">Limba</th>
                <th scope="col">Dimensiune</th>
                <th scope="col">Cantitate</th>
                <th scope="col">Actiuni</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="carte in carti" :key="carte.id">
                <th scope="col">{{ carte.id }}</th>
                <th scope="col">{{ carte.titlu }}</th>
                <th scope="col">{{ carte.autor }}</th>
                <th scope="col">{{ carte.imagine }}</th>
                <th scope="col">{{ carte.isbn }}</th>
                <th scope="col">{{ carte.editura }}</th>
                <th scope="col">{{ carte.pret }}</th>
                <th scope="col">{{ carte.an_aparitie }}</th>
                <th scope="col">{{ carte.nr_pg }}</th>
                <th scope="col">{{ carte.tip_coperta }}</th>
                <th scope="col">{{ carte.limba }}</th>
                <th scope="col">{{ carte.dimensiune }}</th>
                <th scope="col">{{ carte.cantitate }}</th>
                <th scope="col">
                    <img :src="'/icons/trash-can-solid-1.svg'" alt="Profile SVG" @click="deleteItem(carte)">
                    <img :src="'/icons/pen-to-square-solid-1.svg'" alt="Profile SVG" @click="changePopupEdit(carte)">
                </th>
            </tr>
            </tbody>
        </table>
        <div v-if="popupAdd" class="popup-container">
            <div class="popup-content">
                <form>
                    <div class="mb-3">
                        <label for="titlu" class="form-label">Titlu</label>
                        <input type="text" class="form-control" id="titlu" v-model="carte.titlu">
                    </div>

                    <div class="mb-3">
                        <label for="autor" class="form-label">Autor</label>
                        <input type="text" class="form-control" id="autor" v-model="carte.autor">
                    </div>

                    <div class="mb-3">
                        <label for="imagine" class="form-label">Imagine</label>
                        <input type="text" class="form-control" id="imagine" v-model="carte.imagine">
                    </div>

                    <div class="mb-3">
                        <label for="isbn" class="form-label">ISBN</label>
                        <input type="text" class="form-control" id="isbn" v-model="carte.isbn">
                    </div>

                    <div class="mb-3">
                        <label for="editura" class="form-label">Editura</label>
                        <input type="text" class="form-control" id="editura" v-model="carte.editura">
                    </div>

                    <div class="mb-3">
                        <label for="pret" class="form-label">Pret</label>
                        <input type="text" class="form-control" id="pret" v-model="carte.pret">
                    </div>

                    <div class="mb-3">
                        <label for="an-aparitie" class="form-label">An aparitie</label>
                        <input type="text" class="form-control" id="an-aparitie" v-model="carte.an_aparitie">
                    </div>

                    <div class="mb-3">
                        <label for="nr-pg" class="form-label">Numar pagini</label>
                        <input type="text" class="form-control" id="nr-pg" v-model="carte.nr_pg">
                    </div>

                    <div class="mb-3">
                        <label for="coperta" class="form-label">Tip coperta</label>
                        <input type="text" class="form-control" id="coperta" v-model="carte.tip_coperta">
                    </div>

                    <div class="mb-3">
                        <label for="limba" class="form-label">Limba</label>
                        <input type="text" class="form-control" id="limba" v-model="carte.limba">
                    </div>

                    <div class="mb-3">
                        <label for="dimensiune" class="form-label">Dimensiune</label>
                        <input type="text" class="form-control" id="dimensiune" v-model="carte.dimensiune">
                    </div>

                    <div class="mb-3">
                        <label for="cantitate" class="form-label">Cantitate</label>
                        <input type="text" class="form-control" id="cantitate" v-model="carte.cantitate">
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-primary" @click="addCarte()">Submit</button>
                        <button type="button" class="btn btn-secondary" @click="changePopupAdd()">Close</button>
                    </div>
                </form>
            </div>
        </div>
        <div v-if="popupEdit" class="popup-container">
            <div class="popup-content">
                <form>
                    <div class="mb-3">
                        <label for="titlu" class="form-label">Titlu</label>
                        <input type="text" class="form-control" id="titlu" v-model="carte.titlu">
                    </div>

                    <div class="mb-3">
                        <label for="autor" class="form-label">Autor</label>
                        <input type="text" class="form-control" id="autor" v-model="carte.autor">
                    </div>

                    <div class="mb-3">
                        <label for="imagine" class="form-label">Imagine</label>
                        <input type="text" class="form-control" id="imagine" v-model="carte.imagine">
                    </div>

                    <div class="mb-3">
                        <label for="isbn" class="form-label">ISBN</label>
                        <input type="text" class="form-control" id="isbn" v-model="carte.isbn">
                    </div>

                    <div class="mb-3">
                        <label for="editura" class="form-label">Editura</label>
                        <input type="text" class="form-control" id="editura" v-model="carte.editura">
                    </div>

                    <div class="mb-3">
                        <label for="pret" class="form-label">Pret</label>
                        <input type="text" class="form-control" id="pret" v-model="carte.pret">
                    </div>

                    <div class="mb-3">
                        <label for="an-aparitie" class="form-label">An aparitie</label>
                        <input type="text" class="form-control" id="an-aparitie" v-model="carte.an_aparitie">
                    </div>

                    <div class="mb-3">
                        <label for="nr-pg" class="form-label">Numar pagini</label>
                        <input type="text" class="form-control" id="nr-pg" v-model="carte.nr_pg">
                    </div>

                    <div class="mb-3">
                        <label for="coperta" class="form-label">Tip coperta</label>
                        <input type="text" class="form-control" id="coperta" v-model="carte.tip_coperta">
                    </div>

                    <div class="mb-3">
                        <label for="limba" class="form-label">Limba</label>
                        <input type="text" class="form-control" id="limba" v-model="carte.limba">
                    </div>

                    <div class="mb-3">
                        <label for="dimensiune" class="form-label">Dimensiune</label>
                        <input type="text" class="form-control" id="dimensiune" v-model="carte.dimensiune">
                    </div>

                    <div class="mb-3">
                        <label for="cantitate" class="form-label">Cantitate</label>
                        <input type="text" class="form-control" id="cantitate" v-model="carte.cantitate">
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-primary" @click="editCarte()">Submit</button>
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
            carti: [],
            adminUser: [],
            adminClient: [],
            dataLoaded: false,
            showData: false,
            popupAdd: false,
            popupEdit: false,
            carte: [
                {
                    id: '',
                    titlu: '',
                    autor: '',
                    imagine: '',
                    isbn: '',
                    editura: '',
                    pret: '',
                    an_aparitie: '',
                    nr_pg: '',
                    tip_coperta: '',
                    limba: '',
                    dimensiune: '',
                    cantitate: '',
                }
            ]
        }
    },
    computed: {
        ...mapGetters(['isAuthenticated']),
    },
    mounted() {
        this.getData();
        this.getCarti();

        Promise.all([this.getData(), this.getCarti()])
            .then(() => {
                this.checkAdmin();
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
        async getCarti() {
            await axios.get('/carte', {
                headers: {
                    'Authorization': 'Bearer ' + this.isAuthenticated
                }
            })
                .then(response => {
                    this.carti = response.data;
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
        async deleteItem(carte) {
            await axios.delete('/carte/' + carte.id, {
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
        },
        show() {
            this.showData = !this.showData;
        },
        changePopupAdd() {
            this.popupAdd = !this.popupAdd;
        },
        changePopupEdit(carte) {
            this.carte = carte;
            this.popupEdit = !this.popupEdit;
        },
        async addCarte() {
            await axios.post('/carte', {
                    titlu: this.carte.titlu,
                    autor: this.carte.autor,
                    imagine: this.carte.imagine,
                    isbn: this.carte.isbn,
                    editura: this.carte.editura,
                    pret: this.carte.pret,
                    an_aparitie: this.carte.an_aparitie,
                    nr_pg: this.carte.nr_pg,
                    tip_coperta: this.carte.tip_coperta,
                    limba: this.carte.limba,
                    dimensiune: this.carte.dimensiune,
                    cantitate: this.carte.cantitate,
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
        async editCarte () {
            await axios.put('/carte', {
                    id: this.carte.id,
                    titlu: this.carte.titlu,
                    autor: this.carte.autor,
                    imagine: this.carte.imagine,
                    isbn: this.carte.isbn,
                    editura: this.carte.editura,
                    pret: this.carte.pret,
                    an_aparitie: this.carte.an_aparitie,
                    nr_pg: this.carte.nr_pg,
                    tip_coperta: this.carte.tip_coperta,
                    limba: this.carte.limba,
                    dimensiune: this.carte.dimensiune,
                    cantitate: this.carte.cantitate,
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
    overflow: auto;
    padding-top: 400px;
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
