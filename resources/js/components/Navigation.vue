<template>
    <nav class="navigation background" >
        <div class="left-section">
            <a href="/principala">
                <img v-bind:src="'/icons/logo.png'" width="210" height="44" alt="logo">
            </a>
            <form @submit.prevent="search()" class="search-container">
                <input type="search" class="search" v-model="titlu" placeholder="Search">
            </form>
        </div>
        <div class="right-section">
            <ul>
                <li>
                    <div class="dropdown">
                        <a class="dropdown-toggle" href="#" role="button" @click="toggleDropdown" :aria-expanded="isDropdownOpen.toString()">
                            Dropdown
                        </a>
                        <ul v-if="isLogged" class="dropdown-menu" v-show="isDropdownOpen" @click="closeDropdown">
                            <li><a class="dropdown-item" @click="profile">Profil</a></li>
                            <li><a class="dropdown-item" @click="logout">Logout</a></li>
                        </ul>
                        <ul v-else class="dropdown-menu" v-show="isDropdownOpen" @click="closeDropdown">
                            <li><a class="dropdown-item" @click="login">Login</a></li>
                            <li><a class="dropdown-item" @click="register">Autentificare</a></li>
                        </ul>
                    </div>
                </li>
                <li><a href="#">Favorite</a></li>
                <li><a href="#">Cos</a></li>
                <li><a href="/pagina-donare">Doneaza</a></li>
                <li><a @click="mail">Inchiriaza</a></li>
            </ul>
        </div>
    </nav>
</template>

<script>
import { mapGetters } from 'vuex';
import axios from 'axios';
const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': csrfToken
};
export default {
    name: "Navigation",
    data() {
        return {
            titlu: null,
            isDropdownOpen: false,
            isLogged: false
        }
    },
    computed: {
        ...mapGetters(['isAuthenticated']),
    },
    mounted() {
        this.isLogged = this.isAuthenticated !== null;
    },
    methods: {
        search() {
            axios.post('/search', {
                titlu: this.titlu
            })
                .then(response => {
                    window.location.href = response.data;
                })
                .catch(error => {
                    console.error(error);
                });
        },
        toggleDropdown() {
            this.isDropdownOpen = !this.isDropdownOpen;
        },
        closeDropdown() {
            this.isDropdownOpen = false;
        },
        logout() {
            axios.post('/user/logout', {},
                {
                headers: {
                    'Authorization': 'Bearer ' + this.isAuthenticated
                }
                })
                .then(response => {
                    this.$store.commit('setToken', null);
                    localStorage.removeItem('token');
                    window.location.href = '/cautare';
                })
                .catch(error => {
                    console.error(error);
                });
        },
        login() {
            window.location.href = '/autentificare';
        },
        register() {
            window.location.href = '/inregistrare';
        },
        profile() {
            window.location.href = '/profil';
        },
        mail() {
            axios.post('/mail', {})
                .then(response => {
                    console.log('done')
                })
                .catch(error => {
                    console.error(error);
                });
        }
    }
}
</script>

<style scoped>
@font-face {
    font-family: 'Lora';
    src: url('/Fonts/static/Lora-Regular.ttf');
}

.navigation {
    /*background-color: #048399;*/
    background-color: #008b7a;
    height: 70px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.left-section {
    /*position: relative;*/
    /*height: 70px;*/
    width: 480px;
    /*display: flex;*/
    /*justify-content: center;*/
    /*align-items: center;*/
}

.right-section ul {
    font-family: "Lora",serif;
    display: flex;
    /*gap: 10px;*/
    gap: 7px;
    /*padding-right: 125px;*/
}

.right-section ul li {
    list-style: none;
}

.right-section ul li a {
    /*font-size: 18px;*/
    font-size: 17px;
    font-weight: 700;
    text-decoration: none;
    padding: 10px;
    transition: 0.5s ease;
}

/*.right-section ul:hover li a {*/
/*    color: #FAFAFA;*/
/*}*/

/*.right-section ul:hover li a:not(:hover) {*/
/*    color:white;*/
/*    opacity: 0.4;*/
/*    filter: blur(1px);*/
/*}*/

.search-container{
    position: fixed;
    top: 0;
    left: 30%;
}

.search {
    height: 40px;
    width: 510px;
    background-color: #FAFAFA;
    font-family: "Lora", serif;
    font-size: 14px;
    border: none;
    border-radius: 8px;
    padding-left: 40px;
    background-image: url("/icons/magnifying-glass-solid.svg");
    background-size: 16px 16px;
    background-position-y: center;
    background-position-x: 12px;
    background-repeat: no-repeat;
    outline: none;
    box-shadow: 0 0 0 2px #008b7a;
}

.dropdown-menu {
    display: none;
    position: absolute;
    z-index: 1000;
    min-width: 10rem;
    padding: 0.5rem 0;
    margin: 0.125rem 0 0;
    font-size: 1rem;
    color: #212529;
    text-align: left;
    list-style: none;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid rgba(0, 0, 0, 0.15);
    border-radius: 0.25rem;
    column-count: 1; /* Display items in a single column */
    column-gap: 0;
}

.dropdown-menu li {
    padding: 0.25rem 1.5rem;
}

.dropdown-menu li:hover {
    background-color: #fff;
}

.dropdown-menu li a {
    color: #000000;
    text-decoration: none;
}

.dropdown-menu .dropdown-divider {
    margin: 0.5rem 0;
    border: none;
    border-top: 1px solid rgba(0, 0, 0, 0.15);
}

.dropdown-item {
    color: #000000;
}
</style>
