---
title: Quartos e Tipos
---

# Quartos e Tipos
Este guia apresenta em detalhes como estruturar tipos de quarto e unidades para facilitar operação e evitar inconsistências.

1) Definições
- Tipo de quarto (Room Type): modelo que define atributos compartilhados (capacidade, amenidades, regras de cancelamento).
- Unidade (Room): instância física atribuída a um tipo.

2) Campos recomendados para Tipos
- Nome padronizado (ex.: "Superior Duplo").
- Capacidade: adultos / crianças / máxima.
- Amenidades: lista (Wi-Fi, ar-condicionado, TV, café da manhã incluído).
- Políticas: cancelamento, extra bed, taxa de limpeza.
- Fotos: imagem principal + galeria (padrão 1200x800 px).

3) Campos recomendados para Unidades
- Identificador (ex.: 101), status (disponível, manutenção), observações internas.
- Foto de referência (opcional) e vinculação ao tipo.

4) Processos operacionais
- Como adicionar um novo tipo: VikBooking → Room Types → Adicionar.
- Como criar unidade: VikBooking → Rooms → Adicionar — vincule o tipo e salve.

5) Boas práticas e padronização
- Padronize nomes e descrições para facilitar filtros e relatórios.
- Use tags internas para indicar características (ex.: "adaptado", "vista-mar").

6) Verificação e QA
- Verificar no front-end cada tipo criado e testar reserva de uma unidade do tipo.
- Periodicamente revisar fotos e descrições (p.ex. a cada 6 meses).

7) Troubleshooting
- Unidade duplicada: revisar importações/exports e possíveis scripts de sincronização.
- Fotos não mostram: checar permissões de arquivos e paths em `wp-content/uploads`.
