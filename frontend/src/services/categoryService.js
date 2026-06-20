import api from './api'

export const categoryService = {
  async getAllCategories() {
    try {
      const response = await api.get('/categories')
      console.log('Categories response:', response.data)
      
      let categories = response.data
      
      // Remove BOM (Byte Order Mark) if present
      if (typeof categories === 'string') {
        // Remove BOM character (﻿)
        categories = categories.replace(/^\uFEFF/, '')
        try {
          categories = JSON.parse(categories)
        } catch (e) {
          console.error('Failed to parse JSON:', e)
          return []
        }
      }
      
      // If it has a data property (Laravel pagination)
      if (categories && categories.data && Array.isArray(categories.data)) {
        return categories.data
      }
      
      // If it's an object with numeric keys
      if (categories && typeof categories === 'object' && !Array.isArray(categories)) {
        return Object.values(categories)
      }
      
      // If it's already an array
      if (Array.isArray(categories)) {
        return categories
      }
      
      return []
    } catch (error) {
      console.error('Error fetching categories:', error)
      return []
    }
  },

  async createCategory(data) {
    try {
      const response = await api.post('/categories', data)
      return response.data
    } catch (error) {
      console.error('Error creating category:', error)
      throw error
    }
  }
}