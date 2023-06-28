<template>
    <div class="container d-flex justify-content-center align-content-center">
        <div class="col-md-6">
            <form v-if="!!client && !!user" @submit.prevent="checkout" class="row g-3" :style="{ width: 95 + '%', marginLeft: 10 + 'px' }">
                <h4 class="titlu-1"><strong>Date de contact</strong></h4>

                <div class="col-md-6">
                    <label for="inputEmail" class="form-label">E-mail</label>
                    <input type="email" class="form-control" id="inputEmail" v-model="user.email">
                </div>

                <div class="col-md-6">
                    <label for="inputPhone" class="form-label">Telefon</label>
                    <input type="text" class="form-control" id="inputPhone" v-model="client.nr_telefon">
                </div>

                <h4 class="titlu"><strong>Date de livrare</strong></h4>

                <div class="col-md-6">
                    <label for="inputNume" class="form-label">Nume</label>
                    <input type="text" class="form-control" id="inputNume" v-model="client.nume">
                </div>

                <div class="col-md-6">
                    <label for="inputPrenume" class="form-label">Prenume</label>
                    <input type="text" class="form-control" id="inputPrenume" v-model="client.prenume">
                </div>

                <div class="col-12">
                    <label for="inputAddress" class="form-label">Adresa</label>
                    <input type="text" class="form-control" id="inputAddress" v-model="client.adresa">
                </div>

                <div class="col-md-6">
                    <label for="inputCity" class="form-label">Localitate</label>
                    <input type="text" class="form-control" id="inputCity" v-model="client.oras">
                </div>

                <div class="col-md-6">
                    <label for="inputState" class="form-label">Judet</label>
                    <input type="text" class="form-control" id="inputState" v-model="client.judet">
                </div>

                <h4 class="titlu"><strong>Metode de livrare</strong></h4>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="exampleRadios1" id="exampleRadios1" value="fancourier" v-model="delivery" checked>
                    <label class="form-check-label" for="exampleRadios1">
                        Livrare prin FAN Courier
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="exampleRadios2" id="exampleRadios2" value="sameday" v-model="delivery">
                    <label class="form-check-label" for="exampleRadios2">
                        Livrare prin Sameday
                    </label>
                </div>

                <h4 class="titlu"><strong>Metode de plata</strong></h4>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="exampleRadios3" id="exampleRadios3" value="card" v-model="payment" checked>
                    <label class="form-check-label" for="exampleRadios3">
                        Plata online cu cardul
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="exampleRadios4" id="exampleRadios4" value="ramburs" v-model="payment">
                    <label class="form-check-label" for="exampleRadios4">
                        Ramburs la livrare
                    </label>
                </div>

                <div v-if="payment === 'card'" class="row g-3" style="margin-top: 20px">
                    <div class="col-12">
                        <label for="nrCard" class="form-label">Numarul cardului</label>
                        <input type="text" class="form-control" id="nrCard">
                    </div>
                    <div class="col-12">
                        <label for="numeCard" class="form-label">Numele de pe card</label>
                        <input type="text" class="form-control" id="numeCard">
                    </div>
                    <div class="col-md-8">
                        <label for="dataExp" class="form-label">Data de expirare</label>
                        <input type="text" class="form-control" id="dataExp">
                    </div>
                    <div class="col-md-4">
                        <label for="cvc" class="form-label">CVC</label>
                        <input type="text" class="form-control" id="cvc">
                    </div>
                </div>

                <div class="" style="margin-top: 40px; width: 100%; margin-bottom: 100px">
                    <button type="submit" class="btn btn-primary" style="width: 100%">Trimite comanda</button>
                </div>
            </form>
        </div>
        <div class="col-md-5 bg-custom">
            <div v-if="!!carti" class="container custom-container">
                <div v-for="carte in carti" class="card custom mb-3" style="max-width: 540px;">
                    <div class="row g-0">
                        <div class="col-md-2">
                            <img class="img-fluid rounded-start" :src="'/carti/' + carte.imagine" alt="Book image cap">
                        </div>
                        <div class="col-md-7">
                            <div class="card-body">
                                <h5 class="card-title">{{ carte.titlu }}</h5>
                                <p class="card-text">{{ carte.autor }}</p>
                                <p v-if="!isDiscounted(carte)" class="card-text card-price">{{ (carte.pret * carte.cos).toFixed(2) }} Lei</p>
                                <p v-else class="card-text card-price">{{ ((carte.pret * carte.cos).toFixed(2) - ((mappedDiscountedBooks[carte.id] * carte.pret * carte.cos) / 100)).toFixed(2) }} Lei <span class="text-decoration-line-through reduced-price">{{ (carte.pret * carte.cos).toFixed(2) }} Lei</span></p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <img class="end-delete" :src="'/icons/trash-can-solid-1.svg'" alt="Profile SVG" @click="deleteItem(carte)">

                            <select class="end-quantity form-select" aria-label="Default select example" v-model="carte.cos" @change="updateCos(carte)">
                                <option v-for="i in carte.cantitate" :value="i" :selected="i === carte.cos">{{ i }}</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="checkout-container">
                <div class="">Subtotal:</div>
                <div class="">{{ total }} Lei</div>
            </div>
            <div class="checkout-container">
                <div class="">Taxe de transport:</div>
                <div class="">15.00 Lei</div>
            </div>
            <div class="checkout-container-total">
                <div class="">Total:</div>
                <div class="">{{ total + 15.00 }} Lei</div>
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
    name: "Cos",
    data() {
        return {
            client: null,
            user: null,
            carti: null,
            showPopup: false,
            discountedBooks: [],
            mappedDiscountedBooks: [],
            quantity: 0,
            quantityModified: [],
            total: 0.00,
            delivery: null,
            payment: null,
        }
    },
    computed: {
        ...mapGetters(['isAuthenticated']),
    },
    mounted() {
        this.getClient();
        this.getCos();
        this.getDiscounted();
        setTimeout(() => {
            this.getTotal();
        }, 1000);
    },
    methods: {
        getClient() {
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
                this.client = {
                    nume: null,
                    prenume: null,
                    nr_telefon: null,
                    adresa: null,
                    oras: null,
                    judet: null,
                    id: 0,
                };
                this.user = {
                    email: null
                };
            }
        },
        getCos() {
            if (this.isAuthenticated) {
                axios.get('/cos', {
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
            } else {
                axios.get('/cos')
                    .then(response => {
                        this.carti = response.data;
                    })
                    .catch(error => {
                        console.log(error);
                    });
            }
        },
        getDiscounted() {
            axios.get('/discounts')
                .then(response => {
                    this.discountedBooks = response.data;
                    this.discountedBooks.forEach(book => {
                        this.mappedDiscountedBooks[book.id_carte] = book.promotie;
                    })
                })
                .catch(error => {
                    console.log(error);
                })
        },
        isDiscounted(book) {
            for (let i = 0; i < this.discountedBooks.length; i++) {
                if (this.discountedBooks[i].id_carte === book.id) {
                    return true;
                }
            }
            return false;
        },
        deleteItem(carte) {
            if (this.isAuthenticated) {
                axios.delete('/cos/' + carte.id, {
                        headers: {
                            'Authorization': 'Bearer ' + this.isAuthenticated
                        }
                    })
                    .then(response => {
                        window.location.reload();
                    })
                    .catch(error => {
                        console.log(error);
                    });
            } else {
                axios.delete('/cos/' + carte.id)
                    .then(response => {
                        window.location.reload();
                    })
                    .catch(error => {
                        console.log(error);
                    });
            }
        },
        updateCos(carte) {
            if (this.isAuthenticated) {
                axios.put('/cos', {
                    id_carte: carte.id,
                    cantitate: carte.cos
                },
                    {
                        headers: {
                            'Authorization': 'Bearer ' + this.isAuthenticated
                        }
                })
                    .then(response => {
                        window.location.reload();
                    })
                    .catch(error => {
                        console.log(error);
                    });
            } else {
                axios.put('/cos', {
                        id_carte: carte.id,
                        cantitate: carte.cos
                    })
                    .then(response => {
                        window.location.reload();
                    })
                    .catch(error => {
                        console.log(error);
                    });
            }
        },
        getTotal() {
            this.carti.forEach(carte => {
                if (!this.isDiscounted(carte)) {
                    this.total += parseFloat((carte.pret * carte.cos).toFixed(2)); // Use += for numeric addition
                } else {
                    this.total += parseFloat(((carte.pret * carte.cos).toFixed(2) - ((this.mappedDiscountedBooks[carte.id] * carte.pret * carte.cos) / 100)).toFixed(2)); // Use += for numeric addition
                }
            });
        },
        checkout() {
            axios.post('/checkout', {
                carti: this.carti,
                id_client: this.client.id,
                tip: 'comanda',
                pret_comanda: this.total + 15.00,
                adresa_livrare: this.client.adresa,
                oras_livrare: this.client.oras,
                judet_livrare: this.client.judet,
                status: 'in curs de pregatire',
                metoda_plata: this.payment,
            })
                .then(response => {
                    window.location.href = '/';
                })
                .catch(error => {
                    console.log(error);
                });
        }
    }
}
</script>

<style scoped>
.btn-primary {
    display: block;
    background-color: #00A896;
    border: none;
}

.reduced-price {
    font-size: 16px;
    margin-left: 10px;
    color: rgba(23, 42, 58, 0.6)
}

.form-select {
    width: 90%;
}

.custom {
    border: none;
    background-color: transparent;
    width: 100%;
    padding-bottom: 30px;
    border-bottom: 1px solid rgba(0, 0, 0, 0.2);
    border-radius: 0;
}

.custom-container {
    background-color: #fafafa;
}

.end-delete {
    position: absolute;
    right: 0;
    top: 15px;
}

.end-quantity {
    position: absolute;
    right: 0;
    bottom: 45px;
    width: 13%;
}

.checkout-container {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 10px;
    background-color: transparent;
}

.checkout-container-total {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 10px;
    background-color: transparent;
    margin-top: 20px;
    border-top: 1px solid rgba(0, 0, 0, 0.2);
    border-radius: 0;
}

.bg-custom {
    background-color: #fafafa;
}

.titlu {
    font-family: "Lora",serif;
    color: #333333;
    margin-bottom: 30px;
    margin-top: 50px;
}

.titlu-1 {
    font-family: "Lora",serif;
    color: #333333;
    margin-bottom: 30px;
}

/* Customize the appearance of the checked radio button */
.form-check-input[type="radio"]:checked {
    background-color: #008b7a;
    border-color: #008b7a;
}

</style>
