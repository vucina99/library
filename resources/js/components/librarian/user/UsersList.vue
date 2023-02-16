<template>
    <div>
        <div class="container">
            <div class="row ">
                <div class="col-lg-4 col-md-12">
                    <!--                modali za edit i prikaz usera-->
                    <show-user></show-user>
                    <edit-user></edit-user>
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
                            <input type="text" name="firstName"  required id="firstName"
                                   v-model="user.firstName"
                                   class="form-control" placeholder="FIRST NAME">
                        </div>

                        <div class="form-group search-font-size">
                            <label for="lastName">LAST NAME</label>
                            <input type="text" name="lastName"  required id="lastName"
                                   v-model="user.lastName"
                                   class="form-control" placeholder="LAST NAME">
                        </div>

                        <div class="form-group search-font-size">
                            <label for="email">E-mail</label>
                            <input type="email" name="email"  required id="email"
                                   v-model="user.email"
                                   class="form-control" placeholder="E-mail">
                        </div>
                        <div class="form-group search-font-size">
                            <label for="password">Password</label>
                            <input type="password" name="password"  required id="password"
                                   v-model="user.password"
                                   class="form-control" placeholder="Password">
                        </div>
                        <div class="form-group search-font-size">
                            <label for="role">ROLE</label>
                            <select name="role" id="role"  required v-model="user.role" class="form-control">
                                <option value="">SELECT ROLE</option>
                                <option v-for="(role, key) in allRoles" :key="key" :value="role.id">{{ role.name }}
                                </option>
                            </select>
                        </div>
                        <div class="pt-3">
                            <div class="w-100 d-flex justify-content-between">
                                <button class="btn btn-dark w-100 mr-1" @click.prevent="addUser()">
                                    ADD USER <i class="fa fa-plus" aria-hidden="true"></i>
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
                                <th scope="col" class="text-center">FIRST NAME</th>
                                <th scope="col" class="text-center">LAST NAME</th>
                                <th scope="col" class="text-center">E-MAIL</th>
                                <th scope="col" class="text-center">ROLE</th>
                                <th scope="col" class="text-center">EDIT</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(user, index) in allUsers">

                                <td class="text-center" @click.prevent="showUser(user)">{{ user.firstName }}</td>
                                <td class="text-center" @click.prevent="showUser(user)">{{ user.lastName }}</td>
                                <td class="text-center" @click.prevent="showUser(user)">{{ user.email }}</td>
                                <td class="text-center" @click.prevent="showUser(user)">{{ user.role?.name }}</td>
                                <td class="text-center" @click.prevent="editUserModal(user , index)">
                                    <div class="w-100 text-center"><i class="fa text-dark fa fa-pencil"
                                                                      aria-hidden="true"></i>
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
import EditUser from "./EditUser";
import ShowUser from "./ShowUser";

export default {
    name: "UsersList",
    components: {
        'edit-user': EditUser,
        'show-user': ShowUser,
    },
    data() {
        return {
            allUsers: [],
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
        }
    },

    methods: {
        addUser() {
            //treba validacija da se radi i na beku i na frontu, ali na ovoj aplikaciji uradicu samo na backu
            axios.post('/librarian/create/user', this.user).then(({data}) => {

                this.success = true
                this.errorData = {}
                this.error = false
                this.allUsers.push(data);
                this.user = {
                    'firstName': '',
                    'lastName': '',
                    'email': '',
                    'password': '',
                    'role': ''
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
        },
        getUsers() {
            axios.get('/librarian/get/users').then(({data}) => {
                this.allUsers = data

            })
        },

        getRoles() {
            axios.get('/librarian/get/roles').then(({data}) => {
                this.allRoles = data

            })
        },

        showUser(data) {
            this.$modal.show('show-user-modal', {'user': data});
        },

        editUserModal(data, index) {
            this.$modal.show('edit-user-modal', {'user': data, 'index': index});
        },
    },

    created() {
        this.getUsers();
        this.getRoles();

        this.$root.$on("editedUser", (data) => {
            if (typeof this.allUsers[data.index] !== "undefined") {
                this.allUsers = this.allUsers.map((x, indexMap) => (data.index === indexMap) ? data.data : x)

            }
        })

        this.$root.$on("removeUserFromArray", (index) => {
            if (typeof this.allUsers[index] !== "undefined") {

                this.allUsers.splice(index, 1);

            }
        })
    }
}
</script>

<style scoped>

</style>
