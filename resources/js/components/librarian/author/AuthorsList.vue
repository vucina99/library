<template>
    <div>
        <div class="container">
            <div class="row ">
                <div class="col-lg-4 col-md-12">
                    <author-edit></author-edit>
                    <author-show></author-show>
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
                            <label for="firstName">FIRST NAME</label>
                            <input type="text" name="firstName" id="firstName"
                                   v-model="author.firstName"
                                   class="form-control" placeholder="FIRST NAME" required>
                        </div>

                        <div class="form-group search-font-size">
                            <label for="lastName">LAST NAME</label>
                            <input type="text" name="lastName" id="lastName"
                                   v-model="author.lastName"
                                   class="form-control"  required placeholder="LAST NAME">
                        </div>

                        <div class="form-group search-font-size">
                            <label for="file">IMAGE</label>
                            <input type="file" name="file" id="file"
                                   class="form-control" placeholder="IMAGE" @change="onFileSelected"
                                   accept=".jpg, .jpeg, .png">
                        </div>

                        <div class="pt-3">
                            <div class="w-100 d-flex justify-content-between">
                                <button class="btn btn-dark w-100 mr-1" @click.prevent="addAuthor()">
                                    ADD AUTHOR <i class="fa fa-plus" aria-hidden="true"></i>
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
                                <th scope="col" class="text-center">IMAGE</th>
                                <th scope="col" class="text-center">FIRST NAME</th>
                                <th scope="col" class="text-center">LAST NAME</th>
                                <th scope="col" class="text-center">EDIT</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-if="allAuthors.length > 0" v-for="(author , index) in allAuthors" :key="index" >
                                <td class="text-center" @click.prevent="showAuthor(author)"><img :src="'/img/authors/'+author.image?.name"  class="img-author" alt=""></td>
                                <td class="text-center" @click.prevent="showAuthor(author)">{{ author.firstName }}</td>
                                <td class="text-center" @click.prevent="showAuthor(author)">{{ author.lastName }}</td>
                                <td class="text-center" @click.prevent="editAuthor(author,index)">
                                    <div class="w-100 text-center"><i class="fa text-dark fa fa-pencil"
                                                                      aria-hidden="true"></i>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="4" v-if="allAuthors.length < 1" class="text-center bg-light">NO RESULT</td>
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
import AuthorEdit from "./AuthorEdit";
import AuthorShow from "./AuthorShow";

export default {
    name: "AuthorsList",
    components: {
        'author-edit': AuthorEdit,
        'author-show': AuthorShow,
    },
    data() {
        return {
            errorData: {},
            success: false,
            error: false,
            allAuthors: [],
            author: {
                'firstName': '',
                'lastName': '',
                'image': ''
            }
        }
    },

    methods: {
        getAuthors() {
            axios.get('/librarian/get/authors').then(({data}) => {
                this.allAuthors = data
            })
        },
        onFileSelected(event) {
            this.author.image = event.target.files[0];
            console.log(event.target.files[0]);
        },
        addAuthor() {
            const formData = new FormData();
            formData.append('image', this.author.image);
            formData.append('firstName', this.author.firstName);
            formData.append('lastName', this.author.lastName);

            axios.post('/librarian/create/author', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            })
                .then(({data}) => {
                    this.allAuthors.push(data)
                    this.errorData = {}
                    this.success = true
                    this.error = false
                })
                .catch(error => {
                    if (error.response.status == 422) {
                        console.log(error.response);
                        this.errorData = error.response.data.errors
                        this.success = false
                        this.error = false
                    } else {
                        this.error = true
                        this.success = false
                    }
                });

        },

        showAuthor(data) {
            this.$modal.show('show-author-modal', {'author': data});
        },

        editAuthor(data, index) {
            this.$modal.show('edit-author-modal', {'author': data, 'index': index});
        },
    },
    created() {
        this.getAuthors();

        this.$root.$on("editedAuthor", (data) => {
            if (typeof this.allAuthors[data.index] !== "undefined") {
                this.allAuthors = this.allAuthors.map((x, indexMap) => (data.index === indexMap) ? data.data : x)

            }
        })

        this.$root.$on("removeAuthorFromArray", (index) => {
            if (typeof this.allAuthors[index] !== "undefined") {

                this.allAuthors.splice(index, 1);

            }
        })



    }
}
</script>

<style scoped>

</style>
