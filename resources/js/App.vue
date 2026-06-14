<template>
  <div id="app">
    <ProductList />
  </div>
</template>

<script>
import ProductList from './views/ProductList.vue';

export default {
  name: 'App',
  components: {
    ProductList
  }
}
</script>

<style>
body {
  background-color: #f8f9fa;
}
</style>
