<template>
  <button @click="clickHandler" class="btn btn-purple round">
    {{ textButton }}
  </button>
</template>

<script>
export default {
  props: {
    textButton: {
      type: String,
      required: true
    }
  },
  data() {
    return {
      observer: null
    }
  },
  mounted() {
    this.observer = new IntersectionObserver(([entry]) => {
      if (entry && entry.isIntersecting)
        this.$emit('intersect')
    })
  },
  methods: {
    clickHandler() {
      this.observer.observe(this.$el)
    }
  }
}
</script>
