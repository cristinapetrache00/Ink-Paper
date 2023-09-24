<template>
    <div v-if="!!orders">
        <div v-for="order in orders" :key="order.id">
            <div class="card">
                <p> <strong>ID comanda: {{ order.id }}</strong> </p>
                <p> Data plasare: {{order.data_plasare}} </p>
                <div class="row">
                    <p class="col-md-auto"> Suma achitata: {{order.pret_comanda}} </p>
                    <p class="col-md-auto"> Metoda de plata: {{order.metoda_plata}} </p>
                </div>
                <div class="row">
                    <p class="col-md-auto"> Data estimata de livrare: {{order.data_livrare}} </p>
                    <p class="col-md-auto"> Status: {{order.status}} </p>
                </div>
                <div class="row">
                    <p class="col-md-auto"> Adresa livrare: {{order.adresa_livrare + ', ' + order.oras_livrare + ', ' + order.judet_livrare}} </p>
                </div>
                <button type="button" class="btn btn-primary" @click="showBooks">Arata cartile din comanda</button>
                <div v-if="show" style="margin-top: 30px">
                    <div class="row" v-for="book in mappedBooks[order.id]">
                        <div class="card w-75 mb-3">
                            <div class="card-body">
                                <h5 class="card-title">{{ book.titlu }}</h5>
                                <p class="card-text">{{ book.autor }}</p>
                                <a href="#" class="btn btn-primary" @click="returnOrder(order, book)">Returneaza</a>
                            </div>
                        </div>
                    </div>
                </div>
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
    name: "MyOrders",
    data() {
        return {
            orders: null,
            mappedBooks: {},
            books: null,
            show: false,
        }
    },
    computed: {
        ...mapGetters(['isAuthenticated']),
    },
    mounted() {
        this.getOrders();
        setTimeout(() => {
            this.orderBooks();
        }, 500);
    },
    methods: {
        getOrders() {
            axios.get('/comenzi', {
                headers: {
                    'Authorization': 'Bearer ' + this.isAuthenticated
                }
            })
                .then(response => {
                    this.orders = response.data;
                })
                .catch(error => {
                    console.log(error);
                });
        },
        orderBooks() {
            this.orders.forEach(async (order) => {
                const books = await this.getOrderBooks(order);
                this.mappedBooks[order.id] = books;
            });
            console.log(this.mappedBooks);
        },

        async getOrderBooks(order) {
            try {
                const response = await axios.get('/comanda-carti/' + order.id, {
                    headers: {
                        'Authorization': 'Bearer ' + this.isAuthenticated
                    }
                });
                return response.data;
            } catch (error) {
                console.log(error);
                return null;
            }
        },
        showBooks() {
            this.show = !this.show;
        },
        returnOrder(order, book) {
            axios.post('/retur', {
                id_comanda: order.id,
                id_carte: book.id,
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
        },
    }
}
</script>

<style scoped>
@font-face {
    font-family: 'Lora';
    src: url('/Fonts/static/Lora-Regular.ttf');
}

.card {
    margin-bottom: 30px;
    border: none;
    font-family: "Lora", serif;
    background-color: #FAFAFA;
}

.btn-primary {
    display: block;
    background-color: #00A896;
    border: none;
    width: 250px;
}

</style>
