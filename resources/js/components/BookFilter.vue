<template>
    <div class="book-filter">
            <h2>Categories</h2>
            <div class="category" v-for="category in categories" :key="category.id">
                <input type="checkbox" :id="category.id" v-model="selectedCategories" :value="category.id">
                <label :for="category.id">{{ category.name }}</label>

            </div>
    </div>
</template>

<script>
// export default {
//     name: "BookFilter"
export default {
    data() {
        return {
            categories: [
                { id: 1, name: 'Category 1' },
                { id: 2, name: 'Category 2' },
                { id: 3, name: 'Category 3' },
                // Add more categories here
            ],
            selectedCategories: [],
        };
    },
};

</script>

<style scoped>
.book-filter {
    position: fixed;
    top: 70px;
    left: 0;
    bottom: 0;
    width: 280px;
    background-color: #FAFAFA;
    padding: 20px;
}

.category {
    display: flex;
    align-items: center;
    padding: 10px;
    border-bottom: 1px solid #E0E0E0;
}
</style>

