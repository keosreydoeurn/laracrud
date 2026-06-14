<template>
  <div class="container mt-4">
    <div class="card">
      <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h3 class="mb-0">📦 Product Management System</h3>
        <button @click="showCreateModal" class="btn btn-light">
          ➕ Add New Product
        </button>
      </div>
      <div class="card-body">
        <!-- Loading Spinner -->
        <div v-if="loading" class="text-center">
          <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
          </div>
        </div>

        <!-- Error Message -->
        <div v-if="error" class="alert alert-danger alert-dismissible fade show" role="alert">
          {{ error }}
          <button type="button" class="btn-close" @click="error = null"></button>
        </div>

        <!-- Success Message -->
        <div v-if="successMessage" class="alert alert-success alert-dismissible fade show" role="alert">
          {{ successMessage }}
          <button type="button" class="btn-close" @click="successMessage = null"></button>
        </div>

        <!-- Product Table -->
        <ProductTable
          v-if="!loading && products.length > 0"
          :products="products"
          @view="viewProduct"
          @edit="editProduct"
          @delete="deleteProduct"
        />

        <!-- No Products -->
        <div v-if="!loading && products.length === 0" class="alert alert-info text-center">
          <h4>No products found!</h4>
          <p>Click the "Add New Product" button to create your first product.</p>
        </div>
      </div>
    </div>

    <!-- Product Modal -->
    <div class="modal fade" id="productModal" tabindex="-1" data-bs-backdrop="static">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header" :class="modalClass">
            <h5 class="modal-title">{{ modalTitle }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <div v-if="modalType !== 'view'">
              <form @submit.prevent="submitForm">
                <div class="mb-3">
                  <label class="form-label">Product Name *</label>
                  <input
                    type="text"
                    class="form-control"
                    v-model="formData.name"
                    required
                  />
                </div>

                <div class="mb-3">
                  <label class="form-label">Description</label>
                  <textarea
                    class="form-control"
                    v-model="formData.description"
                    rows="3"
                  ></textarea>
                </div>

                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label class="form-label">Price *</label>
                    <input
                      type="number"
                      step="0.01"
                      class="form-control"
                      v-model="formData.price"
                      required
                    />
                  </div>

                  <div class="col-md-6 mb-3">
                    <label class="form-label">Quantity *</label>
                    <input
                      type="number"
                      class="form-control"
                      v-model="formData.quantity"
                      required
                    />
                  </div>
                </div>

                <div class="d-flex justify-content-between">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    ❌ Cancel
                  </button>
                  <button type="submit" class="btn" :class="modalType === 'create' ? 'btn-success' : 'btn-warning'">
                    {{ modalType === 'create' ? '✅ Create Product' : '🔄 Update Product' }}
                  </button>
                </div>
              </form>
            </div>
            <div v-else>
              <div class="row mb-3">
                <div class="col-md-3 fw-bold">Name:</div>
                <div class="col-md-9">{{ formData.name }}</div>
              </div>
              <div class="row mb-3">
                <div class="col-md-3 fw-bold">Description:</div>
                <div class="col-md-9">{{ formData.description || '—' }}</div>
              </div>
              <div class="row mb-3">
                <div class="col-md-3 fw-bold">Price:</div>
                <div class="col-md-9">${{ formatPrice(formData.price) }}</div>
              </div>
              <div class="row mb-3">
                <div class="col-md-3 fw-bold">Quantity:</div>
                <div class="col-md-9">{{ formData.quantity }}</div>
              </div>
            </div>
          </div>
          <div class="modal-footer" v-if="modalType === 'view'">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-warning" @click="editFromView">Edit Product</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import { Modal } from 'bootstrap';
import ProductTable from '../components/ProductTable.vue';
import ProductForm from '../components/ProductForm.vue';

export default {
  name: 'ProductList',
  components: {
    ProductTable,
    ProductForm
  },
  data() {
    return {
      products: [],
      loading: false,
      error: null,
      successMessage: null,
      modal: null,
      modalType: null, // 'create', 'edit', 'view'
      formData: {
        id: null,
        name: '',
        description: '',
        price: '',
        quantity: ''
      }
    }
  },
  computed: {
    modalTitle() {
      if (this.modalType === 'create') return 'Create New Product';
      if (this.modalType === 'edit') return 'Edit Product';
      if (this.modalType === 'view') return 'Product Details';
      return '';
    },
    modalClass() {
      if (this.modalType === 'create') return 'bg-success text-white';
      if (this.modalType === 'edit') return 'bg-warning';
      if (this.modalType === 'view') return 'bg-info text-white';
      return '';
    }
  },
  mounted() {
    this.fetchProducts();
    this.modal = new Modal(document.getElementById('productModal'));
  },
  methods: {
    async fetchProducts() {
      this.loading = true;
      this.error = null;

      try {
        const response = await axios.get('/api/products');
        this.products = response.data.products;
      } catch (err) {
        this.error = 'Failed to load products. Please try again.';
        console.error(err);
      } finally {
        this.loading = false;
      }
    },

    showCreateModal() {
      this.modalType = 'create';
      this.formData = {
        id: null,
        name: '',
        description: '',
        price: '',
        quantity: ''
      };
      this.modal.show();
    },

    viewProduct(product) {
      this.modalType = 'view';
      this.formData = { ...product };
      this.modal.show();
    },

    editProduct(product) {
      this.modalType = 'edit';
      this.formData = { ...product };
      this.modal.show();
    },

    editFromView() {
      this.modalType = 'edit';
      this.modal.show();
    },

    async submitForm() {
      // Validate form data
      if (!this.formData.name || !this.formData.price || !this.formData.quantity) {
        this.error = 'Please fill in all required fields';
        return;
      }

      // Prepare data with correct types
      const dataToSend = {
        name: this.formData.name,
        description: this.formData.description || '',
        price: parseFloat(this.formData.price),
        quantity: parseInt(this.formData.quantity)
      };

      try {
        if (this.modalType === 'create') {
          const response = await axios.post('/api/products', dataToSend);
          this.products.unshift(response.data.product);
          this.successMessage = response.data.message;
        } else if (this.modalType === 'edit') {
          const response = await axios.put(`/api/products/${this.formData.id}`, dataToSend);
          const index = this.products.findIndex(p => p.id === this.formData.id);
          if (index !== -1) {
            this.products[index] = response.data.product;
          }
          this.successMessage = response.data.message;
        }

        this.closeModal();
        await this.fetchProducts(); // Refresh the list
      } catch (err) {
        if (err.response && err.response.status === 422) {
          // Validation error
          const errors = err.response.data.errors;
          this.error = Object.values(errors).flat().join(', ');
        } else {
          this.error = err.response?.data?.message || 'An error occurred';
        }
        console.error(err);
      }
    },

    async deleteProduct(id) {
      if (confirm('Are you sure you want to delete this product?')) {
        try {
          await axios.delete(`/api/products/${id}`);
          this.products = this.products.filter(p => p.id !== id);
          this.successMessage = 'Product deleted successfully!';
        } catch (err) {
          this.error = 'Failed to delete product';
          console.error(err);
        }
      }
    },

    closeModal() {
      this.modal.hide();
      this.modalType = null;
      this.formData = {
        id: null,
        name: '',
        description: '',
        price: '',
        quantity: ''
      };
    },

    formatPrice(price) {
      return Number(price).toFixed(2);
    }
  }
}
</script>

<style scoped>
.modal-header.bg-success {
  background-color: #28a745 !important;
}
.modal-header.bg-warning {
  background-color: #ffc107 !important;
}
.modal-header.bg-info {
  background-color: #17a2b8 !important;
}
</style>
