<template>
    <nav class="navigation background" >
        <div class="left-section">
            <a href="/pagina-principala">
                <img v-bind:src="'/icons/logo.png'" width="210" height="44" alt="logo">
            </a>
            <form @submit.prevent="search()" class="search-container">
                <input type="search" class="search" v-model="titlu" placeholder="Search">
            </form>
        </div>
        <div class="right-section">
            <ul>
                <li><a href="#">Cont</a></li>
                <li><a href="#">Favorite</a></li>
                <li><a href="#">Cos</a></li>
                <li><a href="/pagina-donare">Doneaza</a></li>
                <li><a href="#">Inchiriaza</a></li>
            </ul>
        </div>
    </nav>
</template>

<script>
export default {
    name: "Navigation",
    data() {
        return {
            titlu: null
        }
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
    color: #FAFAFA;
    padding: 10px;
    transition: 0.5s ease;
}

.right-section ul:hover li a {
    color: #FAFAFA;
}

.right-section ul:hover li a:not(:hover) {
    color:white;
    opacity: 0.4;
    filter: blur(1px);
}

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

</style>
