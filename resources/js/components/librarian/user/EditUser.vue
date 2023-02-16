<template>
    <div>

        <modal name="edit-user-modal" @before-open="beforeOpen" :shiftY="0.1" :scrollable="true" :adaptive="true"
               :resizable="true" height="auto">

            <div class="container">
                <div class="row ">
                    <div class="col-lg-12 pt-5 pb-5">
                        <h4 class="text-center text-dark">EDIT USER </h4> <br><br>
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


                        <form action="">
                            <div class="form-group search-font-size">
                                <label for="firstName">FIRST NAME</label>
                                <input type="text" name="firstName" id="firstName"
                                       v-model="user.firstName"
                                       class="form-control" placeholder="FIRST NAME">
                            </div>

                            <div class="form-group search-font-size">
                                <label for="lastName">LAST NAME</label>
                                <input type="text" name="lastName" id="lastName"
                                       v-model="user.lastName"
                                       class="form-control" placeholder="LAST NAME">
                            </div>


                            <div class="form-group search-font-size">
                                <label for="role">ROLE</label>
                                <select name="role" id="role" v-model="user.role" class="form-control">
                                    <option value="">SELECT ROLE</option>
                                    <option v-for="(role, key) in allRoles" :key="key" :value="role.id">{{ role.name }}
                                    </option>
                                </select>
                            </div>
                            <div class="pt-3">
                                <div class="w-100 ">
                                    <button class="btn btn-dark w-100 mr-1" @click.prevent="editUser()">
                                        EDIT USER <i class="fa fa fa-pencil"
                                                     aria-hidden="true"></i>
                                    </button>
                                    <br><br>
                                    <button class="btn btn-danger w-100 mr-1" @click.prevent="deleteUser()">
                                        DELETE USER <i class="fa fa fa-trash"
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
    name: "EditUser",
    data() {
        return {

            user: {
                'firstName': '',
                'lastName': '',
                'email': '',
                'password': '',
                'role': ''
            },
            errorData: {},
            success: false,
            error: false,
            allRoles: [],
            userIndex: '',

        }
    },
    methods: {
        getRoles() {
            axios.get('/librarian/get/roles').then(({data}) => {
                this.allRoles = data
            })
        },
        closeModal() {
            this.$modal.hide('edit-user-modal');
        },
        beforeOpen(event) {
            this.user = JSON.parse(JSON.stringify(event.params.user));
            this.user.role = this.user.role.id;
            this.userIndex = event.params.index;
            this.success = false
            this.errorData = {}
            this.error = false
            console.log(this.user);
        },
        deleteUser() {
            axios.delete('/librarian/delete/user/' + this.user.id).then(({data}) => {
                this.$root.$emit('removeUserFromArray', this.userIndex);
                this.closeModal();
            })
        },
        editUser() {
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

    created() {
        this.getRoles();
    }
}


</script>

<style scoped>

</style>
