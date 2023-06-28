<template>
    <div>
        <profile-navigation @changeTab="activeTab" :accessedTab="currentTab"></profile-navigation>
        <my-profile v-if="currentTab === 'date_personale'" class="top-margin"></my-profile>
        <my-favorites v-if="currentTab === 'produse_favorite'" class="top-margin"></my-favorites>
        <my-orders v-if="currentTab === 'comenzile_mele'" class="top-margin"></my-orders>
        <my-products v-if="currentTab === 'produse_cumparate'" class="top-margin"></my-products>

    </div>
</template>


<script>
import ProfileNavigation from "./ProfileNavigation.vue";
import MyProfile from "./MyProfile.vue";
import MyFavorites from "./MyFavorites.vue";
import MyOrders from "./MyOrders.vue";
import MyProducts from "./MyProducts.vue";
export default {
    name: "Profile",
    props: ['ref1'],
    components: {
        ProfileNavigation,
        MyProfile,
        MyFavorites,
        MyOrders,
        MyProducts,
    },
    data() {
        return {
            currentTab: null,
        }
    },
    mounted() {
        if (this.ref1 !== null) {
            this.currentTab = this.ref1;
        } else {
            this.currentTab = 'date_personale';
        }
    },
    methods: {
        activeTab(tab) {
            this.currentTab = tab;
        }
    }
}
</script>

<style scoped>
    .top-margin {
        margin-top: 80px;
    }
</style>
