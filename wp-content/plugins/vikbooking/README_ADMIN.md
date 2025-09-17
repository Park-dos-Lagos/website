# VikBooking - Guia do Administrador

## Índice
1. [Visão Geral do Plugin](#visão-geral-do-plugin)
2. [Dashboard e Configuração Inicial](#dashboard-e-configuração-inicial)
3. [Gerenciamento de Quartos](#gerenciamento-de-quartos)
4. [Sistema de Reservas](#sistema-de-reservas)
5. [Calendários e Disponibilidade](#calendários-e-disponibilidade)
6. [Preços e Tarifas](#preços-e-tarifas)
7. [Gateways de Pagamento](#gateways-de-pagamento)
8. [Clientes e Relatórios](#clientes-e-relatórios)
9. [Shortcodes e Páginas](#shortcodes-e-páginas)
10. [Permissões e ACL](#permissões-e-acl)
11. [Configurações Avançadas](#configurações-avançadas)
12. [Customização e Hooks](#customização-e-hooks)
13. [Manutenção e Backup](#manutenção-e-backup)

## Visão Geral do Plugin

O VikBooking é um sistema completo de gestão hoteleira (PMS) e motor de reservas para WordPress. Desenvolvido especificamente para propriedades individuais como hotéis, pousadas, apartamentos e hostels.

### Características Principais

- **PMS Completo**: Sistema de gestão de propriedade
- **Motor de Reservas**: Booking engine integrado
- **Channel Manager Ready**: Compatível com E4jConnect
- **Multi-idioma**: Suporte nativo a tradução
- **Responsivo**: Interface adaptável a dispositivos móveis
- **Extensível**: Sistema de hooks e filtros
- **Compliance**: PCI-DSS e OpenTravel compatível

### Arquitetura do Plugin

```
vikbooking/
├── admin/          # Interface administrativa
├── site/           # Interface pública
├── libraries/      # Bibliotecas e frameworks
├── languages/      # Arquivos de tradução
├── sql/           # Scripts de banco de dados
└── modules/       # Módulos e widgets
```

## Dashboard e Configuração Inicial

### Acessando o Dashboard

1. **Login no WordPress Admin**
   - Acesse `/wp-admin`
   - Menu lateral: `VikBooking`

2. **Dashboard Principal**
   - Visão geral das estatísticas
   - Widgets configuráveis
   - Métricas de desempenho
   - Reservas recentes

### Primeira Configuração

#### 1. Configurações Básicas (`VikBooking > Configurações`)

**Aba 1 - Configurações Gerais:**
```php
// Configurações essenciais
- Nome da Empresa/Hotel
- Endereço completo
- Telefone e e-mail
- Website oficial
- Fuso horário
- Formato de data
- Moeda padrão
```

**Aba 2 - Configurações de Reserva:**
```php
// Parâmetros de reserva
- Horário check-in/check-out
- Tempo mínimo de antecedência
- Máximo de dias para reserva futura
- Número máximo de quartos por reserva
- Política de cancelamento padrão
```

**Aba 3 - Configurações de E-mail:**
```php
// Sistema de notificações
- E-mail remetente
- Template de confirmação
- Template de cancelamento
- Notificações automáticas
- Configurações SMTP (se necessário)
```

**Aba 4 - Configurações da Empresa:**
```php
// Informações legais
- Razão social
- CNPJ/CPF
- Inscrição estadual
- Logo da empresa
- Informações de contato
```

#### 2. Configuração de Páginas

**Criação de Páginas Essenciais:**

1. **Página de Quartos** (`/quartos/`)
   ```
   [vikbooking view="roomslist"]
   ```

2. **Página de Reservas** (`/reservar/`)
   ```
   [vikbooking view="search"]
   ```

3. **Página de Confirmação** (`/confirmacao/`)
   ```
   [vikbooking view="booking"]
   ```

4. **Área do Cliente** (`/minha-conta/`)
   ```
   [vikbooking view="orderslist"]
   ```

## Gerenciamento de Quartos

### Criando e Configurando Quartos

#### 1. Adicionar Novo Quarto (`VikBooking > Quartos > Novo`)

**Informações Básicas:**
```php
// Dados fundamentais
- Nome do quarto
- Descrição completa
- Descrição curta
- Capacidade máxima (adultos + crianças)
- Metros quadrados
- Número de camas
- Tipo de camas
```

**Configurações Avançadas:**
```php
// Parâmetros específicos
- Preço base por noite
- Unidades disponíveis (número de quartos do mesmo tipo)
- Taxa de limpeza
- Depósito caução
- Política específica de cancelamento
```

#### 2. Gestão de Fotos

**Upload de Imagens:**
- Foto principal (thumbnail)
- Galeria de fotos (múltiplas imagens)
- Dimensões recomendadas: 1200x800px
- Formatos suportados: JPG, PNG, WebP
- Otimização automática de imagens

**Organização de Fotos:**
- Ordem de exibição
- Legendas descritivas
- Alt text para SEO
- Compressão automática

#### 3. Amenidades e Características

**Configuração de Amenidades:**
- Ar condicionado
- Wi-Fi gratuito
- TV a cabo/streaming
- Frigobar
- Cofre
- Varanda/Vista
- Banheiro privativo
- Amenidades customizadas

### Tipos de Quartos vs Unidades

**Tipo de Quarto:**
- Categoria geral (ex: Standard, Deluxe, Suíte)
- Características compartilhadas
- Preços base similares

**Unidades:**
- Quartos físicos individuais
- Podem ter números específicos
- Características únicas (vista, andar, etc.)

## Sistema de Reservas

### Gerenciamento de Reservas (`VikBooking > Reservas`)

#### 1. Lista de Reservas

**Filtros Disponíveis:**
```php
// Opções de filtro
- Status (Pendente, Confirmada, Check-in, Check-out, Cancelada)
- Data de chegada/partida
- Cliente (nome ou e-mail)
- Quarto reservado
- Canal de reserva (Website, OTA, Manual)
- Valor da reserva
```

**Ações em Massa:**
- Confirmar múltiplas reservas
- Cancelar selecionadas
- Exportar dados
- Enviar e-mails em lote
- Atualizar status

#### 2. Detalhes da Reserva

**Informações Completas:**
```php
// Dados da reserva
- Código único da reserva
- Datas de estadia
- Número de hóspedes (adultos/crianças)
- Quarto(s) reservado(s)
- Valor total e detalhamento
- Status de pagamento
- Observações especiais
```

**Dados do Cliente:**
```php
// Informações pessoais
- Nome completo
- Documento (CPF/RG/Passaporte)
- E-mail e telefone
- Endereço completo
- Data de nascimento
- Nacionalidade
```

#### 3. Criando Reserva Manual

**Processo Passo a Passo:**

1. **Selecionar Datas**
   - Check-in e check-out
   - Verificar disponibilidade
   - Escolher quarto

2. **Dados do Cliente**
   - Informações pessoais
   - Dados de contato
   - Documentos

3. **Configurar Reserva**
   - Adicionar serviços extras
   - Aplicar descontos
   - Definir método de pagamento
   - Observações especiais

4. **Finalizar**
   - Revisar dados
   - Confirmar reserva
   - Enviar confirmação

### Status de Reservas

**Fluxo de Estados:**
```
Pendente → Confirmada → Check-in → Check-out
     ↓
  Cancelada
```

**Descrição de Status:**

- **Pendente**: Aguardando pagamento ou confirmação manual
- **Confirmada**: Reserva paga e confirmada
- **Check-in**: Hóspede realizou check-in
- **Check-out**: Estadia finalizada
- **Cancelada**: Reserva cancelada (manual ou automática)

### Check-in e Check-out

#### Processo de Check-in

1. **Localizar Reserva**
   - Por código da reserva
   - Por nome do cliente
   - Por documento

2. **Verificar Dados**
   - Confirmar identidade
   - Validar documentos
   - Verificar acompanhantes

3. **Finalizar Check-in**
   - Marcar como "Check-in"
   - Registrar horário
   - Gerar documentos necessários
   - Ativar acesso ao quarto

#### Processo de Check-out

1. **Verificar Consumos**
   - Frigobar
   - Serviços extras
   - Danos (se houver)

2. **Calcular Conta Final**
   - Valor base da hospedagem
   - Serviços adicionais
   - Taxas aplicáveis
   - Descontos/créditos

3. **Finalizar Checkout**
   - Processar pagamentos pendentes
   - Marcar como "Check-out"
   - Liberar quarto para limpeza
   - Enviar pesquisa de satisfação

## Calendários e Disponibilidade

### Calendário Principal (`VikBooking > Calendário`)

#### 1. Visão Geral

**Tipos de Visualização:**
- **Mensal**: Visão geral do mês
- **Semanal**: Detalhes da semana
- **Diária**: Agenda detalhada do dia
- **Ocupação**: Percentual de ocupação

**Código de Cores:**
```css
/* Legenda padrão */
.disponivel { background: #green; }      /* Disponível */
.ocupado { background: #red; }           /* Ocupado */
.check-in { background: #blue; }         /* Chegadas */
.check-out { background: #orange; }      /* Partidas */
.bloqueado { background: #gray; }        /* Bloqueado */
.limpeza { background: #yellow; }        /* Limpeza */
```

#### 2. Gestão de Disponibilidade

**Bloquear Datas:**
- Selecionar quarto e período
- Motivo do bloqueio (manutenção, limpeza, etc.)
- Anotações internas
- Bloqueio automático por regras

**Liberar Datas:**
- Remover bloqueios
- Ajustar disponibilidade
- Configurar restrições temporárias

#### 3. Tableaux (Quadro de Ocupação)

**Funcionalidades:**
```php
// Recursos avançados
- Drag & drop de reservas
- Código de cores customizável
- Filtros por tipo de quarto
- Notas e observações
- Impressão do quadro
- Exportação de dados
```

### Calendário de Tarifas (`VikBooking > Tarifas > Calendário`)

#### 1. Gestão de Preços

**Alteração Rápida:**
- Clique simples para editar preço
- Aplicação em massa
- Cópia de tarifas
- Percentuais de ajuste

**Temporadas:**
- Alta temporada
- Baixa temporada
- Feriados especiais
- Eventos locais

#### 2. Restrições de Reserva

**Configurações:**
```php
// Tipos de restrição
- Estadia mínima (Min LOS)
- Estadia máxima (Max LOS)
- Chegada obrigatória (CTA)
- Partida obrigatória (CTD)
- Fechamento de vendas
```

## Preços e Tarifas

### Sistema de Tarifas (`VikBooking > Tarifas`)

#### 1. Planos de Tarifa

**Tipos Básicos:**
```php
// Categorias principais
1. Standard (tarifa padrão)
2. Flexível (cancelamento gratuito)
3. Não reembolsável (preço menor)
4. Promoção (ofertas especiais)
5. Last minute (reservas de última hora)
```

**Configuração de Planos:**
- Nome descritivo
- Descrição das condições
- Percentual de desconto/acréscimo
- Regras de cancelamento
- Período de validade

#### 2. Sazonalidade

**Criando Temporadas:**

1. **Alta Temporada**
   ```php
   - Período: Dezembro - Março
   - Multiplicador: 1.5x (50% de aumento)
   - Estadia mínima: 3 noites
   - Chegada restrita: sexta a domingo
   ```

2. **Baixa Temporada**
   ```php
   - Período: Abril - Novembro
   - Multiplicador: 0.8x (20% de desconto)
   - Estadia mínima: 1 noite
   - Sem restrições
   ```

3. **Eventos Especiais**
   ```php
   - Carnaval, Réveillon, etc.
   - Preços específicos por data
   - Políticas especiais
   - Disponibilidade limitada
   ```

#### 3. Extras e Opcionais

**Serviços Adicionais:**
```php
// Configuração de extras
- Café da manhã: R$ 25/pessoa/dia
- Transfer aeroporto: R$ 80/trecho
- Berço: R$ 15/dia
- Cama extra: R$ 50/dia
- Pet friendly: R$ 30/dia
- Late checkout: R$ 100 (sujeito à disponibilidade)
```

**Configurações Avançadas:**
- Obrigatório vs opcional
- Por pessoa vs por reserva
- Por noite vs taxa única
- Limite de quantidade
- Disponibilidade por quarto

## Gateways de Pagamento

### Configuração de Pagamentos (`VikBooking > Configurações > Pagamentos`)

#### 1. Gateways Disponíveis (Versão Free)

**Opções Básicas:**
```php
// Métodos incluídos
1. PayPal
2. Transferência bancária
3. Pagamento na chegada
4. Cartão offline (dados por e-mail)
```

#### 2. Configuração PayPal

**Parâmetros Necessários:**
```php
// Configuração PayPal
- E-mail PayPal Business
- Moeda de pagamento
- Modo (Sandbox/Live)
- IPN URL (automático)
- Página de retorno
- Página de cancelamento
```

**Teste de Configuração:**
- Usar sandbox do PayPal
- Realizar transação teste
- Verificar notificações IPN
- Validar retorno de status

#### 3. Transferência Bancária

**Configuração:**
```php
// Dados bancários
- Banco: [Nome do banco]
- Agência: [Número da agência]
- Conta: [Número da conta]
- CNPJ/CPF: [Documento]
- Favorecido: [Nome da empresa]
- PIX: [Chave PIX se aplicável]
```

**Instruções Personalizadas:**
- Texto explicativo
- Prazo para pagamento
- Confirmação manual
- E-mail de acompanhamento

#### 4. Pagamento na Chegada

**Configurações:**
```php
// Parâmetros
- Métodos aceitos (dinheiro, cartão)
- Política de garantia
- Taxa de no-show
- Instruções especiais
```

### Gateways Avançados (Versão Pro)

**Opções Adicionais:**
- Stripe (cartões)
- PagSeguro
- Mercado Pago
- Cielo
- Rede
- GetNet
- SafetyPay
- Mais de 60 gateways disponíveis

## Clientes e Relatórios

### Gerenciamento de Clientes (`VikBooking > Clientes`)

#### 1. Base de Clientes

**Informações Armazenadas:**
```php
// Dados pessoais
- Nome completo
- Documento (CPF/RG/Passaporte)
- Data de nascimento
- Nacionalidade
- Gênero
- Estado civil

// Contato
- E-mail principal
- Telefone/WhatsApp
- Endereço completo
- Preferências de contato

// Histórico
- Número de estadias
- Valor total gasto
- Última visita
- Preferências de quarto
- Observações especiais
```

#### 2. Segmentação de Clientes

**Categorias:**
- **VIP**: Clientes frequentes ou alto valor
- **Corporativo**: Empresas e viajantes a negócio
- **Família**: Hóspedes com crianças
- **Casal**: Reservas românticas
- **Grupo**: Excursões e eventos

**Benefícios por Categoria:**
- Descontos específicos
- Upgrades automáticos
- Prioridade no atendimento
- Ofertas personalizadas

### Sistema de Relatórios (`VikBooking > Relatórios`)

#### 1. Relatórios Financeiros

**Receita:**
```php
// Métricas de receita
- Receita total por período
- Receita por quarto/tipo
- Receita por canal de venda
- Média por reserva (ADR)
- Receita por hóspede (RevPAR)
```

**Análise de Pagamentos:**
- Pagamentos recebidos
- Pagamentos pendentes
- Cancelamentos e estornos
- Comissões de OTAs
- Impostos e taxas

#### 2. Relatórios Operacionais

**Ocupação:**
```php
// Métricas de ocupação
- Taxa de ocupação por período
- Ocupação por tipo de quarto
- Previsão de ocupação
- Comparativo com período anterior
- Ocupação por canal
```

**Check-in/Check-out:**
- Lista de chegadas do dia
- Lista de partidas do dia
- No-shows
- Estadias prolongadas
- Relatório de housekeeping

#### 3. Relatórios Customizados

**Filtros Disponíveis:**
- Período específico
- Tipo de quarto
- Canal de reserva
- Status da reserva
- Forma de pagamento
- Nacionalidade do hóspede

**Exportação:**
- PDF para impressão
- Excel para análise
- CSV para importação
- E-mail automático

### PMS Reports (Versão Pro)

**Relatórios Obrigatórios:**
- RAIS (Brasil)
- Polícia Civil (registro de hóspedes)
- Receita Federal
- Órgãos de turismo
- Relatórios internacionais

## Shortcodes e Páginas

### Gerenciamento de Shortcodes (`VikBooking > Shortcodes`)

#### 1. Lista de Shortcodes

**Visualização dos Shortcodes:**
```php
// Informações exibidas
- Nome do shortcode
- Tipo de visualização
- Página associada
- Status (ativo/inativo)
- Idioma
- Data de criação
```

**Ações Disponíveis:**
- Editar configurações
- Duplicar shortcode
- Adicionar à página
- Visualizar no front-end
- Excluir

#### 2. Criando Novos Shortcodes

**Processo de Criação:**

1. **Escolher Tipo**
   - roomslist, roomdetails, search, etc.
   - Cada tipo tem parâmetros específicos

2. **Configurar Parâmetros**
   ```php
   // Exemplo: roomslist
   - Número de quartos por página
   - Ordem de exibição
   - Filtros disponíveis
   - Layout (grid/lista)
   ```

3. **Definir Página**
   - Criar nova página WordPress
   - Ou associar a página existente
   - Definir slug e título

4. **Customizar Aparência**
   - CSS personalizado
   - Template override
   - Configurações responsivas

#### 3. Parâmetros Avançados por Tipo

**roomslist:**
```php
[vikbooking view="roomslist" 
    order="price" 
    perpage="6" 
    layout="grid"
    filter_amenities="1"
    filter_price="1"]
```

**search:**
```php
[vikbooking view="search" 
    checkin="today+1" 
    checkout="today+2"
    adults="2"
    children="0"
    submit_ajax="1"]
```

**roomdetails:**
```php
[vikbooking view="roomdetails" 
    roomid="1"
    layout="classic"
    showcalendar="1"
    showgallery="1"]
```

### TinyMCE Integration

**Editor Visual:**
- Botão VikBooking no editor
- Lista de shortcodes disponíveis
- Inserção com um clique
- Preview dos shortcodes

## Permissões e ACL

### Sistema de Controle de Acesso (`VikBooking > ACL`)

#### 1. Níveis de Usuário WordPress

**Mapeamento de Permissões:**
```php
// Níveis WordPress -> VikBooking
- Administrator: Acesso total
- Editor: Gestão de conteúdo e reservas
- Author: Visualização e relatórios básicos
- Contributor: Apenas leitura
- Subscriber: Área do cliente
```

#### 2. Permissões Específicas do VikBooking

**Categorias de Permissão:**

**Gestão Global:**
- Configurações do sistema
- Gateways de pagamento
- Templates e idiomas
- Backup e restauração

**Gestão de Reservas:**
- Criar reservas manuais
- Modificar reservas existentes
- Cancelar reservas
- Processar check-in/check-out

**Gestão de Quartos:**
- Criar/editar quartos
- Gerenciar preços
- Configurar disponibilidade
- Upload de fotos

**Relatórios:**
- Acessar relatórios financeiros
- Exportar dados
- Visualizar estatísticas
- Relatórios PMS

#### 3. Criando Perfis Customizados

**Exemplo: Recepcionista**
```php
// Permissões específicas
✓ Visualizar reservas
✓ Criar reservas manuais
✓ Check-in/check-out
✓ Relatórios básicos
✗ Alterar preços
✗ Configurações globais
✗ Gestão de usuários
```

**Exemplo: Gerente**
```php
// Permissões específicas
✓ Todas as permissões de reservas
✓ Gestão de preços e tarifas
✓ Relatórios completos
✓ Configurações operacionais
✗ Configurações de sistema
✗ Gateways de pagamento
```

### Auditoria e Logs

**Registro de Atividades:**
- Login/logout de usuários
- Criação/modificação de reservas
- Alterações de preços
- Acessos a relatórios
- Tentativas de acesso negado

## Configurações Avançadas

### Configurações Técnicas (`VikBooking > Configurações`)

#### 1. Performance e Otimização

**Cache:**
```php
// Configurações de cache
- Cache de páginas (compatível com plugins)
- Cache de consultas de banco
- Cache de imagens
- Minificação de CSS/JS
```

**Banco de Dados:**
```php
// Otimizações
- Limpeza automática de logs
- Compactação de tabelas
- Backup automático
- Índices otimizados
```

#### 2. SEO e Integração

**URLs Amigáveis:**
```php
// Exemplos
/quartos/suite-deluxe/
/reservar/
/disponibilidade/
/ofertas/
```

**Meta Tags:**
- Títulos dinâmicos por página
- Descrições automáticas
- Open Graph para redes sociais
- Schema.org markup

**Integração Google:**
- Google Analytics
- Google Tag Manager
- Google Maps (localização)
- Google My Business

#### 3. Multi-idioma

**Configuração:**
```php
// Idiomas suportados
- Português (pt_BR)
- Inglês (en_US)
- Espanhol (es_ES)
- Francês (fr_FR)
- Italiano (it_IT)
```

**Tradução:**
- Interface administrativa
- Front-end público
- E-mails automáticos
- Relatórios

### Integrações Externas

#### 1. Channel Manager (Versão Pro)

**E4jConnect:**
- Conexão com OTAs
- Sincronização automática
- Gestão unificada
- Relatórios consolidados

**OTAs Suportadas:**
- Booking.com
- Airbnb
- Expedia
- Agoda
- Hotels.com
- E muitas outras

#### 2. Sistemas Externos

**PMS Integration:**
- Opera PMS
- Hotelogix
- RoomRaccoon
- MyHotel

**Ferramentas de Marketing:**
- Mailchimp
- Google Ads
- Facebook Pixel
- WhatsApp Business

## Customização e Hooks

### Sistema de Hooks (`/wp-content/plugins/vikbooking/libraries/hooks.md`)

#### 1. Hooks de Pagamento

**payment_before_admin_params_vikbooking**
```php
// Personalizar parâmetros do gateway
do_action('payment_before_admin_params_vikbooking', $payment);

// Exemplo de uso
add_action('payment_before_admin_params_vikbooking', function($payment) {
    // Modificar configurações do gateway
    $payment->setParam('custom_field', 'valor');
});
```

**payment_after_validate_transaction_vikbooking**
```php
// Ações após validação de pagamento
do_action('payment_after_validate_transaction_vikbooking', $payment, $status, $response);

// Exemplo de uso
add_action('payment_after_validate_transaction_vikbooking', function($payment, $status, $response) {
    if ($status->verified) {
        // Pagamento confirmado - executar ações customizadas
        enviar_confirmacao_personalizada($payment);
    }
});
```

#### 2. Hooks do Sistema

**vikbooking_before_dispatch**
```php
// Executa antes de qualquer ação do plugin
do_action('vikbooking_before_dispatch');

// Exemplo de uso
add_action('vikbooking_before_dispatch', function() {
    // Carregar bibliotecas customizadas
    // Verificar permissões específicas
});
```

#### 3. Filtros Personalizados

**get_supported_payments_vikbooking**
```php
// Filtrar gateways de pagamento disponíveis
$gateways = apply_filters('get_supported_payments_vikbooking', $gateways);

// Exemplo de uso
add_filter('get_supported_payments_vikbooking', function($gateways) {
    // Adicionar gateway customizado
    $gateways[] = 'MinhaGatewayPersonalizada';
    return $gateways;
});
```

### Template Overrides

#### 1. Estrutura de Templates

**Localização:**
```
/wp-content/plugins/vikbooking/site/views/
├── roomslist/tmpl/default.php
├── roomdetails/tmpl/default.php
├── search/tmpl/default.php
└── booking/tmpl/default.php
```

**Override no Tema:**
```
/wp-content/themes/seu-tema/vikbooking/
├── roomslist/default.php
├── roomdetails/default.php
└── search/default.php
```

#### 2. Customização CSS

**Arquivo Principal:**
```css
/* /wp-content/plugins/vikbooking/site/resources/vikbooking.css */

/* Classes principais */
.vbo-roomslist-container { }
.vbo-room-item { }
.vbo-room-details { }
.vbo-booking-form { }
```

**CSS Customizado:**
```css
/* No tema ou plugin child */
.vbo-room-item {
    border: 2px solid #your-color;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.vbo-booking-button {
    background: linear-gradient(45deg, #color1, #color2);
    color: white;
    padding: 12px 24px;
    border-radius: 25px;
}
```

### Desenvolvimento de Plugins Complementares

#### 1. Estrutura Básica

```php
<?php
/*
Plugin Name: VikBooking Extension
Description: Extensão personalizada para VikBooking
Version: 1.0
*/

// Verificar se VikBooking está ativo
if (!class_exists('VikBooking')) {
    return;
}

class VikBookingExtension {
    
    public function __construct() {
        add_action('init', array($this, 'init'));
    }
    
    public function init() {
        // Registrar hooks do VikBooking
        add_action('payment_after_validate_transaction_vikbooking', 
                   array($this, 'after_payment'));
    }
    
    public function after_payment($payment, $status, $response) {
        // Sua lógica personalizada
    }
}

new VikBookingExtension();
```

#### 2. Gateway de Pagamento Customizado

```php
<?php
// Classe do gateway personalizado
class MeuGatewayPersonalizado extends JPayment {
    
    public function getName() {
        return 'Meu Gateway';
    }
    
    public function buildAdminParameters() {
        return array(
            'api_key' => array(
                'type' => 'text',
                'label' => 'API Key',
                'required' => true
            ),
            'sandbox' => array(
                'type' => 'select',
                'label' => 'Modo',
                'options' => array('0' => 'Produção', '1' => 'Teste')
            )
        );
    }
    
    public function beginTransaction(VBOOrderBooking $order, VBOPaymentTransaction $transaction) {
        // Implementar lógica de pagamento
        return '<form>...</form>';
    }
    
    public function validateTransaction(VBOOrderBooking $order, VBOPaymentTransaction $transaction) {
        // Validar transação
        return new JPaymentStatus();
    }
}

// Registrar o gateway
add_action('load_payment_gateway_vikbooking', function(&$drivers, $payment) {
    if ($payment == 'meugateway') {
        $drivers[] = 'MeuGatewayPersonalizado';
    }
});
```

## Manutenção e Backup

### Backup e Segurança

#### 1. Backup Automático

**Configuração:**
```php
// Backup do banco de dados
- Agendamento automático (diário/semanal)
- Backup completo vs incremental
- Armazenamento local e nuvem
- Retenção de backups (30 dias padrão)
```

**Backup Manual:**
- Via dashboard do plugin
- Exportação de dados específicos
- Backup antes de atualizações
- Verificação de integridade

#### 2. Segurança

**Medidas de Proteção:**
```php
// Configurações de segurança
- SSL obrigatório para pagamentos
- Validação de entrada de dados
- Sanitização de uploads
- Proteção contra SQL injection
- CSRF tokens
```

**Logs de Segurança:**
- Tentativas de login falhadas
- Acessos suspeitos
- Modificações críticas
- Alertas automáticos

### Atualizações

#### 1. Processo de Atualização

**Preparação:**
- Backup completo antes da atualização
- Verificar compatibilidade com WordPress
- Testar em ambiente de desenvolvimento
- Ler changelog das mudanças

**Execução:**
- Atualização via dashboard WordPress
- Verificar funcionalidades críticas
- Testar processamento de pagamentos
- Validar front-end público

#### 2. Versionamento

**Controle de Versões:**
```php
// Histórico de versões
- 1.7.8 (atual) - Melhorias e correções
- 1.7.7 - Novos widgets admin
- 1.7.6 - Dock bar e mensagens
- 1.7.5 - Calendários aprimorados
```

### Troubleshooting

#### 1. Problemas Comuns

**Reservas Não Aparecem:**
```php
// Verificações
1. Shortcode correto na página
2. Permissões do usuário
3. Cache do navegador/site
4. Conflitos com outros plugins
5. Logs de erro do WordPress
```

**Pagamentos Falham:**
```php
// Diagnóstico
1. Configurações do gateway
2. Certificado SSL válido
3. URLs de retorno corretas
4. Logs de transação
5. Teste em sandbox
```

**Performance Lenta:**
```php
// Otimizações
1. Ativar cache
2. Otimizar imagens
3. Limpar logs antigos
4. Verificar consultas SQL
5. Aumentar limites PHP
```

#### 2. Logs e Diagnóstico

**Localização dos Logs:**
```
/wp-content/debug.log (WordPress)
/wp-content/plugins/vikbooking/logs/ (Plugin)
/wp-content/uploads/vikbooking/logs/ (Uploads)
```

**Ativar Debug:**
```php
// wp-config.php
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);

// Plugin específico
?debug=on (na URL)
```

---

## Recursos Adicionais

### Documentação Oficial
- [VikWP.com](https://vikwp.com)
- [Documentação Técnica](https://vikwp.com/docs)
- [Canal no YouTube](https://youtube.com/vikwp)

### Suporte Técnico
- **Fórum**: Comunidade de usuários
- **Tickets**: Suporte oficial (versão Pro)
- **Base de Conhecimento**: Artigos e tutoriais

### Treinamento
- **Webinars**: Sessões ao vivo
- **Tutoriais**: Passo a passo em vídeo
- **Certificação**: Programa de especialistas

---

*Última atualização: Março 2025*
*Versão do Plugin: VikBooking 1.7.8*