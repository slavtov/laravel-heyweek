<template>
  <div>
    <div class="input-group">
      <input
        @keyup.enter="handleButton"
        @input="getItems"
        v-model="textInput"
        type="search"
        class="form-control"
        name="search"
        placeholder="Search"
        aria-label="Search"
      >

      <div class="input-group-append">
        <button
          @click="handleButton"
          class="btn btn-purple"
          type="submit"
        >
          <i class="fas fa-search"></i>
        </button>
      </div>
    </div>

    <div v-show="isLoaded">
      <div v-if="!error">
        <div 
          v-for="item of items" 
          :key="item.id"
        >
          <div class="card shadow-sm mt-2">
            <div class="card-body">
              <div class="d-flex align-items-center">
                <img :src="item.img" class="rounded mb-1 mr-2">
                {{ item.title }}
              </div>

              <div class="d-flex justify-content-between small">
                <div class="d-flex">
                  <div 
                    class="font-weight-bold mr-2"
                    v-for="category of item.categories" 
                    :key="category.id"
                  >
                    <span :style="{ color: category.color }">
                      {{ category.name }}
                    </span>
                  </div>
                </div>

                <div>
                  <span class="text-gray mx-2">
                    <i class="far fa-comment"></i>
                    {{ item.comments_count }}
                  </span>

                  <span class="text-gray">
                    <i class="far fa-eye"></i>
                    {{ item.views }}
                  </span>
                </div>
              </div>
            </div>

            <a class="stretched-link" :href="item.link"></a>
          </div>
        </div>
      </div>

      <div v-else class="mt-2">
        {{ error }}
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      textInput: '',
      error: null,
      isLoaded: false,
      items: []
    }
  },
  methods: {
    getItems(event) {
      if (event.target.value.trim()) {
        fetch('/api/search?q=' + event.target.value.trim())
        .then(res => res.json())
        .then(res => {
          this.items = res
          this.error = null
        })
        .catch(() => this.error = 'Too many requests. Wait 1 minute')

        this.isLoaded = true
      } else
        this.isLoaded = false
    },
    handleButton() {
      if (this.textInput.trim())
        window.location.href = document.documentElement.lang === 'en'
        ? '/search?q=' + this.textInput.trim()
        : '/' + document.documentElement.lang + '/search?q=' + this.textInput.trim()
    }
  }
}
</script>

<style scoped>
button {
  border-top-right-radius: 10px;
  border-bottom-right-radius: 10px;
}

img {
  height: 30px;
  width: 60px;
}

.form-control {
  border-top-left-radius: 10px;
  border-bottom-left-radius: 10px;
}
</style>
