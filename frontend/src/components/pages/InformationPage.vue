<template>
  <div class="information-page">
    <header class="header">
      <span>{{ title }}</span>
    </header>
    <div v-if="loading" class="loading">
      <span>Carregando...</span>
    </div>
    <div v-else class="info">
      <p><strong>Nome:</strong> {{ supplier.name }}</p>
      <p>
        <strong>Identificação:</strong>
        {{ formatIdentification(supplier.identification) }}
      </p>
      <p><strong>Email:</strong> {{ supplier.email }}</p>
      <p><strong>Telefone:</strong> {{ supplier.phone }}</p>
      <p>
        <strong>Endereço:</strong> {{ supplier.street }}, {{ supplier.number }},
        {{ supplier.neighborhood }}, {{ supplier.city }} - {{ supplier.state }},
        CEP: {{ formatCEP(supplier.postal_code) }}
      </p>
      <p><strong>Situação:</strong> {{ supplier.situation }}</p>
      <p><strong>Tipo:</strong> {{ supplier.type }}</p>
      <p><strong>Natureza Jurídica:</strong> {{ supplier.legal_nature }}</p>
      <p>
        <strong>Data de Abertura:</strong>
        {{ formatDate(supplier.opening_date) }}
      </p>
      <p>
        <strong>Data de situação:</strong>
        {{ formatDate(supplier.situation_date) }}
      </p>
      <p>
        <strong>Motivo da situação:</strong>
        {{ supplier.situation_reason || "NÃO INFORMADO" }}
      </p>
      <div class="buttons">
        <router-link :to="{ name: 'Register', params: { id: supplier.id } }"
          >Editar</router-link
        >

        <a href="#" @click="confirmDelete" class="delete-link">Excluir</a>
        <router-link :to="{ name: 'List' }" class="back-link"
          >Voltar</router-link
        >
      </div>
    </div>
  </div>
</template>
<script>
import axios from "axios";
import { format, parseISO } from "date-fns";
import { ptBR } from "date-fns/locale";

export default {
  props: {
    id: {
      type: Number,
      required: true
    },
  },
  data() {
    return {
      loading: false,
      supplier: {},
      title: "Informações do Fornecedor",
    };
  },
  mounted() {
    this.loading = true;
    axios
      .get(`http://localhost:8000/api/v1/supplier/${this.id}`)
      .then((response) => {
        this.supplier = response.data["data"];
      })
      .catch((error) => {
        console.error("Erro ao buscar fornecedor:", error);
      })
      .then(() => {
        this.loading = false;
      });
  },
  methods: {
    formatIdentification(identification) {
      if (identification.length === 11) {
        return identification.replace(
          /^(\d{3})(\d{3})(\d{3})(\d{2})$/,
          "$1.$2.$3-$4"
        );
      } else if (identification.length === 14) {
        return identification.replace(
          /^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})$/,
          "$1.$2.$3/$4-$5"
        );
      } else {
        return identification;
      }
    },

    formatCEP(cep) {
      return cep.replace(/^(\d{5})(\d{3})$/, "$1-$2");
    },

    formatDate(dateString) {
      if (!dateString) return "";
      const date = parseISO(dateString);
      const formattedDate = format(date, "dd 'DE' MMMM 'DE' yyyy", {
        locale: ptBR,
      });
      const parts = formattedDate.split(" ");
      parts[2] = parts[2].toUpperCase();
      return parts.join(" ");
    },

    confirmDelete() {
      if (window.confirm("Tem certeza que deseja excluir este fornecedor?")) {
        this.deleteSupplier();
      }
    },

    formatName(name) {
      if (!name) return "";
      return name.charAt(0).toUpperCase() + name.slice(1).toLowerCase();
    },

    deleteSupplier() {
      axios
        .delete(`http://localhost:8000/api/v1/supplier/${this.id}`)
        .then(() => {
          this.$router.push({ name: "List" });
        })
        .catch((error) => {
          console.error("Erro ao excluir fornecedor:", error);
        });
    },
  },
};
</script>


<style scoped>
.information-page {
  padding: 20px;
}

.info {
  margin-bottom: 20px;
}

.loading {
  margin: 20px 0;
}

.buttons {
  display: flex;
  justify-content: center;
  width: 100%;
  margin-top: 20px;
}

.back-link {
  display: inline-block;
  color: #007bff;
  text-decoration: none;
  margin-top: 10px;
}

.edit-link,
.delete-link {
  margin-right: 10px;
}

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

.buttons a {
  text-decoration: none;
  margin: 0 40px;
  padding: 12px 32px;
  background-color: var(--color-pink);
  color: var(--color-white);
  border: none;
  border-radius: 12px;
  cursor: pointer;
}

.buttons a:first-child {
  background-color: var(--color-green);
}

.buttons a:last-child {
  background-color: var(--color-blue);
}
</style>
