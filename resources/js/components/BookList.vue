<template>
    <div class="book-list">
        <div class="row" style="margin-left: 10px">
            <div class="col" v-for="book in books" :key="book.id">
                <div class="card-wrapper">
                    <div ref="card" class="card mb-2">
                        <img class="card-img-top" :src="'/carti/' + book.imagine" alt="Card image cap" @click="redirectBook(book)">
                        <span v-if="isDiscounted(book)" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="margin-top: 10px">
                            {{ '-' +mappedDiscountedBooks[book.id] + '%' }}
                          </span>
                        <div class="card-body">
                            <div class="card">
                                <div class="card-body d-flex">
                                    <h5 class="flex-grow-1 card-title" @click="redirectBook(book)">{{ book.titlu }} - {{ book.autor }}</h5>
                                    <div style="margin: 10px">
                                        <img @click="addFavorite(book)" v-if="!checkFavorite(book)" :src="'/icons/heart-regular-1.svg'" alt="Heart SVG">
                                        <img @click="addFavorite(book)" v-else :src="'/icons/heart-solid-3.svg'" alt="Heart SVG">
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex">
                                <img :src="'/icons/star-solid-1.svg'" alt="Star SVG">
                                <p class="card-review">{{ formatRating(book.rating) }} ({{ book.nr_reviewuri }})</p>
                            </div>
                            <p v-if="!isDiscounted(book)" class="card-text card-price">{{ book.pret.toFixed(2) }} Lei</p>
                            <p v-else class="card-text card-price">{{ (book.pret.toFixed(2) - ((mappedDiscountedBooks[book.id] * book.pret) / 100)).toFixed(2) }} Lei <span class="text-decoration-line-through reduced-price">{{ book.pret.toFixed(2) }} Lei</span></p>
                            <a v-if="book.cantitate !== 0" @click="addToCart(book)" class="btn btn-primary">Adauga in cos</a>
                            <a v-else class="btn btn-primary disabled" style="background-color: rgba(23, 42, 58, 0.6)">Adauga in cos</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': csrfToken
};
export default {
    name: "BookList",
    props: ['books', 'token'],
    data() {
        return {
            cardElement: null,
            cardWidth: 0,
            favorite: [],
            discountedBooks: [],
            mappedDiscountedBooks: [],
        }
    },
    mounted() {
        this.getFavorite();
        this.getDiscounted();
    },
    watch: {
        books: {
            immediate: true,
            handler() {
                this.getCardWidth();
            }
        }
    },
    methods: {
        getCardWidth() {
            const cardElement = document.querySelector('.card');
            if (cardElement) {
                const cardRect = cardElement.getBoundingClientRect();
                this.cardWidth = cardRect.width;
            }
        },
        getFavorite() {
            if (this.token === null) return;
            axios.get('/favorite', {
                    headers: {
                        'Authorization': 'Bearer ' + this.token
                    }
                })
                .then(response => {
                    this.favorite = response.data;
                })
                .catch(error => {
                    console.log(error);
                });
        },
        checkFavorite(carte) {
            if (this.token === null) return false;

            for (let i = 0; i < this.favorite.length; i++) {
                if (this.favorite[i].id_carte === carte.id) {
                    return true;
                }
            }
            return false;
        },
        addFavorite(carte) {
            if (this.token === null) {
                window.location.href = '/autentificare';
            }
            axios.post('/favorite',
                {
                    id_carte: carte.id,
                },
                {
                headers: {
                    'Authorization': 'Bearer ' + this.token
                }
            })
                .then(response => {
                    this.getFavorite();
                })
                .catch(error => {
                    console.log(error);
                });
        },
        redirectBook(carte) {
            window.location.href = '/carte/' + carte.isbn;
        },
        addToCart(book) {
            if (this.token) {
                axios.post('/cos', {
                        id_carte: book.id,
                        cantitate: 1,
                        subtotal: this.isDiscounted(book) ? (book.pret.toFixed(2) - ((this.mappedDiscountedBooks[book.id] * book.pret) / 100)).toFixed(2) : book.pret.toFixed(2),
                    },
                    {
                        headers: {
                            'Authorization': 'Bearer ' + this.token
                        }
                    })
                    .then(response => {
                        console.log(response.data);
                    })
                    .catch(error => {
                        console.log(error);
                    })
            } else {
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
        formatRating(rating) {
            if (typeof rating === 'number' && !isNaN(rating)) {
                return rating.toFixed(2);
            } else {
                return rating;
            }
        },
    },
}
</script>

<style scoped>
@font-face {
    font-family: 'Lora';
    src: url('/Fonts/static/Lora-Regular.ttf');
}

.book-list {
    background-color: #FAFAFA;
    padding-top: 20px;
}

.card-wrapper {
    width: 200px;
    margin-right: 5px;
    margin-left: 5px;
    margin-bottom: 10px;
    display: inline-block;
    vertical-align: top;
}

.row {
    display: flex;
    flex-wrap: wrap;
}

.col {
    flex: 0 0 200px;
    margin-right: 5px;
    margin-left: 5px;
    margin-bottom: 10px;
}

.card {
    width: 100%;
    border: none;
    background-color: #FAFAFA;
}

.card-img-top {
    width: 100%;
    height: auto;
}

.card-body {
    padding: 0;
}

.card-title {
    display: -webkit-box;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 3;
    overflow: hidden;
    font-size: 18px;
    height: 70px;
    padding-top: 5px;
    font-family: "Lora",serif;
    color: #333333;
}

.card-price {
    display: -webkit-box;
    -webkit-box-orient: vertical;
    font-size: 20px;
    overflow: hidden;
    font-family: "Lora",serif;
    color: #333333;
}

.card-review {
    margin-bottom: 0;
    margin-left: 0;
    font-size: 16px;
    font-family: "Lora",serif;
}

.btn-primary {
    display: block;
    background-color: #00A896;
    border: none;
    margin-top: 1rem;
}

.reduced-price {
    font-size: 16px;
    margin-left: 10px;
    color: rgba(23, 42, 58, 0.6)
}
</style>

