<template>
  <div class="mb-5">
    <div v-if="error" class="text-center">
      <p>{{ error }}</p>
      <button @click="fetchPosts" class="btn btn-purple">
        {{ tryButton }}
      </button>
    </div>

    <div v-else-if="!isLoaded" class="text-center">
      <div class="spinner-grow text-warning my-lg-5" role="status">
        <span class="sr-only">Loading...</span>
      </div>
    </div>

    <div v-else class="row">
      <div 
        v-for="post of posts"
        :key="post.id"
        class="col-md-6"
      >
        <Item v-bind:item="post" />
      </div>
    </div>

    <div v-show="!isFinished">
      <div v-if="isLoaded" class="text-center" style="height: 30px;">
        <div v-if="isLoadedMore">
          <div class="spinner-border text-warning" role="status">
            <span class="sr-only">Loading...</span>
          </div>
        </div>

        <Observer v-else @intersect="loadMore" :textButton="loadButton" />
      </div>
    </div>
  </div>
</template>

<script>
import Item from './Item.vue'
import Observer from './Observer.vue'

export default {
  components: {
    Item,
    Observer
  },
  props: {
    link: {
      type: String,
      required: true
    }
  },
  data() {
    return {
      loadButton: 'Load more',
      tryButton: 'Try again',
      textError: 'Too many requests. Wait 1 minute',
      page: 2,
      isLoaded: false,
      isFinished: false,
      isLoadedMore: false,
      error: null,
      posts: []
    }
  },
  created() {
    if (document.documentElement.lang === 'ru') {
      this.loadButton = 'Загрузить еще'
      this.tryButton = 'Еще раз'
      this.textError = 'Слишком много запросов. Подождите минуту'
    }
  },
  mounted() {
    this.fetchPosts()
  },
  methods: {
    fetchPosts() {
      fetch(`/api/${this.link}`)
      .then(res => res.json())
      .then(res => {
        this.posts.push(...res.data)
        this.isLoaded = true
        this.error = null

        if (res.meta.current_page === res.meta.last_page)
          this.isFinished = true
      })
      .catch(() => this.error = this.textError)
    },
    loadMore() {
      this.isLoadedMore = true

      fetch(`/api/${this.link}?page=${this.page}`)
      .then(res => res.json())
      .then(res => {
        this.isLoadedMore = false
        this.posts.push(...res.data)

        if (res.meta.current_page === res.meta.last_page)
          this.isFinished = true
      })
      .catch(() => this.isLoadedMore = false)

      this.page++
    }
  }
}
</script>

<style scoped>
.spinner-grow {
  width: 2.3rem;
  height: 2.3rem;
}
</style>
