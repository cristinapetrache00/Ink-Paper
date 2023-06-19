<template>
    <div class="book-list">
        <div>
            <div class="row">
                <div class="col-md-4" v-for="book in books" :key="book.id">
                    <div class="card mb-3">
                        <img class="card-img-top" src="" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title">{{ book.titlu }}</h5>
                            <p class="card-text">{{ book.autor }}</p>
                            <a href="#" class="btn btn-primary">Cumpara acum</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "BookList",
    props: ['books'],
    mounted() {
        this.test()
    },
    methods: {
        test() {
            console.log("AAAA", this.books)
        }
    }
}
</script>

<style scoped>
.book-list {
    position: fixed;
    top: 70px;
    left: 280px;
    bottom: 0;
    width: calc(100% - 280px);
    background-color: #FAFAFA;
}
</style>

