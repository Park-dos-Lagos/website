---
title: Pagamentos (Admin)
---

# Pagamentos (Admin)
Este documento descreve, em detalhes práticos, como configurar gateways, validar webhooks e executar conciliação de pagamentos.

Mapa de navegação (painel)
- Gateways de pagamento: WordPress > VikBooking > Payments/Pagamentos
- Webhooks (no gateway): Painel do Gateway (Stripe/PayPal/etc) > Webhooks/Notificações

1) Configuração de gateways (passo a passo)
1. VikBooking → Pagamentos / Payments → selecione o gateway.
2. Insira credenciais (Client ID, Secret, API Key) em modo TEST/SANDBOX inicialmente.
3. Configure URLs de callback/webhook informadas pelo gateway.
4. Salve e faça uma transação de teste.

2) Estados de pagamento e significado
- Pendente: pagamento iniciado mas não confirmado (aguardando webhook ou retorno do gateway).
- Autorizado: valor autorizado (cartão) mas ainda não capturado.
- Capturado: valor efetivamente cobrado — reserva confirmada.
- Falha: pagamento recusado ou erro de processamento.

3) Reconciliar pagamentos (processo recomendado)
1. Diariamente, exporte transações do gateway (CSV) e compare com reservas confirmadas no VikBooking.
2. Marque divergências: transações sem reserva, reservas sem transação, valores divergentes.
3. Aplique correções: registrar pagamentos manuais, solicitar reembolso ou abrir disputa no gateway.

4) Webhooks e segurança
- Verificar assinatura HMAC (ou outro método) do gateway no payload.
- Registrar entrada do webhook e o ID do evento para deduplicação.
- Em caso de falha no processamento, tentar reprocessar e avisar a equipe se falhas persistentes.

5) Reembolsos e estornos
- Reembolsos devem ser iniciados no gateway e no sistema registrar o reembolso com o motivo e o valor.
- Políticas de reembolso devem estar alinhadas com as regras da tarifa.

6) Logs e auditoria
- Manter logs de eventos de pagamento, tentativas de webhook e ações manuais.
- Registrar nome do operador que realizou alterações manuais para auditoria.

7) Troubleshooting comum
- Pagamento pendente mesmo após webhook: verificar se o webhook chegou e se foi processado com sucesso (ver logs).
- Notificação duplicada: deduplicar por event_id do gateway.

8) Boas práticas
- Habilitar sandbox para testes e um ambiente de staging.
- Nunca armazenar dados de cartão no servidor sem PCI compliance; usar tokens do gateway.
