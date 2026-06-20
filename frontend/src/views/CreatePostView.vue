<template>
  <div class="page-shell">
    <div class="page-header">
      <h3 class="page-title">Create Post</h3>
      <router-link to="/posts" class="btn btn-outline-secondary">Back</router-link>
    </div>

    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">
            <h3 class="mb-0">Create New Post</h3>
          </div>
          <div class="card-body">
            <div v-if="loading" class="text-center py-3">
              <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
              </div>
            </div>

            <div v-else-if="categories.length === 0" class="alert alert-warning">
              No categories found. Please add categories first.
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
                  {{ submitting ? 'Creating...' : 'Create Post' }}
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
import { useRouter } from 'vue-router'
import { postService } from '../services/postService'
import { categoryService } from '../services/categoryService'
import { toast } from 'vue3-toastify'

const router = useRouter()
const categories = ref([])
const loading = ref(true)
const submitting = ref(false)

const form = ref({
  title: '',
  category_id: '',
  content: '',
})

const loadCategories = async () => {
  loading.value = true
  try {
    const data = await categoryService.getAllCategories()
    categories.value = data
    console.log('Categories loaded:', categories.value.length)
  } catch (error) {
    console.error('Failed to load categories:', error)
    toast.error('Failed to load categories')
  } finally {
    loading.value = false
  }
}

const handleSubmit = async () => {
  submitting.value = true

  try {
    if (!form.value.title.trim()) {
      toast.error('Please enter a title')
      submitting.value = false
      return
    }

    if (!form.value.content.trim()) {
      toast.error('Please enter content')
      submitting.value = false
      return
    }

    if (!form.value.category_id) {
      toast.error('Please select a category')
      submitting.value = false
      return
    }

    const postData = {
      title: form.value.title.trim(),
      content: form.value.content.trim(),
      category_id: parseInt(form.value.category_id),
    }

    await postService.createPost(postData)
    toast.success('Post created successfully!')
    router.push('/posts')
  } catch (error) {
    console.error('Error:', error)
    toast.error('Failed to create post')
  } finally {
    submitting.value = false
  }
}

onMounted(() => {
  loadCategories()
})
</script>

