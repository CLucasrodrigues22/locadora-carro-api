<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <!-- Card de busca de modelos -->
        <card-component titulo="Busca de Modelos">
          <template v-slot:conteudo>
            <div class="row">
              <div class="col mb-3">
                <input-container-component
                  titulo="Nome do modelo"
                  id="inputNome"
                  id-help="nomeHelp"
                  texto-ajuda="(Opcional) selecione o nome do Modelo"
                >
                  <select class="form-select" v-model="busca.nome">
                    <option
                      v-for="(item, key) in modelos.data"
                      :key="key"
                      :value="item['nome']"
                    >
                      {{ item["nome"] }}
                    </option>
                  </select>
                </input-container-component>
              </div>

              <div class="col mb-3">
                <input-container-component
                  titulo="Marca do modelo"
                  id="inputMarca"
                  id-help="nomeHelp"
                  texto-ajuda="(Opcional) selecione a marca do Modelo"
                >
                  <select class="form-select" v-model="busca.marca_id">
                    <option
                      v-for="(item, key) in marcas.data"
                      :key="key"
                      :value="item[0]"
                    >
                      {{ item[1] }}
                    </option>
                  </select>
                </input-container-component>
              </div>

              <div class="col mb-3">
                <input-container-component
                  titulo="Possui ABS"
                  id="inputABS"
                  id-help="ABSHelp"
                  texto-ajuda="(Opcional) selecione caso queira um modelo com ABS"
                >
                  <select class="form-select" v-model="busca.abs">
                    <option value="1">Com ABS</option>
                    <option value="0">Sem ABS</option>
                  </select>
                </input-container-component>
              </div>

              <div class="col mb-3">
                <input-container-component
                  titulo="Quantidade de portas"
                  id="inputPortas"
                  id-help="nomeHelp"
                  texto-ajuda="(Opcional) Informe a quantidade de portas"
                >
                  <input
                    type="text"
                    class="form-control"
                    id="inputPortas"
                    aria-describedby="portasHelp"
                    placeholder="Ex: 4"
                    v-model="busca.numero_portas"
                  />
                </input-container-component>
              </div>

              <div class="col mb-3">
                <input-container-component
                  titulo="Possui Air Bag"
                  id="inputAirbag"
                  id-help="airbagHelp"
                  texto-ajuda="(Opcional) selecione caso queira um modelo com Air Bag"
                >
                  <select class="form-select" v-model="busca.air_bag">
                    <option value="1">Com Air Bag</option>
                    <option value="0">Sem Air Bag</option>
                  </select>
                </input-container-component>
              </div>
            </div>
          </template>
          <template v-slot:rodape>
            <button
              type="submit"
              class="btn btn-primary btn-sm float-left m-1"
              @click="pesquisar()"
            >
              Pesquisar
            </button>
            <button
              type="submit"
              class="btn btn-success btn-sm float-left"
              @click="limparFiltro()"
            >
              Limpar Filtro
            </button>
          </template>
        </card-component>
        <!-- Fim do card de busca de modelos -->

        <!-- Card de Listagem de modelo -->
        <card-component titulo="Relação de Modelos">
          <template v-slot:conteudo>
            <table-component
              :dados="modelos.data"
              :visualizar="{
                visivel: true,
                dataToggle: 'modal',
                dataTarget: '#modalModeloVisualizar',
              }"
              :editar="{
                visivel: true,
                dataToggle: 'modal',
                dataTarget: '#modalModeloEditar',
              }"
              :finalizar="{
                dataToggle: 'modal',
                dataTarget: '#modalLocacoesFinalizar',
                visivel: false,
              }"
              :deletar="{
                dataToggle: 'modal',
                dataTarget: '#modalModeloDeletar',
                visivel: true,
              }"
              :titulos="{
                id: { titulo: 'ID', tipo: 'texto' },
                nome: { titulo: 'Nome', tipo: 'texto' },
                created_at: { titulo: 'Data de Criação', tipo: 'data' },
                marca: { titulo: 'Marca', tipo: 'array' },
              }"
            >
            </table-component>
          </template>

          <template v-slot:rodape>
            <div class="row">
              <div class="col-10">
                <pagination-component>
                  <li
                    :class="li.active ? 'page-item active' : 'page-item'"
                    v-for="(li, key) in modelos.links"
                    :key="key"
                    @click="paginacao(li)"
                  >
                    <a class="page-link" v-html="li.label"></a>
                  </li>
                </pagination-component>
              </div>
              <div class="col-2">
                <button
                  type="button"
                  class="btn btn-primary btn-sm adicionar"
                  data-bs-toggle="modal"
                  data-bs-target="#modalModelo"
                >
                  Adicionar
                </button>
              </div>
            </div>
          </template>
        </card-component>
        <!-- Fim do Card de Listagem de modelo -->
      </div>
    </div>

    <!-- Modal de cadastro de modelo -->
    <modal-component id="modalModelo" titulo="Cadastro de Modelo">
      <template v-slot:conteudo>
        <div class="form-group">
          <input-container-component
            titulo="Marca do modelo"
            id="marcaModelo"
            id-help="marcaModeloHelp"
            texto-ajuda="(Obrigatório) Informe a marca que o modelo pertence"
          >
            <select class="form-select" v-model="marcaModelo">
              <option
                v-for="(item, key) in marcas.data"
                :key="key"
                :value="item[0]"
              >
                {{ item[1] }}
              </option>
            </select>
          </input-container-component>
          <input-container-component
            titulo="Nome do Modelo"
            id="novoModelo"
            id-help="novoModeloHelp"
            texto-ajuda="(Obrigatório) Informe o nome do modelo"
          >
            <input
              type="text"
              class="form-control"
              id="novoNome"
              aria-describedby="novoNomeHelp"
              placeholder="Nome do modelo"
              v-model="novoModelo"
              required
            />
          </input-container-component>
          <input-container-component
            titulo="Número de Portas"
            id="numeroPortas"
            id-help="numeroPortasHelp"
            texto-ajuda="(Obrigatório) Informe o Número de Portas"
          >
            <select
              class="form-select"
              aria-label="numeroPortas"
              v-model="numeroPortas"
            >
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
              <option value="6">6</option>
            </select>
          </input-container-component>
          <input-container-component
            titulo="Lugares"
            id="lugaresModelo"
            id-help="lugaresHelp"
            texto-ajuda="(Obrigatório) Informe a quantidade de Lugares"
          >
            <select
              class="form-select"
              aria-label="lugaresModelo"
              id="lugaresModelo"
              v-model="lugaresModelo"
            >
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
              <option value="6">6</option>
              <option value="7">7</option>
            </select>
          </input-container-component>
          <input-container-component
            titulo="Air Bag"
            id="airbagModelo"
            id-help="airbagHelp"
            texto-ajuda="(Obrigatório) Informe se o modelo possui Air Bag"
          >
            <select
              class="form-select"
              aria-label="airbagModelo"
              id="airbagModelo"
              v-model="airbagModelo"
            >
              <option value="1">Sim</option>
              <option value="0">Não</option>
            </select>
          </input-container-component>
          <input-container-component
            titulo="ABS"
            id="absModelo"
            id-help="absHelp"
            texto-ajuda="(Obrigatório) Informe se o modelo possui ABS"
          >
            <select
              class="form-select"
              aria-label="absModelo"
              id="absModelo"
              v-model="absModelo"
            >
              <option value="1">Sim</option>
              <option value="0">Não</option>
            </select>
          </input-container-component>
          <input-container-component
            titulo="Imagem do Modelo"
            id="novaImagem"
            name="novaImagem"
            id-help="imagemHelp"
            texto-ajuda="(Obrigatório) Selecione a imagem do modelo"
          >
            <input
              type="file"
              class="form-control"
              id="novaImagem"
              aria-describedby="imagemHelp"
              @change="carregarImagem($event)"
              required
            />
          </input-container-component>
        </div>
      </template>
      <template v-slot:rodape>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
          Fechar
        </button>
        <button type="button" class="btn btn-primary" @click="salvar()">
          Salvar Modelo
        </button>
      </template>
    </modal-component>
    <!-- Fim do modal de cadastro de modelo -->

    <!-- Modal de vizualização de modelo -->
    <modal-component id="modalModeloVisualizar" titulo="Dados do Modelo">
      <template v-slot:conteudo>
        <div class="card">
          <img
            :src="'storage/' + $store.state.item.imagem"
            class="card-img-top"
            alt="..."
          />
          <div class="card-body">
            <h4 class="card-title mb-3">
              Modelo: <strong>{{ $store.state.item.nome }}</strong>
            </h4>
            <ol class="list-group list-group">
              <li
                class="list-group-item d-flex justify-content-between align-items-start"
              >
                <div class="ms-2 me-auto">
                  <div class="fw-bold">Número de Portas</div>
                  {{ $store.state.item.numero_portas }}
                </div>
              </li>
              <li
                class="list-group-item d-flex justify-content-between align-items-start"
              >
                <div class="ms-2 me-auto">
                  <div class="fw-bold">Lugares</div>
                  {{ $store.state.item.lugares }} Lugares
                </div>
              </li>
              <li
                class="list-group-item d-flex justify-content-between align-items-start"
              >
                <div class="ms-2 me-auto">
                  <div class="fw-bold">Air Bag</div>
                  {{
                    $store.state.item.air_bag != 1
                      ? "Não possui Air Bag"
                      : "Possui Air Bag"
                  }}
                </div>
              </li>
              <li
                class="list-group-item d-flex justify-content-between align-items-start"
              >
                <div class="ms-2 me-auto">
                  <div class="fw-bold">ABS</div>
                  {{
                    $store.state.item.abs != 1 ? "Não possui ABS" : "Possui ABS"
                  }}
                </div>
              </li>
            </ol>
          </div>
        </div>
      </template>
      <template v-slot:rodape>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
          Fechar
        </button>
      </template>
    </modal-component>
    <!-- Fim do modal de vizualização de modelo -->

    <!-- Modal de exclusão de modelo -->
    <modal-component
      id="modalModeloDeletar"
      titulo="Dados da marca a ser removida"
    >
      <template v-slot:conteudo>
        <div class="card">
          <img
            :src="'storage/' + $store.state.item.imagem"
            class="card-img-top"
            alt="..."
          />
          <div class="card-body">
            <h4 class="card-title mb-3">
              Modelo: <strong>{{ $store.state.item.nome }}</strong>
            </h4>
          </div>
        </div>
      </template>
      <template v-slot:rodape>
        <div class="btnDeletar">
          <button
            type="button"
            class="btn btn-secondary m-1"
            data-bs-dismiss="modal"
          >
            Fechar
          </button>
          <button
            type="button"
            class="btn btn-danger m-1"
            @click="deletar($store.state.item)"
          >
            Deletar
          </button>
        </div>
      </template>
    </modal-component>
    <!-- Fim do modal de exclusão de modelo -->

    <!-- Modal de edição de modelo -->
    <modal-component id="modalModeloEditar" titulo="Dados do Modelo">
      <template v-slot:conteudo>
        <img
          :src="'storage/' + $store.state.item.imagem"
          class="card-img-top"
          alt="Imagem do Modelo"
        />
        <div class="form-group">
          <input-container-component
            titulo="Marca do modelo"
            id="marcaModelo"
            id-help="marcaModeloHelp"
            texto-ajuda="(Opcional) Informe a marca que o modelo pertence"
          >
            <select
              class="form-select"
              aria-label="numeroPortas"
              v-model="$store.state.item.marca_id"
            >
              <option
                v-for="(item, key) in marcas.data"
                :key="key"
                :value="item[0]"
              >
                {{ item[1] }}
              </option>
            </select>
          </input-container-component>
          <input-container-component
            titulo="Nome do Modelo"
            id="novoModelo"
            id-help="novoModeloHelp"
            texto-ajuda="(Opcional) Informe o nome do modelo"
          >
            <input
              type="text"
              class="form-control"
              id="novoNome"
              aria-describedby="novoNomeHelp"
              placeholder="Nome do modelo"
              v-model="$store.state.item.nome"
              required
            />
          </input-container-component>
          <input-container-component
            titulo="Número de Portas"
            id="numeroPortas"
            id-help="numeroPortasHelp"
            texto-ajuda="(Opcional) Informe o Número de Portas"
          >
            <select
              class="form-select"
              aria-label="numeroPortas"
              v-model="$store.state.item.numero_portas"
            >
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
              <option value="6">6</option>
            </select>
          </input-container-component>
          <input-container-component
            titulo="Total de Lugares"
            id="lugaresModelo"
            id-help="lugaresModeloHelp"
            texto-ajuda="(Opcional) Informe a quantidade de lugares"
          >
            <select
              class="form-select"
              aria-label="lugaresModelo"
              v-model="$store.state.item.lugares"
            >
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
              <option value="6">6</option>
              <option value="7">7</option>
            </select>
          </input-container-component>
          <input-container-component
            titulo="Possui Air Bag?"
            id="airbagModelo"
            id-help="airbagModeloHelp"
            texto-ajuda="(Opcional) Informe se o veiculo possui Air Bag"
          >
            <select
              class="form-select"
              aria-label="airbagModelo"
              v-model="$store.state.item.air_bag"
            >
              <option value="1">Sim</option>
              <option value="0">Não</option>
            </select>
          </input-container-component>
          <input-container-component
            titulo="Possui ABS?"
            id="absModeloModelo"
            id-help="absModeloModeloHelp"
            texto-ajuda="(Opcional) Informe se o veiculo possui ABS"
          >
            <select
              class="form-select"
              aria-label="absModeloModelo"
              v-model="$store.state.item.abs"
            >
              <option value="1">Sim</option>
              <option value="0">Não</option>
            </select>
          </input-container-component>
          <input-container-component
            titulo="Imagem"
            id="atualizarImagem"
            id-help="atualizarImagemHelp"
            texto-ajuda="Selecione uma imagem no formato PNG"
          >
            <input
              type="file"
              class="form-control"
              id="atualizarImagem"
              aria-describedby="atualizarImagemHelp"
              placeholder="Selecione uma imagem"
              @change="carregarImagem($event)"
            />
          </input-container-component>
        </div>
      </template>
      <template v-slot:rodape>
        <div class="btnModalModelo">
          <button
            type="button"
            class="btn btn-secondary m-1"
            data-bs-dismiss="modal"
          >
            Fechar
          </button>
          <button
            type="button"
            class="btn btn-primary m-1"
            @click="editar($store.state.item)"
          >
            Salvar Alteração
          </button>
        </div>
      </template>
    </modal-component>
    <!-- Fim do modal de edição de modelo -->
  </div>
</template>

<script>
export default {
  props: {
    multiple: {
      type: Boolean,
      default: true,
    },
  },
  data() {
    return {
      urlBase: "http://localhost/api/v1/modelo",
      urlPaginacao: "",
      urlFiltro: "",
      marcaModelo: "",
      novoModelo: "",
      numeroPortas: "",
      lugaresModelo: "",
      airbagModelo: "",
      absModelo: "",
      imagemModelo: [],
      feedbackStatus: "",
      feedbackMessage: [],
      modelos: {
        data: [],
      },
      marcas: {
        data: [],
      },
      busca: {
        id: "",
        nome: "",
        numero_portas: "",
        lugares: "",
        air_bag: "",
        abs: "",
        marca_id: "",
      },
    };
  },
  methods: {
    limparFiltro() {
      this.busca.id = "";
      this.busca.nome = "";
      this.busca.marca_id = "";
      this.busca.numero_portas = "";
      this.busca.lugares = "";
      this.busca.air_bag = "";
      this.busca.abs = "";
      this.urlFiltro = "";
      this.carregarModelos();
    },
    pesquisar() {
      let filtro = "";
      for (let chave in this.busca) {
        if (this.busca[chave]) {
          if (filtro != "") {
            filtro += ";";
          }

          filtro += chave + ":like:" + this.busca[chave] + "%";
        }
      }
      if (filtro != "") {
        this.urlPaginacao = "page=1";
        this.urlFiltro = "&filtro=" + filtro;
        console.log(this.urlFiltro);
      } else {
        this.urlFiltro = "";
      }
      this.carregarModelos();
    },
    paginacao(li) {
      if (li.url) {
        this.urlPaginacao = li.url.split("?")[1];
        this.carregarModelos(); // requisitando novamente os dados para nossa API com base na URL atualizada
      }
    },
    carregarModelos() {
      let url = this.urlBase + "?" + this.urlPaginacao + this.urlFiltro;
      axios
        .get(url)
        .then((response) => {
          this.modelos = response.data;
        })
        .catch((errors) => {
          console.log(errors);
        });
    },
    carregarDadosMarcas() {
      let urlMarca = "http://localhost/api/v1/marca?all";
      axios
        .get(urlMarca)
        .then((response) => {
          let marcasDados = response.data;
          marcasDados.forEach((valorAtual) => {
            var dadosMarca = [valorAtual.id, valorAtual.nome];
            this.marcas.data.push(dadosMarca);
          });
        })
        .catch((errors) => {
          console.log(errors);
        });
    },
    carregarImagem(e) {
      this.imagemModelo = e.target.files;
    },
    salvar() {
      // instanciando um formulário para definir os atributos
      let formData = new FormData();
      formData.append("marca_id", this.marcaModelo);
      formData.append("nome", this.novoModelo);
      formData.append("imagem", this.imagemModelo[0]);
      formData.append("numero_portas", this.numeroPortas);
      formData.append("lugares", this.lugaresModelo);
      formData.append("air_bag", this.airbagModelo);
      formData.append("abs", this.absModelo);

      // cabeçalhos da requisição
      let cfg = {
        headres: {
          "Content-Type": "multipart/form-data",
        },
      };

      // enviando atributos para a requisição post para que seja salvo no back-end
      axios
        .post(this.urlBase, formData, cfg)
        .then((response) => {
          swal(
            "Sucesso!",
            `Modelo ${this.novoModelo} cadastrado com sucesso!`,
            "success"
          );
          this.carregarModelos();
        })
        .catch((errors) => {
          swal(
            "Erro!",
            `Ocorreu o seguinte erro: ${errors.response.data.message}.`,
            "error"
          );
          // console.log(errors.response.data.message)
        });
    },
    editar() {
      let formData = new FormData();
      formData.append("_method", "patch");
      formData.append("marca_id", this.$store.state.item.marca_id);
      formData.append("nome", this.$store.state.item.nome);
      formData.append("numero_portas", this.$store.state.item.numero_portas);
      formData.append("lugares", this.$store.state.item.lugares);
      formData.append("air_bag", this.$store.state.item.air_bag);
      formData.append("abs", this.$store.state.item.abs);
      if (this.imagemModelo[0]) {
        formData.append("imagem", this.imagemModelo[0]);
      }

      let url = this.urlBase + "/" + this.$store.state.item.id;

      let cfg = {
        headers: {
          "Content-Type": "multipart/form-data",
        },
      };

      axios
        .post(url, formData, cfg)
        .then((response) => {
          swal(
            "Sucesso!",
            `Modelo ${this.$store.state.item.nome} editado com sucesso!`,
            "success"
          );
          atualizarImagem.value = "";
          this.carregarModelos();
        })
        .catch((errors) => {
          swal(
            "Erro!",
            `Ocorreu um erro na edição do modelo: erro ${errors.response.data.message}`,
            "error"
          );
          console.log(errors.response);
        });
    },
    deletar(item) {
      swal({
        title: "Você tem certeza?",
        text: `Ao confirmar o exclusão, todos os dados de ${item.nome} serão removidos permanentimente da base de dados.`,
        icon: "warning",
        buttons: ["Cancelar", "Deletar"],
        dangerMode: true,
      }).then((willDelete) => {
        if (willDelete) {
          // criando url para delete
          let url = this.urlBase + "/" + this.$store.state.item.id;
          // criando uma instância de forData e passando o metodo para delete
          let formData = new FormData();
          formData.append("_method", "delete");

          axios
            .post(url, formData)
            .then((response) => {
              swal(`O modelo ${item.nome} foi removida com sucesso!`, {
                icon: "success",
              });
              this.carregarModelos();
            })
            .catch((errors) => {
              swal(
                `Erro, verifique se existe algum carro com relação ao modelo ${item.nome}.`,
                {
                  icon: "error",
                }
              );
              console.log(errors);
            });
        }
      });
    },
  },
  mounted() {
    this.carregarModelos();
    this.carregarDadosMarcas();
  },
};
</script>j