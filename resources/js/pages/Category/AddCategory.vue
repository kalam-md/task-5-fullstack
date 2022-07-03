<template>
    <div>
        <h4 class="text-center">Add Category</h4>
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <form @submit.prevent="addCategory">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" v-model="category.name">
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Save</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            category: {}
        }
    },
    methods: {
        addCategory() {
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post('/api/categories/add', this.category)
                    .then(response => {
                        this.$router.push({ name: 'categories' })
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            })
        }
    },
    beforeRouteEnter(to, from, next) {
        if (!window.Laravel.isLoggedin) {
            window.location.href = "/";
        }
        next();
    }
}
</script>