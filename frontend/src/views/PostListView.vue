<template>
  <div class="page-shell">
    <div class="page-header">
      <h2 class="page-title">Blog Posts</h2>
      <router-link to="/posts/create" class="btn btn-primary">Create Post</router-link>
    </div>

    <div v-if="loading" class="text-center py-5">
      <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
    </div>

    <div v-else>
      <div v-if="posts.length > 0" class="row g-4">
        <div v-for="post in posts" :key="post.id" class="col-md-6 col-lg-4">
          <div class="card h-100 shadow-sm">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-start mb-2">
                <h5 class="card-title">{{ post.title }}</h5>
                <span class="badge bg-primary">{{ post.category?.name || 'Uncategorized' }}</span>
              </div>
              <p class="card-text text-muted">
                {{ post.content ? post.content.slice(0, 150) + '...' : 'No content' }}
              </p>
              <div class="d-flex justify-content-between align-items-center">
                <small class="text-muted">{{ formatDate(post.created_at) }}</small>
                <router-link :to="`/posts/${post.id}`" class="btn btn-sm btn-outline-primary">Read More</router-link>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div v-else class="text-center py-5">
        <h3>No posts found</h3>
        <p class="text-muted">Create your first post now!</p>
        <router-link to="/posts/create" class="btn btn-primary">Create Post</router-link>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { postService } from '../services/postService'
import { toast } from 'vue3-toastify'

const posts = ref([])
const loading = ref(true)

const loadPosts = async () => {
  loading.value = true
  try {
    console.log('📤 Fetching posts...')
    const data = await postService.getAllPosts()

    // Handle both array and paginated responses
    if (Array.isArray(data)) {
      posts.value = data
    } else if (data && data.data && Array.isArray(data.data)) {
      posts.value = data.data
    } else {
      posts.value = []
    }

    console.log('✅ Posts loaded:', posts.value.length)
  } catch (error) {
    console.error('❌ Failed to load posts:', error)
    toast.error('Failed to load posts')
  } finally {
    loading.value = false
  }
}

const formatDate = (date) => {
  if (!date) return ''
  return new Date(date).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
  })
}

onMounted(() => {
  loadPosts()
})
</script>

