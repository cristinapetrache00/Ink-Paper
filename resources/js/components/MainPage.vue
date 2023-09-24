<template>
    <div>
        <book-carousel :books="bookLatest" :title="sectionLatest" :style="{ marginTop: 100 + 'px'}"></book-carousel>
        <book-carousel :books="bookDiscounted" :title="sectionDiscounted" :style="{ marginTop: 100 + 'px'}"></book-carousel>
        <contact-form :style="{ marginTop: 100 + 'px', marginBottom: 100 + 'px'}"></contact-form>
    </div>
</template>

<script>
import BookCarousel from "./BookCarousel.vue";
import ContactForm from "./ContactForm.vue";
import axios from "axios";
const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': csrfToken
};

export default {
    name: "MainPage",
    data() {
        return {
            bookLatest: [],
            sectionLatest: 'Noutati',
            bookDiscounted: [],
            sectionDiscounted: 'Promotii',
        }
    },
    components: {
        BookCarousel,
        ContactForm,
    },
    mounted() {
        this.getLatest();
        this.getDiscounted();
    },
    methods: {
        getLatest() {
            axios.get('/latest')
                .then(response => {
                    this.bookLatest = response.data;
                })
                .catch(error => {
                    console.log(error);
                });
        },
        getDiscounted() {
            axios.get('/discounted')
                .then(response => {
                    this.bookDiscounted = response.data;
                })
                .catch(error => {
                    console.log(error);
                });
        },
    }
}
</script>

<style scoped>

</style>
