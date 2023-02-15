<template>
    <div>
        <div class="container">
            <div class="row ">
                <div class="col-lg-4 col-md-12">
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
                            <label >AUTHOR</label>
                            <v-select
                                :options="allAuthor"
                                :id="'author'"
                                label="name"
                                v-model="book.author"
                                placeholder="AUTHOR">
                            </v-select>
                        </div>

                        <div class="pt-3">
                            <div class="w-100 d-flex justify-content-between">
                                <button class="btn btn-dark w-100 mr-1" @click.prevent="addAuthor()">
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
                            <tr>

                                <td class="text-center">Mark</td>
                                <td class="text-center">Otto</td>
                                <td class="text-center">@mdo</td>
                                <td class="text-center">
                                    <div class="w-100 text-center"><i class="fa text-dark fa fa-pencil" aria-hidden="true"></i>
                                    </div>
                                </td>
                            </tr>

                            </tbody>
                        </table>

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
            allAuthor : [],
            book: {
                'title': '',
                'description': '',
                'bookNumber': '',
                'author': '',

            }
        }
    },

    methods: {
        addBook() {

        }
    }
}
</script>

<style scoped>
@import "vue-select/dist/vue-select.css";

</style>
