<template>
  <div :class="[type === 'error' ? 'error-message' : 'success-message']">
    <p>{{ message }}</p>
  </div>
</template>

<script>
export default {
  props: {
    message: {
      type: String,
      required: true
    },
    type: {
      type: String,
      default: 'error'
    }
  }
};
</script>

<style scoped>
.error-message {
  background-color: #ffcccc;
  color: #ff0000;
}

.success-message {
  background-color: #ccffcc;
  color: #008000;
}
</style>
