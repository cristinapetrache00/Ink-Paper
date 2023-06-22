<template>
    <div class="book-list">
        <div class="row" style="margin-left: 10px">
            <div class="col" v-for="book in books" :key="book.id">
                <div class="card-wrapper">
                    <div ref="card" class="card mb-2">
                        <img class="card-img-top" :src="'/carti/' + book.imagine" alt="Card image cap">
                        <div class="card-body">
                            <div class="card">
                                <div class="card-body d-flex">
                                    <h5 class="flex-grow-1 card-title">{{ book.titlu }} - {{ book.autor }}</h5>
                                    <div style="margin: 10px">
                                        <img @click="addFavorite(book)" v-if="!checkFavorite(book)" :src="'/icons/heart-regular-1.svg'" alt="Heart SVG">
                                        <img @click="addFavorite(book)" v-else :src="'/icons/heart-solid-3.svg'" alt="Heart SVG">
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex">
                                <img :src="'/icons/star-solid-1.svg'" alt="Star SVG">
                                <p class="card-review">{{ book.rating }} ({{ book.nr_reviewuri }})</p>
                            </div>
                            <p class="card-text card-price">{{ book.pret }} Lei</p>
                            <a href="#" class="btn btn-primary">Cumpara acum</a>
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
        }
    },
    mounted() {
        this.getCardWidth();
        this.getFavorite();
    },
    methods: {
        getCardWidth() {
            this.cardElement = this.$refs.card.offsetWidth;
            if (this.cardElement) {
                this.cardWidth = this.cardElement.offsetWidth;}
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

.card {
    width: 100%;
    border: none;
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

.card-author {
    display: -webkit-box;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 2;
    font-size: 16px;
    height: 3rem;
    overflow: hidden;
    font-family: "Lora",serif;
    color: rgba(51, 51, 51, 0.6);
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
</style>

