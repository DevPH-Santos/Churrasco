# 🔥 Churras SOS: Seu Assistente de Churrasco com Inteligência Artificial

O **Churras SOS** é uma aplicação web interativa projetada para salvar qualquer churrasco! Seja calculando a quantidade exata de carne, ajudando a escolher os melhores cortes, sugerindo acompanhamentos ou dando dicas de última hora sobre como acender o carvão, nossa inteligência artificial está pronta para responder. 

O projeto utiliza o framework **Laravel**, com a interface construída em **PHP Blade** e estilizada com **Tailwind CSS**. A inteligência por trás do chat é alimentada pelo modelo **Gemini da Google**, integrado via **Google AI Studio**.

---

## 🚀 Funcionalidades

* 💬 **Chat em Tempo Real:** Conversa fluida com uma IA especializada na cultura do churrasco.
* 🥩 **Cálculo de Quantidades:** Ajuda a definir quantos gramas de carne, acompanhamentos e bebidas comprar por pessoa.
* 🕒 **Dicas de Preparo:** Instruções passo a passo sobre ponto da carne, marinadas e técnicas de grelha.
* 🎨 **Interface Responsiva:** Design limpo e otimizado para dispositivos móveis e desktop usando Blade e Tailwind.

---

## 🛠️ Tecnologias Utilizadas

* **Framework Backend:** Laravel
* **Frontend:** Blade Templates & Tailwind CSS
* **Banco de Dados:** SQLite
* **Integração de IA:** API do Google Gemini via Google AI Studio

---

## 📦 Pré-requisitos

Antes de iniciar, certifique-se de ter instalado em sua máquina:
* PHP & Composer
* Node.js & NPM
* **XAMPP** (ou outro ambiente com MySQL)
* Uma chave de API do [Google AI Studio](https://google.com)

---

## 🔧 Instalação e Configuração

Siga os passos abaixo para rodar o projeto localmente:

1. **Clone o repositório:**
   ```bash
   git clone [https://github.com](https://github.com/DevPH-Santos/Churrasco.git)
   cd Churrasco
   ```

2. **Instale as dependências do PHP:**
   ```bash
   composer self-update
   composer install
   ```

3. **Configure o arquivo de ambiente:**
   Copie o arquivo de exemplo `.env.example` para `.env`:
   ```bash
   cp .env.example .env
   ```

4. **Gere a chave da aplicação Laravel:**
   ```bash
   php artisan key:generate
   ```

5. **Configure as credenciais e o Banco de Dados:**
   * Abra o Painel do **XAMPP** e ligue o módulo **MySQL**.
   * Crie um banco de dados vazio chamado `churras_sos` no seu `phpMyAdmin`.
   * Abra o arquivo `.env` (ou `.env.example`) e insira a conexão com o banco e a sua chave da API do Gemini:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=churras_sos
   DB_USERNAME=root
   DB_PASSWORD=

   GEMINI_API_KEY="sua_chave_da_api_aqui"
   ```

6. **Rode as migrações do banco de dados:**
   ```bash
   php artisan migrate
   ```

7. **Inicie o servidor local:**
   ```bash
   php artisan serve
   ```

Agora, acesse `http://localhost:8000` no seu navegador para testar o **Churras SOS**!

---

## 💡 Como a IA foi configurada?

O assistente utiliza engenharia de prompt (*System Instructions*) para garantir que o Gemini adote a persona de um **Mestre Churrasqueiro**. Ele prioriza respostas amigáveis, descontraídas e focadas puramente em gastronomia, carnes e na experiência de organizar um bom evento.

---

## 📄 Licença

Este projeto está sob a licença MIT. Veja o arquivo [LICENSE](LICENSE) para mais detalhes.
