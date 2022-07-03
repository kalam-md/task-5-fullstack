<template>
  <div>
    <h4 class="text-center">All Categories</h4><br />
    <button type="button" class="btn btn-primary mb-3" @click="this.$router.push('/categories/add')">Add
      Category</button>
    <table class="table table-hover">
      <thead>
        <tr>
          <th>No</th>
          <th>Name</th>
          <th>Created At</th>
          <th>Updated At</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(category, key) in categories" :key="category.id">
          <td>{{ key + 1 }}</td>
          <td>{{ category.name }}</td>
          <td>{{ category.created_at }}</td>
          <td>{{ category.updated_at }}</td>
          <td>
            <div class="btn-group" role="group">
              <router-link :to="{ name: 'editcategory', params: { id: category.id } }" class="btn btn-success">Edit
              </router-link>
              <button class="btn btn-danger" @click="deleteCategory(category.id)">Delete</button>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  data() {
    return {
      categories: []
    }
  },
  created() {
    this.$axios.get('/sanctum/csrf-cookie').then(response => {
      this.$axios.get('/api/categories')
        .then(response => {
          this.categories = response.data;
        })
        .catch(function (error) {
          console.error(error);
        });
    })
  },
  methods: {
    deleteCategory(id) {
      this.$axios.get('/sanctum/csrf-cookie').then(response => {
        this.$axios.delete(`/api/categories/delete/${id}`)
          .then(response => {
            let i = this.categories.map(item => item.id).indexOf(id); // find index of your object
            this.categories.splice(i, 1)
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