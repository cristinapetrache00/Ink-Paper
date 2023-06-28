<template>
    <div class="container-fluid">

        <div class="ctg-title" style="margin-top: 0; padding-top: 20px">
            <span>Sorteaza</span>
        </div>
        <div class="container-fluid ctg" :style="{ height: 120 + 'px' }">
            <div class="items" v-for="order in orders">
                <input type="radio" :value="order.order" v-model="selectedOrder" @change="applyFilters">
                <label :for="order.id">{{ order.name }}</label>
            </div>
        </div>

        <div class="ctg-title">
            <span>Pret</span>
        </div>
        <div class="container-fluid ctg" :style="{ height: 90 + 'px' }">
            <div class="items" v-for="price in prices">
                <input type="radio" :value="price.pret" v-model="selectedPrice" @change="applyFilters">
                <label :for="price.id">{{ price.interval }}</label>
            </div>
        </div>

        <div class="ctg-title">
            <span>Categorii</span>
        </div>
        <div class="container-fluid ctg" :style="{ height: 300 + 'px' }">
            <div class="items" v-for="category in categories">
                <input type="checkbox" :value="category.nume" v-model="selectedCategories" @change="applyFilters">
                <label :for="category.id">{{ category.nume }}</label>
            </div>
        </div>

        <div class="ctg-title">
            <span>Autori</span>
        </div>
        <div class="container-fluid ctg" :style="{ height: 300 + 'px' }">
            <div class="items" v-for="author in authors">
                <input type="checkbox" :value="author.autor" v-model="selectedAuthors" @change="applyFilters">
                <label :for="author.id">{{ author.autor }}</label>
            </div>
        </div>

        <div class="ctg-title">
            <span>Edituri</span>
        </div>
        <div class="container-fluid ctg" :style="{ height: 300 + 'px' }">
            <div class="items" v-for="publish in publishing">
                <input type="checkbox" :value="publish.editura" v-model="selectedPublishing" @change="applyFilters">
                <label :for="publish.id">{{ publish.editura }}</label>
            </div>
        </div>

        <div class="ctg-title">
            <span>Limbi</span>
        </div>
        <div class="container-fluid ctg" :style="{ height: 90 + 'px' }">
            <div class="items" v-for="language in languages">
                <input type="checkbox" :value="language.limba" v-model="selectedLanguages" @change="applyFilters">
                <label :for="language.id">{{ language.limba }}</label>
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
            {id: 1, name: 'Pret crescator', order: 'pret_crescator'},
            {id: 2, name: 'Pret descrescator', order: 'pret_descrescator'},
            {id: 3, name: 'Alfabetic crescator', order: 'alfabetic_crescator'},
            {id: 4, name: 'Alfabetic descrescator', order: 'alfabetic_descrescator'},
        ]
        this.getFilters();
    },
    beforeUnmount() {
        window.removeEventListener('resize', this.getWindowDimensions);
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
            console.log(this.selectedOrder)
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
                    this.$emit('filtered', response.data);
                })
                .catch(error => {
                    console.log(error);
                });
        },
    },
};

</script>

<style scoped>

@font-face {
    font-family: 'Lora';
    src: url('/Fonts/static/Lora-Regular.ttf');
}

.ctg {
    overflow-y: auto;
    padding-left: 20px;
    padding-right: 20px;
}

::-webkit-scrollbar-track {
    background-color: #F0F1F2;
    border-radius: 10px;
}

::-webkit-scrollbar-thumb {
    background-color: #FFB6B9;
    border-radius: 10px;
    border: 3px solid #FFB6B9;
}

::-webkit-scrollbar-thumb:hover {
    background-color: #FFB6B9;
}

::-webkit-scrollbar-corner {
    background-color: #FFB6B9;
}

::-webkit-scrollbar {
    width: 10px;
    height: 10px;
}

.ctg-title {
    font-family: "Lora",serif;
    font-size: 20px;
    font-weight: bold;
    padding-left: 20px;
    margin-top: 20px;
}

.items {
    font-family: "Lora",serif;
    display: flex;
    font-size: 14px;
    padding-top: 8px;
}
</style>

