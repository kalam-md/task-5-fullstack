<template>
  <div>
    <h4 class="text-center">Add Article</h4>
    <div class="row">
      <div class="col-md-3"></div>
      <div class="col-md-6">
        <form @submit.prevent="addArticle">
          <div class="form-group">
            <label>Title</label>
            <input type="text" class="form-control mb-3" v-model="article.title">
          </div>
          <div class="form-group mb-3">
            <label>Category</label>
            <select class="form-select" v-model="article.category_id">
              <option value>Select Category</option>
              <option v-for="category in categories" :key="category.id" :value="category.id">
                {{
                    category.name
                }}
              </option>
            </select>
          </div>
          <div class="form-group">
            <label>Content</label>
            <input type="text" class="form-control mb-3" v-model="article.content">
          </div>
          <div class="form-group">
            <label>Image</label>
            <input type="file" name="image" @change="handleFileObject" class="form-control">
            <img class="mt-3" :src="previewImage" width="500" style="border-radius:5px;">
          </div>
          <div class="form-group">
            <input type="hidden" class="form-control" v-model="article.user_id">
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
      article: {
        title: "",
        content: "",
        image: null,
        category_id: "",
        user_id: document.querySelector("meta[name='user_id']").getAttribute('content'),
      },
      categories: {},
      previewImage: null,

    }
  },
  created() {
    this.getCategories();
  },
  methods: {
    handleFileObject(e) {
      let files = e.target.files[0];
      this.previewImage = URL.createObjectURL(files);
      this.article.image = files;
    },
    addArticle() {
      let article = new FormData();
      article.append('file', this.article.image);

      _.each(this.article, (value, key) => {
        article.append(key, value);
      });

      this.$axios.get('/sanctum/csrf-cookie').then(response => {
        this.$axios.post('/api/articles/add', article, {
          headers: {
            'Content-Type': 'multipart/form-data',
          }
        }).then(response => {
          this.$router.push({ name: 'articles' })
        })
          .catch(function (error) {
            console.error(error);
          });
      })
    },
    getCategories() {
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
  },
  beforeRouteEnter(to, from, next) {
    if (!window.Laravel.isLoggedin) {
      window.location.href = "/";
    }
    next();
  }
}
</script>