---
title: Disponibilidade e Restrições
---

# Disponibilidade e Restrições
Este guia explica em detalhe como gerir a disponibilidade das unidades e aplicar restrições que evitem overbooking e conflitos com tarifas.

Mapa de navegação (painel)
- Disponibilidade: WordPress > VikBooking > Availability/Calendário
- Restrições: WordPress > VikBooking > Rules/Restrictions

1) Conceitos
- Bloqueio: marcar uma unidade como indisponível por manutenção ou evento.
- Stop-sell: impedir novas reservas em uma data/tipo específico.
- Restrições: mínimo/máximo de noites, dias de chegada permitidos, antecedência mínima.

2) Como bloquear datas (passo a passo)
1. VikBooking → Availability / Calendário: selecione unidade ou tipo de quarto.
2. Marque o intervalo de datas e escolha motivo (manutenção/fechado).
3. Salve e verifique no front-end se a disponibilidade refletiu corretamente.

3) Configurar stop-sell e restrições
1. VikBooking → Rules/Restrictions: crie regra de stop-sell por período e por tipo de quarto.
2. Defina mínimo/máximo de noites e dias de chegada/saída permitidos.
3. Priorize regras quando houver conflitos (documentar ordem de avaliação).

4) Antecedência e políticas especiais
- Antecedência mínima: útil para check-ins com logística (ex.: mínimo 1 dia antes).
- Regras de última hora: permitir reservas com antecedência curta com tarifa específica.

5) Verificações e testes
- Use casos de teste: reserva com datas limite, reserva cruzada em duas unidades do mesmo tipo, aplicação de stop-sell.
- Verifique alertas de overbooking e revise histórico quando identificados problemas.

6) Troubleshooting comum
- Disponibilidade mostra errado: verificar se há bloqueios em nível de unidade e em nível de tipo (um pode sobrepor o outro).
- Reserva permitida mesmo com stop-sell: checar cachê do plugin e reindexar disponibilidade ou limpar cache.

7) Boas práticas
- Mantenha um calendário público interno com eventos e manutenção planejada.
- Automatize bloqueios periódicos (feriados) usando regras recorrentes.
