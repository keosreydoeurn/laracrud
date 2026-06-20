import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import PostListView from '../views/PostListView.vue'
import CreatePostView from '../views/CreatePostView.vue'
import EditPostView from '../views/EditPostView.vue'
import PostDetailView from '../views/PostDetailView.vue'

const routes = [
  { path: '/', name: 'Home', component: HomeView },
  { path: '/posts', name: 'Posts', component: PostListView },
  { path: '/posts/create', name: 'CreatePost', component: CreatePostView },
  { path: '/posts/:id/edit', name: 'EditPost', component: EditPostView },
  { path: '/posts/:id', name: 'PostDetail', component: PostDetailView },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

export default router
