<template>
  <div class="about-page">
    <header class="header">
      <span>{{ title }}</span>
    </header>
    <div v-if="loading" class="loading">
      <span>Carregando...</span>
    </div>
    <div v-else class="info">
      <p><strong>Autor:</strong> {{ apiInfo.author }}</p>
      <p><strong>Versão:</strong> {{ apiInfo.version }}</p>
       <p><strong>Repositório:</strong> {{ apiInfo.repository }}</p>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      title: "Sobre o API",
      loading: false,
      apiInfo: {},
    };
  },
  mounted() {
    this.loading = true;
    axios
      .get("http://localhost:8000/api/v1")
      .then((response) => {
        this.apiInfo = response.data["data"];
      })
      .catch((error) => {
        console.error("Erro ao buscar informações da API:", error);
      })
      .then(() => {
        this.loading = false;
      });
  },
};
</script>

<style scoped>

.header {
  display: flex;
  height: 80px;
  padding: 0px 80px;
  align-items: center;
  justify-content: space-between;
}

.header span {
  font-weight: 600;
  font-size: 2em;
}
.about-page {
  padding: 20px;
}

.info {
  margin-bottom: 20px;
}

.loading {
  margin: 20px 0;
}
</style>
