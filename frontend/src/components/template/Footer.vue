<template>
  <footer class="footer">
    <span>Copyright <strong>{{ author }}</strong> ©️ {{ currentYear }}</span>
  </footer>
</template>

<script lang="ts">
import Vue from "vue";

export default Vue.extend({
  data() {
    return {
      author: "Miqueias Rodrigues",
      currentYear: "",
    };
  },
  mounted() {
    const now = new Date();
    this.currentYear = now.getFullYear().toString();
  },
});
</script>

<style scoped>
  .footer{
    background-color: var(--color-gray);
    grid-area: footer;
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .footer strong{
    font-weight: 500;
  }
</style>
