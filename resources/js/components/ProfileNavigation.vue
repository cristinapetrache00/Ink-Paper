<template>
    <div class="nav-container">
        <ul class="nav nav-underline">
            <li class="nav-item">
                <a
                    :class="['nav-link', { active: currentTab === 'date_personale' }]"
                    href="/profil/date_personale"
                    @click="changeTab('date_personale')"
                >
                    Date personale
                </a>
            </li>
            <li class="nav-item">
                <a
                    :class="['nav-link', { active: currentTab === 'comenzile_mele' }]"
                    href="/profil/comenzile_mele"
                    @click="changeTab('comenzile_mele')"
                >
                    Comenzile mele
                </a>
            </li>
            <li class="nav-item">
                <a
                    :class="['nav-link', { active: currentTab === 'produse_cumparate' }]"
                    href="/profil/produse_cumparate"
                    @click="changeTab('produse_cumparate')"
                >
                    Produse cumparate
                </a>
            </li>
            <li class="nav-item">
                <a
                    :class="['nav-link', { active: currentTab === 'produse_favorite' }]"
                    href="/profil/produse_favorite"
                    @click="changeTab('produse_favorite')"
                >
                    Produse favorite
                </a>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    name: "ProfileNavigation",
    props: ['accessedTab'],
    data() {
        return {
            currentTab: null,
        }
    },
    computed: {
        underlineStyle() {
            const activeLink = document.querySelector('.nav-link.active');
            if (activeLink) {
                const { left, width } = activeLink.getBoundingClientRect();
                return {
                    left: `${left}px`,
                    width: `${width}px`,
                };
            }
            return {};
        },
    },
    mounted() {
        setTimeout(() => {
            console.log(this.accessedTab)
            if (this.accessedTab !== null) {
                this.currentTab = this.accessedTab;
            } else {
                this.currentTab = 'date_personale';
            }
        }, 500);

    },
    methods: {
        changeTab(tab) {
            this.currentTab = tab;
            this.$emit('changeTab', tab);
        }
    }
}
</script>

<style scoped>
.nav-container {
    border-bottom: 1px solid #ccc; /* Add a border as a separator */
}

.nav-underline {
    display: flex; /* Display items in a row */
    justify-content: space-between; /* Add space between items */
    padding: 0;
    list-style: none;
}

.nav-item {
    flex: 1; /* Distribute the width evenly among items */
}

.nav-link {
    display: block;
    padding: 10px;
    text-align: center;
    text-decoration: none;
    color: #000;
}

.nav-link.active {
    font-weight: bold;
}
</style>
