---
title: Relatórios e Faturas
---

# Relatórios e Faturas
Relatórios e faturamento são essenciais para controle financeiro e conformidade. Este documento consolida os relatórios disponíveis e descreve procedimentos práticos para geração, exportação e conciliação.

Mapa de navegação (painel)
- Relatórios: WordPress > VikBooking > Reports/Relatórios
- Faturamento: WordPress > VikBooking > Billing/Faturas

1) Relatórios principais e uso
- Ocupação por período e tipo de quarto: análise de demanda e sazonalidade.
- Financeiro por status de pagamento: identificar valores pendentes, capturados e reembolsados.
- Receita por tarifa e canal: entender quais tarifas performam melhor e origem das vendas.

2) Como gerar relatórios (passo a passo)
1. Acesse VikBooking → Reports / Relatórios.
2. Selecione o tipo de relatório desejado.
3. Filtre por período, tipo de quarto, canal e status de pagamento.
4. Visualize e, se necessário, exporte em CSV/PDF.

3) Exportação e integração
- Exporte CSV para importação em ferramentas contábeis ou planilhas (Excel/Google Sheets).
- Para integração automática, use os endpoints/API disponíveis ou exporte relatórios agendados quando suportado.

4) Faturas e recibos
1. Configurar dados fiscais: VikBooking → Billing / Faturas — preencha razão social, CNPJ/CPF, endereço e dados fiscais necessários.
2. Defina regra de emissão automática (ao confirmar reserva) ou manual (admin).
3. Numeração: definir prefixo e sequência para evitar colisões.
4. Emitir e anexar PDF da fatura à reserva.

5) Conciliação financeira (processo recomendado)
1. Periodicamente (diário/semanal), exporte o relatório financeiro do VikBooking.
2. Exporte o extrato/transações do gateway (CSV).
3. Compare transações: confirme que cada reserva com pagamento capturado tem uma transação correspondente.
4. Registre divergências e ações (pagamento manual, solicitação de estorno, contato ao cliente).

6) Retenção e compliance
- Arquivar faturas e relatórios por prazo legal exigido pela legislação local.
- Manter backups das tabelas do plugin que armazenam informações de faturamento.

7) Troubleshooting
- Faturas não geradas: verifique se a reserva atingiu o status necessário (ex.: Captured) e se a configuração de faturamento está ativa.
- Dados fiscais incorretos: corrija os dados em Billing e gere nota de correção quando aplicável.

8) Boas práticas
- Agende exports periódicos (backup + contabilidade).
- Mantenha um log de alterações de faturas (quem fez a ação, timestamp, motivo).
