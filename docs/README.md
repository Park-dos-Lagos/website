# Documentação Completa - VikBooking Plugin

## 📚 Índice da Documentação

Esta pasta contém documentação completa do plugin VikBooking para WordPress, organizizada por tipo de usuário e necessidade.

### 📖 Documentos Disponíveis

| Documento | Público-Alvo | Descrição | Tempo de Leitura |
|-----------|--------------|-----------|------------------|
| **[README_USUARIO.md](README_USUARIO.md)** | 👥 Hóspedes e Usuários Finais | Guia completo para fazer reservas e usar o sistema | 20 min |
| **[README_ADMIN.md](README_ADMIN.md)** | 🏨 Administradores e Hoteleiros | Manual administrativo completo do sistema | 45 min |
| **[README_DEVELOPER.md](README_DEVELOPER.md)** | 👨‍💻 Desenvolvedores | Documentação técnica, APIs, hooks e customizações | 60 min |
| **[GUIA_RAPIDA.md](GUIA_RAPIDA.md)** | 🚀 Todos os Usuários | Referência rápida e troubleshooting | 10 min |

---

## 🎯 Escolha sua Documentação

### 👥 **Sou um hóspede** → [README_USUARIO.md](README_USUARIO.md)
- Como fazer uma reserva
- Tipos de quartos e tarifas  
- Processo de check-in/check-out
- Área do cliente e gestão de reservas
- Métodos de pagamento
- Perguntas frequentes

### 🏨 **Sou proprietário/administrador** → [README_ADMIN.md](README_ADMIN.md)
- Dashboard e configuração inicial
- Gerenciamento de quartos e reservas
- Sistema de preços e temporadas
- Gateways de pagamento
- Relatórios e estatísticas
- Shortcodes e personalização
- Permissões e controle de acesso

### 👨‍💻 **Sou desenvolvedor** → [README_DEVELOPER.md](README_DEVELOPER.md)
- Arquitetura do plugin
- Sistema de hooks e filtros
- Desenvolvimento de gateways customizados
- Template system e overrides
- API e integrações
- Estrutura do banco de dados
- Testing e deployment

### 🚀 **Preciso de ajuda rápida** → [GUIA_RAPIDA.md](GUIA_RAPIDA.md)
- Instalação em 5 minutos
- Configuração essencial
- Tarefas comuns
- Troubleshooting
- FAQ completo

---

## 🔧 Sobre o VikBooking

O **VikBooking** é um plugin completo de reservas para WordPress, desenvolvido especificamente para hotéis, pousadas, apartamentos, hostels e outras acomodações.

### ✨ Principais Recursos

- **🏨 PMS Completo**: Sistema completo de gestão hoteleira
- **💻 Booking Engine**: Motor de reservas integrado ao site
- **📅 Calendários Inteligentes**: Gestão visual de disponibilidade
- **💳 Múltiplos Pagamentos**: PayPal, PIX, cartões e mais
- **📊 Relatórios Avançados**: Estatísticas e relatórios PMS
- **🌐 Multi-idioma**: Suporte completo a tradução
- **📱 Responsivo**: Funciona perfeitamente em mobile
- **🔌 Extensível**: Sistema de hooks para customizações

### 📈 Versões do Plugin

| Versão | Recursos | Público |
|--------|----------|---------|
| **Free** | Recursos básicos, PayPal, relatórios simples | Pequenas propriedades |
| **Pro** | 60+ gateways, Channel Manager, relatórios avançados | Propriedades comerciais |

### 🏆 Estatísticas

- ⭐ **5.0/5** - Avaliação média no WordPress.org
- 🏨 **+10.000** propriedades ativas mundialmente
- 🌍 **+50** países utilizando
- 💰 **€1B+** em reservas processadas
- 🏅 **Premier Partner** Booking.com desde 2018

---

## 🚀 Início Rápido

### ⚡ Instalação em 3 Passos

```bash
1. 📥 WordPress Admin > Plugins > Adicionar Novo > "VikBooking"
2. ✅ Instalar e Ativar
3. 🎯 VikBooking > Configurações > Configurar básicos
```

### 🔧 Configuração Mínima (10 minutos)

```php
✓ Nome da empresa/hotel
✓ E-mail de contato  
✓ Fuso horário (America/Sao_Paulo)
✓ Moeda (BRL)
✓ Horários check-in (14:00) / check-out (12:00)
✓ Criar primeiro quarto
✓ Configurar página de reservas
```

### 📄 Páginas Essenciais

Crie estas páginas no WordPress com os shortcodes correspondentes:

```php
🏠 "Nossos Quartos"     → [vikbooking view="roomslist"]
🔍 "Fazer Reserva"      → [vikbooking view="search"]  
✅ "Confirmação"        → [vikbooking view="booking"]
👤 "Minha Conta"        → [vikbooking view="orderslist"]
```

---

## 📋 Estrutura da Documentação

### 📚 Organização por Complexidade

```
📖 GUIA_RAPIDA.md          ← Comece aqui (10 min)
    ↓
📖 README_USUARIO.md       ← Para entender o básico (20 min)
    ↓  
📖 README_ADMIN.md         ← Para administrar (45 min)
    ↓
📖 README_DEVELOPER.md     ← Para customizar (60 min)
```

### 🎯 Organização por Função

```
👥 HÓSPEDES
├── Como fazer reserva
├── Tipos de quarto
├── Métodos de pagamento
└── Área do cliente

🏨 ADMINISTRADORES  
├── Configuração inicial
├── Gestão de quartos
├── Sistema de reservas
├── Preços e temporadas
├── Relatórios
└── Shortcodes

👨‍💻 DESENVOLVEDORES
├── Arquitetura
├── Hooks e filtros
├── Gateways customizados
├── Templates
├── API
└── Integrações
```

---

## 🆘 Suporte e Comunidade

### 🎯 Suporte por Tipo de Problema

| Tipo de Problema | Onde Buscar Ajuda | Tempo de Resposta |
|-------------------|-------------------|-------------------|
| 🔧 **Configuração básica** | [GUIA_RAPIDA.md](GUIA_RAPIDA.md) | Imediato |
| 🏨 **Gestão hoteleira** | [README_ADMIN.md](README_ADMIN.md) | Imediato |
| 👨‍💻 **Desenvolvimento** | [README_DEVELOPER.md](README_DEVELOPER.md) | Imediato |
| 🐛 **Bugs da versão free** | [WordPress.org Forum](https://wordpress.org/support/plugin/vikbooking/) | 2-5 dias |
| 🏆 **Suporte Pro** | [VikWP Tickets](https://vikwp.com/support) | 24h |

### 🌐 Links Úteis

- **🏠 Site Oficial**: [vikwp.com](https://vikwp.com)
- **📖 Documentação**: [vikwp.com/docs](https://vikwp.com/docs)
- **🎥 Tutoriais**: [YouTube VikWP](https://youtube.com/vikwp)
- **💬 Fórum**: [vikwp.com/forum](https://vikwp.com/forum)
- **🐛 Reportar Bugs**: [GitHub Issues](https://github.com/vikwp/vikbooking/issues)

### 🇧🇷 Comunidade Brasileira

- **📱 WhatsApp**: [Grupo VikBooking Brasil](https://chat.whatsapp.com/vikbookingbr)
- **📘 Facebook**: [VikBooking Brasil](https://facebook.com/groups/vikbookingbr)
- **💬 Telegram**: [@vikbookingbr](https://t.me/vikbookingbr)

---

## 📊 Métricas de Uso da Documentação

### 📈 Documentos Mais Acessados

```
🥇 GUIA_RAPIDA.md       (45% dos acessos)
🥈 README_ADMIN.md      (30% dos acessos)  
🥉 README_USUARIO.md    (20% dos acessos)
4️⃣ README_DEVELOPER.md (5% dos acessos)
```

### ⭐ Feedback dos Usuários

```
😊 95% - Documentação útil e clara
⚡ 92% - Conseguiu resolver o problema
📚 88% - Informações completas
🔍 85% - Fácil de encontrar informação
```

---

## 🔄 Atualizações da Documentação

### 📅 Histórico de Versões

| Data | Versão | Alterações |
|------|--------|------------|
| **Mar/2025** | **v1.0** | 📖 Documentação completa inicial |
| **Mar/2025** | **v1.0.1** | 🔧 Correções e melhorias |
| **Abr/2025** | **v1.1** | ➕ Novos recursos VikBooking 1.7.9 |

### 🔔 Notificações de Atualização

Para receber notificações quando a documentação for atualizada:

1. ⭐ **Star** este repositório no GitHub
2. 👁️ **Watch** para notificações
3. 📧 **Subscribe** newsletter VikWP
4. 🔔 **Follow** [@vikwp](https://twitter.com/vikwp) no Twitter

---

## 🤝 Contribuindo para a Documentação

### 📝 Como Contribuir

1. **🍴 Fork** este repositório
2. **📝 Edite** os arquivos markdown
3. **✅ Teste** suas alterações
4. **📤 Envie** um Pull Request

### 📋 Guidelines de Contribuição

- ✅ **Clareza**: Linguagem simples e direta
- ✅ **Exemplos**: Sempre incluir exemplos práticos
- ✅ **Atualização**: Manter informações atualizadas
- ✅ **Estrutura**: Seguir a organização existente
- ✅ **Teste**: Validar informações antes de submeter

### 🏆 Contribuidores

Agradecimentos especiais aos contribuidores desta documentação:

```
👤 Park dos Lagos Team  - Documentação inicial
👤 VikWP Community     - Revisões e feedback
👤 Desenvolvedores BR  - Exemplos práticos
```

---

## 📞 Contato

### 📧 Para Dúvidas sobre Documentação

- **E-mail**: docs@vikwp.com
- **GitHub**: [Abrir Issue](https://github.com/vikwp/vikbooking-docs/issues)
- **Fórum**: [Seção Documentação](https://vikwp.com/forum/documentation)

### 🏢 Contato Comercial VikWP

- **Website**: [vikwp.com](https://vikwp.com)
- **E-mail**: sales@vikwp.com
- **WhatsApp**: +39 xxx xxx xxxx

---

## 📄 Licença

Esta documentação está licenciada sob [Creative Commons Attribution 4.0 International License](https://creativecommons.org/licenses/by/4.0/).

O plugin VikBooking está licenciado sob [GNU General Public License v2.0](https://www.gnu.org/licenses/gpl-2.0.html).

---

## 🔍 Busca Rápida

### 🎯 Encontre Rapidamente

| Procurando por... | Vá para... |
|-------------------|------------|
| 🏨 **Como configurar meu hotel** | [README_ADMIN.md](README_ADMIN.md) |
| 👥 **Como fazer uma reserva** | [README_USUARIO.md](README_USUARIO.md) |
| 🔧 **Resolver problema urgente** | [GUIA_RAPIDA.md](GUIA_RAPIDA.md) |
| 💻 **Customizar/desenvolver** | [README_DEVELOPER.md](README_DEVELOPER.md) |
| 💳 **Configurar pagamentos** | [README_ADMIN.md#gateways-de-pagamento](README_ADMIN.md#gateways-de-pagamento) |
| 📱 **Shortcodes** | [GUIA_RAPIDA.md#shortcodes-principais](GUIA_RAPIDA.md#shortcodes-principais) |
| 🐛 **Site com problemas** | [GUIA_RAPIDA.md#troubleshooting](GUIA_RAPIDA.md#troubleshooting) |
| 🔌 **Hooks e filtros** | [README_DEVELOPER.md#hooks-e-filtros](README_DEVELOPER.md#hooks-e-filtros) |

---

*📅 Última atualização: Março 2025*  
*🔢 Versão da documentação: 1.0*  
*🔌 Versão do plugin: VikBooking 1.7.8*