<template>
  <div>
    <h4 class="text-center">All Articles</h4><br />
    <button type="button" class="btn btn-primary mb-3" @click="this.$router.push('/articles/add')">Add
      Article</button>
    <table class="table table-hover">
      <thead>
        <tr>
          <th>No</th>
          <th>Title</th>
          <th>Content</th>
          <th>Category</th>
          <th>Image</th>
          <th>User</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(article, key) in articles" :key="article.id">
          <td>{{ key + 1 }}</td>
          <td>{{ article.title }}</td>
          <td>{{ article.content }}</td>
          <td>{{ article.category.name }}</td>
          <td><img v-if="article.image" :src="'images/' + article.image" width="80" style="border-radius:5px;"></td>
          <td>{{ article.user.name }}</td>
          <td>
            <div class="btn-group" role="group">
              <router-link :to="{ name: 'editarticle', params: { id: article.id } }" class="btn btn-success">Edit
              </router-link>
              <button class="btn btn-danger" @click="deleteArticle(article.id)">Delete</button>
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
      articles: []
    }
  },
  created() {
    this.$axios.get('/sanctum/csrf-cookie').then(response => {
      this.$axios.get('/api/articles')
        .then(response => {
          this.articles = response.data.articles;
        })
        .catch(function (error) {
          console.error(error);
        });
    })
  },
  methods: {
    deleteArticle(id) {
      this.$axios.get('/sanctum/csrf-cookie').then(response => {
        this.$axios.delete(`/api/articles/delete/${id}`)
          .then(response => {
            let i = this.articles.map(item => item.id).indexOf(id); // find index of your object
            this.articles.splice(i, 1)
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