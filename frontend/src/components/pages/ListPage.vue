<template>
  <div class="grid-container">
    <header class="header">
      <span>{{ title }}</span>
      <input
        type="text"
        v-model="searchTerm"
        placeholder="Pesquisar fornecedor..."
        @input="searchSupplier"
      />
    </header>

    <div class="table-container">
      <div v-if="loading" class="loading">
        <span>Carregando...</span>
      </div>
      <div v-else class="table-wrapper">
        <template v-if="loading">
          <div class="loading">
            <span class="span-font">Carregando...</span>
          </div>
        </template>
        <template v-else>
          <template v-if="filteredSuppliers.length > 0">
            <table>
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Identificação</th>
                  <th>Situação</th>
                  <th>Tipo</th>
                  <th>Cidade</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="supplier in displayedSuppliers" :key="supplier.id">
                  <td>{{ supplier.name }}</td>
                  <td>{{ formatIdentification(supplier.identification) }}</td>
                  <td>{{ supplier.situation }}</td>
                  <td>{{ supplier.type }}</td>
                  <td>{{ supplier.city.concat(" - ", supplier.state) }}</td>
                  <td>
                    <router-link
                      :to="{ name: 'Information', params: { id: supplier.id } }"
                      >Detalhes</router-link
                    >
                  </td>
                </tr>
              </tbody>
            </table>
          </template>
          <template v-else>
            <div class="not-found">
              <span class="span-font">Não há fornecedores disponíveis.</span>
            </div>
          </template></template
        >
      </div>
    </div>
    <template v-if="filteredSuppliers.length > 0">
      <div class="pagination">
        <button @click="prevPage" :disabled="currentPage === 0">
          Anterior
        </button>
        <button @click="nextPage" :disabled="currentPage === pageCount - 1">
          Próximo
        </button>
      </div>
    </template>
  </div>
</template>

<script>
import Vue from "vue";
import axios from "axios";

export default Vue.extend({
  data() {
    return {
      loading: false,
      suppliers: [],
      currentPage: 0,
      pageSize: 5,
      searchTerm: "",
      title: "Lista de Fornecedores",
    };
  },
  computed: {
    pageCount() {
      return Math.ceil(this.filteredSuppliers.length / this.pageSize);
    },
    filteredSuppliers() {
      if (!this.searchTerm) {
        return this.suppliers;
      }
      const searchTermLower = this.searchTerm.toLowerCase();
      return this.suppliers.filter((supplier) =>
        Object.values(supplier).some((value) =>
          String(value).toLowerCase().includes(searchTermLower)
        )
      );
    },
    displayedSuppliers() {
      const startIndex = this.currentPage * this.pageSize;
      return this.filteredSuppliers.slice(
        startIndex,
        startIndex + this.pageSize
      );
    },
  },
  mounted() {
    this.loading = true;
    axios
      .get(
        "http://localhost:8000/api/v1/supplier?attributes=id,name,identification,situation,type,city,state"
      )
      .then((response) => {
        this.suppliers = response.data.data;
      })
      .catch((error) => {
        console.error("Erro ao buscar fornecedores:", error);
      })
      .then(() => {
        this.loading = false;
      });
  },
  methods: {
    showDetails(supplierId) {
      this.$router.push({
        name: "supplier-details",
        params: { id: supplierId },
      });
    },
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
    prevPage() {
      if (this.currentPage > 0) {
        this.currentPage--;
      }
    },
    nextPage() {
      if (this.currentPage < this.pageCount - 1) {
        this.currentPage++;
      }
    },
    searchSupplier() {
      this.currentPage = 0;
    },
  },
});
</script>


<style scoped>
.not-found {
  display: flex;
  justify-content: center;
}

.grid-container {
  display: flex;
  flex-direction: column;
  height: 100%;
}

.header {
  display: flex;
  height: 80px;
  padding: 0px 80px;
  align-items: center;
  justify-content: space-between;
}

.header input {
  border: 1px solid var(--color-gray);
  border-radius: 18px;
  height: 50px;
  width: 300px;
  padding-left: 20px;
}
.header span {
  font-weight: 600;
  font-size: 2em;
}

.table-container {
  flex-grow: 1;
  display: flex;
  justify-content: center;
  align-items: center;
}

.table-wrapper {
  width: 100%;
}
table {
  width: 100%;
  display: flex;
  flex-direction: column;
  background-color: var(--color-white);
  border-radius: 12px;
  overflow: hidden;
  border-collapse: collapse;
}

a {
  text-decoration: none;
  color: var(--color-pink);
  font-weight: 600;
}

tr:nth-child(even) {
  background-color: var(--color-table-dark);
}

thead {
  width: 100%;
  display: flex;
  flex-direction: column;
  justify-content: center;
  background-color: var(--color-white);
  font-weight: 600;
  border-bottom: 1px solid var(--color-gray);
}

tbody {
  width: 100%;
  display: flex;
  flex-direction: column;
}

tr,
td,
th {
  color: var(--color-green);
  width: 100%;
  padding: 8px 20px;
  display: flex;
  justify-content: space-around;
  align-items: center;
}

td {
  color: var(--color-purple);
  font-weight: 400;
}

.pagination {
  padding: 20px 0px;
  display: flex;
  justify-content: center;
}

.pagination button {
  margin: 0 40px;
  padding: 12px 32px;
  background-color: var(--color-blue);
  color: var(--color-white);
  border: none;
  border-radius: 12px;
  cursor: pointer;
}

.pagination button:hover {
  background-color: var(--color-green);
}

.pagination button:disabled {
  opacity: 0.5;
  cursor: not-allowed;
  background-color: #6e6e6e;
}

.router-link {
  text-decoration: none;
  color: #13678a;
  font-weight: bold;
}

.router-link:hover {
  text-decoration: underline;
}
</style>
