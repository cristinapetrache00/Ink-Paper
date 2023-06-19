<template>
    <div class="book-filter">
        <div class="category-title d-flex justify-content-between align-items-center">
            <span>Sorteaza</span>
        </div>
        <div class="items" v-for="order in orders">
            <input type="checkbox" :value="order.order" v-model="selectedOrder" @change="applyFilters">
            <label :for="order.id">{{ order.name }}</label>
        </div>
        <div class="category-title d-flex justify-content-between align-items-center">
            <span>Pret</span>
            <svg @click="shrinkPrice" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-up-fill" viewBox="0 0 16 16">
                <path d="m7.247 4.86-4.796 5.481c-.566.647-.106 1.659.753 1.659h9.592a1 1 0 0 0 .753-1.659l-4.796-5.48a1 1 0 0 0-1.506 0z"/>
            </svg>
            <svg @click="expandPrice" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down-fill" viewBox="0 0 16 16">
                <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
            </svg>
        </div>
        <div v-if="priceExpanded" class="items" v-for="price in prices">
            <input type="checkbox" :value="price.pret" v-model="selectedPrice" @change="applyFilters">
            <label :for="price.id">{{ price.interval }}</label>
        </div>
        <div class="category-title d-flex justify-content-between align-items-center">
            <span>Categorii</span>
            <svg @click="shrinkCategory" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-up-fill" viewBox="0 0 16 16">
                <path d="m7.247 4.86-4.796 5.481c-.566.647-.106 1.659.753 1.659h9.592a1 1 0 0 0 .753-1.659l-4.796-5.48a1 1 0 0 0-1.506 0z"/>
            </svg>
            <svg @click="expandCategory" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down-fill" viewBox="0 0 16 16">
                <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
            </svg>
        </div>
        <div v-if="categoriesExpanded" class="items" v-for="category in categories">
            <input type="checkbox" :value="category.nume" v-model="selectedCategories" @change="applyFilters">
            <label :for="category.id">{{ category.nume }}</label>
        </div>
        <div class="category-title d-flex justify-content-between align-items-center">
            <span>Autori</span>
            <svg @click="shrinkAuthor" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-up-fill" viewBox="0 0 16 16">
                <path d="m7.247 4.86-4.796 5.481c-.566.647-.106 1.659.753 1.659h9.592a1 1 0 0 0 .753-1.659l-4.796-5.48a1 1 0 0 0-1.506 0z"/>
            </svg>
            <svg @click="expandAuthor" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down-fill" viewBox="0 0 16 16">
                <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
            </svg>
        </div>
        <div v-if="authorsExpanded" class="items" v-for="author in authors">
            <input type="checkbox" :value="author.autor" v-model="selectedAuthors" @change="applyFilters">
            <label :for="author.id">{{ author.autor }}</label>
        </div>
        <div class="category-title d-flex justify-content-between align-items-center">
            <span>Edituri</span>
            <svg @click="shrinkPublishing" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-up-fill" viewBox="0 0 16 16">
                <path d="m7.247 4.86-4.796 5.481c-.566.647-.106 1.659.753 1.659h9.592a1 1 0 0 0 .753-1.659l-4.796-5.48a1 1 0 0 0-1.506 0z"/>
            </svg>
            <svg @click="expandPublishing" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down-fill" viewBox="0 0 16 16">
                <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
            </svg>
        </div>
        <div v-if="publishingExpanded" class="items" v-for="publish in publishing">
            <input type="checkbox" :value="publish.editura" v-model="selectedPublishing" @change="applyFilters">
            <label :for="publish.id">{{ publish.editura }}</label>
        </div>
        <div class="category-title d-flex justify-content-between align-items-center">
            <span>Limbi</span>
            <svg @click="shrinkLanguage" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-up-fill" viewBox="0 0 16 16">
                <path d="m7.247 4.86-4.796 5.481c-.566.647-.106 1.659.753 1.659h9.592a1 1 0 0 0 .753-1.659l-4.796-5.48a1 1 0 0 0-1.506 0z"/>
            </svg>
            <svg @click="expandLanguage" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down-fill" viewBox="0 0 16 16">
                <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
            </svg>
        </div>
        <div v-if="languageExpanded" class="items" v-for="language in languages">
            <input type="checkbox" :value="language.limba" v-model="selectedLanguages" @change="applyFilters">
            <label :for="language.id">{{ language.limba }}</label>
        </div>
    </div>
</template>

<script>
export default {
    name: "BookFilter",
    data() {
        return {
            prices: null,
            categories: null,
            authors: null,
            publishing: null,
            languages: null,
            orders: null,

            categoriesExpanded: false,
            authorsExpanded: false,
            publishingExpanded: false,
            languageExpanded: false,
            priceExpanded: false,

            selectedOrder: [],
            selectedCategories: [],
            selectedAuthors: [],
            selectedPublishing: [],
            selectedLanguages: [],
            selectedPrice: [],
        };
    },
    mounted() {
        this.prices = [
            {id: 1, interval: '0 - 50', pret: [0, 50]},
            {id: 2, interval: '50 - 100', pret: [50, 100]},
            {id: 3, interval: '100 - 150', pret: [100, 150]},
        ];
        this.orders = [
            {id: 1, name: 'Pret crescator', order: 'pret_creascator'},
            {id: 2, name: 'Pret descrescator', order: 'pret_descrescator'},
            {id: 3, name: 'Alfabetic crescator', oreder: 'alfabetic_crescator'},
            {id: 4, name: 'Alfabetic descrescator', order: 'alfabetic_descrescator'},
        ]
        this.getFilters();
    },
    methods: {
        getFilters() {
            axios.get('/filtre')
                .then(response => {
                    this.categories = response.data.categorii;
                    this.authors = response.data.autori;
                    this.publishing = response.data.edituri;
                    this.languages = response.data.limbi;
                })
                .catch(error => {
                    console.log(error);
                });
        },

        applyFilters() {
            axios.post('/filtre', {
                autor: this.selectedAuthors,
                categorie: this.selectedCategories,
                editura: this.selectedPublishing,
                limba: this.selectedLanguages,
                pret: this.selectedPrice,
                ordine: this.selectedOrder,
            })
                .then(response => {
                    console.log(response.data);
                })
                .catch(error => {
                    console.log(error);
                });
        },

        expandCategory() {
            this.categoriesExpanded = true;
        },
        shrinkCategory() {
            this.categoriesExpanded = false;
        },
        expandAuthor() {
            this.authorsExpanded = true;
        },
        shrinkAuthor() {
            this.authorsExpanded = false;
        },
        expandPublishing() {
            this.publishingExpanded = true;
        },
        shrinkPublishing() {
            this.publishingExpanded = false;
        },
        expandLanguage() {
            this.languageExpanded = true;
        },
        shrinkLanguage() {
            this.languageExpanded = false;
        },
        expandPrice() {
            this.priceExpanded = true;
        },
        shrinkPrice() {
            this.priceExpanded = false;
        },
    },
};

</script>

<style scoped>
@font-face {
    font-family: 'Lora';
    src: url('/Fonts/static/Lora-Regular.ttf');
}

.items {
    font-family: "Lora",serif;
    display: flex;
    font-size: 14px;
    padding-top: 8px;
}

.book-filter {
    overflow: auto;
    position: fixed;
    font-size: 16px;
    /*font-weight: bold;*/
    top: 70px;
    bottom: 0;
    width: 380px;
    background-color: #FAFAFA;
    /*background-color: red;*/
    padding-top: 20px;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.category-title {
    font-family: "Lora",serif;
    font-size: 16px;
    font-weight: bold;
    /*margin-bottom: 0px;*/
    margin-left: -23px;
;
}

.category {
    font-family: "Lora",serif;
    display: flex;
    font-size: 14px;
    margin-left: -23px;
    padding-top: 8px;
}
</style>

