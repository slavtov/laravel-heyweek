import Vue from 'vue'
import SearchComponent from './components/SearchComponent.vue'
import EditorComponent from './components/EditorComponent.vue'
import PostComponent from './components/PostComponent.vue'
import './bootstrap'

Vue.component('search-component', SearchComponent)
Vue.component('editor-component', EditorComponent)
Vue.component('post-component', PostComponent)

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

new Vue({
    el: '#app',
})
