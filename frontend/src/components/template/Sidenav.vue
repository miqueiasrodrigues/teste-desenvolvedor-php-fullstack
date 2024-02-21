<template>
  <nav class="nav">
    <div class="icons-link">
      <router-link to="/">
        <Icon icon="iconamoon:home-fill" width="35" height="35" class="icon" />
      </router-link>
      <router-link to="/register">
        <Icon
          icon="material-symbols:create-new-folder"
          width="35"
          height="35"
          class="icon"
        />
      </router-link>
      <router-link to="/about">
        <Icon icon="solar:info-square-bold" width="35" height="35" class="icon" />
      </router-link>
    </div>
  </nav>
</template>

<script lang="ts">
import Vue from "vue";
import { Icon } from "@iconify/vue2";

export default Vue.extend({
  components: {
    Icon,
  },
});
</script>

<style scoped>
.nav {
  background-color: var(--color-white);
  grid-area: sidenav;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  border-right: 1px solid var(--color-gray);
}

.icons-link {
  height: 30%;
  width: 100%;
  display: flex;
  flex-direction: column;
  justify-content: space-around;
  align-items: center;
}


.icon {
  color: #b4b6af;
}

.icon:hover {
  color: var(--color-green); 
}
</style>
