<template>
  <div id="app">
    <Sidenav />
    <Content />
    <Footer />
  </div>
</template>

<script lang="ts">
import Vue from "vue";
import Content from "./components/template/Content.vue";
import Footer from "./components/template/Footer.vue";
import Sidenav from "./components/template/Sidenav.vue";

export default Vue.extend({
  components: {
    Sidenav,
    Content,
    Footer,
  },
});
</script>

<style>
:root {
    --color-bg: #F8F7FD;
  --color-white: #ffffff;
  --color-gray: #f1f1f0;
  --color-green: #709718;
  --color-blue: #2a73a1;
  --color-pink: #E84D7A;
  --color-table-dark: #f7f8f7;
   --color-purple: #3b3d64;
}

* {
  font-family: "Poppins", sans-serif;
}

body {
  margin: 0;
}

#app {
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  height: 100vh;
  display: grid;
  grid-template-rows: 1fr 40px;
  grid-template-columns: 80px 1fr;
  grid-template-areas: "sidenav content" "sidenav footer";
}
</style>
