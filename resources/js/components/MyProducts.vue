<template>
    <div v-if="products !== []">
        <book-list :books="products" :token="isAuthenticated"></book-list>
    </div>
</template>

<script>
import BookList from "./BookList.vue";
import { mapGetters } from 'vuex';
import axios from 'axios';
const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': csrfToken
};
export default {
    name: "MyProducts",
    components: {
        BookList,
    },
    data() {
        return {
            products: [],
            windowHeight: 0,
            windowWidth: 0,
        }
    },
    computed: {
        ...mapGetters(['isAuthenticated']),
    },
    mounted() {
        this.getWindowDimensions();
        setTimeout(() => {
            this.getProducts();
        }, 500);
    },
    methods: {
        getProducts() {
            if (this.isAuthenticated) {
                axios.get('/comenzi-carti', {
                    headers: {
                        'Authorization': 'Bearer ' + this.isAuthenticated
                    }
                })
                    .then(response => {
                        this.products = response.data;
                    })
                    .catch(error => {
                        console.log(error);
                    });
            } else {
                window.location.href = '/autentificare';
            }
        },
        getWindowDimensions() {
            this.windowHeight = window.innerHeight;
            this.windowWidth = window.innerWidth;
        },
    },
}
</script>

<style scoped>

</style>
