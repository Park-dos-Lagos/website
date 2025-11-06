---
title: Reservas — Gestão Completa
---

# Reservas — Gestão Completa
Este guia aprofunda a gestão de reservas, cobrindo criação, edição, conciliação e resolução de conflitos.

Mapa de navegação (painel)
- Reservas: WordPress > VikBooking > Reservas/Bookings

1) Fluxo detalhado de uma reserva
1. Criação: reserva criada pelo hóspede via front-end ou manualmente por um operador (VikBooking → Reservas → Nova Reserva).
2. Validação: o sistema confere disponibilidade e aplica a tarifa correspondente.
3. Pagamento: dependendo da configuração, a reserva pode ficar Pendente até confirmação via gateway.
4. Confirmação: reserva muda para Confirmada quando pagamento capturado ou a confirmação manual é feita.

2) Status e significado
- Pendente: aguardando ação (pagamento/webhook).
- Confirmada: reserva aceita e registrada.
- Cancelada: hóspede ou operador cancelou; pode haver política de reembolso.
- No-show: hóspede não compareceu.

3) Criar ou editar reserva manualmente (passo a passo)
1. VikBooking → Reservas → Nova Reserva.
2. Preencher dados do hóspede, datas, tipo/unidade, tarifa e status inicial.
3. Se necessário, registrar pagamento manualmente e anexar comprovante.
4. Salvar e enviar e-mail de confirmação ao hóspede.

4) Editando uma reserva existente
- Atenção: alterar datas ou unidade pode afetar a tarifa. Sempre recalcular preçário e comunicar o hóspede.
- Registrar histórico de alterações com notas (quem, quando e por que).

5) Overbooking — prevenção e resolução
- Prevenção: usar regras de disponibilidade e bloqueios, revisar integração com canais externos (OTAs) se houver.
- Resolução: quando houver conflito, priorizar reservas confirmadas (ou conforme política interna) e contatar hóspedes afetados oferecendo alternativas.

6) Logs, auditoria e relatórios de reservas
- Habilitar logs de ação administrativa (edições, cancelamentos, registro de pagamentos) e revisá-los em auditorias.

7) Troubleshooting comum
- Reserva sem pagamento registrado: verificar webhooks e logs do gateway.
- Não é possível editar data: checar restrições de tarifa (mínimo de noites) e disponibilidade do período.

8) Boas práticas operacionais
- Sempre comunicar o hóspede por e-mail quando alterar o status ou dados da reserva.
- Treinar operadores para registrar motivo de alterações e usar notas internas para rastreabilidade.
