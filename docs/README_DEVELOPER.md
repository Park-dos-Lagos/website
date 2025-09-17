# VikBooking - Guia do Desenvolvedor

## Índice
1. [Arquitetura do Plugin](#arquitetura-do-plugin)
2. [Estrutura de Arquivos](#estrutura-de-arquivos)
3. [Hooks e Filtros](#hooks-e-filtros)
4. [Desenvolvimento de Gateways de Pagamento](#desenvolvimento-de-gateways-de-pagamento)
5. [Template System](#template-system)
6. [API e Integração](#api-e-integração)
7. [Banco de Dados](#banco-de-dados)
8. [Desenvolvimento de Extensões](#desenvolvimento-de-extensões)
9. [Testing e Debug](#testing-e-debug)
10. [Deployment e Performance](#deployment-e-performance)

## Arquitetura do Plugin

### Visão Geral

O VikBooking segue uma arquitetura MVC (Model-View-Controller) adaptada para WordPress, baseada no framework Joomla com adaptações específicas para o ecossistema WordPress.

```
VikBooking Framework
├── Adapter Layer (WordPress Integration)
├── MVC Framework (Models, Views, Controllers)
├── Payment System (Gateway Abstraction)
├── Template Engine (Overridable Views)
├── Hook System (WordPress Actions/Filters)
└── Database Layer (Custom Tables + WordPress)
```

### Principais Componentes

#### 1. Adapter System
```php
// Abstração para diferentes CMS
JFactory::getApplication()  // WordPress Application
JFactory::getDbo()          // WordPress Database
JFactory::getUser()         // WordPress User
JText::_()                  // i18n Translation
```

#### 2. MVC Framework
```php
// Controllers: admin/controllers/ e site/controllers/
class VikBookingControllerBooking extends JController {
    public function display($cachable = false, $urlparams = array()) {
        // Lógica do controller
    }
}

// Models: admin/models/ e site/models/
class VikBookingModelBooking extends JModel {
    public function getBookings() {
        // Lógica de dados
    }
}

// Views: admin/views/ e site/views/
class VikBookingViewBooking extends JView {
    public function display($tpl = null) {
        // Lógica de apresentação
    }
}
```

### Lifecycle do Plugin

```php
// 1. Autoload e Inicialização
require_once 'autoload.php';

// 2. Registro de Hooks WordPress
add_action('init', array('VikBookingInstaller', 'onInit'));
add_shortcode('vikbooking', 'vikbooking_shortcode_handler');

// 3. Dispatch da Requisição
// admin: via menu WordPress
// site: via shortcode handler

// 4. MVC Processing
Controller -> Model -> View -> Output
```

## Estrutura de Arquivos

### Organização Principal

```
wp-content/plugins/vikbooking/
├── admin/                  # Interface administrativa
│   ├── controllers/        # Controllers do admin
│   ├── models/            # Models do admin
│   ├── views/             # Views do admin
│   ├── helpers/           # Classes auxiliares
│   ├── resources/         # CSS, JS, imagens
│   └── config.xml         # Configuração do admin
├── site/                  # Interface pública
│   ├── controllers/       # Controllers do site
│   ├── models/           # Models do site
│   ├── views/            # Views do site
│   ├── helpers/          # Classes auxiliares
│   └── resources/        # CSS, JS, imagens
├── libraries/            # Framework e bibliotecas
│   ├── adapter/          # Adaptação WordPress
│   ├── hooks.md          # Documentação de hooks
│   └── src/              # Classes principais
├── languages/            # Arquivos de tradução
├── sql/                  # Scripts de banco de dados
├── modules/              # Widgets e módulos
├── autoload.php          # Autoloader principal
├── defines.php           # Constantes do plugin
├── vikbooking.php        # Arquivo principal
└── readme.txt           # Documentação WordPress
```

### Arquivos Principais

#### vikbooking.php
```php
<?php
/*
Plugin Name:  VikBooking
Description:  Certified Booking Engine for Hotels and Accommodations.
Version:      1.7.8
*/

// Autoload dependencies
require_once dirname(__FILE__) . DIRECTORY_SEPARATOR . 'autoload.php';

// Handle shortcodes
add_shortcode('vikbooking', function($atts, $content = null) {
    // Shortcode handler implementation
    return VikBookingSiteDispatcher::dispatch($atts);
});

// Admin menu integration
add_action('admin_menu', array('VikBookingBuilder', 'adminMenu'));
```

#### autoload.php
```php
<?php
// Framework setup
if (!class_exists('JLoader')) {
    require_once 'libraries/adapter/loader/loader.php';
    JLoader::setup();
}

// Import core dependencies
JLoader::import('adapter.mvc.controller');
JLoader::import('adapter.mvc.model');
VikBookingLoader::import('system.install');

// Setup autoloader
VikBookingLoader::import('helpers.src.autoload', VBO_ADMIN_PATH);
```

## Hooks e Filtros

### Sistema de Hooks Nativo

O VikBooking implementa um sistema de hooks específico baseado nos actions e filters do WordPress.

#### Hooks de Pagamento

```php
// Antes de gerar parâmetros admin do gateway
do_action('payment_before_admin_params_vikbooking', JPayment $payment);

// Após gerar parâmetros admin do gateway  
do_action_ref_array('payment_after_admin_params_vikbooking', 
                    array(&$payment, &$config));

// Antes de iniciar transação
do_action('payment_before_begin_transaction_vikbooking', JPayment $payment);

// Após gerar formulário de pagamento
do_action_ref_array('payment_after_begin_transaction_vikbooking', 
                    array(&$payment, &$html));

// Antes de validar transação
do_action('payment_before_validate_transaction_vikbooking', JPayment $payment);

// Após validar transação
do_action_ref_array('payment_after_validate_transaction_vikbooking', 
                    array(&$payment, &$status, &$response));

// Após completar validação
do_action('payment_on_after_validation_vikbooking', JPayment $payment, bool $result);
```

#### Hooks do Sistema

```php
// Antes do dispatch principal
do_action('vikbooking_before_dispatch');

// Após o dispatch principal
do_action('vikbooking_after_dispatch');

// Carregamento de gateway de pagamento
do_action_ref_array('load_payment_gateway_vikbooking', 
                    array(&$drivers, $payment_name));
```

#### Filtros Importantes

```php
// Filtrar gateways de pagamento suportados
$drivers = apply_filters('get_supported_payments_vikbooking', $drivers);

// Filtrar logo do gateway na confirmação
$logo = apply_filters('vikbooking_oconfirm_payment_logo', $logo_array);

// Filtrar configurações de e-mail
$mail_config = apply_filters('vikbooking_mail_config', $config);

// Filtrar dados da reserva antes de salvar
$booking_data = apply_filters('vikbooking_before_save_booking', $data);
```

### Implementação de Hooks Customizados

#### Exemplo: Hook Personalizado Após Reserva

```php
// No código do plugin (após salvar reserva)
do_action('vikbooking_after_booking_created', $booking_id, $booking_data);

// No seu plugin/tema
add_action('vikbooking_after_booking_created', function($booking_id, $data) {
    // Enviar notificação personalizada
    enviar_sms_confirmacao($data['customer_phone'], $booking_id);
    
    // Integrar com CRM
    crm_create_lead($data);
    
    // Analytics personalizado
    track_conversion($booking_id, $data['total_amount']);
});
```

## Desenvolvimento de Gateways de Pagamento

### Estrutura Base do Gateway

```php
<?php
/**
 * Gateway de Pagamento Personalizado
 */
class MinhaGatewayPersonalizada extends JPayment
{
    /**
     * Nome do gateway exibido no admin
     */
    public function getName()
    {
        return 'Minha Gateway Personalizada';
    }
    
    /**
     * Configurações admin do gateway
     */
    public function buildAdminParameters()
    {
        return array(
            'api_key' => array(
                'type'        => 'text',
                'label'       => 'API Key',
                'description' => 'Sua chave de API',
                'required'    => true,
            ),
            'secret_key' => array(
                'type'        => 'password',
                'label'       => 'Secret Key',
                'description' => 'Sua chave secreta',
                'required'    => true,
            ),
            'sandbox' => array(
                'type'    => 'select',
                'label'   => 'Modo de Operação',
                'options' => array(
                    '0' => 'Produção',
                    '1' => 'Sandbox/Teste'
                ),
                'default' => '1',
            ),
            'currency' => array(
                'type'    => 'select',
                'label'   => 'Moeda',
                'options' => array(
                    'BRL' => 'Real Brasileiro',
                    'USD' => 'Dólar Americano',
                    'EUR' => 'Euro'
                ),
                'default' => 'BRL',
            ),
        );
    }
    
    /**
     * Inicia processo de pagamento
     */
    public function beginTransaction(VBOOrderBooking $order, VBOPaymentTransaction $transaction)
    {
        // Configurações da gateway
        $api_key = $this->getParam('api_key');
        $secret_key = $this->getParam('secret_key');
        $sandbox = $this->getParam('sandbox', 0);
        
        // URLs de retorno
        $return_url = $this->getReturnUrl($order, $transaction);
        $cancel_url = $this->getCancelUrl($order, $transaction);
        $notify_url = $this->getNotifyUrl($order, $transaction);
        
        // Dados da transação
        $amount = $transaction->getAmount();
        $currency = $this->getParam('currency', 'BRL');
        $order_id = $order->getId();
        
        // API da gateway
        $gateway_api = new MinhaGatewayAPI($api_key, $secret_key, $sandbox);
        
        try {
            // Criar transação na gateway
            $response = $gateway_api->createTransaction(array(
                'amount'      => $amount,
                'currency'    => $currency,
                'order_id'    => $order_id,
                'description' => 'Reserva #' . $order_id,
                'return_url'  => $return_url,
                'cancel_url'  => $cancel_url,
                'notify_url'  => $notify_url,
                'customer'    => array(
                    'name'  => $order->getCustomerName(),
                    'email' => $order->getCustomerEmail(),
                    'phone' => $order->getCustomerPhone(),
                ),
            ));
            
            if ($response['success']) {
                // Salvar transaction_id para posterior validação
                $transaction->setTransactionId($response['transaction_id']);
                
                // Retornar HTML do formulário ou redirect
                return $this->buildPaymentForm($response);
            } else {
                throw new Exception($response['error']);
            }
            
        } catch (Exception $e) {
            // Log do erro
            VikBooking::getLogger()->error('Gateway Error: ' . $e->getMessage());
            
            // Exibir erro para o usuário
            return '<div class="alert alert-danger">Erro: ' . $e->getMessage() . '</div>';
        }
    }
    
    /**
     * Valida o retorno da transação
     */
    public function validateTransaction(VBOOrderBooking $order, VBOPaymentTransaction $transaction)
    {
        $status = new JPaymentStatus();
        
        // Configurações
        $api_key = $this->getParam('api_key');
        $secret_key = $this->getParam('secret_key');
        $sandbox = $this->getParam('sandbox', 0);
        
        // ID da transação
        $transaction_id = $transaction->getTransactionId();
        
        if (!$transaction_id) {
            $status->verified = false;
            $status->notes = 'ID da transação não encontrado';
            return $status;
        }
        
        try {
            // Consultar status na gateway
            $gateway_api = new MinhaGatewayAPI($api_key, $secret_key, $sandbox);
            $response = $gateway_api->getTransactionStatus($transaction_id);
            
            if ($response['success']) {
                switch ($response['status']) {
                    case 'approved':
                        $status->verified = true;
                        $status->notes = 'Pagamento aprovado';
                        break;
                        
                    case 'pending':
                        $status->verified = false;
                        $status->notes = 'Pagamento pendente';
                        break;
                        
                    case 'rejected':
                        $status->verified = false;
                        $status->notes = 'Pagamento rejeitado: ' . $response['reason'];
                        break;
                        
                    default:
                        $status->verified = false;
                        $status->notes = 'Status desconhecido: ' . $response['status'];
                }
                
                // Dados adicionais
                $status->transaction_id = $transaction_id;
                $status->amount = $response['amount'];
                $status->currency = $response['currency'];
                
            } else {
                $status->verified = false;
                $status->notes = 'Erro na consulta: ' . $response['error'];
            }
            
        } catch (Exception $e) {
            $status->verified = false;
            $status->notes = 'Exceção: ' . $e->getMessage();
            
            VikBooking::getLogger()->error('Validation Error: ' . $e->getMessage());
        }
        
        return $status;
    }
    
    /**
     * Constrói formulário de pagamento
     */
    private function buildPaymentForm($gateway_response)
    {
        if (isset($gateway_response['redirect_url'])) {
            // Redirect direto
            return '<script>window.location.href = "' . $gateway_response['redirect_url'] . '";</script>';
        }
        
        if (isset($gateway_response['form_data'])) {
            // Formulário POST
            $html = '<form id="payment-form" method="POST" action="' . $gateway_response['form_action'] . '">';
            
            foreach ($gateway_response['form_data'] as $name => $value) {
                $html .= '<input type="hidden" name="' . htmlspecialchars($name) . '" value="' . htmlspecialchars($value) . '">';
            }
            
            $html .= '<input type="submit" value="Prosseguir com Pagamento" class="btn btn-primary">';
            $html .= '</form>';
            $html .= '<script>document.getElementById("payment-form").submit();</script>';
            
            return $html;
        }
        
        return '<div class="alert alert-danger">Erro na configuração do pagamento</div>';
    }
}
```

### Registrando o Gateway

```php
<?php
// Em plugin separado ou functions.php do tema

// Autoload da classe (se necessário)
require_once 'path/to/MinhaGatewayPersonalizada.php';

// Registrar o gateway
add_action('load_payment_gateway_vikbooking', function(&$drivers, $payment) {
    if ($payment == 'minhagateway') {
        $drivers[] = 'MinhaGatewayPersonalizada';
    }
}, 10, 2);

// Adicionar à lista de gateways suportados
add_filter('get_supported_payments_vikbooking', function($drivers) {
    $drivers['minhagateway'] = 'Minha Gateway Personalizada';
    return $drivers;
});
```

### API Helper Class

```php
<?php
/**
 * Classe para comunicação com API externa
 */
class MinhaGatewayAPI
{
    private $api_key;
    private $secret_key;
    private $sandbox;
    private $base_url;
    
    public function __construct($api_key, $secret_key, $sandbox = false)
    {
        $this->api_key = $api_key;
        $this->secret_key = $secret_key;
        $this->sandbox = $sandbox;
        $this->base_url = $sandbox ? 'https://sandbox.api.gateway.com' : 'https://api.gateway.com';
    }
    
    public function createTransaction($data)
    {
        $endpoint = '/v1/transactions';
        return $this->makeRequest('POST', $endpoint, $data);
    }
    
    public function getTransactionStatus($transaction_id)
    {
        $endpoint = '/v1/transactions/' . $transaction_id;
        return $this->makeRequest('GET', $endpoint);
    }
    
    private function makeRequest($method, $endpoint, $data = null)
    {
        $url = $this->base_url . $endpoint;
        
        $headers = array(
            'Authorization: Bearer ' . $this->api_key,
            'Content-Type: application/json',
            'X-Secret-Key: ' . $this->secret_key,
        );
        
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSL_VERIFYPEER => !$this->sandbox,
        ));
        
        if ($method === 'POST' && $data) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }
        
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);
        
        if ($error) {
            throw new Exception('cURL Error: ' . $error);
        }
        
        $decoded = json_decode($response, true);
        
        if ($http_code >= 400) {
            throw new Exception('HTTP Error ' . $http_code . ': ' . ($decoded['message'] ?? 'Unknown error'));
        }
        
        return $decoded;
    }
}
```

## Template System

### Hierarquia de Templates

O VikBooking usa um sistema de templates hierárquico que permite override completo:

```
1. Theme Override:     /themes/seu-tema/vikbooking/view/layout.php
2. Plugin Default:     /plugins/vikbooking/site/views/view/tmpl/layout.php
3. Plugin Alternative: /plugins/vikbooking/site/views/view/tmpl/layout_alt.php
```

### Template Override

#### 1. Criando Override no Tema

```php
// Estrutura no tema
wp-content/themes/seu-tema/
└── vikbooking/
    ├── roomslist/
    │   └── default.php      # Override da lista de quartos
    ├── roomdetails/
    │   └── default.php      # Override dos detalhes do quarto
    ├── search/
    │   └── default.php      # Override da busca
    └── booking/
        └── default.php      # Override da confirmação
```

#### 2. Exemplo de Template Override

```php
<?php
/**
 * Template Override: Lista de Quartos
 * Localização: /themes/seu-tema/vikbooking/roomslist/default.php
 */

// Dados disponíveis
$rooms = $this->rooms;              // Array de quartos
$search_data = $this->search_data;  // Dados da busca
$pagination = $this->pagination;    // Paginação

// CSS personalizado
?>
<style>
.custom-room-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
    margin: 20px 0;
}

.custom-room-card {
    border: 1px solid #ddd;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
}

.custom-room-card:hover {
    transform: translateY(-5px);
}
</style>

<div class="custom-room-grid">
    <?php foreach ($rooms as $room): ?>
        <div class="custom-room-card">
            <div class="room-image">
                <?php if ($room['img']): ?>
                    <img src="<?php echo VikBooking::getImageUrl($room['img']); ?>" 
                         alt="<?php echo htmlspecialchars($room['name']); ?>"
                         style="width: 100%; height: 200px; object-fit: cover;">
                <?php endif; ?>
            </div>
            
            <div class="room-content" style="padding: 15px;">
                <h3><?php echo htmlspecialchars($room['name']); ?></h3>
                <p><?php echo $room['shortdesc']; ?></p>
                
                <div class="room-features">
                    <span>👥 Até <?php echo $room['toadult']; ?> pessoas</span>
                    <span>🛏️ <?php echo $room['beds']; ?> cama(s)</span>
                    <?php if ($room['mq']): ?>
                        <span>📐 <?php echo $room['mq']; ?>m²</span>
                    <?php endif; ?>
                </div>
                
                <div class="room-price">
                    <strong>R$ <?php echo number_format($room['price'], 2, ',', '.'); ?></strong>
                    <span>/noite</span>
                </div>
                
                <a href="<?php echo $room['booking_url']; ?>" 
                   class="btn btn-primary btn-block">
                    Reservar Agora
                </a>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php if ($pagination): ?>
    <div class="pagination-wrapper">
        <?php echo $pagination; ?>
    </div>
<?php endif; ?>
```

### Sub-templates e Includes

```php
<?php
/**
 * Template principal pode incluir sub-templates
 */

// Carregar sub-template específico
echo $this->loadTemplate('search_form');    // Carrega search_form.php
echo $this->loadTemplate('room_grid');      // Carrega room_grid.php
echo $this->loadTemplate('pagination');     // Carrega pagination.php

// Sub-template com parâmetros
echo $this->loadTemplate('room_card', array(
    'room' => $room,
    'show_amenities' => true,
    'layout' => 'compact'
));
```

### Layouts Alternativos

```php
// Shortcode com layout específico
[vikbooking view="roomslist" layout="grid"]
[vikbooking view="roomslist" layout="list"]
[vikbooking view="roomslist" layout="carousel"]

// Implementação no template
<?php
$layout = $this->layout ?? 'default';

switch ($layout) {
    case 'grid':
        echo $this->loadTemplate('grid');
        break;
    case 'list':
        echo $this->loadTemplate('list');
        break;
    case 'carousel':
        echo $this->loadTemplate('carousel');
        break;
    default:
        echo $this->loadTemplate('default');
}
?>
```

## API e Integração

### REST API Endpoints

O VikBooking expõe endpoints REST para integração externa:

```php
// Registro de endpoints customizados
add_action('rest_api_init', function() {
    register_rest_route('vikbooking/v1', '/rooms', array(
        'methods' => 'GET',
        'callback' => 'vb_api_get_rooms',
        'permission_callback' => 'vb_api_permissions'
    ));
    
    register_rest_route('vikbooking/v1', '/booking', array(
        'methods' => 'POST',
        'callback' => 'vb_api_create_booking',
        'permission_callback' => 'vb_api_permissions'
    ));
});

function vb_api_get_rooms(WP_REST_Request $request) {
    $checkin = $request->get_param('checkin');
    $checkout = $request->get_param('checkout');
    $adults = $request->get_param('adults') ?: 2;
    
    // Buscar quartos disponíveis
    $helper = VikBooking::getAvailabilityInstance();
    $rooms = $helper->getAvailableRooms($checkin, $checkout, $adults);
    
    return new WP_REST_Response($rooms, 200);
}

function vb_api_create_booking(WP_REST_Request $request) {
    $data = $request->get_json_params();
    
    // Validar dados
    if (!isset($data['room_id'], $data['checkin'], $data['checkout'])) {
        return new WP_Error('missing_data', 'Dados obrigatórios ausentes', array('status' => 400));
    }
    
    try {
        // Criar reserva
        $booking = VikBooking::createBooking($data);
        return new WP_REST_Response($booking, 201);
    } catch (Exception $e) {
        return new WP_Error('booking_error', $e->getMessage(), array('status' => 500));
    }
}
```

### Integração com External APIs

```php
<?php
/**
 * Classe para integração com sistemas externos
 */
class VikBookingExternalIntegration
{
    public function __construct()
    {
        // Hook após criação de reserva
        add_action('vikbooking_after_booking_created', array($this, 'syncToExternalPMS'));
        
        // Hook após pagamento confirmado
        add_action('payment_after_validate_transaction_vikbooking', 
                   array($this, 'notifyExternalSystem'), 10, 3);
    }
    
    /**
     * Sincronizar com PMS externo
     */
    public function syncToExternalPMS($booking_id)
    {
        $booking = VikBooking::getBookingData($booking_id);
        
        // Mapear dados para formato do PMS externo
        $external_data = array(
            'reservation_id' => $booking['id'],
            'guest_name' => $booking['custdata']['first_name'] . ' ' . $booking['custdata']['last_name'],
            'checkin_date' => $booking['checkin'],
            'checkout_date' => $booking['checkout'],
            'room_type' => $booking['room_name'],
            'total_amount' => $booking['total'],
            'status' => $booking['status']
        );
        
        // Enviar para API externa
        $this->sendToPMS($external_data);
    }
    
    /**
     * Notificar sistema de CRM
     */
    public function notifyExternalSystem($payment, $status, $response)
    {
        if ($status->verified) {
            // Buscar dados da reserva
            $booking_id = $payment->getBookingId();
            $booking = VikBooking::getBookingData($booking_id);
            
            // Enviar para CRM
            $this->sendToCRM($booking);
            
            // Atualizar sistema de fidelidade
            $this->updateLoyaltyProgram($booking);
        }
    }
    
    private function sendToPMS($data)
    {
        $api_endpoint = get_option('vb_external_pms_api');
        $api_key = get_option('vb_external_pms_key');
        
        if (!$api_endpoint || !$api_key) {
            return;
        }
        
        wp_remote_post($api_endpoint, array(
            'headers' => array(
                'Authorization' => 'Bearer ' . $api_key,
                'Content-Type' => 'application/json'
            ),
            'body' => json_encode($data),
            'timeout' => 30
        ));
    }
}

// Inicializar integração
new VikBookingExternalIntegration();
```

## Banco de Dados

### Estrutura das Tabelas

```sql
-- Tabelas principais do VikBooking
wp_vikbooking_rooms           -- Quartos
wp_vikbooking_orders          -- Reservas
wp_vikbooking_busy            -- Ocupação/Bloqueios
wp_vikbooking_prices          -- Preços e tarifas
wp_vikbooking_seasons         -- Temporadas
wp_vikbooking_customers       -- Clientes
wp_vikbooking_optionals       -- Serviços extras
wp_vikbooking_payments        -- Gateways de pagamento
wp_vikbooking_wpshortcodes    -- Shortcodes configurados
wp_vikbooking_config          -- Configurações
```

### Consultas Customizadas

```php
<?php
/**
 * Helper para consultas customizadas
 */
class VikBookingQueryHelper
{
    /**
     * Buscar reservas por período
     */
    public static function getBookingsByPeriod($start_date, $end_date, $status = null)
    {
        $dbo = JFactory::getDbo();
        
        $query = $dbo->getQuery(true)
            ->select('o.*, r.name as room_name, c.first_name, c.last_name')
            ->from($dbo->qn('#__vikbooking_orders', 'o'))
            ->leftJoin($dbo->qn('#__vikbooking_rooms', 'r') . ' ON ' . $dbo->qn('r.id') . ' = ' . $dbo->qn('o.idroom'))
            ->leftJoin($dbo->qn('#__vikbooking_customers', 'c') . ' ON ' . $dbo->qn('c.id') . ' = ' . $dbo->qn('o.idcustomer'))
            ->where($dbo->qn('o.checkin') . ' >= ' . $dbo->q($start_date))
            ->where($dbo->qn('o.checkout') . ' <= ' . $dbo->q($end_date));
        
        if ($status) {
            $query->where($dbo->qn('o.status') . ' = ' . $dbo->q($status));
        }
        
        $query->order($dbo->qn('o.checkin') . ' ASC');
        
        $dbo->setQuery($query);
        return $dbo->loadObjectList();
    }
    
    /**
     * Estatísticas de ocupação
     */
    public static function getOccupancyStats($year, $month = null)
    {
        $dbo = JFactory::getDbo();
        
        $start_date = $year . '-' . ($month ?: '01') . '-01';
        $end_date = $month ? 
            date('Y-m-t', strtotime($start_date)) : 
            $year . '-12-31';
        
        $query = $dbo->getQuery(true)
            ->select([
                'COUNT(*) as total_bookings',
                'SUM(CASE WHEN status = "confirmed" THEN 1 ELSE 0 END) as confirmed_bookings',
                'SUM(total) as total_revenue',
                'AVG(total) as average_booking_value',
                'AVG(days) as average_stay_length'
            ])
            ->from($dbo->qn('#__vikbooking_orders'))
            ->where($dbo->qn('checkin') . ' >= ' . $dbo->q($start_date))
            ->where($dbo->qn('checkin') . ' <= ' . $dbo->q($end_date));
        
        $dbo->setQuery($query);
        return $dbo->loadObject();
    }
    
    /**
     * Top clientes por valor gasto
     */
    public static function getTopCustomers($limit = 10, $period_months = 12)
    {
        $dbo = JFactory::getDbo();
        $start_date = date('Y-m-d', strtotime("-{$period_months} months"));
        
        $query = $dbo->getQuery(true)
            ->select([
                'c.id',
                'c.first_name',
                'c.last_name', 
                'c.email',
                'COUNT(o.id) as total_bookings',
                'SUM(o.total) as total_spent',
                'AVG(o.total) as average_booking_value',
                'MAX(o.checkin) as last_booking_date'
            ])
            ->from($dbo->qn('#__vikbooking_customers', 'c'))
            ->innerJoin($dbo->qn('#__vikbooking_orders', 'o') . ' ON ' . $dbo->qn('o.idcustomer') . ' = ' . $dbo->qn('c.id'))
            ->where($dbo->qn('o.checkin') . ' >= ' . $dbo->q($start_date))
            ->where($dbo->qn('o.status') . ' = ' . $dbo->q('confirmed'))
            ->group($dbo->qn('c.id'))
            ->order($dbo->qn('total_spent') . ' DESC')
            ->setLimit($limit);
        
        $dbo->setQuery($query);
        return $dbo->loadObjectList();
    }
}
```

### Migrations e Updates

```php
<?php
/**
 * Sistema de migrations para customizações
 */
class VikBookingCustomMigrations
{
    public static function createCustomTables()
    {
        global $wpdb;
        
        $charset_collate = $wpdb->get_charset_collate();
        
        // Tabela para dados customizados de clientes
        $sql = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}vikbooking_customer_preferences (
            id int(11) NOT NULL AUTO_INCREMENT,
            customer_id int(11) NOT NULL,
            preference_key varchar(100) NOT NULL,
            preference_value text,
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY customer_id (customer_id),
            KEY preference_key (preference_key)
        ) $charset_collate;";
        
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
        
        // Tabela para log de ações customizadas
        $sql = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}vikbooking_custom_logs (
            id int(11) NOT NULL AUTO_INCREMENT,
            booking_id int(11),
            user_id int(11),
            action varchar(100) NOT NULL,
            data text,
            ip_address varchar(45),
            created_at datetime DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            KEY booking_id (booking_id),
            KEY user_id (user_id),
            KEY action (action)
        ) $charset_collate;";
        
        dbDelta($sql);
    }
    
    public static function addCustomFields()
    {
        global $wpdb;
        
        // Adicionar campos customizados na tabela de quartos
        $wpdb->query("ALTER TABLE {$wpdb->prefix}vikbooking_rooms 
                      ADD COLUMN IF NOT EXISTS custom_amenities TEXT AFTER params");
        
        // Adicionar campos customizados na tabela de reservas
        $wpdb->query("ALTER TABLE {$wpdb->prefix}vikbooking_orders 
                      ADD COLUMN IF NOT EXISTS custom_requests TEXT AFTER special_requests");
    }
}

// Executar na ativação do plugin customizado
register_activation_hook(__FILE__, array('VikBookingCustomMigrations', 'createCustomTables'));
```

## Desenvolvimento de Extensões

### Plugin Base para Extensões

```php
<?php
/*
Plugin Name: VikBooking Custom Extension
Description: Extensão personalizada para VikBooking
Version: 1.0.0
*/

// Verificar se VikBooking está ativo
if (!defined('VBO_INSTALLED') || !class_exists('VikBooking')) {
    add_action('admin_notices', function() {
        echo '<div class="notice notice-error"><p>VikBooking Custom Extension requer o plugin VikBooking ativo.</p></div>';
    });
    return;
}

/**
 * Classe principal da extensão
 */
class VikBookingCustomExtension
{
    const VERSION = '1.0.0';
    
    private static $instance = null;
    
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    private function __construct()
    {
        add_action('init', array($this, 'init'));
    }
    
    public function init()
    {
        // Carregar arquivos de tradução
        load_plugin_textdomain('vbo-custom-ext', false, dirname(plugin_basename(__FILE__)) . '/languages');
        
        // Registrar hooks do VikBooking
        $this->registerHooks();
        
        // Registrar admin hooks
        if (is_admin()) {
            $this->registerAdminHooks();
        }
        
        // Registrar front-end hooks
        if (!is_admin()) {
            $this->registerFrontendHooks();
        }
    }
    
    private function registerHooks()
    {
        // Hooks gerais
        add_action('vikbooking_after_booking_created', array($this, 'onBookingCreated'), 10, 2);
        add_action('payment_after_validate_transaction_vikbooking', array($this, 'onPaymentValidated'), 10, 3);
        
        // Filtros
        add_filter('vikbooking_booking_data_before_save', array($this, 'filterBookingData'));
        add_filter('get_supported_payments_vikbooking', array($this, 'addCustomPaymentMethods'));
    }
    
    private function registerAdminHooks()
    {
        // Menu admin
        add_action('admin_menu', array($this, 'addAdminMenu'));
        
        // Scripts e styles admin
        add_action('admin_enqueue_scripts', array($this, 'enqueueAdminAssets'));
        
        // Ajax handlers
        add_action('wp_ajax_vbo_custom_action', array($this, 'handleCustomAction'));
    }
    
    private function registerFrontendHooks()
    {
        // Scripts e styles front-end
        add_action('wp_enqueue_scripts', array($this, 'enqueueFrontendAssets'));
        
        // Shortcodes customizados
        add_shortcode('vbo_custom_widget', array($this, 'customWidgetShortcode'));
    }
    
    public function onBookingCreated($booking_id, $booking_data)
    {
        // Lógica personalizada após criação de reserva
        $this->sendCustomNotification($booking_id);
        $this->updateCustomStats($booking_data);
    }
    
    public function onPaymentValidated($payment, $status, $response)
    {
        if ($status->verified) {
            // Lógica após pagamento confirmado
            $this->processLoyaltyPoints($payment);
        }
    }
    
    public function filterBookingData($data)
    {
        // Adicionar dados customizados
        $data['custom_field'] = sanitize_text_field($_POST['custom_field'] ?? '');
        return $data;
    }
    
    public function addCustomPaymentMethods($methods)
    {
        $methods['custom_gateway'] = 'Custom Payment Gateway';
        return $methods;
    }
    
    public function addAdminMenu()
    {
        add_submenu_page(
            'vikbooking',
            'Custom Extension',
            'Custom Ext',
            'manage_options',
            'vbo-custom-ext',
            array($this, 'adminPage')
        );
    }
    
    public function adminPage()
    {
        ?>
        <div class="wrap">
            <h1>VikBooking Custom Extension</h1>
            <form method="post" action="options.php">
                <?php
                settings_fields('vbo_custom_ext_settings');
                do_settings_sections('vbo_custom_ext_settings');
                ?>
                <table class="form-table">
                    <tr>
                        <th scope="row">API Key</th>
                        <td>
                            <input type="text" name="vbo_custom_api_key" 
                                   value="<?php echo esc_attr(get_option('vbo_custom_api_key')); ?>" />
                        </td>
                    </tr>
                </table>
                <?php submit_button(); ?>
            </form>
        </div>
        <?php
    }
    
    private function sendCustomNotification($booking_id)
    {
        // Implementar notificação personalizada
    }
    
    private function updateCustomStats($booking_data)
    {
        // Atualizar estatísticas personalizadas
    }
    
    private function processLoyaltyPoints($payment)
    {
        // Processar pontos de fidelidade
    }
}

// Inicializar extensão
VikBookingCustomExtension::getInstance();
```

## Testing e Debug

### Debug Configuration

```php
// wp-config.php
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);

// Para debug específico do VikBooking
// Adicionar ?debug=on na URL
```

### Logging Personalizado

```php
<?php
/**
 * Sistema de logging personalizado
 */
class VikBookingCustomLogger
{
    private static $log_file;
    
    public static function init()
    {
        self::$log_file = WP_CONTENT_DIR . '/uploads/vikbooking-custom.log';
    }
    
    public static function log($level, $message, $context = array())
    {
        if (!self::$log_file) {
            self::init();
        }
        
        $timestamp = date('Y-m-d H:i:s');
        $log_entry = sprintf(
            "[%s] %s: %s %s\n",
            $timestamp,
            strtoupper($level),
            $message,
            $context ? json_encode($context) : ''
        );
        
        file_put_contents(self::$log_file, $log_entry, FILE_APPEND | LOCK_EX);
    }
    
    public static function debug($message, $context = array())
    {
        if (WP_DEBUG) {
            self::log('debug', $message, $context);
        }
    }
    
    public static function info($message, $context = array())
    {
        self::log('info', $message, $context);
    }
    
    public static function error($message, $context = array())
    {
        self::log('error', $message, $context);
    }
}

// Usar o logger
VikBookingCustomLogger::debug('Booking process started', array('booking_id' => $booking_id));
VikBookingCustomLogger::error('Payment validation failed', array('error' => $error_message));
```

### Unit Testing

```php
<?php
/**
 * Testes unitários para extensões VikBooking
 */
class VikBookingCustomTests extends WP_UnitTestCase
{
    public function setUp()
    {
        parent::setUp();
        
        // Ativar VikBooking para testes
        activate_plugin('vikbooking/vikbooking.php');
        
        // Configurar dados de teste
        $this->setupTestData();
    }
    
    public function test_booking_creation()
    {
        $booking_data = array(
            'checkin' => '2025-04-01',
            'checkout' => '2025-04-03',
            'room_id' => 1,
            'adults' => 2,
            'customer_name' => 'Test Customer',
            'customer_email' => 'test@example.com'
        );
        
        $booking_id = VikBooking::createBooking($booking_data);
        
        $this->assertIsInt($booking_id);
        $this->assertGreaterThan(0, $booking_id);
        
        // Verificar se booking foi salvo corretamente
        $saved_booking = VikBooking::getBookingData($booking_id);
        $this->assertEquals($booking_data['customer_email'], $saved_booking['customer_email']);
    }
    
    public function test_custom_payment_gateway()
    {
        $gateway = new MinhaGatewayPersonalizada();
        
        // Testar configuração
        $this->assertEquals('Minha Gateway Personalizada', $gateway->getName());
        
        // Testar parâmetros admin
        $params = $gateway->getAdminParameters();
        $this->assertArrayHasKey('api_key', $params);
        $this->assertArrayHasKey('sandbox', $params);
    }
    
    public function test_template_override()
    {
        // Verificar se override de template funciona
        $template_path = get_stylesheet_directory() . '/vikbooking/roomslist/default.php';
        
        if (file_exists($template_path)) {
            $this->assertTrue(true, 'Template override exists');
        } else {
            $this->markTestSkipped('Template override not found');
        }
    }
    
    private function setupTestData()
    {
        // Criar dados de teste necessários
        global $wpdb;
        
        // Inserir quarto de teste
        $wpdb->insert(
            $wpdb->prefix . 'vikbooking_rooms',
            array(
                'name' => 'Test Room',
                'img' => '',
                'idcat' => 0,
                'toadult' => 2,
                'totchild' => 1,
                'cost' => 100.00,
                'units' => 1
            )
        );
    }
}
```

## Deployment e Performance

### Otimização de Performance

```php
<?php
/**
 * Otimizações de performance para VikBooking
 */
class VikBookingPerformanceOptimizer
{
    public function __construct()
    {
        add_action('init', array($this, 'init'));
    }
    
    public function init()
    {
        // Cache de consultas
        add_filter('posts_request', array($this, 'cacheQueries'));
        
        // Otimização de imagens
        add_filter('wp_get_attachment_image_src', array($this, 'optimizeImages'), 10, 4);
        
        // Lazy loading para calendários
        add_action('wp_footer', array($this, 'lazyLoadCalendars'));
        
        // Minificação de CSS/JS
        if (!WP_DEBUG) {
            add_filter('vikbooking_css_output', array($this, 'minifyCSS'));
            add_filter('vikbooking_js_output', array($this, 'minifyJS'));
        }
    }
    
    public function cacheQueries($sql)
    {
        // Implementar cache de consultas frequentes
        if (strpos($sql, 'vikbooking_rooms') !== false) {
            $cache_key = 'vb_rooms_' . md5($sql);
            $cached = wp_cache_get($cache_key, 'vikbooking');
            
            if ($cached !== false) {
                return $cached;
            }
        }
        
        return $sql;
    }
    
    public function optimizeImages($image, $attachment_id, $size, $icon)
    {
        // Otimizar imagens de quartos
        if ($size === 'vikbooking-room-thumb') {
            // Adicionar WebP se suportado
            if (function_exists('imagewebp')) {
                // Converter para WebP se necessário
            }
        }
        
        return $image;
    }
    
    public function lazyLoadCalendars()
    {
        ?>
        <script>
        // Lazy loading para calendários pesados
        if ('IntersectionObserver' in window) {
            const calendarObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        loadCalendar(entry.target);
                        calendarObserver.unobserve(entry.target);
                    }
                });
            });
            
            document.querySelectorAll('.vbo-calendar-lazy').forEach(cal => {
                calendarObserver.observe(cal);
            });
        }
        </script>
        <?php
    }
    
    public function minifyCSS($css)
    {
        // Remover comentários e espaços extras
        $css = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css);
        $css = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $css);
        return $css;
    }
    
    public function minifyJS($js)
    {
        // Minificação básica de JavaScript
        $js = preg_replace('/(?:(?:\/\*(?:[^*]|(?:\*+[^*\/]))*\*+\/)|(?:(?<!\:|\\\|\'|\")\/\/.*))/', '', $js);
        $js = str_replace(array("\r\n", "\r", "\n", "\t"), '', $js);
        return $js;
    }
}

new VikBookingPerformanceOptimizer();
```

### Deployment Checklist

```bash
# Lista de verificação para deployment

## 1. Backup
- [ ] Backup completo do banco de dados
- [ ] Backup dos arquivos do plugin
- [ ] Backup das customizações do tema

## 2. Testes
- [ ] Teste de funcionalidades críticas
- [ ] Teste de processamento de pagamentos
- [ ] Teste de e-mails automáticos
- [ ] Teste em diferentes dispositivos

## 3. Performance
- [ ] Ativar cache do WordPress
- [ ] Otimizar imagens
- [ ] Verificar tempo de carregamento
- [ ] Testar sob carga

## 4. Segurança
- [ ] Atualizar WordPress e plugins
- [ ] Verificar permissões de arquivos
- [ ] Configurar SSL
- [ ] Testar formulários de pagamento

## 5. Configuração
- [ ] URLs de produção nos gateways
- [ ] E-mails de notificação corretos
- [ ] Configurações de fuso horário
- [ ] Configurações de moeda

## 6. Monitoramento
- [ ] Configurar logs
- [ ] Monitoramento de uptime
- [ ] Alertas de erro
- [ ] Analytics configurado
```

---

## Recursos Adicionais

### Documentação Oficial
- [VikWP Developer Docs](https://vikwp.com/docs/developers)
- [Plugin Repository](https://github.com/vikwp/vikbooking)
- [API Reference](https://vikwp.com/api-docs)

### Comunidade
- [Developer Forum](https://vikwp.com/forum/developers)
- [Discord Channel](https://discord.gg/vikwp)
- [Stack Overflow Tag](https://stackoverflow.com/questions/tagged/vikbooking)

### Ferramentas de Desenvolvimento
- [VikBooking CLI](https://vikwp.com/cli) (em desenvolvimento)
- [Code Snippets Library](https://vikwp.com/snippets)
- [Testing Framework](https://github.com/vikwp/testing-framework)

---

*Última atualização: Março 2025*
*Versão do Plugin: VikBooking 1.7.8*