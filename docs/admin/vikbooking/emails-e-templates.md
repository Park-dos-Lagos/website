---
title: E-mails e Modelos
---

# E-mails e Modelos
Este documento detalha os templates de e-mail do VikBooking, variáveis disponíveis e procedimentos de teste e envio.

Mapa de navegação (painel)
- Templates de e-mail: WordPress > VikBooking > Emails/Templates

1) Modelos principais e variáveis comuns
- Confirmação de reserva: variável importantes: {guest_name}, {arrival_date}, {departure_date}, {booking_code}, {total_amount}.
- Lembrete de pagamento/pré-check-in: {due_date}, {payment_link}, {room_details}.
- Cancelamento: {cancellation_policy}, {refund_amount}.

2) Como editar templates (passo a passo)
1. VikBooking → E-mails/Emails → Templates.
2. Selecione o template e altere texto/assunto. Use variáveis entre chaves conforme lista disponível no plugin.
3. Salve e use a opção de envio de teste para um e-mail interno.

3) Testando envio e entregabilidade
- Configure uma conta SMTP de teste (p.ex. SMTP do provedor ou serviço como SendGrid).
- Envie e-mails de teste e verifique headers (SPF/DKIM) para evitar cair em spam.

4) Layout e personalização
- Incluir cabeçalho com logo e rodapé com contatos e links de política de privacidade.
- Preferir templates HTML responsivos; teste em mobile e desktop.

5) Logs e troubleshooting
- Se e-mails não são enviados: verificar fila de envio, configurações SMTP e logs de erro do servidor.
- Erros de template (variáveis não encontradas): certifique-se de que os nomes das variáveis correspondem aos suportados pela versão do plugin.

6) Boas práticas
- Mantenha tom alinhado com a marca e inclua instruções claras para o hóspede sobre contato e cancelamento.
- Não incluir dados sensíveis (nº de cartão) em e-mails.
