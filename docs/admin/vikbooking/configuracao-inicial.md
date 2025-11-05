---
title: Configuração Inicial do VikBooking
---

# Configuração Inicial do VikBooking
Este documento descreve, passo a passo, as configurações iniciais recomendadas ao ativar o VikBooking em um site WordPress.

Mapa de navegação (painel)
- Configurações gerais: WordPress > VikBooking > Settings/Configurações
- Tipos de quarto: WordPress > VikBooking > Room Types
- Unidades: WordPress > VikBooking > Rooms
- Tarifas: WordPress > VikBooking > Rates/Price Plans
- Pagamentos: WordPress > VikBooking > Payments/Pagamentos
- E-mails: WordPress > VikBooking > Emails/Templates
- Páginas/Shortcodes: WordPress > Páginas | Aparência > Widgets

1) Pré-requisitos
- Acesso administrador ao WordPress.
- Backup antes de começar (veja `backup-e-manutencao.md`).

2) Configurações gerais (passo a passo)
1. Acesse VikBooking → Settings / Configurações.
2. Defina moeda (ex.: BRL), símbolo, casas decimais e fuso horário. Salve.
3. Ajuste formato de data (dd/mm/aaaa) para consistência com o público.
4. Configure políticas globais: horas de check-in/check-out, política padrão de cancelamento e comportamento de overbooking.

Verificação: abra uma busca no front-end e confirme que as datas e valores aparecem corretamente.

3) Tipos de quarto e unidades
1. VikBooking → Room Types: clique em "Adicionar Novo Tipo".
2. Campos importantes: nome (padronizar p.ex. "Superior Casal"), capacidade (adultos/crianças), descrição curta e longa, amenidades (ex.: ar-condicionado, café da manhã), políticas de cancelamento específicas (se aplicável).
3. Salve o tipo.
4. VikBooking → Rooms: clique em "Adicionar Unidade". Vincule a unidade ao tipo criado, preencha identificador (nº da unidade), status (disponível/manutenção) e faça upload de fotos (padrão 1200x800 px).

Boas práticas: mantenha nomes consistentes e inclua uma foto principal e 3-5 fotos adicionais com boa iluminação.

4) Tarifas e planos (passo a passo)
1. VikBooking → Rates / Price Plans: clique em "Novo Plano".
2. Defina: nome da tarifa, período (datas válidas), preço por noite, regras por ocupação (ex.: preço para casal, adicional por pessoa extra), política de cancelamento.
3. Configure restrições: mínimo de noites, dias de chegada permitidos.
4. Salve e teste criando uma pesquisa que caia dentro do período da tarifa.

Exemplo: tarifa "Fim de Semana" — Válida: sex-dom, preço R$ 350/noite, mínimo 2 noites.

5) Métodos de pagamento
1. VikBooking → Payments / Pagamentos: escolha um gateway (PayPal, Stripe, ou módulos específicos).
2. Insira credenciais em modo teste (sandbox). Habilite modo teste se disponível.
3. Configure webhooks no painel do gateway para apontar para a URL fornecida pelo plugin (verifique documentação do gateway).
4. Realize um teste completo de reserva (sandbox) e valide os estados de pagamento.

6) Páginas e shortcodes
1. Crie páginas no WordPress: Busca, Resultados, Checkout, Confirmação.
2. Insira os shortcodes correspondentes (ex.: `[vikbooking_search]`, `[vikbooking_rooms]`, `[vikbooking_checkout]`).
3. Defina estas páginas nas configurações do VikBooking (mapeamento de páginas).

7) E-mails e documentos
1. VikBooking → E-mails: edite os templates (confirmação, cancelamento, lembrete). Use as variáveis disponíveis (nome do hóspede, datas, código de reserva).
2. Configure remetente e teste envio (usar conta de teste SMTP se necessário).
3. Ative faturas/recibos nas configurações de faturamento se for emitir documentos fiscais.

8) Validação final antes de entrar em produção
- Teste 3 fluxos: reserva completa (pagamento com cartão sandbox), reserva manual (admin) e alteração de reserva.
- Verifique e-mails transacionais, geração de fatura e logs de webhook.

Anexos úteis
- Checklist rápido: backup → configurar moeda → tipos e unidades → tarifas → gateways → páginas → testar.
