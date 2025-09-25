---
title: Como executar a documentação (local)
---

# Como executar a documentação (local)

Pré-requisitos:
- WSL habilitado no Windows.
- Node.js e npm instalados no ambiente WSL.

Instalação (primeira vez):

```bash
cd /mnt/d/Rede/Github/Park-dos-Lagos/website/docs
npm install
```

Rodar em modo desenvolvimento (servidor local):

```bash
cd /mnt/d/Rede/Github/Park-dos-Lagos/website/docs
npm run docs:dev
```

Build de produção (gera arquivos estáticos em .vitepress/dist):

```bash
cd /mnt/d/Rede/Github/Park-dos-Lagos/website/docs
npm run docs:build
```

Pré-visualizar o build:

```bash
cd /mnt/d/Rede/Github/Park-dos-Lagos/website/docs
npm run docs:preview
```

Observação: se o editor mostrar erro de tipos no arquivo `docs/.vitepress/config.ts` (módulo `vitepress` não encontrado), execute `npm install` no diretório `docs/` para instalar as dependências.
