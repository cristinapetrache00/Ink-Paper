<template>
    <div class="donation-container">
        <div class="donation" :class="{ 'donation-step1': step === 1, 'donation-step2': step === 2 }">
            <form action="">
                <div v-show="step===1">
                    <h2>Informatii donator</h2>
                    <div class="donation-input">
                        <input type="text" name="" required title="">
                        <label>Nume</label>
                    </div>
                    <div class="donation-input">
                        <input type="text" name="" required="">
                        <label>Prenume</label>
                    </div>
                    <div class="donation-input">
                        <input type="email" name="" required="">
                        <label>Email</label>
                    </div>
                    <div class="donation-input">
                        <input type="tel" name="" required="">
                        <label>Telefon</label>
                    </div>
                    <button type="button" class="donation-button-next" @click="nextStep()">Continua</button>
                    </div>

                <div v-show="step===2">
                    <h2>Detalii donatie</h2>
                    <div v-for="(book, index) in books" :key="index">
                        <div class="donation-details">
                            <div class="donation-input">
                                <input type="text" name=""  required title="">
                                <label>Titlu</label>
                            </div>
                            <div class="donation-input">
                                <input type="text" name="" required="">
                                <label>Autor</label>
                            </div>
                            <div class="donation-input">
                                <input type="text" name="" required="">
                                <label>ISBN</label>
                            </div>
                            <div class="buttons-container">
                                <button type="button" class="add-button" @click="addBook()">+</button>
                                <button type="button" class="remove-button" @click="removeBook(index)">-</button>
                            </div>
                        </div>
                    </div>
                    <div class="navigation-buttons-container">
                        <button type="button" class="donation-button-next-prev" @click="prevStep()">Inapoi</button>
                        <button type="button" class="donation-button-next-prev" @click="nextStep()">Continua</button>
                    </div>
                </div>

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
    name: "DonationForm",
    data() {
        return {
            step: 1,
            books: [
                { titlu: '', autor: '', isbn: '' }
            ]
        };
    },
    methods: {
        nextStep() {
            this.step++;
        },
        prevStep() {
            this.step--;
        },
        addBook() {
            this.books.push({ titlu: '', autor: '', isbn: '' });
        },
        removeBook(index) {
            this.books.splice(index,1);
            }
        }
}
</script>

<style scoped>
.donation-container {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 100px;
    margin-bottom: 100px;
}

.donation {
    /*width: 380px;*/
    position: relative;
    padding: 50px;
    background: #fafafa;
    box-sizing: border-box;
    box-shadow: 0 15px 25px rgba(0,0,0,0.1);
    border-radius: 10px;
}

.donation-step1 {
    width: 420px;
}

.donation-step2 {
    width: 950px;
}

.donation-details{
    display:flex;
    flex-direction: row;
    align-items: center;
    gap: 100px;
}

.donation .donation-details .donation-input input{
    width: 140%;
}

.buttons-container {
    display: flex;
    margin-bottom: 20px;
    gap: 2px;
}

.add-button {
    width: 20px;
    height: 20px;
    border: none;
    border-radius: 2px;
    background-color: #FFB6B9;
    /*border-width: 1px;*/
    /*border-color: white;*/
}

.remove-button {
    width: 20px;
    height: 20px;
    border: none;
    border-radius: 2px;
    background-color: #FFB6B9;
}

.donation h2 {
    margin: 0 0 40px;
    padding-bottom: 20px;
    color: #09554c;
    text-align: center;
}

.donation .donation-input {
    position: relative;
}

.donation .donation-input input {
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

.donation .donation-input label {
    position: absolute;
    top:0;
    left: 0;
    padding: 6px 0;
    font-size: 14px;
    color: #09554c;
    pointer-events: none;
    transition: .5s;
}

.donation .donation-input input:focus ~ label,
.donation .donation-input input:valid ~ label {
    top: -20px;
    left: 0;
    color: #333333;
    font-size: 12px;
}

.navigation-buttons-container {
    display: flex;
    justify-content: space-between;
    margin-left: 0;
    right: 0;
}

.donation-button-next {
    color: #fff;
    font: inherit;
    padding: 12px 25px;
    border-radius: 8px;
    cursor: pointer;
    background: linear-gradient(to left, #80CBC4, #008b7a);
    /*border: 2px solid rgba(0,0,0,0.5);*/
    border: none;
    /*margin: 40px 20px auto;*/
    margin-top: 40px;
    margin-right: 0;
    margin-left: 203px;

}

.donation-button-next-prev {
    color: #fff;
    font: inherit;
    padding: 12px 25px;
    border-radius: 8px;
    cursor: pointer;
    background: linear-gradient(to left, #80CBC4, #008b7a);
    /*border: 2px solid rgba(0,0,0,0.5);*/
    border: none;
    margin: 40px 0 0 0;
}

.donation-button-next:hover {
    background: linear-gradient(to right, #80CBC4, #008b7a);
}

.donation-button-next-prev:hover {
    background: linear-gradient(to right, #80CBC4, #008b7a);
}

</style>
