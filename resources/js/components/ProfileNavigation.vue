<template>
    <div class="nav-container">
        <ul class="nav nav-underline">
            <li class="nav-item">
                <a
                    :class="['nav-link', { active: currentTab === 'date_personale' }]"
                    href="#"
                    @click="changeTab('date_personale')"
                >
                    Date personale
                </a>
            </li>
            <li class="nav-item">
                <a
                    :class="['nav-link', { active: currentTab === 'comenzile_mele' }]"
                    href="#"
                    @click="changeTab('comenzile_mele')"
                >
                    Comenzile mele
                </a>
            </li>
            <li class="nav-item">
                <a
                    :class="['nav-link', { active: currentTab === 'produse_cumparate' }]"
                    href="#"
                    @click="changeTab('produse_cumparate')"
                >
                    Produse cumparate
                </a>
            </li>
            <li class="nav-item">
                <a
                    :class="['nav-link', { active: currentTab === 'produse_favorite' }]"
                    href="#"
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
    data() {
        return {
            currentTab: 'date_personale',
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

.nav-underline-line {
    position: absolute;
    bottom: 0;
    height: 2px;
    background-color: #000; /* Change this to your desired underline color */
    transition: all 0.3s ease;
}
</style>
