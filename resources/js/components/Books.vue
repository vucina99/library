<template>
    <div class="container">
        <div class="row ">
            <div class="col-lg-4 col-md-12">
                <form action="">
                    <div class="form-group search-font-size">
                        <label  for="book_number">BOOK NUMBER</label>
                        <input type="text" name="book_number" id="book_number"
                               v-model="search.book_number"
                               class="form-control" placeholder="BOOK NUMBER">
                    </div>

                    <div class="form-group search-font-size">
                        <label for="book_name">BOOK NAME</label>
                        <input type="text" name="number_court" v-model="search.book_name"
                               id="book_name"
                               class="form-control" placeholder="BOOK NAME">
                    </div>

                    <div class="form-group search-font-size">
                        <label >LIBRARIAN</label>
                        <v-select
                            :options="allLibrarian"
                            :id="'librarian'"
                            label="name"
                            v-model="search.librarian"
                            placeholder="LIBRARIAN">
                        </v-select>
                    </div>

                    <div class="pt-3">
                        <div class="w-100 d-flex justify-content-between">
                            <button class="btn btn-dark w-50 mr-1" @click.prevent="getBooks()">
                                PRETRAGA <i class="fa fa-search" aria-hidden="true"></i>
                            </button>
                            <button class="btn btn-dark ml-1 w-50"
                                    @click.prevent="resetFilter()">
                                RESETUJ <i class="fa fa-refresh" aria-hidden="true"></i>

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
                        <th scope="col">BOOK NUMBER</th>
                        <th scope="col">TITLE</th>
                        <th scope="col">AUTHOR</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>

                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                    </tr>

                    </tbody>
                </table>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
import vSelect from "vue-select";
export default {
    name: "Books",
    components: {
        'v-select': vSelect,
    },
    data(){
        return{
            search : {
                'book_number' : '',
                'book_name' : '',
                'librarian' : '',
            },
            allLibrarian : []
        }
    },

    methods : {
        resetFilter(){

        },
        getBooks(page=0){

        }
    }
}
</script>

<style scoped>
@import "vue-select/dist/vue-select.css";
</style>
