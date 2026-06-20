import api from './api'

export const postService = {
  async getAllPosts(params = {}) {
    const response = await api.get('/posts', { params })
    return response.data
  },

  async getPost(id) {
    const response = await api.get(`/posts/${id}`)
    return response.data
  },

  async createPost(data) {
    const response = await api.post('/posts', data)
    return response.data
  },

  async updatePost(id, data) {
    const response = await api.put(`/posts/${id}`, data)
    return response.data
  },

  async deletePost(id) {
    const response = await api.delete(`/posts/${id}`)
    return response.data
  }
}