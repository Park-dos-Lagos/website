# VikBooking - Guia do Usuário

## Índice
1. [Introdução](#introdução)
2. [Instalação e Configuração Inicial](#instalação-e-configuração-inicial)
3. [Como Fazer uma Reserva](#como-fazer-uma-reserva)
4. [Tipos de Visualização (Shortcodes)](#tipos-de-visualização-shortcodes)
5. [Gerenciamento de Reservas](#gerenciamento-de-reservas)
6. [Pagamentos](#pagamentos)
7. [Recursos Especiais](#recursos-especiais)
8. [Perguntas Frequentes](#perguntas-frequentes)

## Introdução

O VikBooking é um plugin completo de reservas para WordPress, projetado especificamente para hotéis, pousadas, apartamentos, hostels e outras acomodações. Este sistema permite gerenciar reservas diretamente no seu site WordPress, oferecendo uma experiência profissional tanto para hóspedes quanto para administradores.

### Recursos Principais

- **Motor de Reservas Completo**: Sistema de reservas em tempo real
- **Gestão de Quartos**: Controle total sobre tipos de quartos e disponibilidade
- **Calendários de Disponibilidade**: Visualização clara da ocupação
- **Múltiplas Opções de Pagamento**: Integração com diversos gateways
- **Relatórios PMS**: Sistema completo de gestão hoteleira
- **8 Tipos de Shortcodes**: Diferentes visualizações para seu site
- **Multilíngue**: Suporte completo a múltiplos idiomas

## Instalação e Configuração Inicial

### Instalação via WordPress Admin

1. **Acesse o Admin do WordPress**
   - Faça login no painel administrativo (`/wp-admin`)

2. **Instale o Plugin**
   - Vá para `Plugins > Adicionar Novo`
   - Procure por "VikBooking"
   - Clique em "Instalar Agora"
   - Ative o plugin após a instalação

3. **Primeiro Acesso**
   - Um novo menu "VikBooking" aparecerá no painel lateral
   - Clique para acessar o dashboard do plugin

### Configuração Inicial Básica

1. **Configurações Gerais**
   - Acesse `VikBooking > Configurações`
   - Configure informações da empresa/hotel
   - Defina fuso horário e formato de data
   - Configure moeda e idioma padrão

2. **Criar Seu Primeiro Quarto**
   - Vá para `VikBooking > Quartos`
   - Clique em "Novo Quarto"
   - Preencha as informações básicas:
     - Nome do quarto
     - Descrição
     - Capacidade máxima
     - Preço base
   - Adicione fotos do quarto

3. **Configurar Página de Reservas**
   - Crie uma nova página no WordPress
   - Adicione o shortcode `[vikbooking view="roomslist"]`
   - Publique a página

## Como Fazer uma Reserva

### Para Hóspedes (Front-end)

1. **Buscar Disponibilidade**
   - Acesse a página de reservas do site
   - Selecione as datas de check-in e check-out
   - Escolha o número de hóspedes
   - Clique em "Buscar Disponibilidade"

2. **Escolher Quarto**
   - Visualize os quartos disponíveis
   - Compare preços e características
   - Clique em "Reservar" no quarto escolhido

3. **Preencher Dados**
   - Insira informações pessoais:
     - Nome completo
     - E-mail
     - Telefone
     - Documento de identidade
   - Adicione solicitações especiais (opcional)

4. **Finalizar Reserva**
   - Revise os detalhes da reserva
   - Escolha método de pagamento
   - Confirme a reserva

5. **Confirmação**
   - Receba confirmação por e-mail
   - Anote o código da reserva
   - Imprima o voucher (se necessário)

### Processo de Check-in

1. **Apresentação na Recepção**
   - Chegue no horário acordado
   - Apresente documento de identidade
   - Forneça código da reserva

2. **Documentação**
   - Preencha ficha de registro
   - Assine termos de hospedagem
   - Receba chaves/cartões de acesso

3. **Informações do Hotel**
   - Horários de funcionamento
   - Serviços disponíveis
   - Regras da propriedade

## Tipos de Visualização (Shortcodes)

O VikBooking oferece 8 diferentes shortcodes para personalizar a experiência de reserva:

### 1. Lista de Quartos (`roomslist`)
```
[vikbooking view="roomslist"]
```
- **Uso**: Página principal de quartos
- **Descrição**: Mostra todos os quartos disponíveis com fotos, descrições e preços
- **Funcionalidades**:
  - Filtros de busca
  - Comparação de quartos
  - Visualização em grade ou lista

### 2. Detalhes do Quarto (`roomdetails`)
```
[vikbooking view="roomdetails" roomid="1"]
```
- **Uso**: Página individual de cada quarto
- **Descrição**: Página detalhada com todas as informações do quarto
- **Funcionalidades**:
  - Galeria de fotos
  - Descrição completa
  - Amenidades
  - Calendário de disponibilidade
  - Formulário de reserva

### 3. Busca (`search`)
```
[vikbooking view="search"]
```
- **Uso**: Formulário de busca independente
- **Descrição**: Caixa de busca para pesquisar disponibilidade
- **Funcionalidades**:
  - Seletor de datas
  - Número de hóspedes
  - Filtros avançados

### 4. Disponibilidade (`availability`)
```
[vikbooking view="availability"]
```
- **Uso**: Calendário de disponibilidade
- **Descrição**: Mostra disponibilidade de todos os quartos em formato de calendário
- **Funcionalidades**:
  - Visualização mensal
  - Cores indicativas de ocupação
  - Links diretos para reserva

### 5. Promoções (`promotions`)
```
[vikbooking view="promotions"]
```
- **Uso**: Página de ofertas especiais
- **Descrição**: Exibe promoções e pacotes especiais
- **Funcionalidades**:
  - Ofertas por temporada
  - Descontos especiais
  - Pacotes promocionais

### 6. Lista de Pacotes (`packageslist`)
```
[vikbooking view="packageslist"]
```
- **Uso**: Pacotes de serviços
- **Descrição**: Mostra pacotes especiais disponíveis
- **Funcionalidades**:
  - Pacotes temáticos
  - Serviços inclusos
  - Preços especiais

### 7. Confirmação de Reserva (`booking`)
```
[vikbooking view="booking" sid="CODIGO_RESERVA"]
```
- **Uso**: Página de confirmação
- **Descrição**: Exibe detalhes da reserva confirmada
- **Funcionalidades**:
  - Detalhes completos da reserva
  - Status de pagamento
  - Informações de contato
  - Opções de cancelamento

### 8. Histórico de Reservas (`orderslist`)
```
[vikbooking view="orderslist"]
```
- **Uso**: Área do cliente (requer login)
- **Descrição**: Lista reservas do cliente logado
- **Funcionalidades**:
  - Histórico completo
  - Status das reservas
  - Opções de modificação

## Gerenciamento de Reservas

### Para Clientes Registrados

1. **Criar Conta**
   - Registre-se durante a primeira reserva
   - Use e-mail como nome de usuário
   - Crie senha segura

2. **Área do Cliente**
   - Acesse via login no site
   - Visualize todas suas reservas
   - Modifique dados pessoais

3. **Gerenciar Reservas**
   - **Visualizar**: Detalhes completos da reserva
   - **Modificar**: Alterar datas (quando permitido)
   - **Cancelar**: Cancelar reserva (sujeito a políticas)
   - **Imprimir**: Voucher de confirmação

### Status das Reservas

- **Pendente**: Aguardando confirmação/pagamento
- **Confirmada**: Reserva confirmada e paga
- **Check-in**: Hóspede já fez check-in
- **Check-out**: Estadia finalizada
- **Cancelada**: Reserva cancelada

## Pagamentos

### Métodos de Pagamento Disponíveis

1. **Cartão de Crédito/Débito**
   - Visa, Mastercard, American Express
   - Processamento seguro online
   - Cobrança imediata ou na chegada

2. **PIX** (se configurado)
   - Pagamento instantâneo
   - Via QR Code ou chave PIX
   - Confirmação automática

3. **PayPal**
   - Conta PayPal existente
   - Cartões via PayPal
   - Proteção do comprador

4. **Transferência Bancária**
   - Pagamento manual
   - Confirmação após compensação
   - Dados bancários fornecidos

5. **Pagamento na Chegada**
   - Dinheiro ou cartão na recepção
   - Reserva garantida com cartão
   - Política de cancelamento específica

### Política de Pagamento

- **Reserva**: Pode exigir pré-pagamento ou garantia
- **Cancelamento**: Varia conforme tarifa escolhida
- **Reembolso**: Processado conforme política da propriedade
- **Moeda**: Preços exibidos na moeda configurada

## Recursos Especiais

### Tarifas Especiais

1. **Tarifa Flexível**
   - Cancelamento gratuito até 24h antes
   - Modificação permitida
   - Preço ligeiramente maior

2. **Tarifa Não Reembolsável**
   - Preço mais baixo
   - Sem cancelamento gratuito
   - Sem modificações

3. **Tarifa Refundável**
   - Reembolso total até prazo determinado
   - Taxas de modificação aplicáveis
   - Preço padrão

### Serviços Adicionais

- **Early Check-in**: Check-in antecipado (taxas aplicáveis)
- **Late Check-out**: Check-out tardio (sujeito à disponibilidade)
- **Quartos Comunicantes**: Para famílias ou grupos
- **Berço**: Para bebês (sob solicitação)
- **Café da Manhã**: Incluso ou adicional
- **Transfer**: Serviço de transporte (quando disponível)

### Acessibilidade

- **Quartos Acessíveis**: Para pessoas com mobilidade reduzida
- **Equipamentos Especiais**: Conforme necessidades
- **Localização**: Acesso facilitado
- **Banheiros Adaptados**: Barras de apoio e espaço ampliado

## Perguntas Frequentes

### Reservas

**P: Posso modificar minha reserva após a confirmação?**
R: Depende da tarifa escolhida. Tarifas flexíveis permitem modificações, enquanto tarifas não reembolsáveis não permitem alterações.

**P: Como cancelo minha reserva?**
R: Acesse sua área do cliente ou entre em contato diretamente com a propriedade. Observe as políticas de cancelamento da tarifa escolhida.

**P: Não recebi o e-mail de confirmação. O que fazer?**
R: Verifique sua pasta de spam. Se não encontrar, entre em contato com a propriedade fornecendo seus dados da reserva.

**P: Posso fazer reserva para terceiros?**
R: Sim, mas você será responsável pela reserva. Informe os dados corretos do hóspede principal.

### Pagamentos

**P: Quando serei cobrado?**
R: Depende da configuração da propriedade. Pode ser no momento da reserva, alguns dias antes da chegada, ou no check-in.

**P: O que fazer se o pagamento não foi processado?**
R: Verifique os dados do cartão e tente novamente. Se persistir, entre em contato com a propriedade para pagamento alternativo.

**P: Posso dividir o pagamento?**
R: Isso depende da política da propriedade. Entre em contato para verificar opções disponíveis.

### Check-in/Check-out

**P: Qual o horário de check-in?**
R: Geralmente 14:00, mas pode variar. Verifique as informações específicas da propriedade.

**P: Posso chegar mais cedo?**
R: Early check-in pode estar disponível mediante disponibilidade e taxa adicional.

**P: E se eu chegar após o horário da recepção?**
R: Entre em contato previamente para arranjar check-in tardio ou instruções de acesso.

### Problemas Técnicos

**P: O site não está carregando as datas disponíveis.**
R: Limpe o cache do navegador, verifique sua conexão com a internet e tente novamente.

**P: Não consigo finalizar a reserva.**
R: Verifique se todos os campos obrigatórios estão preenchidos corretamente e se o método de pagamento está funcionando.

**P: Como atualizar meus dados pessoais?**
R: Acesse sua área do cliente para atualizar informações pessoais e preferências.

---

## Suporte Técnico

Para suporte adicional, entre em contato:
- **E-mail**: [email da propriedade]
- **Telefone**: [telefone da propriedade]
- **WhatsApp**: [se disponível]
- **Chat Online**: [se disponível no site]

---

*Última atualização: Março 2025*
*Versão do Plugin: VikBooking 1.7.8*