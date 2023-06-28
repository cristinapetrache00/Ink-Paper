<template>
    <div class="container" style="padding-top: 30px; padding-bottom: 30px">
        <h3 class="container d-flex justify-content-center"><strong>Contact</strong></h3>
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Adresa e-mail</label>
            <input type="email" class="form-control" id="exampleFormControlInput1" v-model="email" placeholder="name@example.com">
        </div>
        <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Mesaj</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" v-model="message" rows="3"></textarea>
        </div>
        <div class="d-flex justify-content-end">
            <button type="button" class="btn btn-primary" @click="sendContact">Trimite</button>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
axios.defaults.headers.common = {
    'X-Requested-With': 'XMLHttpRequest',
    'X-CSRF-TOKEN': csrfToken
};
export default {
    name: "ContactForm",
    data() {
        return {
            message: null,
            email: null,
        }
    },
    methods: {
        sendContact() {
            axios.post('/contact', {
                email: this.email,
                message: this.message,
            })
            .then(response => {
                this.email = '';
                this.message = '';
            })
            .catch(error => {
                console.log(error);
            });
        }
    }
}
</script>

<style scoped>
.container {
    background: #EDF6F6;
    color: #09554c;
    font-family: "Lora",serif;
    margin-left: 0;
    margin-right: 0;
}

.btn-primary {
    font-family: "Lora",serif;
    display: block;
    background-color: #00A896;
    border: none;
}
</style>
