<template>
    <div>

        <modal name="show-user-modal" @before-open="beforeOpen" :shiftY="0.1" :scrollable="true" :adaptive="true"
               :resizable="true" height="auto">

            <div class="container">
                <div class="row ">
                    <div class="col-lg-12 pt-5 pb-5">
                        <h4 class="text-center text-dark">SHOW USER </h4> <br><br>


                        <form action="">
                            <div class="form-group search-font-size">
                                <label for="firstName">FIRST NAME</label>
                                <input type="text" name="firstName" disabled  id="firstName"
                                       v-model="user.firstName"
                                       class="form-control" placeholder="FIRST NAME">
                            </div>

                            <div class="form-group search-font-size">
                                <label for="lastName">LAST NAME</label>
                                <input type="text" name="lastName" disabled  id="lastName"
                                       v-model="user.lastName"
                                       class="form-control" placeholder="LAST NAME">
                            </div>

                            <div class="form-group search-font-size">
                                <label for="email">E-MAIL</label>
                                <input type="email" name="email" disabled  id="email"
                                       v-model="user.email"
                                       class="form-control" placeholder="E-MAIL">
                            </div>

                            <div class="form-group search-font-size">
                                <label for="role">ROLE</label>
                                <select name="role" disabled id="role" v-model="user.role.id" class="form-control">
                                    <option value="">SELECT ROLE</option>
                                    <option v-for="(role, key) in allRoles" :key="key" :value="role.id">{{ role.name }}
                                    </option>
                                </select>
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
    name: "ShowUser",
    data() {
        return {
            user: {
                'firstName': '',
                'lastName': '',
                'email': '',
                'password': '',
                'role': ''
            },
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
            this.$modal.hide('show-user-modal');
        },
        beforeOpen(event) {
            this.user = JSON.parse(JSON.stringify(event.params.user));
            console.log(this.user)
        },

    },

    created() {
        this.getRoles();
    }
}


</script>

<style scoped>

</style>
