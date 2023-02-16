<template>
    <div>

        <modal name="edit-author-modal" @before-open="beforeOpen" :shiftY="0.1" :scrollable="true" :adaptive="true"
               :resizable="true" height="auto">

            <div class="container">
                <div class="row ">
                    <div class="col-lg-12 pt-5 pb-5">
                        <h4 class="text-center text-dark">EDIT AUTHOR </h4> <br><br>
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
                                       class="form-control" required placeholder="LAST NAME">
                            </div>

                            <div class="form-group search-font-size">
                                <label for="file">IMAGE</label>
                                <input type="file" name="file" id="file"
                                       class="form-control" placeholder="IMAGE" @change="onFileSelected"
                                       accept=".jpg, .jpeg, .png">
                            </div>

                            <div class="pt-3">
                                <div class="w-100 ">
                                    <button class="btn btn-dark w-100 mr-1" @click.prevent="editAutor()">
                                        EDIT AUTHOR <i class="fa fa fa-pencil"
                                                       aria-hidden="true"></i>
                                    </button>
                                    <br><br>
                                    <button class="btn btn-danger w-100 mr-1" @click.prevent="deleteAutor()">
                                        DELETE AUTHOR <i class="fa fa fa-trash"
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
export default {
    name: "AuthorEdit",
    data() {
        return {

            author: {
                'firstName': '',
                'lastName': '',
                'image': ''
            },
            errorData: {},
            success: false,
            error: false,
            allRoles: [],
            authorIndex: '',

        }
    },
    methods: {
        onFileSelected(event) {
            this.author.image = event.target.files[0];

        },
        closeModal() {
            this.$modal.hide('edit-author-modal');
        },
        beforeOpen(event) {
            this.author = JSON.parse(JSON.stringify(event.params.author));
            this.author.image = '';
            this.authorIndex = event.params.index;
            this.success = false
            this.errorData = {}
            this.error = false

        },
        deleteAutor(){
            axios.delete('/librarian/delete/author/' + this.author.id).then(({data}) => {
                this.$root.$emit('removeAuthorFromArray', this.authorIndex);
                this.closeModal();
            })
        },
        editAutor(){
            const formDataUpdate = new FormData();
            formDataUpdate.append('image', this.author.image);
            formDataUpdate.append('firstName', this.author.firstName);
            formDataUpdate.append('lastName', this.author.lastName);
            formDataUpdate.append('id', this.author.id);
            console.log(formDataUpdate);
            //treba validacija da se radi i na beku i na frontu, ali na ovoj aplikaciji uradicu samo na backu
            axios.post('/librarian/edit/author', formDataUpdate, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }).then(({data}) => {
                this.success = true
                this.errorData = {}
                this.error = false
                this.$root.$emit('editedAuthor', {'data': data, 'index': this.authorIndex});
            }).catch((error) => {
                if (error.response.status == 422) {
                    console.log(error.response);
                    this.errorData =  error.response.data.errors
                    this.success = false
                    this.error = false
                } else {
                    this.error = true
                    this.success = false
                }
            })
        }
    },

}


</script>

<style scoped>

</style>
