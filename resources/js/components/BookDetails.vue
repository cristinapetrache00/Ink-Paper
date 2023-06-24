<template>
    <div class="d-flex justify-content-center" style="margin-top: 100px">
        <div class="card mb-3" style="width: 1000px">
            <div class="row">
                <div class="col-md-auto">
                    <img :src="'/carti/' + book.imagine" class="img-fluid rounded-start" alt="...">
                </div>
                <div class="col">
                    <div class="card-body">
                        <h5 class="card-title">{{ book.titlu }}</h5>
                        <p class="card-text">Autor: {{ book.autor}} </p>
                        <p class="card-text">Editura: {{ book.editura }} </p>
                        <p class="card-text" style="margin-top: 30px"><small class="text-body-secondary">Anul aparitiei: {{ book.an_aparitie }} </small></p>
                        <p class="card-text"><small class="text-body-secondary">Numar pagini: {{ book.nr_pg }} </small></p>
                        <p class="card-text"><small class="text-body-secondary">Limba: {{ book.limba }} </small></p>
                        <p class="card-text"><small class="text-body-secondary">Dimensiuni: {{ book.dimensiune }} </small></p>
                    </div>
                </div>
                <div class="col">
                    <div class="card-body price">
                        <h5 class="card-title">Pret: {{ book.pret }} RON</h5>
                        <p class="card-text">Stoc: {{availability}}</p>
                        <a href="#" class="btn btn-primary">Adauga in cos</a>
                        <a href="#" class="btn btn-primary-outline">Adauga la favorite</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "BookDetails",
    props: ['book'],
    data() {
        return {
            availability: null,
        }
    },
    mounted() {
        this.checkAvailability();
    },
    methods: {
        checkAvailability() {
            if (this.book.cantitate > 0) {
                if (this.book.cantitate < 5) {
                    this.availability = 'Ultimul exemplar';
                } else {
                    this.availability = 'In stoc';
                }
            } else {
                this.availability = 'Indisponibil';
            }
        }
    }
}
</script>

<style scoped>
.price {
    border-left: rgba(0, 0, 0, 0.1) 1px solid;
    height: 100%;
}

.card {
    border: none;
}

.card-title {
    display: -webkit-box;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 2;
    overflow: hidden;
    font-size: 18px;
    font-weight: 700;
    height: 50px;
    padding-top: 5px;
    font-family: "Lora",serif;
    color: #333333;
}

.card-text {
    display: -webkit-box;
    -webkit-box-orient: vertical;
    overflow: hidden;
    font-size: 16px;
    font-family: "Lora",serif;
    color: #333333;
}

.btn-primary {
    display: block;
    background-color: #00A896;
    border: none;
}

.btn-primary-outline {
    display: block;
    background-color: transparent;
    border: 1px solid #00A896;
    margin-top: 10px;
}
</style>
