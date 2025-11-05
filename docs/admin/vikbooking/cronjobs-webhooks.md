---
title: Cronjobs e Webhooks
---

# Cronjobs e Webhooks
Este documento explica como configurar, monitorar e depurar cronjobs e webhooks usados pelo VikBooking.

1) Conceitos rápidos
- Cronjobs: tarefas agendadas (ex.: lembretes, geração de relatórios, limpeza de logs).
- Webhooks: chamadas HTTP recebidas de terceiros (gateways) notificando eventos (pagamentos, reembolsos).

2) Configuração de cronjobs (WordPress)
- Usar WP-Cron: desativar em produção (`define('DISABLE_WP_CRON', true)` no wp-config.php) e configurar um cron real no servidor para acionar `wp-cron.php` a cada 5–15 minutos.

Exemplo (crontab):

```bash
# Rodar WP-Cron a cada 10 minutos
*/10 * * * * curl -s https://seu-dominio.com/wp-cron.php?doing_wp_cron > /dev/null 2>&1
```

3) Rotina comum de cron do VikBooking
- Lembretes de pagamento/pré-check-in.
- Atualizações de disponibilidade derivadas de regras.
- Tarefas de manutenção (limpeza temp, geração de relatórios).

4) Configuração de webhooks (gateways e integrações)
1. No painel do gateway, configure a URL do webhook (por ex.: `https://seu-dominio.com/wp-json/vikbooking/v1/webhook`).
2. Configure um segredo/assinatura (se o gateway suportar) e registre-o nas configurações do plugin.
3. No plugin, habilite logs de webhook para depuração inicial.

5) Validação de assinaturas e segurança
- Sempre usar HTTPS.
- Validar cabeçalhos de assinatura enviados pelo gateway (p.ex. `X-Signature`) comparando com HMAC do payload e o segredo armazenado.
- Rejeitar requests sem timestamp ou com timestamp muito antigo para evitar replay attacks.

Exemplo rápido de validação HMAC (pseudo):

```php
$expected = hash_hmac('sha256', $payload, $secret);
if (!hash_equals($expected, $received_signature)) {
	http_response_code(400);
	exit('invalid signature');
}
```

6) Monitoramento e reprocessamento
- Persistir logs de webhook com: timestamp, payload, status do processamento e motivo de falha.
- Implementar endpoint administrativo que permita reprocessar uma notificação falhada (retry manual).
- Alertar a equipe se vários webhooks falharem (ex.: >5 falhas em 10 minutos).

7) Troubleshooting comum
- Falha: gateway responde 500 — verificar logs do servidor e do plugin.
- Notificação duplicada: deduplicar por ID de evento do gateway.
- Evento recebido mas status não atualizado: checar mapeamento de status e se o processador do plugin retornou OK.

8) Boas práticas operacionais
- Teste webhooks em ambiente de sandbox antes de produção.
- Documente os formatos de payloads suportados e mantenha um registro das URLs configuradas.
- Rotacione segredos de webhook periodicamente.
