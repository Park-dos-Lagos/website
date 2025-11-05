---
title: Conceitos e Estrutura do VikBooking
---

# Conceitos e Estrutura do VikBooking
Este documento descreve as entidades, relações e fluxo de dados do VikBooking para ajudar administradores e times técnicos a entenderem a arquitetura funcional.

1) Principais entidades e relacionamentos
- Room Types (Tipos de quarto): definem atributos compartilhados (capacidade, comodidades, políticas). Cada tipo pode ter múltiplas Units.
- Rooms / Units (Unidades): instâncias físicas vinculadas a um tipo (ex.: Quarto 101 vinculado ao Tipo "Superior").
- Rates / Price Plans (Tarifas): ligadas a tipos/unidades e aplicadas por período e ocupação.
- Availability (Disponibilidade): calendário por unidade/tipo que indica bloqueios e reservas.
- Bookings / Reservations (Reservas): registros com status (Pendente, Confirmada, Cancelada, No-show) e associações a unidade/tarifa e pagamentos.
- Payments (Pagamentos): entradas ligadas a reservas, com status (autorizado, capturado, reembolsado).

2) Fluxo de criação de uma reserva (resumo técnico)
1. Hóspede pesquisa disponível via shortcode (frontend) — plugin consulta a tabela de disponibilidade e tarifas.
2. Seleção de quarto + política -> criar reserva em estado Pendente.
3. Pagamento (integração): gateway notifica via webhook; status da reserva é atualizado para Confirmada quando pagamento finalizado.
4. Logs e e-mails transacionais são disparados conforme configuração.

3) Mapeamento técnico (tabelas e dados)
- O VikBooking usa tabelas próprias no banco WordPress (`wp_vikbooking_*`) para armazenar tipos, unidades, tarifas, disponibilidade e reservas.
- Dados a preservar em backup: tabelas do plugin + uploads (imagens) + configurações.

4) Integrações comuns
- Gateways de pagamento (PayPal, Stripe, intermediadores locais)
- Sistemas de contabilidade/exportação via CSV
- Webhooks para notificação de status de pagamento

5) Considerações para desenvolvedores
- Atualizações: testar migração de dados em staging.
- Customizações: respeitar hooks/filters do plugin para manter compatibilidade com atualizações futuras.

6) Troubleshooting estrutural
- Dados inconsistentes (p.ex. reserva sem unidade): verificar integridade das tabelas e logs de jobs cron.
- Perdas de disponibilidade: conferir jobs que reindexam disponibilidade e eventuais scripts externos que alterem tabelas.
