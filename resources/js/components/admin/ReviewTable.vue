<template>
    <div>
        <div class="container">
            <h4 style="margin-top: 50px">Reviewuri</h4>
            <button v-if="showData" type="button" class="btn btn-primary" @click="show()">Ascunde</button>
            <button v-else type="button" class="btn btn-primary" @click="show()">Arata</button>
        </div>
        <table v-if="!!dataLoaded && showData" class="table table-striped">
            <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">ID Client</th>
                <th scope="col">ID Carte</th>
                <th scope="col">Comentariu</th>
                <th scope="col">Rating</th>
                <th scope="col">Data</th>
                <th scope="col">Titlu</th>
                <th scope="col">Actiuni</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="review in reviwuri" :key="review.id">
                <th scope="col">{{ review.id }}</th>
                <th scope="col">{{ review.id_client }}</th>
                <th scope="col">{{ review.id_carte }}</th>
                <th scope="col">{{ review.comentariu }}</th>
                <th scope="col">{{ review.rating }}</th>
                <th scope="col">{{ review.data_review }}</th>
                <th scope="col">{{ review.titlu }}</th>
                <th scope="col">
                    <img :src="'/icons/trash-can-solid-1.svg'" alt="Profile SVG" @click="deleteItem(review)">
                    <img :src="'/icons/pen-to-square-solid-1.svg'" alt="Profile SVG" @click="changePopupEdit(review)">
                </th>
            </tr>
            </tbody>
        </table>
        <div v-if="popupEdit" class="popup-container">
            <div class="popup-content">
                <form>
                    <div class="mb-3">
                        <label for="review" class="form-label">ID</label>
                        <input type="text" class="form-control" id="review" v-model="review.id">
                    </div>

                    <div class="mb-3">
                        <label for="client" class="form-label">ID Client</label>
                        <input type="text" class="form-control" id="client" v-model="review.id_client">
                    </div>

                    <div class="mb-3">
                        <label for="carte" class="form-label">ID Carte</label>
                        <input type="text" class="form-control" id="carte" v-model="review.id_carte">
                    </div>

                    <div class="mb-3">
                        <label for="comentariu" class="form-label">Comentariu</label>
                        <input type="text" class="form-control" id="comentariu" v-model="review.comentariu">
                    </div>

                    <div class="mb-3">
                        <label for="rating" class="form-label">Rating</label>
                        <input type="text" class="form-control" id="rating" v-model="review.rating">
                    </div>

                    <div class="mb-3">
                        <label for="data" class="form-label">Data</label>
                        <input type="text" class="form-control" id="data" v-model="review.data_review">
                    </div>

                    <div class="mb-3">
                        <label for="titlu" class="form-label">Titlu</label>
                        <input type="text" class="form-control" id="titlu" v-model="review.titlu">
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-primary" @click="editReview()">Submit</button>
                        <button type="button" class="btn btn-secondary" @click="changePopupEdit()">Close</button>
                    </div>
                </form>
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
    name: "CarteTable",
    data() {
        return {
            reviwuri: [],
            adminUser: [],
            adminClient: [],
            dataLoaded: false,
            showData: false,
            popupEdit: false,
            review: [],
        }
    },
    computed: {
        ...mapGetters(['isAuthenticated']),
    },
    mounted() {
        this.getData();
        this.getReviews();

        Promise.all([this.getData(), this.getReviews()])
            .then(() => {
                this.checkAdmin();
                this.dataLoaded = true;
            });
    },
    methods: {
        async getData() {
            if (this.isAuthenticated) {
                await axios.get('/user', {
                    headers: {
                        'Authorization': 'Bearer ' + this.isAuthenticated
                    }
                })
                    .then(response => {
                        this.adminClient = response.data.client;
                        this.adminUser = response.data.user;
                    })
                    .catch(error => {
                        console.log(error);
                    });
            } else {
                window.location.href = '/autentificare'
            }
        },
        async getReviews() {
            await axios.get('/reviewuri', {
                headers: {
                    'Authorization': 'Bearer ' + this.isAuthenticated
                }
            })
                .then(response => {
                    this.reviwuri = response.data;
                })
                .catch(error => {
                    console.log(error);
                });
        },
        checkAdmin() {
            if (this.adminUser.email !== 'inkpaper2023@hotmail.com') {
                alert('Nu aveti acces la aceasta pagina!');
                window.location.href = '/autentificare';
            }
        },
        async deleteItem(review) {
            await axios.delete('/reviewuri/' + review.id, {
                headers: {
                    'Authorization': 'Bearer ' + this.isAuthenticated
                }
            })
                .then(response => {
                    console.log(response);
                })
                .catch(error => {
                    console.log(error);
                });
        },
        show() {
            this.showData = !this.showData;
        },
        changePopupEdit(review) {
            this.review = review;
            this.popupEdit = !this.popupEdit;
        },
        async editReview() {
            await axios.put('/reviewuri', {
                    id: this.review.id,
                    id_client: this.review.id_client,
                    id_carte: this.review.id_carte,
                    comentariu: this.review.comentariu,
                    rating: this.review.rating,
                    data_review: this.review.data_review,
                    titlu: this.review.titlu,
                },
                {
                    headers: {
                        'Authorization': 'Bearer ' + this.isAuthenticated
                    }
                })
                .then(response => {
                    console.log(response);
                })
                .catch(error => {
                    console.log(error);
                });
            this.popupEdit = !this.popupEdit;
        }
    }
}
</script>

<style scoped>
.table {
    width: 100%;
}

.btn-primary {
    display: block;
    background-color: #00A896;
    border: none;
    margin-bottom: 10px;
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

.container {
    padding-left: 0;
}
</style>
