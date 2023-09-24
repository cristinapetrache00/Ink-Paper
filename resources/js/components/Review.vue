<template>
    <div>
        <h4 class="titlu"><strong>Rating</strong> {{ book.titlu }}</h4>
        <div :style="{ width: 50 + '%', marginBottom: 30 + 'px' }">
            <h5 class="titlu"><strong>{{ book.rating }}</strong></h5>

            <div class="row ">
                <div class="col-md-auto" :style="{ width: 12 + 'px', marginBottom: 10 + 'px' }" v-for="i in 5" :key="i">
                    <img :src="'/icons/star-solid-1.svg'" alt="Heart SVG">
                </div>
            </div>
            <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                <div class="progress-bar" :style="{ width: calculateWidth(5) + '%'}">
                    <span v-if="statistics[5] !== 0">{{ statistics[5] }}</span>
                </div>
            </div>

            <div class="row">
                <div class="col-md-auto" :style="{ width: 12 + 'px', marginBottom: 10 + 'px' }" v-for="i in 5" :key="i">
                    <img v-if="i <= 4" :src="'/icons/star-solid-1.svg'" alt="Heart SVG">
                    <img v-else :src="'/icons/star-regular-1.svg'" alt="Heart SVG">
                </div>
            </div>
            <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                <div class="progress-bar" :style="{ width: calculateWidth(4) + '%'}">
                    <span v-if="statistics[4] !== 0">{{ statistics[4] }}</span>
                </div>
            </div>

            <div class="row">
                <div class="col-md-auto" :style="{ width: 12 + 'px', marginBottom: 10 + 'px' }" v-for="i in 5" :key="i">
                    <img v-if="i <= 3" :src="'/icons/star-solid-1.svg'" alt="Heart SVG">
                    <img v-else :src="'/icons/star-regular-1.svg'" alt="Heart SVG">
                </div>
            </div>
            <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                <div class="progress-bar" :style="{ width: calculateWidth(3) + '%'}">
                    <span v-if="statistics[3] !== 0">{{ statistics[3] }}</span>
                </div>
            </div>

            <div class="row">
                <div class="col-md-auto" :style="{ width: 12 + 'px', marginBottom: 10 + 'px' }" v-for="i in 5" :key="i">
                    <img v-if="i <= 2" :src="'/icons/star-solid-1.svg'" alt="Heart SVG">
                    <img v-else :src="'/icons/star-regular-1.svg'" alt="Heart SVG">
                </div>
            </div>
            <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                <div class="progress-bar" :style="{ width: calculateWidth(2) + '%'}">
                    <span v-if="statistics[2] !== 0">{{ statistics[2] }}</span>
                </div>
            </div>

            <div class="row">
                <div class="col-md-auto" :style="{ width: 12 + 'px', marginBottom: 10 + 'px' }" v-for="i in 5" :key="i">
                    <img v-if="i <= 1" :src="'/icons/star-solid-1.svg'" alt="Heart SVG">
                    <img v-else :src="'/icons/star-regular-1.svg'" alt="Heart SVG">
                </div>
            </div>
            <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">
                <div class="progress-bar" :style="{ width: calculateWidth(1) + '%'}">
                    <span v-if="statistics[1] !== 0">{{ statistics[1] }}</span>
                </div>
            </div>
        </div>
        <div v-for="review in reviews" :key="review.id">
            <div class="card">
                <p> <strong>{{ review.titlu }}</strong> </p>
                <p> {{ review.comentariu }} </p>
                <div class="row">
                    <div class="col-md-auto" :style="{ width: 12 + 'px' }" v-for="i in 5" :key="i">
                        <img v-if="i <= review.rating" :src="'/icons/star-solid-1.svg'" alt="Heart SVG">
                        <img v-if="i > review.rating" :src="'/icons/star-regular-1.svg'" alt="Heart SVG">
                    </div>
                    <p class="col-md-auto"> {{ review.nume_client }} {{ review.prenume_client }} </p>
                    <span class="col-md-auto">{{ review.data_review }}</span>
                </div>
            </div>
        </div>
        <div :style="{ marginBottom: 30 + 'px' }">
            <button id="formular" class="btn btn-primary form-control" type="button" @click="openPopup">Adauga review</button>
            <div v-if="showPopup" class="popup-container">
                <div class="popup-content" :style="{ width: 600 + 'px' }">
                    <form>
                        <div class="input-group mb-3">
                            <label class="input-group-text" for="inputGroupSelect01">Nota</label>
                            <select class="form-select" id="inputGroupSelect01" v-model="rating">
                                <option value=1>1</option>
                                <option value=2>2</option>
                                <option value=3>3</option>
                                <option value=4>4</option>
                                <option value=5>5</option>
                            </select>
                        </div>
                        <div class="form-floating" style="margin-bottom: 15px">
                            <input type="text" class="form-control" id="floatingInputValue" v-model="title" placeholder="Recomand">
                            <label for="floatingInputValue">Titlu</label>
                        </div>
                        <div class="form-floating">
                            <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px" v-model="comment"></textarea>
                            <label for="floatingTextarea2">Comentariu</label>
                        </div>

                        <div class="d-flex justify-content-end" style="margin-top: 30px">
                            <button type="button" class="btn btn-primary" @click="addReview" style="margin-right: 10px">Submit</button>
                            <button type="button" class="btn btn-secondary" @click="closePopup">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
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
    name: "Review",
    props: ['book'],
    data() {
        return {
            reviews: null,
            statistics: [
                0,
                0,
                0,
                0,
                0,
            ],
            showPopup: false,
            rating: 5,
            title: null,
            comment: null,
        }
    },
    mounted() {
        this.getReview();
    },
    computed: {
        ...mapGetters(['isAuthenticated']),
    },
    methods: {
        getReview() {
            axios.get('/reviewuri/carte/' + this.book.id)
                .then(response => {
                    console.log(response.data)
                    this.reviews = response.data.reviews;
                    console.log(this.reviews)
                    this.statistics = response.data.statistics;
                })
                .catch(error => {
                    console.log(error);
                });
        },
        openPopup() {
            if (this.isAuthenticated) {
                console.log(this.isAuthenticated)
                this.showPopup = true;
            } else {
                window.location.href = '/autentificare';
            }
        },
        closePopup() {
            this.showPopup = false;
        },
        addReview() {
            axios.post('/reviewuri',
                {
                    id_carte: this.book.id,
                    comentariu: this.comment,
                    titlu: this.title,
                    rating: this.rating,
                },
                {
                    headers: {
                        'Authorization': 'Bearer ' + this.isAuthenticated
                    }
                })
                .then(response => {
                    this.closePopup();
                    this.getReview();
                    window.location.reload()
                })
                .catch(error => {
                    console.log(error);
                });
        },
        calculateWidth(index) {
            if (this.book.nr_reviewuri === 0) {
                return 0;
            } else {
                return this.statistics[index] / this.book.nr_reviewuri * 100;
            }
        }
    }
}
</script>

<style scoped>
@font-face {
    font-family: 'Lora';
    src: url('/Fonts/static/Lora-Regular.ttf');
}

.card {
    margin-bottom: 30px;
    border: none;
    font-family: "Lora", serif;
    background-color: #FAFAFA;
}

.titlu {
    font-family: "Lora",serif;
    color: #333333;
    margin-left: 5px;
    margin-bottom: 30px;
}

.progress {
    margin-bottom: 10px;
}

.progress-bar {
    background-color: #008b7a;
}

.btn-primary {
    display: block;
    background-color: #00A896;
    border: none;
    width: auto;
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

</style>
