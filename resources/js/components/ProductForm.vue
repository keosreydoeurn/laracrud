<template>
  <div class="product-form">
    <form @submit.prevent="submitForm">
      <div class="mb-3">
        <label for="name" class="form-label">Product Name *</label>
        <input
          type="text"
          class="form-control"
          id="name"
          v-model="form.name"
          required
          placeholder="Enter product name"
        />
      </div>

      <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea
          class="form-control"
          id="description"
          v-model="form.description"
          rows="3"
          placeholder="Enter product description"
        ></textarea>
      </div>

      <div class="row">
        <div class="col-md-6 mb-3">
          <label for="price" class="form-label">Price *</label>
          <div class="input-group">
            <span class="input-group-text">$</span>
            <input
              type="number"
              step="0.01"
              class="form-control"
              id="price"
              v-model="form.price"
              required
              placeholder="0.00"
            />
          </div>
        </div>

        <div class="col-md-6 mb-3">
          <label for="quantity" class="form-label">Quantity *</label>
          <input
            type="number"
            class="form-control"
            id="quantity"
            v-model="form.quantity"
            required
            placeholder="Enter quantity"
          />
        </div>
      </div>

      <div class="d-flex justify-content-between">
        <button type="button" @click="cancel" class="btn btn-secondary">
          ❌ Cancel
        </button>
        <button type="submit" class="btn" :class="isEdit ? 'btn-warning' : 'btn-success'">
          {{ isEdit ? '🔄 Update Product' : '✅ Create Product' }}
        </button>
      </div>
    </form>
  </div>
</template>

<script>
export default {
  name: 'ProductForm',
  props: {
    initialData: {
      type: Object,
      default: () => ({
        name: '',
        description: '',
        price: '',
        quantity: ''
      })
    },
    isEdit: {
      type: Boolean,
      default: false
    }
  },
  data() {
    return {
      form: { ...this.initialData }
    }
  },
  watch: {
    initialData: {
      handler(newVal) {
        this.form = { ...newVal };
      },
      deep: true
    }
  },
  methods: {
    submitForm() {
      this.$emit('submit', this.form);
    },
    cancel() {
      this.$emit('cancel');
    }
  }
}
</script>
