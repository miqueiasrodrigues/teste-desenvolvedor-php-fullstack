<template>
  <div class="content">
    <router-view></router-view>
  </div>
</template>

<script lang="ts">
import Vue from "vue";

export default Vue.extend({
  data() {
    return {
      mensagem: "Olá, mundo!",
    };
  },
});
</script>

<style scoped>
.content{
  background-color: var(--color-bg);
  grid-area: content;
}

</style>
