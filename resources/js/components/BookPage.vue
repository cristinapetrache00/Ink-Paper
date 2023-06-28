<template>
    <div>
        <book-details :book="book" @bookList="redirectList"></book-details>
        <book-carousel :books="bookList" :title="sectionTitle" :style="{ marginTop: 150 + 'px'}"></book-carousel>
        <review :book="book" :style="{ marginTop: 150 + 'px' }"></review>
    </div>
</template>

<script>
import BookDetails from "./BookDetails.vue";
import BookCarousel from "./BookCarousel.vue";
import Review from "./Review.vue";
export default {
    name: "BookPage",
    props: ['book'],
    components: {
        BookDetails,
        BookCarousel,
        Review,
    },
    data() {
        return {
            bookList: null,
            sectionTitle: 'Te-ar putea interesa si ...',
        }
    },
    methods: {
        redirectList(bookList) {
            this.bookList = bookList;
        }
    }
}
</script>

<style scoped>

</style>
