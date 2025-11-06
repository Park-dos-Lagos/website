---
title: Operação do VikBooking — Passo a passo para Administradores
---

# Operação do VikBooking — Passo a passo

Este documento reúne procedimentos operacionais práticos para administradores e operadores do VikBooking: passos sequenciais para configurar, operar e manter reservas no dia-a-dia.

Mapa de navegação (painel)
- Configurações: WordPress > VikBooking > Settings/Configurações
- Tipos/Unidades: WordPress > VikBooking > Room Types | Rooms
- Tarifas: WordPress > VikBooking > Rates/Price Plans
- Disponibilidade/Restrições: WordPress > VikBooking > Availability | Rules/Restrictions
- Pagamentos: WordPress > VikBooking > Payments/Pagamentos (Webhooks no painel do gateway)
- E-mails: WordPress > VikBooking > Emails/Templates
- Reservas: WordPress > VikBooking > Reservas/Bookings
- Relatórios/Faturas: WordPress > VikBooking > Reports | Billing

## Contrato rápido
- Entrada: Acesso de administrador ao painel WordPress + credenciais de gateways (se aplicável).
- Saída: Site configurado, tarifas atualizadas, reservas operáveis e procedimentos de verificação.
- Erros comuns: falta de backup antes de atualizações; credenciais de gateway erradas; conflitos de cache.

## 1) Antes de começar — pré-requisitos
- Acesso administrador ao WordPress (wp-admin).
- Backup recente (veja `backup-e-manutencao.md`).
- Credenciais de pagamento/teste (sandbox) se for configurar gateways.

## 2) Configuração inicial (resumo rápido)
1. Navegue em VikBooking → Configurações Gerais.
2. Ajuste moeda, fuso horário e formato de data.
3. Defina políticas padrão: check-in, check-out, regras de cancelamento.
4. Salve e valide URLs das páginas de busca/checkout.

## 3) Tipos de quarto e unidades (step-by-step)
1. VikBooking → Room Types: clique em "Novo Tipo".
2. Preencha nome, capacidade (adultos/crianças), descrição e comodidades.
3. Salve e então vá para "Rooms" → "Nova Unidade" para cadastrar unidades físicas vinculadas ao tipo.
4. Atribua fotos e número/identificador da unidade.

Verificação: abra a página de listagem no front-end e confirme que os quartos aparecem.

## 4) Tarifas e planos
1. VikBooking → Rates/Price Plans: criar nova tarifa.
2. Defina período (temporada), preço base e regras de ocupação.
3. Adicione políticas (reembolsável, mínimo de noites).
4. Use calibragem por datas: crie períodos de alta/baixa temporada.

Exemplo: Criar tarifa fim de semana com mínimo de 2 noites.

## 5) Disponibilidade e restrições
1. VikBooking → Availability: bloquear datas em manutenção.
2. Defina stop-sell em datas específicas (p.ex. eventos).
3. Configure restrições: mínimo/máximo de noites e dias de chegada permitidos.

## 6) Configurar métodos de pagamento
1. VikBooking → Pagamentos → Gateways: habilite o gateway desejado.
2. Insira credenciais (API keys, client ID, segredos). Use ambiente de testes primeiro.
3. Configure webhooks na dashboard do gateway para notificar pagamentos.
4. Teste uma transação em sandbox e confirme o status no painel do VikBooking.

Observação: manter chaves em local seguro e rotacioná-las periodicamente.

## 7) Páginas e shortcodes
1. Criar páginas: Busca, Resultados, Checkout, Confirmação.
2. Inserir os shortcodes principais onde necessário, por exemplo:

- [vikbooking_search] — formulário de busca
- [vikbooking_rooms] — listagem de quartos

3. Testar a experiência do usuário: pesquisar datas, selecionar quarto e avançar até o checkout (não efetue cobranças em produção durante testes).

## 8) Gestão diária de reservas (checklist rápido)
- Verificar novas reservas e status de pagamento (Pendente/Confirmada/Falha).
- Conciliar reservas com extratos dos gateways (diariamente ou conforme volume).
- Responder solicitações de alteração e registrar pagamentos manuais quando necessário.

Processo para editar uma reserva
1. Acessar VikBooking → Reservas → selecionar reserva.
2. Editar datas/quarto/hóspedes (atenção: pode alterar tarifa).
3. Registrar pagamento manual ou enviar link de pagamento.
4. Salvar e enviar e-mail de confirmação.

## 9) Cancelamentos e reembolsos
- Seguir política definida nas tarifas.
- Registrar reembolso no sistema e no gateway (se houver integração).
- Emitir e enviar comprovante ao hóspede.

## 10) Relatórios e faturamento
- Gerar relatórios periódicos: ocupação, receita por tarifa, relatórios por canal.
- Exportar CSV/PDF para conciliação financeira.

## 11) Cronjobs, webhooks e integrações
- Cronjobs: garantir que tarefas agendadas rodem (lembretes, envios de e-mail, geração de relatórios).
- Webhooks: validar assinatura e segurança das notificações.

## 12) Troubleshooting comum (passos rápidos)
- Reserva não aparece: checar disponibilidade, bloqueios e sobreposição de tarifas.
- Pagamento pendente: verificar logs de webhook e painel do gateway; reenviar notificação se necessário.
- E-mails não enviados: checar servidor SMTP, filas e logs do plugin de e-mail.

## 13) Checklist de operação (diário / semanal / mensal)
- Diário: verificar novas reservas, pagamentos e e-mails de erro.
- Semanal: revisar disponibilidade, aplicar bloqueios e revisar tarifas promocionais.
- Mensal: gerar relatórios de receita, backup completo e revisar logs de segurança.

## 14) Próximos passos e recursos
- Para backup e manutenção: `docs/admin/vikbooking/backup-e-manutencao.md`.
- Para configuração inicial: `docs/admin/vikbooking/configuracao-inicial.md`.
- Para dúvidas específicas, criar ticket para equipe técnica com: URL, ID da reserva e timestamp do erro.

---
Checklist rápido final: sempre fazer backup antes de atualizações e testar em ambiente de staging.
