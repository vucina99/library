<template>
    <div>
        <div class="container">
            <div class="row ">
                <div class="col-lg-4 col-md-12">
                    <form action="" enctype="multipart/form-data">
                        <div class="form-group search-font-size">
                            <label for="firstName">FIRST NAME</label>
                            <input type="text" name="firstName" id="firstName"
                                   v-model="author.firstName"
                                   class="form-control" placeholder="FIRST NAME">
                        </div>

                        <div class="form-group search-font-size">
                            <label for="lastName">LAST NAME</label>
                            <input type="text" name="lastName" id="lastName"
                                   v-model="author.lastName"
                                   class="form-control" placeholder="LAST NAME">
                        </div>

                        <div class="form-group search-font-size">
                            <label for="file">IMAGE</label>
                            <input type="file" name="file" id="file"
                                   ref="file"
                                   class="form-control" placeholder="IMAGE">
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
export default {
    name: "AuthorsList",
    data() {
        return {
            author: {
                'firstName': '',
                'lastName': '',
            }
        }
    },

    methods: {
        addAuthor() {

        }
    }
}
</script>

<style scoped>

</style>
