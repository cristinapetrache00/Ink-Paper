<template>
<div class="sign-up-container">
    <div class="sign-up">
        <h2>Reseteaza parola</h2>
        <form @submit.prevent="reset">
            <div class="sign-up-input">
                <input type="password" v-model="parola" required="">
                <label>Parola noua</label>
            </div>
            <div class="sign-up-input">
                <input type="password" v-model="confirmare_parola" required="">
                <label>Confirmare parola</label>
            </div>
            <button type="submit" class="sign-up-button">Resetare</button>
        </form>
    </div>
</div>
</template>


<script>
import { mapMutations } from 'vuex';
import axios from 'axios';
const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': csrfToken
};
export default {
    name: "Signup",
    props: ['data'],
    data() {
        return {
            parola: null,
            confirmare_parola: null,
        }
    },
    mounted() {
        console.log(this.data);
    },
    methods: {
        reset() {
            if (this.parola !== this.confirmare_parola) {
                alert('Parolele nu coincid!');
                return;
            }
            axios.put('/reset-password', {
                email: this.data,
                parola: this.parola,
            })
                .then(response => {
                    window.location.href = '/principala';
                })
                .catch(error => {
                    console.log(error);
            })
        }
    }
}
</script>

<style scoped>
.sign-up-container {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 100px;
    margin-bottom: 100px;
}

.sign-up {
    width: 420px;
    padding: 50px;
    /*background: #F2EFE9;*/
    background: #fafafa;
    box-sizing: border-box;
    box-shadow: 0 15px 25px rgba(0,0,0,0.1);
    border-radius: 10px;
}

.sign-up h2 {
    margin: 0 0 40px;
    padding-bottom: 20px;
    color: #09554c;
    text-align: center;
}

.sign-up .sign-up-input {
    position: relative;
}

.sign-up .sign-up-input input {
    width: 100%;
    padding: 6px 0;
    font-size: 14px;
    color: #09554c;
    margin-bottom: 30px;
    border: none;
    border-bottom: 1px solid #09554c;
    outline: none;
    background: transparent;
}

.sign-up .sign-up-input label {
    position: absolute;
    top:0;
    left: 0;
    padding: 6px 0;
    font-size: 14px;
    color: #09554c;
    pointer-events: none;
    transition: .5s;
}

.sign-up .sign-up-input input:focus ~ label,
.sign-up .sign-up-input input:valid ~ label {
    top: -20px;
    left: 0;
    color: #333333;
    font-size: 12px;
}

.sign-up-button {
    display: block;
    margin: 40px auto 48px;
    padding: 14px 60px;
    background: linear-gradient(to left, #80CBC4, #008b7a);
    color: #ffffff;
    font: inherit;
    border: none;
    cursor: pointer;
    border-radius: 8px;

}

.sign-up-button:hover {
    background: linear-gradient(to right, #80CBC4, #008b7a);
}

.sign-up-switch {
    display: block;
    text-align: center;
    font-size: 16px;
    color: #333333;
}

.sign-up-switch a {
    text-decoration: none;
    color: #26A69A;
}

.sign-up-switch a:hover {
    text-decoration: underline;
}

</style>
