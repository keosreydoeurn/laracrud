import axios from 'axios'

const API_URL = import.meta.env.VITE_API_URL || 'http://localhost:8000/api'

console.log('🔗 API URL:', API_URL)

const api = axios.create({
  baseURL: API_URL,
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
  },
})

// Request interceptor
api.interceptors.request.use(
  config => {
    console.log(`📤 ${config.method.toUpperCase()} ${config.url}`)
    return config
  },
  error => {
    console.error('❌ Request Error:', error)
    return Promise.reject(error)
  }
)

// Response interceptor - parse JSON and remove BOM
api.interceptors.response.use(
  response => {
    console.log(`📥 ${response.status} ${response.config.url}`)
    
    // If the response is a string and looks like JSON, parse it
    if (typeof response.data === 'string') {
      try {
        // Remove BOM if present
        let data = response.data.replace(/^\uFEFF/, '')
        response.data = JSON.parse(data)
        console.log('📥 Parsed JSON response')
      } catch (e) {
        // Not JSON, leave as is
        console.log('📥 Response is not JSON, leaving as string')
      }
    }
    
    return response
  },
  error => {
    console.error('❌ Response Error:', error)
    return Promise.reject(error)
  }
)

export default api