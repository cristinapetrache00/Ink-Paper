<template>
    <div class="d-flex justify-content-center" style="margin-top: 100px">
        <div class="card mb-3" style="width: 100%">
            <div class="row">
                <div class="col-md-auto">
                    <img :src="'/carti/' + book.imagine" class="img-fluid rounded-start" alt="..." style="height: 500px; width: auto">
                    <span v-if="isDiscounted(book)" class="position-absolute top-0  translate-middle badge rounded-pill bg-danger" style="margin-top: 10px">
                            {{ '-' +mappedDiscountedBooks[book.id] + '%' }}
                          </span>
                </div>
                <div class="col">
                    <div class="card-body">
                        <h4 class="card-title">{{ book.titlu }}</h4>
                        <div class="container d-flex align-content-center justify-content-start" style="margin-bottom: 10px; padding-left: 0">
                            <img :src="'/icons/star-solid-1.svg'" alt="Heart SVG">
                            <p class="card-text">{{ book.rating }} ({{ book.nr_reviewuri }})</p>
                        </div>
                        <p class="card-text">Autor: {{ book.autor}} </p>
                        <p class="card-text">Editura: {{ book.editura }} </p>
                        <div class="container d-flex align-content-center" style="padding-left: 0">
                            <p class="card-text">Categorie:&nbsp</p>
                            <p class="card-text" v-for="(categorie) in categorii"> {{ categorie.nume }},&nbsp</p>
                        </div>
                        <p class="card-text">Anul aparitiei: {{ book.an_aparitie }} </p>
                        <p class="card-text">Numar pagini: {{ book.nr_pg }} </p>
                        <p class="card-text">ISBN: {{ book.isbn }} </p>
                        <p class="card-text">Tip coperta: {{ book.tip_coperta }} </p>
                        <p class="card-text">Limba: {{ book.limba }} </p>
                        <p class="card-text">Dimensiuni: {{ book.dimensiune }} </p>
                    </div>
                </div>
                <div class="col">
                    <div class="card-body price">
                        <h5 v-if="!isDiscounted(book)" class="card-title card-price">Pret: {{ book.pret.toFixed(2) }} Lei</h5>
                        <h5 v-else class="card-title card-price">Pret: {{ (book.pret.toFixed(2) - ((mappedDiscountedBooks[book.id] * book.pret) / 100)).toFixed(2) }} Lei <span class="text-decoration-line-through reduced-price">{{ book.pret.toFixed(2) }} Lei</span></h5>

                        <p class="card-text">Stoc: {{availability}}</p>
                        <a v-if="availability !== 'Indisponibil'" @click="addToCart(book)" class="btn btn-primary">Adauga in cos</a>
                        <a v-else class="btn btn-primary disabled" style="background-color: rgba(23, 42, 58, 0.6)">Adauga in cos</a>
                        <a v-if="!checkFavorite(book)" @click="addFavorite(book)" class="btn btn-primary-outline">Adauga la favorite</a>
                        <a v-else @click="addFavorite(book)" class="btn btn-primary-full">Sterge de la favorite</a>
                    </div>
                </div>
            </div>
        </div>
<!--        <book-carousel :books="bookList"></book-carousel>-->
    </div>
</template>

<script>
import BookCarousel from "./BookCarousel.vue";
import axios from 'axios';
import {mapGetters} from "vuex";
const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': csrfToken
};
export default {
    name: "BookDetails",
    components: {
        BookCarousel,
    },
    props: ['book'],
    data() {
        return {
            availability: null,
            bookList: null,
            favorite: [],
            categorii: '',
            discountedBooks: [],
            mappedDiscountedBooks: [],
        }
    },
    mounted() {
        this.getCategorii();
        this.checkAvailability();
        this.getRecommandations();
        this.getFavorite();
        this.getDiscounted();
    },
    computed: {
        ...mapGetters(['isAuthenticated']),
    },
    methods: {
        checkAvailability() {
            if (this.book.cantitate > 0) {
                if (this.book.cantitate < 5) {
                    this.availability = 'Ultimele exemplare';
                } else {
                    this.availability = 'In stoc';
                }
            } else {
                this.availability = 'Indisponibil';
            }
        },
        getRecommandations() {
            axios.get('/carti/recomandari/' + this.book.id)
                .then(response => {
                    console.log(response.data);
                    this.bookList = response.data;
                    this.$emit('bookList', this.bookList);
                })
                .catch(error => {
                    console.log(error);
                })
        },
        checkFavorite(carte) {
            if (this.isAuthenticated === null) return false;

            for (let i = 0; i < this.favorite.length; i++) {
                if (this.favorite[i].id_carte === carte.id) {
                    return true;
                }
            }
            return false;
        },
        getFavorite() {
            if (this.isAuthenticated === null) return;
            axios.get('/favorite', {
                headers: {
                    'Authorization': 'Bearer ' + this.isAuthenticated
                }
            })
                .then(response => {
                    this.favorite = response.data;
                })
                .catch(error => {
                    console.log(error);
                });
        },
        addFavorite(carte) {
            if (this.isAuthenticated === null) {
                window.location.href = '/autentificare';
            }
            axios.post('/favorite',
                {
                    id_carte: carte.id,
                },
                {
                    headers: {
                        'Authorization': 'Bearer ' + this.isAuthenticated
                    }
                })
                .then(response => {
                    this.getFavorite();
                })
                .catch(error => {
                    console.log(error);
                });
        },
        getCategorii() {
            axios.get('/carti/categorii/' + this.book.id)
                .then(response => {
                    this.categorii = response.data;
                })
                .catch(error => {
                    console.log(error);
                })
        },
        addToCart(book) {
            if (this.isAuthenticated) {
                axios.post('/cos', {
                        id_carte: book.id,
                        cantitate: 1,
                        subtotal: this.isDiscounted(book) ? (book.pret.toFixed(2) - ((this.mappedDiscountedBooks[book.id] * book.pret) / 100)).toFixed(2) : book.pret.toFixed(2),
                    },
                    {
                        headers: {
                            'Authorization': 'Bearer ' + this.isAuthenticated
                        }
                    })
                    .then(response => {
                        console.log(response.data);
                    })
                    .catch(error => {
                        console.log(error);
                    })            } else {
                axios.post('/cos', {
                    id_carte: book.id,
                    cantitate: 1,
                    subtotal: this.isDiscounted(book) ? (book.pret.toFixed(2) - ((this.mappedDiscountedBooks[book.id] * book.pret) / 100)).toFixed(2) : book.pret.toFixed(2),
                })
                    .then(response => {
                        console.log(response.data);
                    })
                    .catch(error => {
                        console.log(error);
                    })
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
    }
}
</script>

<style scoped>
.price {
    border-left: rgba(0, 0, 0, 0.1) 1px solid;
    height: 100%;
}

.card {
    border: none;
    background-color: #FAFAFA;
}

.card-title {
    display: -webkit-box;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 2;
    overflow: hidden;
    font-weight: 700;
    height: 50px;
    padding-top: 5px;
    font-family: "Lora",serif;
    color: #333333;
}

.card-text {
    display: -webkit-box;
    -webkit-box-orient: vertical;
    overflow: hidden;
    font-size: 18px;
    font-family: "Lora",serif;
    color: #333333;
}

.btn-primary {
    font-family: "Lora",serif;
    display: block;
    background-color: #00A896;
    border: none;
}

.btn-primary-outline {
    font-family: "Lora",serif;
    display: block;
    background-color: transparent;
    border: 1px solid #FFB6B9;
    margin-top: 10px;
    color: #FFB6B9
}

.btn-primary-full {
    font-family: "Lora",serif;
    display: block;
    background-color: #FFB6B9;
    border: none;
    margin-top: 10px;
    color: #fff
}

.reduced-price {
    font-size: 16px;
    margin-left: 10px;
    color: rgba(23, 42, 58, 0.6)
}
</style>
