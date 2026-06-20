<template>
  <div class="page-shell">
    <div class="page-header">
      <h3 class="page-title">Edit Post</h3>
      <router-link to="/posts" class="btn btn-outline-secondary">Back</router-link>
    </div>

    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">
            <h3 class="mb-0">Edit Post</h3>
          </div>
          <div class="card-body">
            <div v-if="loading" class="text-center py-5">
              <Loading />
            </div>
            <form v-else @submit.prevent="handleSubmit">
              <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input
                  v-model="form.title"
                  type="text"
                  class="form-control"
                  id="title"
                  required
                />
              </div>

              <div class="mb-3">
                <label for="category" class="form-label">Category</label>
                <select
                  v-model="form.category_id"
                  class="form-select"
                  id="category"
                  required
                >
                  <option value="">Select a category</option>
                  <option v-for="category in categories" :key="category.id" :value="category.id">
                    {{ category.name }}
                  </option>
                </select>
              </div>

              <div class="mb-3">
                <label for="content" class="form-label">Content</label>
                <textarea
                  v-model="form.content"
                  class="form-control"
                  id="content"
                  rows="10"
                  required
                ></textarea>
              </div>

              <div class="d-flex justify-content-end">
                <router-link to="/posts" class="btn btn-secondary me-2">Cancel</router-link>
                <button type="submit" class="btn btn-primary" :disabled="submitting">
                  {{ submitting ? 'Updating...' : 'Update Post' }}
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { postService } from '../services/postService'
import { categoryService } from '../services/categoryService'
import Loading from '../components/Loading.vue'
import { toast } from 'vue3-toastify'

const route = useRoute()
const router = useRouter()
const post = ref(null)
const categories = ref([])
const loading = ref(true)
const submitting = ref(false)

const form = ref({
  title: '',
  category_id: '',
  content: '',
})

const loadPost = async () => {
  try {
    const id = route.params.id
    post.value = await postService.getPost(id)
    form.value = {
      title: post.value.title,
      category_id: post.value.category_id,
      content: post.value.content,
    }
  } catch (error) {
    toast.error('Failed to load post')
    router.push('/posts')
  } finally {
    loading.value = false
  }
}

const loadCategories = async () => {
  try {
    categories.value = await categoryService.getAllCategories()
  } catch (error) {
    toast.error('Failed to load categories')
  }
}

const handleSubmit = async () => {
  submitting.value = true
  try {
    const id = route.params.id
    await postService.updatePost(id, form.value)
    toast.success('Post updated successfully!')
    router.push(`/posts/${id}`)
  } catch (error) {
    toast.error('Failed to update post')
  } finally {
    submitting.value = false
  }
}

onMounted(() => {
  loadCategories()
  loadPost()
})
</script>

