<template>
    <div class="container">
        <div class="row ">
            <div class="col-lg-4 col-md-12">
                <show-book></show-book>
                <form action="">
                    <div class="form-group search-font-size">
                        <label for="book_number">BOOK NUMBER</label>
                        <input type="text" name="book_number" id="book_number"
                               v-model="search.bookNumber"
                               class="form-control" placeholder="BOOK NUMBER">
                    </div>

                    <div class="form-group search-font-size">
                        <label for="book_name">TITLE</label>
                        <input type="text" name="number_court" v-model="search.title"
                               id="book_name"
                               class="form-control" placeholder="TITLE">
                    </div>

                    <div class="form-group search-font-size">
                        <label>AUTHOR</label>
                        <v-select
                            :options="allAuthors"
                            :id="'author'"
                            label="name"
                            v-model="search.author"
                            placeholder="AUTHOR">
                        </v-select>
                    </div>

                    <div class="pt-3">
                        <div class="w-100 d-flex justify-content-between">
                            <button class="btn btn-dark w-50 mr-1" @click.prevent="getBooks()">
                                PRETRAGA <i class="fa fa-search" aria-hidden="true"></i>
                            </button>
                            <button class="btn btn-dark ml-1 w-50"
                                    @click.prevent="resetFilter()">
                                RESETUJ FILTER <i class="fa fa-refresh" aria-hidden="true"></i>

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
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(book , index) in allBooks" :key="index">

                            <td class="text-center" @click.prevent="showBookModal(book)">{{ book.title }}</td>
                            <td class="text-center" @click.prevent="showBookModal(book)">{{ book.bookNumber }}</td>
                            <td class="text-center" @click.prevent="showBookModal(book)">{{
                                    book.author?.firstName
                                }}
                            </td>

                        </tr>
                        <tr v-if="allBooks.length < 1">
                            <td colspan="3" class="text-center bg-light">NO RESULT</td>
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
</template>

<script>
import vSelect from "vue-select";
import ShowBook from "./librarian/book/ShowBook";

export default {
    name: "Books",
    components: {
        'v-select': vSelect,
        'show-book': ShowBook
    },
    data() {
        return {
            search: {
                'bookNumber': '',
                'title': '',
                'author': '',
            },
            allAuthors: [],
            page: 0,
            paginateCount: 0,
            allBooks: []
        }
    },

    methods: {
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
        resetFilter() {
            this.search = {
                'bookNumber': '',
                'title': '',
                'author': '',
            }
        },
        getBooks(page = 0) {

            if (this.search.author == '' || this.search.author == null || typeof this.search.author['id'] == 'undefined') {
                this.search.author = ''
            }

            this.page = page
            axios.post('/get/book', {
                'page': this.page,
                'search': this.search
            }).then(({data}) => {
                console.log(data);
                this.allBooks = data.data
                this.paginateCount = data.count
            }).catch((error) => {
                console.log('error get books')
            })
        },

        showBookModal(data) {
            this.$modal.show('show-book-modal', {'book': data});
        },
    },
    created() {
        this.getAuthors();
        this.getBooks()
    }
}
</script>

<style scoped>
@import "vue-select/dist/vue-select.css";
</style>
