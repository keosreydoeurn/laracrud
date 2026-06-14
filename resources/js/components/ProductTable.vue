<template>
  <div class="product-table">
    <table class="table table-bordered table-hover">
      <thead class="table-dark">
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Description</th>
          <th>Price</th>
          <th>Quantity</th>
          <th>Status</th>
          <th width="200px">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="product in products" :key="product.id">
          <td>{{ product.id }}</td>
          <td>{{ product.name }}</td>
          <td>{{ truncate(product.description, 50) }}</td>
          <td>${{ formatPrice(product.price) }}</td>
          <td>{{ product.quantity }}</td>
          <td>
            <span :class="getStockClass(product.quantity)">
              {{ getStockStatus(product.quantity) }}
            </span>
          </td>
          <td>
            <div class="btn-group" role="group">
              <button @click="viewProduct(product)" class="btn btn-info btn-sm">
                👁️ View
              </button>
              <button @click="editProduct(product)" class="btn btn-warning btn-sm">
                ✏️ Edit
              </button>
              <button @click="deleteProduct(product.id)" class="btn btn-danger btn-sm">
                🗑️ Delete
              </button>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  name: 'ProductTable',
  props: {
    products: {
      type: Array,
      required: true
    }
  },
  emits: ['view', 'edit', 'delete'],
  methods: {
    truncate(text, length) {
      if (!text) return '—';
      return text.length > length ? text.substring(0, length) + '...' : text;
    },
    formatPrice(price) {
      return Number(price).toFixed(2);
    },
    getStockStatus(quantity) {
      if (quantity > 10) return 'In Stock';
      if (quantity > 0) return 'Low Stock';
      return 'Out of Stock';
    },
    getStockClass(quantity) {
      if (quantity > 10) return 'badge bg-success';
      if (quantity > 0) return 'badge bg-warning';
      return 'badge bg-danger';
    },
    viewProduct(product) {
      this.$emit('view', product);
    },
    editProduct(product) {
      this.$emit('edit', product);
    },
    deleteProduct(id) {
      this.$emit('delete', id);
    }
  }
}
</script>
