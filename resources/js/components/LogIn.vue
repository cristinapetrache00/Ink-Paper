<template>
    <div class="log-in-container">
        <div class="log-in">
            <h2>Autentificare</h2>
            <form @submit.prevent="login()">
                <div class="log-in-input">
                    <input type="text" v-model="email" required="">
                    <label>E-mail</label>
                </div>
                <div class="log-in-input">
                    <input type="password" v-model="password" required="">
                    <label>Parola</label>
                </div>
                <span class="forget-password-switch">
                    <a @click="openPopup">Ti-ai uitat parola?</a>
                </span>
                <div v-if="showPopup" class="popup-container">
                    <div class="popup-content" :style="{ width: 600 + 'px' }">
                        <form>
                            <div class="mb-3">
                                <label for="pass" class="form-label">Email</label>
                                <input type="email" class="form-control" id="pass" v-model="resetMail">
                            </div>
                            <div class="d-flex justify-content-end" style="margin-top: 30px">
                                <button type="button" class="btn btn-primary" @click="sendRequest" style="margin-right: 10px">Submit</button>
                                <button type="button" class="btn btn-secondary" @click="closePopup">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
                <button type="submit" class="log-in-button">Conectare</button>
                <span class="log-in-switch">Nu ai cont? <a href="/inregistrare">Creeaza unul</a>
                </span>
            </form>
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
    name: "LogIn",
    data() {
        return {
            email: null,
            password: null,
            showPopup: false,
            resetMail: null,
        }
    },
    methods: {
        login() {
            const specialCharRegex = /@/;
            if (!specialCharRegex.test(this.email)) {
                alert('E-mail invalid');
                return;
            }
            axios.post('/login', {
                email: this.email,
                password: this.password
            })
                .then(response => {
                    const token = response.data.token;

                    this.$store.commit('setToken', token);
                    localStorage.setItem('token', token);

                    window.location.href = '/cautare';
                })
                .catch(error => {
                    alert('Datele introduse nu sunt corecte!')
                    console.error(error);
                });
        },
        openPopup() {
            this.showPopup = true;
        },
        closePopup() {
            this.showPopup = false;
        },
        sendRequest() {
            axios.post('/reset-request', {
                email: this.resetMail
            })
                .then(response => {
                    console.log(response.data);
                    this.closePopup();
                })
                .catch(error => {
                    console.error(error);
            })
        }
    }
}
</script>

<style scoped>
.log-in-container {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 100px;
    margin-bottom: 100px;
}

.log-in {
    width: 420px;
    padding: 50px;
    background: #fafafa;
    box-sizing: border-box;
    box-shadow: 0 15px 25px rgba(0,0,0,0.1);
    border-radius: 10px;
}

.log-in h2 {
    margin: 0 0 40px;
    padding-bottom: 20px;
    color: #09554c;
    text-align: center;
}

.log-in .log-in-input {
    position: relative;
}

.log-in .log-in-input input {
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

.log-in .log-in-input label {
    position: absolute;
    top:0;
    left: 0;
    padding: 6px 0;
    font-size: 14px;
    color: #09554c;
    pointer-events: none;
    transition: .5s;
}

.log-in .log-in-input input:focus ~ label,
.log-in .log-in-input input:valid ~ label {
    top: -20px;
    left: 0;
    color: #333333;
    font-size: 12px;
}

.forget-password-switch {
    display: block;
    margin-top: 0;
}

.forget-password-switch a{
    font-size: 14px;
    color: #333333;
}

.forget-password-switch a {
    text-decoration: none;
}

.forget-password-switch a:hover {
    text-decoration: underline;
}

.log-in-button {
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

.log-in-button:hover {
    background: linear-gradient(to right, #80CBC4, #008b7a);
}

.log-in-switch {
    display: block;
    text-align: center;
    font-size: 16px;
    color: #333333;
}

.log-in-switch a {
    text-decoration: none;
    color: #26A69A;
}

.log-in-switch a:hover {
    text-decoration: underline;
}

.popup-container {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
}

.popup-content {
    background-color: #fff;
    padding: 20px;
    border-radius: 4px;
}

.btn-primary {
    display: block;
    background-color: #00A896;
    border: none;
    width: auto;
}
</style>

