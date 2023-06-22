<template>
    <div>
        <profile-navigation @changeTab="activeTab"></profile-navigation>
        <my-profile v-if="currentTab === 'date_personale'" class="top-margin"></my-profile>
    </div>
</template>


<script>
import ProfileNavigation from "./ProfileNavigation.vue";
import MyProfile from "./MyProfile.vue";
export default {
    name: "Profile",
    components: {
        ProfileNavigation,
        MyProfile
    },
    data() {
        return {
            currentTab: 'date_personale'
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
