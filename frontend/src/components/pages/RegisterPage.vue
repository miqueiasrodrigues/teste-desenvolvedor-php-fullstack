<template>
  <div class="grid-container">
    <header class="header">
      <span>{{ title }}</span>
    </header>

    <form v-if="!loading" class="form" @submit.prevent="submitForm">
      <div class="row">
        <div class="input">
          <label>Identificação:</label>
          <input
            v-model="identification"
            type="text"
            @input="handleCnpjInput"
            placeholder="Digite o CPF ou CNPJ..."
          />
        </div>

        <div class="input">
          <label>Nome:</label>
          <input
            v-model="form.name"
            type="text"
            placeholder="Digite o nome..."
          />
        </div>
        <div class="input">
          <label>E-mail:</label>
          <input
            v-model="form.email"
            type="email"
            placeholder="Digite o e-mail..."
          />
        </div>
      </div>

      <div class="row">
        <div class="input">
          <label>Telefone:</label>
          <input
            v-model="form.phone"
            type="tel"
            placeholder="Digite o telefone..."
          />
        </div>

        <div class="input">
          <label>Endereço:</label>
          <input
            v-model="form.street"
            type="text"
            placeholder="Digite o endereço..."
          />
        </div>

        <div class="input">
          <label>Número:</label>
          <input
            v-model="form.number"
            type="text"
            placeholder="Digite o número..."
          />
        </div>
      </div>

      <div class="row">
        <div class="input">
          <label>Bairro:</label>
          <input
            v-model="form.neighborhood"
            type="text"
            placeholder="Digite o bairro..."
          />
        </div>

        <div class="input">
          <label>Cidade:</label>
          <input
            v-model="form.city"
            type="text"
            placeholder="Digite a cidade..."
          />
        </div>

        <div class="input">
          <label>Estado:</label>
          <select v-model="form.state">
            <option value="">Selecione...</option>
            <option v-for="state in brazilStates" :key="state" :value="state">
              {{ state }}
            </option>
          </select>
        </div>
      </div>

      <div class="row">
        <div class="input">
          <label>CEP:</label>
          <input
            v-model="form.postal_code"
            type="text"
            placeholder="Digite o CEP..."
          />
        </div>

        <div class="input">
          <label>Complemento:</label>
          <input
            v-model="form.complement"
            type="text"
            placeholder="Digite o complemento..."
          />
        </div>

        <div class="input">
          <label>Situação:</label>
          <input
            v-model="form.situation"
            type="text"
            placeholder="Digite a situação..."
          />
        </div>
      </div>

      <div class="row">
        <div class="input">
          <label>Tipo:</label>
          <select v-model="form.type">
            <option value="">Selecione...</option>
            <option
              v-for="typeOption in types"
              :key="typeOption.value"
              :value="typeOption.value"
            >
              {{ typeOption.label }}
            </option>
          </select>
        </div>

        <div class="input">
          <label>Natureza Legal:</label>
          <input
            v-model="form.legal_nature"
            type="text"
            placeholder="Digite a natureza legal..."
          />
        </div>

        <div class="input">
          <label>Data de Abertura:</label>
          <input
            v-model="form.opening_date"
            type="date"
            placeholder="Selecione a data de abertura..."
          />
        </div>
      </div>

      <div class="row">
        <div class="input">
          <label>Data da Situação:</label>
          <input
            v-model="form.situation_date"
            type="date"
            placeholder="Selecione a data da situação..."
          />
        </div>

        <div class="input">
          <label>Descrição da Situação:</label>
          <input
            v-model="form.situation_reason"
            type="text"
            placeholder="Digite a descrição da situação..."
          />
        </div>
      </div>

      <div class="buttons">
        <button type="submit" class="button">Registrar</button>
        <router-link :to="{ name: 'List' }" class="link-button"
          >Voltar</router-link
        >
      </div>
    </form>
    <div v-else>
      <p>Carregando...</p>
    </div>
    <Message v-if="isMessage" :message="messageRecive" :type="messageType" />
  </div>
</template>

<script>
import axios from "axios";
import Message from "../template/Message.vue";
import Vue from "vue";

export default Vue.extend({
  components: {
    Message,
  },
  data() {
    return {
      title: "Cadastro de Fornecedor",
      identification: "",
      brazilStates: [
        "AC",
        "AL",
        "AP",
        "AM",
        "BA",
        "CE",
        "DF",
        "ES",
        "GO",
        "MA",
        "MT",
        "MS",
        "MG",
        "PA",
        "PB",
        "PR",
        "PE",
        "PI",
        "RJ",
        "RN",
        "RS",
        "RO",
        "RR",
        "SC",
        "SP",
        "SE",
        "TO",
      ],
      types: [
        { value: "MATRIZ", label: "Matriz" },
        { value: "FILIAL", label: "Filial" },
      ],
      form: {
        name: "",
        email: "",
        phone: "",
        street: "",
        number: "",
        neighborhood: "",
        city: "",
        state: "",
        postal_code: "",
        complement: "",
        situation: "",
        situation_date: "",
        type: "",
        legal_nature: "",
        situation_reason: "",
        opening_date: "",
      },
      loading: false,
      isMessage: false,
      messageRecive: "",
      messageType: "success",
      messageTimer: null,
    };
  },
  created() {
    if (this.$route.params.id) {
      const supplierId = this.$route.params.id;
      this.fetchSupplierDetails(supplierId);
    }
  },
  methods: {
    async fetchSupplierDetails(id) {
      this.loading = true;
      try {
        const response = await axios.get(
          `http://localhost:8000/api/v1/supplier/${id}`
        );
        const supplier = response.data.data;
        this.form = { ...supplier };
        this.identification = response.data.data["identification"];
      } catch (error) {
        console.error("Erro ao buscar detalhes do fornecedor:", error);
      } finally {
        this.loading = false;
      }
    },
    async submitForm() {
      const requestData = {
        name: this.form.name,
        identification: this.removeFormatIdentification(this.identification),
        email: this.form.email,
        phone: this.removeFormatIdentification(this.form.phone),
        street: this.form.street,
        number: this.form.number,
        neighborhood: this.form.neighborhood,
        city: this.form.city,
        state: this.form.state,
        postal_code: this.removeFormatIdentification(this.form.postal_code),
        complement: this.form.complement,
        situation: this.form.situation,
        situation_date: this.form.situation_date,
        type: this.form.type.toLowerCase(),
        legal_nature: this.form.legal_nature,
        situation_reason: this.form.situation_reason,
        opening_date: this.form.opening_date,
      };

      try {
        if (this.$route.params.id) {
          const response = await axios.put(
            "http://localhost:8000/api/v1/supplier/" + this.$route.params.id,
            requestData
          );
           this.showMessage("Fornecedor atualizado com sucesso.", "success");
        } else {
          const response = await axios.post(
            "http://localhost:8000/api/v1/supplier",
            requestData
          );
           this.showMessage("Fornecedor cadastrado com sucesso.", "success");
        }
        this.clearForm();
        this.identification = "";
        setTimeout(() => {
          this.$router.push({ name: "List" });
        }, 2000);
      } catch (error) {
        if (error.response) {
          const errorValues = Object.values(error.response.data.data.errors)[0];
          console.log(error.response.data.data.errors);
          const message = errorValues[0];
          this.showMessage(message, "error");
        }
      }
    },
    async handleCnpjInput() {
      this.identification = this.formatIdentification(
        this.removeFormatIdentification(this.identification)
      );
      if (
        this.removeFormatIdentification(this.identification).length === 14 &&
        this.$route.params.id === undefined
      ) {
        try {
          const response = await axios.get(
            `http://localhost:8000/api/v1/rf/cnpj/${this.removeFormatIdentification(
              this.identification
            )}`
          );
          const data = response.data["data"];
          if (data.status === "OK") {
            this.form.name = data.nome;
            this.form.email = data.email;
            this.form.phone = data.telefone;
            this.form.street = data.logradouro;
            this.form.number = data.numero;
            this.form.neighborhood = data.bairro;
            this.form.state = data.uf;
            this.form.city = data.municipio;
            this.form.postal_code = data.cep;
            this.form.complement = data.complemento;
            this.form.situation = data.situacao;
            this.form.situation_date = this.formatDate(data.data_situacao);
            this.form.type = data.tipo;
            this.form.legal_nature = data.natureza_juridica;
            this.form.situation_reason = data.motivo_situacao;
            this.form.opening_date = this.formatDate(data.abertura);
            this.showMessage(
              "Dados resgatados da API da Receita Federal.",
              "success"
            );
          } else {
            this.clearForm();
          }
        } catch (error) {
          this.showMessage(
            "CNPJ não encontrado na API da Receita Federal.",
            "error"
          );
        }
      } else {
        if (this.$route.params.id === undefined) {
          this.clearForm();
        }
      }
    },

    clearForm() {
      this.form.name = "";
      this.form.email = "";
      this.form.phone = "";
      this.form.street = "";
      this.form.number = "";
      this.form.neighborhood = "";
      this.form.state = "";
      this.form.city = "";
      this.form.postal_code = "";
      this.form.complement = "";
      this.form.situation = "";
      this.form.situation_date = "";
      this.form.type = "";
      this.form.legal_nature = "";
      this.form.situation_reason = "";
      this.form.opening_date = "";
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
    removeFormatIdentification(identification) {
      return identification.replace(/\D/g, "");
    },
    formatDate(dateString) {
      const [day, month, year] = dateString.split("/");
      return `${year}-${month}-${day}`;
    },
    showMessage(message, type) {
      this.isMessage = true;
      this.messageRecive = message;
      this.messageType = type;

      this.messageTimer = setTimeout(() => {
        this.hideMessage();
      }, 2000);
    },
    hideMessage() {
      this.isMessage = false;
      this.messageRecive = "";
      this.messageType = "";
      clearTimeout(this.messageTimer);
    },
  },
});
</script>


<style scoped>
.input {
  display: flex;
  flex-direction: column;
  padding: 0px 20px;
}

.row {
  display: flex;
  align-items: center;
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

.grid-container {
  height: 100%;
  display: grid;
  grid-template-rows: auto 1fr auto;
}
.header {
  grid-row: 1;
}

.form {
  grid-row: 2;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
}

.message-container {
  grid-row: 3;
}

.buttons {
  padding: 20px;
}

.button {
  margin: 0 40px;
  padding: 12px 32px;
  background-color: var(--color-blue);
  color: var(--color-white);
  border: none;
  border-radius: 12px;
  cursor: pointer;
  text-decoration: none;
  font-size: 16px;
}

.link-button {
  margin: 0 40px;
  padding: 12px 32px;
  background-color: var(--color-blue);
  color: var(--color-white);
  border: none;
  border-radius: 12px;
  cursor: pointer;
  text-decoration: none;
  font-size: 16px;
}

button {
  font-size: 16px;
}

.button:hover {
  background-color: var(--color-green);
}

.link-button:hover {
  background-color: var(--color-pink);
}

input {
  border: 1px solid var(--color-gray);
  border-radius: 18px;
  height: 50px;
  width: 300px;
  padding-left: 20px;
}

select {
  border: 1px solid var(--color-gray);
  border-radius: 18px;
  height: 50px;
  width: 324px;
  padding-left: 20px;
}
</style>