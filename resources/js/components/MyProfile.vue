<template>
    <form v-if="!!user && !!client" @submit.prevent="sendData" class="row g-3">
        <div class="col-md-6">
            <label for="inputNume" class="form-label">Nume</label>
            <input type="text" class="form-control" id="inputNume" v-model="client.nume">
        </div>
        <div class="col-md-6">
            <label for="inputPrenume" class="form-label">Prenume</label>
            <input type="text" class="form-control" id="inputPrenume" v-model="client.prenume">
        </div>
        <div class="col-md-6">
            <label for="inputEmail" class="form-label">Email</label>
            <input type="email" class="form-control" id="inputEmail" v-model="user.email">
        </div>
        <div class="col-md-6">
            <label for="inputPhone" class="form-label">Numar Telefon</label>
            <input type="text" class="form-control" id="inputPhone" v-model="client.nr_telefon">
        </div>
        <div class="col-12">
            <label for="inputAddress" class="form-label">Adresa</label>
            <input type="text" class="form-control" id="inputAddress" v-model="client.adresa">
        </div>
        <div class="col-md-6">
            <label for="inputCity" class="form-label">Localitate</label>
            <input type="text" class="form-control" id="inputCity" v-model="client.oras">
        </div>
        <div class="col-md-4">
            <label for="inputState" class="form-label">Judet</label>
            <input type="text" class="form-control" id="inputState" v-model="client.judet">

        </div>
        <div class="col-md-2">
            <label for="formular" class="form-label">Schimba parola</label>
            <button id="formular" class="btn btn-primary form-control" type="button" @click="openPopup">Deschide formular</button>

            <!-- Popup window -->
            <div v-if="showPopup" class="popup-container">
                <div class="popup-content">
                    <form>
                        <!-- Form fields -->
                        <div class="mb-3">
                            <label for="firstName" class="form-label">Parola noua</label>
                            <input type="password" class="form-control" id="firstName" v-model="password">
                        </div>
                        <div class="mb-3">
                            <label for="lastName" class="form-label">Confirmare parola</label>
                            <input type="password" class="form-control" id="lastName" v-model="confirmPassword">
                        </div>

                        <!-- Submit and close buttons -->
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-primary" @click="submitForm">Submit</button>
                            <button type="button" class="btn btn-secondary" @click="closePopup">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary">Salveaza</button>
        </div>
    </form>
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
    name: "MyProfile",
    data() {
        return {
            client: null,
            user: null,
            showPopup: false,
            password: '',
            confirmPassword: '',
        }
    },
    computed: {
        ...mapGetters(['isAuthenticated']),
    },
    mounted() {
        this.getData();
    },
    methods: {
        getData() {
            if (this.isAuthenticated) {
                axios.get('/user', {
                    headers: {
                        'Authorization': 'Bearer ' + this.isAuthenticated
                    }
                })
                    .then(response => {
                        this.client = response.data.client;
                        this.user = response.data.user;
                    })
                    .catch(error => {
                        console.log(error);
                    });
            } else {
                window.location.href = '/autentificare'
            }
        },
        sendData() {
            if (this.isAuthenticated) {
                axios.put('/user',
                    {
                    email: this.user.email,
                    nume: this.client.nume,
                    prenume: this.client.prenume,
                    nr_telefon: this.client.nr_telefon,
                    adresa: this.client.adresa,
                    oras: this.client.oras,
                    judet: this.client.judet,
                },
                    {
                    headers: {
                        'Authorization': 'Bearer ' + this.isAuthenticated
                    }
                })
                .catch(error => {
                    console.log(error);
                });
            }
        },
        openPopup() {
            this.showPopup = true;
        },
        closePopup() {
            this.showPopup = false;
        },
        submitForm() {
            if (this.password !== this.confirmPassword) {
                alert('Parolele nu coincid!');
                return;
            } else {
                axios.put('/user/parola',
                    {
                        parola: this.password,
                    },
                    {
                        headers: {
                            'Authorization': 'Bearer ' + this.isAuthenticated
                        }
                    })
                    .then(response => {
                        this.closePopup();
                    })
                    .catch(error => {
                        console.log(error);
                    });
            }
        },
    }
}
</script>

<style scoped>
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

.btn-primary {
    display: block;
    background-color: #00A896;
    border: none;
}
</style>
