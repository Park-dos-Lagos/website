---
title: Cupons e Descontos
---

# Cupons e Descontos
Este documento detalha como criar, testar e monitorar cupons e descontos no VikBooking.

1) Tipos de desconto
- Percentual (ex.: 10% off)
- Valor fixo (ex.: R$ 50 de desconto)
- Promoções condicionais (p.ex. desconto para estadias >= 3 noites)

2) Criando um cupom (passo a passo)
1. VikBooking → Coupons / Cupons: clique em "Novo Cupom".
2. Preencha código (ex.: PROMO10), tipo (percentual/valor), valor e período de validade.
3. Defina restrições: quantidade máxima de usos, restrição por tarifa, canal ou datas específicas.
4. Salve e teste aplicando em um fluxo de reserva em ambiente de testes.

3) Regras e compatibilidade
- Defina se o cupom é combinável com outras promoções.
- Priorize regras: em caso de conflito entre cupom e tarifa promocional, documente qual regra vence.

4) Monitoramento e métricas
- Acompanhe: número de usos, receita perdida por cupom, taxa de conversão com cupom.
- Relatórios: exportar por período para avaliar impacto.

5) Boas práticas
- Use códigos curtos e fáceis de comunicar.
- Limite usos por hóspede ou por resgate para evitar abuso.
- Registre origem do cupom (marketing, parceiro) para atribuição.

6) Troubleshooting
- Cupom não aplicado: checar datas, restrições por tarifa e canal.
- Usuário reclama de cupom inválido: confirmar se o código foi digitado corretamente (case-insensitive) e se já atingiu limite de usos.
