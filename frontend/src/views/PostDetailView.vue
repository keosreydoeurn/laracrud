<template>
  <div class="page-shell">
    <div v-if="loading" class="text-center py-5">
      <Loading />
    </div>

    <div v-else-if="post">
      <div class="page-header">
        <h3 class="page-title">Post Details</h3>
        <router-link to="/posts" class="btn btn-outline-secondary">Back</router-link>
      </div>

      <article class="page-card card mb-0">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-start mb-3">
            <h1 class="card-title">{{ post.title }}</h1>
            <span class="badge bg-primary">{{ post.category?.name }}</span>
          </div>

          <div class="text-muted mb-3">Posted on {{ formatDate(post.created_at) }}</div>

          <div class="content">{{ post.content }}</div>

          <div class="mt-4 d-flex gap-2">
            <router-link :to="`/posts/${post.id}/edit`" class="btn btn-warning">Edit</router-link>
            <button @click="deletePost" class="btn btn-danger">Delete</button>
          </div>
        </div>
      </article>
    </div>

    <div v-else class="text-center py-5">
      <h3>Post not found</h3>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { postService } from '../services/postService'
import Loading from '../components/Loading.vue'
import { toast } from 'vue3-toastify'

const route = useRoute()
const router = useRouter()
const post = ref(null)
const loading = ref(true)

const loadPost = async () => {
  loading.value = true
  try {
    const id = route.params.id
    post.value = await postService.getPost(id)
  } catch (error) {
    toast.error('Failed to load post')
  } finally {
    loading.value = false
  }
}

const deletePost = async () => {
  if (!confirm('Are you sure you want to delete this post?')) return

  try {
    await postService.deletePost(post.value.id)
    toast.success('Post deleted successfully!')
    router.push('/posts')
  } catch (error) {
    toast.error('Failed to delete post')
  }
}

const formatDate = (date) => {
  return new Date(date).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
  })
}

onMounted(() => {
  loadPost()
})
</script>

<style scoped>
.content {
  font-size: 1.1rem;
  line-height: 1.8;
}
</style>

