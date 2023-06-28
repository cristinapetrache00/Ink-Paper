<template>
    <div v-if="bookList !== []">
        <book-list :books="booklist" :token="isAuthenticated"></book-list>
    </div>
</template>

<script>
import BookList from "./BookList.vue";
import axios from 'axios';
import {mapGetters} from "vuex";
const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': csrfToken
};
export default {
    name: "MyFavorites",
    components: {
        BookList,
    },
    data() {
        return {
            booklist : [],
            favorite: [],
            windowHeight: 0,
            windowWidth: 0,
        }
    },
    computed: {
        ...mapGetters(['isAuthenticated']),
    },
    mounted() {
        this.getWindowDimensions();
        this.getFavorite();
        setTimeout(() => {
            this.getCarti();
        }, 500);
    },
    methods: {
        getFavorite() {
            if (this.isAuthenticated === null) {
                window.location.href = '/autentificare';
            }
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
        getCarti() {
            if (this.favorite !== null) {
                this.favorite.forEach((item) => {
                    axios.get('/carti/' + item.id_carte)
                        .then(response => {
                            this.booklist.push(response.data);
                        })
                        .catch(error => {
                            console.log(error);
                        });
                })
            }
        },
        getWindowDimensions() {
            this.windowHeight = window.innerHeight;
            this.windowWidth = window.innerWidth;
        },
    }
}
</script>

<style scoped>

</style>
