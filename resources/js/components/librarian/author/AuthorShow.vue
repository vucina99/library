<template>
    <div>

        <modal name="show-author-modal" @before-open="beforeOpen" :shiftY="0.1" :scrollable="true" :adaptive="true"
               :resizable="true" height="auto">

            <div class="container">
                <div class="row ">
                    <div class="col-lg-12 pt-5 pb-5">
                        <h4 class="text-center text-dark">SHOW AUTHOR </h4> <br><br>

                        <div class="w-100 d-flex justify-content-center">
                            <img :src="'/img/authors/'+author.image?.name" class="img-fluid" alt="">
                        </div>

                        <form action="" enctype="multipart/form-data">
                            <div class="form-group search-font-size">
                                <label for="firstName">FIRST NAME</label>
                                <input type="text" name="firstName" id="firstName"
                                       v-model="author.firstName" disabled
                                       class="form-control" placeholder="FIRST NAME" required>
                            </div>

                            <div class="form-group search-font-size">
                                <label for="lastName">LAST NAME</label>
                                <input type="text" name="lastName" id="lastName"
                                       v-model="author.lastName" disabled
                                       class="form-control" required placeholder="LAST NAME">
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
    name: "AuthorShow",
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

            this.authorIndex = event.params.index;
            this.success = false
            this.errorData = {}
            this.error = false

        },
        addAuthor() {
            //treba validacija da se radi i na beku i na frontu, ali na ovoj aplikaciji uradicu samo na backu
            axios.patch('/librarian/edit/user/' + this.user.id, this.user).then(({data}) => {
                this.success = true
                this.errorData = {}
                this.error = false
                this.$root.$emit('editedUser', {'data': data, 'index': this.userIndex});
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

}


</script>

<style scoped>

</style>
