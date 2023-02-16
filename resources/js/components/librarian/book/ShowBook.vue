<template>
    <div>

        <modal name="show-book-modal" @before-open="beforeOpen" :shiftY="0.1" :scrollable="true" :adaptive="true"
               :resizable="true" height="auto">

            <div class="container">
                <div class="row ">
                    <div class="col-lg-12 pt-5 pb-5">
                        <h4 class="text-center text-dark">SHOW BOOK </h4> <br><br>

                        <form action="" enctype="multipart/form-data">
                            <div class="form-group search-font-size">
                                <label for="title">TITLE</label>
                                <input type="text" disabled name="title" id="title"
                                       v-model="book.title"
                                       class="form-control" placeholder="TITLE">
                            </div>

                            <div class="form-group search-font-size">
                                <label for="description">DESCRIPTION</label>
                                <textarea type="text" disabled name="description" id="description"
                                          v-model="book.description"
                                          class="form-control" rows="5" placeholder="DESCRIPTION"></textarea>
                            </div>

                            <div class="form-group search-font-size">
                                <label for="bookNumber">BOOK NUMBER</label>
                                <input type="text" disabled name="bookNumber" id="bookNumber"
                                       v-model="book.bookNumber"
                                       class="form-control" placeholder="NUMBER">
                            </div>

                            <div class="form-group search-font-size">
                                <label>AUTHOR</label>
                                <v-select
                                    disabled
                                    :options="allAuthors"
                                    :id="'author'"
                                    label="name"
                                    v-model="book.author"
                                    placeholder="AUTHOR">
                                </v-select>
                            </div>


                        </form>

                    </div>
                </div>
            </div>

            <br><br>
        </modal>
    </div>
</template>

<script>
import vSelect from "vue-select";

export default {
    name: "ShowBook",
    components: {
        'v-select': vSelect,
    },
    data() {
        return {
            allAuthors: [],
            book: [],

        }
    },

    methods: {
        getAuthors() {
            axios.get('/librarian/get/authors').then(({data}) => {
                let authorsWithFullName = []
                this.allAuthors = data
                //radimo override dobijenog objekta da bi imali full name
                this.allAuthors.forEach((author, index) => {
                    author.name = author.firstName + ' ' + author.lastName
                })

            })
        },
        beforeOpen(event) {
            this.book = JSON.parse(JSON.stringify(event.params.book));
            this.book.author.name = this.book.author.firstName + ' ' + this.book.author.lastName

        },
    },
    created() {
        this.getAuthors()
    }
}
</script>

<style scoped>

</style>
