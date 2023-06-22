<template>
    <div>
        <div :style="{ float: 'left', width: 350 + 'px', }">
            <book-filter @filtered="handleData"></book-filter>
        </div>
        <div :style="{ marginLeft: 350 + 'px', width: 1000 + 'px' }" v-if="!!emittedData">
            <book-list :books="emittedData" :token="isAuthenticated"></book-list>
        </div>
    </div>
</template>

<script>
import BookList from "./BookList.vue";
import BookFilter from "./BookFilter.vue";
import { mapGetters } from 'vuex';
import axios from 'axios';
const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': csrfToken
};
export default {
    name: "Books",
    props: ['books'],
    components: {
        BookList,
        BookFilter
    },
    data() {
        return {
            emittedData: null,
            windowHeight: 0,
            windowWidth: 0,
        };
    },
    computed: {
        ...mapGetters(['isAuthenticated']),
    },
    mounted() {
        this.getWindowDimensions();
        window.addEventListener('resize', this.getWindowDimensions);
        if (this.books) {
            this.emittedData = this.books;
        }
    },
    methods: {
        handleData(filtered) {
            this.emittedData = filtered;
        },
        getWindowDimensions() {
            this.windowHeight = window.innerHeight;
            this.windowWidth = window.innerWidth;
        },
    }
}
</script>

<style>

</style>
