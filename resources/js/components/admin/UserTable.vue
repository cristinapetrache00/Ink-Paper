<template>
    <div>
        <div class="container">
            <h4 style="margin-top: 100px">Clienti</h4>
            <button v-if="showData" type="button" class="btn btn-primary" @click="show()">Ascunde</button>
            <button v-else type="button" class="btn btn-primary" @click="show()">Arata</button>
        </div>
        <table v-if="!!dataLoaded && showData" class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">User ID</th>
                    <th scope="col">Client ID</th>
                    <th scope="col">Email</th>
                    <th scope="col">Email verificat</th>
                    <th scope="col">Nume</th>
                    <th scope="col">Prenume</th>
                    <th scope="col">Numar telefon</th>
                    <th scope="col">Adresa</th>
                    <th scope="col">Localitate</th>
                    <th scope="col">Judet</th>
                    <th scope="col">Actiuni</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="user in users" :key="user.id">
                    <th scope="col">{{ user.id }}</th>
                    <th scope="col">{{ user.client_id }}</th>
                    <th scope="col">{{ user.email }}</th>
                    <th scope="col">{{ user.email_verified_at }}</th>
                    <th scope="col">{{ user.client.nume }}</th>
                    <th scope="col">{{ user.client.prenume }}</th>
                    <th scope="col">{{ user.client.nr_telefon }}</th>
                    <th scope="col">{{ user.client.adresa }}</th>
                    <th scope="col">{{ user.client.oras }}</th>
                    <th scope="col">{{ user.client.judet }}</th>
                    <th scope="col"><img :src="'/icons/trash-can-solid-1.svg'" alt="Profile SVG" @click="deleteItem(user)"></th>
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
    name: "UserTable",
    data() {
        return {
            users: [],
            clients: [],
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
        this.getUsers();
        this.getClients();

        Promise.all([this.getData(), this.getUsers(), this.getClients()])
            .then(() => {
                this.checkAdmin();

                this.combineData();
            });

        Promise.all([this.deleteItem()])
            .then(() => {
                this.getUsers();
                this.getClients();
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
        async getUsers() {
            await axios.get('/user/index', {
                headers: {
                    'Authorization': 'Bearer ' + this.isAuthenticated
                }
            })
                .then(response => {
                    this.users = response.data;
                })
                .catch(error => {
                    console.log(error);
                });
        },
        async getClients() {
            await axios.get('/clienti', {
                headers: {
                    'Authorization': 'Bearer ' + this.isAuthenticated
                }
            })
                .then(response => {
                    this.clients = response.data;
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
            this.users.forEach(user => {
                this.clients.forEach(client => {
                    if (user.id === client.user_id) {
                        user.client = client;
                    }
                });
            });
            this.dataLoaded = true;
        },
        async deleteItem(user) {
            await axios.delete('/clienti/' + user.client.id, {
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

            await axios.delete('/user/' + user.id, {
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
