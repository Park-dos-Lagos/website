# VikBooking - Guia Rápido

## Índice
1. [Instalação Rápida](#instalação-rápida)
2. [Configuração Essencial](#configuração-essencial)
3. [Tarefas Comuns - Usuário](#tarefas-comuns---usuário)
4. [Tarefas Comuns - Admin](#tarefas-comuns---admin)
5. [Shortcodes Principais](#shortcodes-principais)
6. [Troubleshooting](#troubleshooting)
7. [FAQ - Perguntas Frequentes](#faq---perguntas-frequentes)

## Instalação Rápida

### 1. Instalar Plugin (5 minutos)

```bash
# Via WordPress Admin
1. Plugins > Adicionar Novo
2. Buscar "VikBooking"
3. Instalar e Ativar
4. Acessar VikBooking no menu lateral
```

### 2. Configuração Mínima (10 minutos)

```php
// Configurações obrigatórias
VikBooking > Configurações:
- Nome da empresa
- E-mail de contato
- Fuso horário
- Moeda (BRL)
- Horários check-in/check-out
```

### 3. Primeiro Quarto (5 minutos)

```php
VikBooking > Quartos > Novo:
- Nome: "Quarto Standard"
- Capacidade: 2 adultos
- Preço: R$ 150/noite
- Upload de foto
- Salvar
```

### 4. Página de Reservas (2 minutos)

```php
// Criar nova página WordPress
Título: "Nossos Quartos"
Conteúdo: [vikbooking view="roomslist"]
Publicar
```

## Configuração Essencial

### Configurações Básicas
| Item | Localização | Valor Recomendado |
|------|-------------|-------------------|
| Check-in | Configurações > Aba 2 | 14:00 |
| Check-out | Configurações > Aba 2 | 12:00 |
| Antecedência mínima | Configurações > Aba 2 | 1 dia |
| Moeda | Configurações > Aba 1 | BRL |
| Fuso horário | Configurações > Aba 1 | America/Sao_Paulo |

### Páginas Obrigatórias
```php
1. Lista de Quartos:    [vikbooking view="roomslist"]
2. Busca:              [vikbooking view="search"]
3. Confirmação:        [vikbooking view="booking"]
4. Área do Cliente:    [vikbooking view="orderslist"]
```

### Gateway de Pagamento
```php
VikBooking > Configurações > Pagamentos:
1. Ativar PayPal
2. Configurar e-mail PayPal Business
3. Testar em modo Sandbox
4. Ativar modo Produção
```

## Tarefas Comuns - Usuário

### Como Fazer uma Reserva
1. **Acessar site** → Página de quartos
2. **Buscar** → Selecionar datas e hóspedes
3. **Escolher** → Quarto disponível
4. **Preencher** → Dados pessoais
5. **Pagar** → Escolher método de pagamento
6. **Confirmar** → Receber e-mail de confirmação

### Como Cancelar Reserva
```php
Opção 1: Via área do cliente
- Login no site
- Minhas Reservas
- Cancelar (se permitido)

Opção 2: Por e-mail/telefone
- Entrar em contato com a propriedade
- Fornecer código da reserva
- Solicitar cancelamento
```

### Como Modificar Reserva
```php
// Se tarifa permite modificação:
1. Área do cliente > Minhas Reservas
2. Editar > Alterar datas
3. Confirmar disponibilidade
4. Pagar diferença (se houver)

// Se tarifa não permite:
- Contatar propriedade diretamente
- Verificar política de cancelamento
- Fazer nova reserva se necessário
```

## Tarefas Comuns - Admin

### Gerenciar Reservas Diárias

#### Check-ins do Dia
```php
VikBooking > Reservas:
1. Filtrar por data de chegada = hoje
2. Status = "Confirmada"
3. Ações: Marcar como "Check-in"
```

#### Check-outs do Dia
```php
VikBooking > Reservas:
1. Filtrar por data de partida = hoje
2. Status = "Check-in"
3. Ações: Marcar como "Check-out"
```

### Bloquear Quartos
```php
VikBooking > Calendário:
1. Selecionar quarto
2. Selecionar período
3. Marcar como "Bloqueado"
4. Motivo: Manutenção/Limpeza
```

### Alterar Preços Rapidamente
```php
VikBooking > Tarifas > Calendário:
1. Clique na data desejada
2. Digite novo preço
3. Enter para salvar
4. Aplicar em massa (opcional)
```

### Criar Reserva Manual
```php
VikBooking > Reservas > Nova:
1. Selecionar datas
2. Escolher quarto disponível
3. Preencher dados do cliente
4. Definir método de pagamento
5. Salvar reserva
```

### Relatórios Rápidos
```php
VikBooking > Relatórios:
- Ocupação do mês: Ocupação > Este mês
- Receita do mês: Financeiro > Este mês  
- Top clientes: Clientes > Ordenar por valor
- Chegadas hoje: Operacional > Chegadas
```

## Shortcodes Principais

### Lista Completa de Shortcodes
```php
// Lista de quartos
[vikbooking view="roomslist"]
[vikbooking view="roomslist" order="price" perpage="6"]

// Busca de quartos  
[vikbooking view="search"]
[vikbooking view="search" checkin="today+1" checkout="today+2"]

// Detalhes do quarto
[vikbooking view="roomdetails" roomid="1"]
[vikbooking view="roomdetails" roomid="1" layout="classic"]

// Disponibilidade
[vikbooking view="availability"]
[vikbooking view="availability" months="2"]

// Promoções
[vikbooking view="promotions"]

// Pacotes
[vikbooking view="packageslist"]

// Confirmação de reserva
[vikbooking view="booking" sid="CODIGO_RESERVA"]

// Área do cliente
[vikbooking view="orderslist"]
```

### Parâmetros Avançados
```php
// Lista de quartos com filtros
[vikbooking view="roomslist" 
    order="price"           // Ordenação: name, price, capacity
    orderdir="ASC"          // Direção: ASC, DESC  
    perpage="6"             // Quartos por página
    layout="grid"           // Layout: grid, list, carousel
    filter_amenities="1"    // Mostrar filtro de amenidades
    filter_price="1"        // Mostrar filtro de preço
    showpagination="1"]     // Mostrar paginação

// Busca com valores pré-definidos
[vikbooking view="search"
    checkin="today+1"       // Data check-in padrão
    checkout="today+2"      // Data check-out padrão
    adults="2"              // Adultos padrão
    children="0"            // Crianças padrão
    submit_ajax="1"]        // Submit via AJAX

// Detalhes com customizações
[vikbooking view="roomdetails"
    roomid="1"              // ID do quarto
    layout="classic"        // Layout: classic, modern, minimal
    showcalendar="1"        // Mostrar calendário
    showgallery="1"         // Mostrar galeria
    showamenities="1"]      // Mostrar amenidades
```

## Troubleshooting

### Problemas Comuns e Soluções

#### 🚫 Reservas não aparecem no site
```php
Verificações:
✓ Shortcode correto na página
✓ Quarto tem unidades disponíveis  
✓ Preços configurados
✓ Status do quarto = publicado
✓ Cache do site limpo
```

#### 💳 Pagamentos falham
```php
Verificações:
✓ SSL ativo (https://)
✓ Configurações do PayPal corretas
✓ URLs de retorno acessíveis
✓ Modo Sandbox desativado (produção)
✓ E-mail PayPal Business válido
```

#### 📧 E-mails não são enviados
```php
Verificações:
✓ Configurações de e-mail no WordPress
✓ Plugin de SMTP configurado
✓ Templates de e-mail ativos
✓ E-mail remetente válido
✓ Verificar pasta spam
```

#### 🐌 Site lento
```php
Otimizações:
✓ Ativar plugin de cache
✓ Otimizar imagens dos quartos
✓ Limpar logs antigos do plugin
✓ Verificar conflitos com outros plugins
✓ Aumentar limites de memória PHP
```

#### 📱 Problemas no mobile
```php
Verificações:
✓ Tema responsivo
✓ CSS customizado compatível
✓ JavaScript não conflitante
✓ Tamanho das imagens adequado
✓ Formulários otimizados para mobile
```

### Logs de Debug

#### Ativar Debug WordPress
```php
// wp-config.php
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);
```

#### Debug VikBooking
```php
// Adicionar na URL
?debug=on

// Localização dos logs
/wp-content/debug.log
/wp-content/uploads/vikbooking/logs/
```

#### Verificar Logs
```bash
# Via FTP/cPanel
tail -f /wp-content/debug.log

# Buscar erros específicos  
grep "vikbooking" /wp-content/debug.log
grep "Fatal error" /wp-content/debug.log
```

## FAQ - Perguntas Frequentes

### 🏨 Gestão Hoteleira

**P: Posso gerenciar múltiplas propriedades?**
R: O VikBooking é projetado para propriedades únicas. Para múltiplas propriedades, você precisa de instalações separadas do WordPress.

**P: Como configurar quartos com preços diferentes por temporada?**
R: Use VikBooking > Temporadas para criar períodos com multiplicadores de preço (ex: alta temporada = 1.5x o preço base).

**P: É possível integrar com OTAs como Booking.com?**
R: Sim, mas requer a versão Pro + Vik Channel Manager (E4jConnect) para integração real via API.

**P: Como criar tarifas flexíveis vs não reembolsáveis?**
R: VikBooking > Tarifas > Criar diferentes planos com políticas de cancelamento distintas.

### 💰 Pagamentos e Preços

**P: Quais gateways de pagamento estão incluídos na versão gratuita?**
R: PayPal, Transferência Bancária e Pagamento na Chegada. A versão Pro inclui 60+ gateways.

**P: Como configurar PIX como método de pagamento?**
R: Requer gateway específico para PIX ou usar campo de transferência bancária com instruções PIX.

**P: Posso cobrar taxa de limpeza separadamente?**
R: Sim, configure em VikBooking > Opcionais ou adicione no preço base do quarto.

**P: Como aplicar descontos automáticos?**
R: Use VikBooking > Cupons para criar códigos de desconto ou configurar descontos por estadia longa.

### 🔧 Técnicas e Customização

**P: Como personalizar a aparência dos formulários?**
R: Via CSS customizado no tema ou criando overrides de template na pasta `/vikbooking/` do tema.

**P: É possível adicionar campos personalizados no formulário de reserva?**
R: Sim, via hooks do WordPress ou modificando templates. A versão Pro oferece campos customizados nativos.

**P: Como criar uma página de disponibilidade em tempo real?**
R: Use o shortcode `[vikbooking view="availability"]` que exibe calendário com disponibilidade atual.

**P: Posso integrar com meu sistema de CRM?**
R: Sim, usando hooks do plugin para enviar dados via API ou webhook após cada reserva.

### 📊 Relatórios e Analytics

**P: Quais relatórios estão disponíveis?**
R: Ocupação, receita, chegadas/partidas, clientes frequentes, e relatórios PMS para órgãos governamentais.

**P: Como exportar dados de reservas?**
R: VikBooking > Reservas > Exportar ou VikBooking > Relatórios > escolher formato (PDF, Excel, CSV).

**P: É possível acompanhar origem das reservas?**
R: Sim, o plugin rastreia automaticamente canal de origem (site, manual, OTA quando integrado).

### 🌐 Multi-idioma e Internacional

**P: Como configurar o site em múltiplos idiomas?**
R: Use plugin de tradução como WPML ou Polylang. O VikBooking tem suporte nativo a traduções.

**P: Posso usar múltiplas moedas?**
R: A versão gratuita suporta uma moeda. Para múltiplas moedas, considere plugins de conversão ou versão Pro.

**P: Como configurar formatos de data específicos do Brasil?**
R: VikBooking > Configurações > Formato de data > dd/mm/yyyy e fuso horário America/Sao_Paulo.

### 🔒 Segurança e Backup

**P: O plugin é seguro para processar pagamentos?**
R: Sim, é compatível com PCI-DSS. Pagamentos são processados pelos gateways (PayPal, etc.), não armazenados localmente.

**P: Como fazer backup das configurações?**
R: Use plugins de backup do WordPress ou exporte dados via VikBooking > Configurações > Backup.

**P: É possível recuperar reservas deletadas?**
R: Apenas via backup do banco de dados. Recomenda-se backup automático diário.

### 📞 Suporte e Atualizações

**P: Como obter suporte técnico?**
R: Versão gratuita: fóruns da comunidade. Versão Pro: suporte oficial via tickets.

**P: Com que frequência o plugin é atualizado?**
R: Atualizações mensais com correções e melhorias. Atualizações de segurança conforme necessário.

**P: É seguro atualizar para versões mais recentes?**
R: Sim, mas sempre faça backup antes. Teste em ambiente de desenvolvimento quando possível.

### 🎯 Casos de Uso Específicos

**P: Funciona para pousadas pequenas (5-10 quartos)?**
R: Perfeitamente. O plugin é otimizado para pequenas e médias propriedades.

**P: Posso usar para aluguel de temporada (Airbnb style)?**
R: Sim, especialmente eficaz para apartamentos, casas e vilas de aluguel por temporada.

**P: É adequado para hostels com camas compartilhadas?**
R: Sim, configure cada cama como uma "unidade" do tipo de quarto "Dormitório".

**P: Funciona para propriedades que alugam por horas?**
R: O sistema é baseado em pernoites. Para locação por horas, seria necessária customização.

---

## 🚀 Próximos Passos

### Para Novos Usuários
1. ✅ Instalar e configurar básico
2. ✅ Criar primeiro quarto  
3. ✅ Configurar páginas essenciais
4. ✅ Testar processo de reserva
5. ⏭️ Configurar gateway de pagamento
6. ⏭️ Personalizar aparência
7. ⏭️ Configurar relatórios

### Para Usuários Avançados
1. ⏭️ Explorar versão Pro
2. ⏭️ Integrar Channel Manager
3. ⏭️ Customizar templates
4. ⏭️ Desenvolver integrações
5. ⏭️ Otimizar performance
6. ⏭️ Configurar automações

### Recursos de Aprendizado
- 📖 [Documentação Completa](README_ADMIN.md)
- 👨‍💻 [Guia do Desenvolvedor](README_DEVELOPER.md)
- 🎥 [Tutoriais em Vídeo](https://youtube.com/vikwp)
- 💬 [Comunidade](https://vikwp.com/forum)

---

## 📞 Contatos e Suporte

### Suporte Oficial
- **Website**: [vikwp.com](https://vikwp.com)
- **Documentação**: [vikwp.com/docs](https://vikwp.com/docs)
- **Fórum**: [vikwp.com/forum](https://vikwp.com/forum)

### Comunidade Brasileira
- **Grupo WhatsApp**: [Link do grupo]
- **Facebook**: [Página no Facebook]
- **Telegram**: [Canal no Telegram]

### Suporte Comercial (Pro)
- **E-mail**: support@vikwp.com
- **Tickets**: Via painel do cliente
- **Telefone**: Disponível para clientes Pro

---

*Guia atualizado para VikBooking 1.7.8 - Março 2025*