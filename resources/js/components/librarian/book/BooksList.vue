<template>
    <div>
        <div class="container">
            <div class="row ">
                <div class="col-lg-4 col-md-12">

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
                            <label for="bookNumber">BOOK NUMBER</label>
                            <input type="text" name="bookNumber" id="bookNumber"
                                   v-model="book.bookNumber"
                                   class="form-control" placeholder="NUMBER">
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
                            <div class="w-100 d-flex justify-content-between">
                                <button class="btn btn-dark w-100 mr-1" @click.prevent="addBook()">
                                    ADD BOOK <i class="fa fa-plus" aria-hidden="true"></i>
                                </button>

                            </div>

                        </div>

                    </form>
                </div>
                <div class="col-lg-1 col-md-12 "></div>
                <div class="col-lg-7 col-md-12 pt-4">
                    <div class="table-responsive">
                        <table class="table table-text-size">
                            <thead class="bg-dark text-light">
                            <tr>
                                <th scope="col" class="text-center">TITLE</th>
                                <th scope="col" class="text-center">BOOK NUMBER</th>
                                <th scope="col" class="text-center">AUTHOR</th>
                                <th scope="col" class="text-center">EDIT</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(book , index) in allBooks" :key="index">

                                <td class="text-center">{{ book.title }}</td>
                                <td class="text-center">{{ book.bookNumber }}</td>
                                <td class="text-center">{{ book.author?.firstName }}</td>
                                <td class="text-center">
                                    <div class="w-100 text-center"><i class="fa text-dark fa fa-pencil"
                                                                      aria-hidden="true"></i>
                                    </div>
                                </td>
                            </tr>

                            </tbody>
                        </table>

                        <br>
                        <nav aria-label="Page navigation example" v-if="paginateCount > 1 ">
                            <ul class="pagination justify-content-center">
                                <li v-if=" page !== 0" :class="[ page == 0 ? 'disabled' : '' ,  'page-item'  ]"
                                    @click.prevent="getBooks(page - 1)">
                                    <a class="page-link one" href="#" tabindex="-1"><i class="fa fa-chevron-left"
                                                                                       aria-hidden="true"></i>
                                    </a>
                                </li>
                                <li v-for="index in paginateCount" :key="index"
                                    @click.prevent="getBooks(index-1)"
                                    :class="[page == index-1 ? 'active' : '' ,'page-item']"><a
                                    class="page-link number" href="#">{{ index }}</a></li>
                                <li v-if=" page !== paginateCount - 1 "
                                    :class="[ page == paginateCount - 1 ? 'disabled' : '' ,  'page-item'  ]"
                                    @click.prevent="getBooks(page + 1)">
                                    <a class="page-link one" href="#"><i class="fa fa-chevron-right"
                                                                         aria-hidden="true"></i>
                                    </a>
                                </li>
                            </ul>
                        </nav>



                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import vSelect from "vue-select";

export default {
    name: "BooksList",
    components: {
        'v-select': vSelect,
    },
    data() {

        return {
            allBooks : [],
            allAuthors: [],
            errorData: {},
            success: false,
            error: false,

            page: 0,
            paginateCount: 0,

            book: {
                'title': '',
                'description': '',
                'bookNumber': '',
                'author': '',

            }
        }
    },

    methods: {
        getBooks(page = 0){
            this.page = page
            axios.post('/get/book', {
                'page': this.page,
            }).then(({data}) => {
                this.allBooks = data.data
                this.paginateCount = data.count
                console.log(this.allBooks);
            }).catch((error) => {
                console.log('error get books')
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
        addBook() {
            console.log(this.book)
            if(typeof this.book.author['id'] == 'undefined'){
                this.book.author = ''
            }

            //treba validacija da se radi i na beku i na frontu, ali na ovoj aplikaciji uradicu samo na backu
            axios.post('/librarian/create/book', this.book).then(({data}) => {

                this.success = true
                this.errorData = {}
                this.error = false
                this.allBooks.push(data);
                this.book = {
                    'title': '',
                    'description': '',
                    'bookNumber': '',
                    'author': '',
                }
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
        }
    },
    created() {
        this.getAuthors()
        this.getBooks()
    }
}
</script>

<style scoped>
@import "vue-select/dist/vue-select.css";

</style>
