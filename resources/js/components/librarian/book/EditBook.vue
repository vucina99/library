<template>
    <div>

        <modal name="edit-book-modal" @before-open="beforeOpen" :shiftY="0.1" :scrollable="true" :adaptive="true"
               :resizable="true" height="auto">

            <div class="container">
                <div class="row ">
                    <div class="col-lg-12 pt-5 pb-5">
                        <h4 class="text-center text-dark">EDIT BOOK </h4> <br><br>
                        <div v-if="Object.keys(this.errorData).length > 0"
                             class="alert error-danger alert-danger alert-dismissible fade show"
                             role="alert">

                            <div v-for="(error, index) in errorData" :key="index">
                                                 <span v-for="(errorChildern, key) in error" :key="key">
                                                        <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> &nbsp;  {{
                                                         errorChildern
                                                     }}
                                                 </span>
                            </div>

                        </div>
                        <div v-if="success"
                             class="alert error-danger alert-success alert-dismissible fade show"
                             role="alert">
                            <span><i class="fa fa-check-square" aria-hidden="true"></i> &nbsp; SUCCESS ADDED</span>
                            <button @click.prevent="success = false" type="button" class="close">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div v-if="error"
                             class="alert error-danger alert-danger alert-dismissible fade show"
                             role="alert">
                        <span> <i class="fa fa-exclamation-triangle"
                                  aria-hidden="true"></i> &nbsp; CHECK ALL FIELDS</span>
                            <button @click.prevent="error = false" type="button" class="close">
                                <span>&times;</span>
                            </button>
                        </div>

                        <form action="" enctype="multipart/form-data">
                            <div class="form-group search-font-size">
                                <label for="title">TITLE</label>
                                <input type="text" name="title" id="title"
                                       v-model="book.title"
                                       class="form-control" placeholder="TITLE">
                            </div>

                            <div class="form-group search-font-size">
                                <label for="description">DESCRIPTION</label>
                                <textarea type="text" name="description" id="description"
                                          v-model="book.description"
                                          class="form-control" rows="5" placeholder="DESCRIPTION"></textarea>
                            </div>


                            <div class="form-group search-font-size">
                                <label>AUTHOR</label>
                                <v-select
                                    :options="allAuthors"
                                    :id="'author'"
                                    label="name"
                                    v-model="book.author"
                                    placeholder="AUTHOR">
                                </v-select>
                            </div>

                            <div class="pt-3">
                                <div class="w-100 ">
                                    <button class="btn btn-dark w-100 mr-1" @click.prevent="editBook()">
                                        EDIT BOOK <i class="fa fa fa-pencil"
                                                     aria-hidden="true"></i>
                                    </button>
                                    <br><br>
                                    <button class="btn btn-danger w-100 mr-1" @click.prevent="deleteBook()">
                                        DELETE BOOK <i class="fa fa fa-trash"
                                                       aria-hidden="true"></i>
                                    </button>
                                </div>

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
    name: "EditBook",
    components: {
        'v-select': vSelect,
    },
    data() {
        return {
            allAuthors: [],
            errorData: {},
            success: false,
            error: false,
            book: [],
            bookIndex: -1

        }
    },

    methods: {
        editBook() {
            if (this.book.author == '' || this.book.author == null || typeof this.book.author['id'] == 'undefined') {
                this.book.author = ''
            }

            axios.patch('/librarian/edit/book/' + this.book.id, this.book).then(({data}) => {
                this.success = true
                this.errorData = {}
                this.error = false
                this.$root.$emit('editedBook', {'data': data, 'index': this.bookIndex});
            }).catch((error) => {
                if (error.response.status == 422) {
                    console.log(error.response);
                    this.errorData = error.response.data.errors
                    this.success = false
                    this.error = false
                } else {
                    this.error = true
                    this.success = false
                }
            })

        },
        closeModal() {
            this.$modal.hide('edit-book-modal');
        },
        deleteBook() {

            axios.delete('/librarian/delete/book/' + this.book.id).then(({data}) => {
                this.$root.$emit('removeBookFromArray', this.bookIndex);
                this.closeModal();
            })
        },
        getAuthors() {
            axios.get('/librarian/get/authors').then(({data}) => {
                let authorsWithFullName = []
                this.allAuthors = data
                //radimo override dobijenog objekta da bi imali full name
                this.allAuthors.forEach((author, index) => {
                    console.log(author);
                    author.name = author.firstName + ' ' + author.lastName
                })

                console.log(this.allAuthors)
            })
        },
        beforeOpen(event) {
            this.book = JSON.parse(JSON.stringify(event.params.book));

            this.book.author.name = this.book.author.firstName + ' ' + this.book.author.lastName

            this.bookIndex = event.params.index;
            this.success = false
            this.errorData = {}
            this.error = false

            console.log(this.book)
        },
    },
    created() {
        this.getAuthors()
    }
}
</script>

<style scoped>

</style>
