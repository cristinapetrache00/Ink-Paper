<template>
    <div>
        <div class="container">
            <h4 style="margin-top: 50px">Donatii</h4>
            <button v-if="showData" type="button" class="btn btn-primary" @click="show()">Ascunde</button>
            <button v-else type="button" class="btn btn-primary" @click="show()">Arata</button>
        </div>
        <table v-if="!!dataLoaded && showData" class="table table-striped">
            <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nume</th>
                <th scope="col">Prenume</th>
                <th scope="col">Email</th>
                <th scope="col">Numar telefon</th>
                <th scope="col">Titlu</th>
                <th scope="col">Autor</th>
                <th scope="col">ISBN</th>
                <th scope="col">Adresa</th>
                <th scope="col">Localitate</th>
                <th scope="col">Judet</th>
                <th scope="col">Actiuni</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="donatie in donatii" :key="donatie.id">
                <th scope="col">{{ donatie.id }}</th>
                <th scope="col">{{ donatie.nume }}</th>
                <th scope="col">{{ donatie.prenume }}</th>
                <th scope="col">{{ donatie.email }}</th>
                <th scope="col">{{ donatie.nr_telefon }}</th>
                <th scope="col">{{ donatie.titlu }}</th>
                <th scope="col">{{ donatie.autor }}</th>
                <th scope="col">{{ donatie.isbn }}</th>
                <th scope="col">{{ donatie.adresa_ridicare }}</th>
                <th scope="col">{{ donatie.oras_ridicare }}</th>
                <th scope="col">{{ donatie.judet_ridicare }}</th>
                <th scope="col">
                    <img :src="'/icons/trash-can-solid-1.svg'" alt="Profile SVG" @click="deleteItem(donatie)">
                </th>
            </tr>
            </tbody>
        </table>
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
            donatii: [],
            adminUser: [],
            adminClient: [],
            dataLoaded: false,
            showData: false,
        }
    },
    computed: {
        ...mapGetters(['isAuthenticated']),
    },
    mounted() {
        this.getData();
        this.getDonatii();

        Promise.all([this.getData(), this.getDonatii()])
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
        async getDonatii() {
            await axios.get('/donatie', {
                headers: {
                    'Authorization': 'Bearer ' + this.isAuthenticated
                }
            })
                .then(response => {
                    this.donatii = response.data;
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
        async deleteItem(donatie) {
            await axios.delete('/donatie/' + donatie.id, {
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

.container {
    padding-left: 0;
}
</style>
