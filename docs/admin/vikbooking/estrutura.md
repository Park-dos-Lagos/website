---
title: Conceitos e Estrutura do VikBooking
---

# Conceitos e Estrutura do VikBooking

Principais entidades:
- Tipos de quarto (Room Types): definem capacidade, comodidades e imagens.
- Unidades (Rooms): unidades físicas, vinculadas a um tipo.
- Tarifas/Planos (Rates/Price Plans): regras de preço por período, ocupação e políticas.
- Disponibilidade: calendário de ocupação e bloqueios.
- Reservas: pedidos com status (pendente, confirmada, cancelada, etc.).
- Pagamentos: integrações como PayPal, cartão, transferência, etc.

Arquitetura no painel:
- Menus do plugin reúnem Configurações, Listagens, Tarifas, Reservas, Relatórios, E-mails, Cupons, e Ferramentas.

Fluxo típico:
1) Cadastrar tipos de quarto e unidades.
2) Definir tarifas, políticas e restrições.
3) Publicar formulários/shortcodes no site.
4) Receber e operar reservas e pagamentos.
