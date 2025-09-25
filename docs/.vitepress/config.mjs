export default {
  lang: 'pt-BR',
  title: 'Documentação – Park dos Lagos',
  description: 'Guia completo do WordPress e do plugin VikBooking para usuários e administradores',
  lastUpdated: true,
  cleanUrls: true,
  themeConfig: {
    search: { provider: 'local' },
    nav: [
      { text: 'Início', link: '/' },
      { text: 'Usuários', link: '/usuario/visao-geral' },
      { text: 'Administradores', link: '/admin/visao-geral' },
      { text: 'Referência', link: '/referencia/glossario' },
      { text: 'Guia Rápido', link: '/guia-rapida' }
    ],
    sidebar: {
      '/usuario/': [
        {
          text: 'Guia do Usuário (Hóspede)',
          items: [
            { text: 'Visão Geral', link: '/usuario/visao-geral' },
            { text: 'Como Reservar', link: '/usuario/como-reservar' },
            { text: 'Pagamentos', link: '/usuario/pagamentos' },
            { text: 'Minha Reserva (alterar/cancelar)', link: '/usuario/minha-reserva' },
            { text: 'Políticas e Privacidade (LGPD)', link: '/usuario/politicas' },
            { text: 'Contato e Suporte', link: '/usuario/contato-suporte' },
            { text: 'Perguntas Frequentes', link: '/usuario/faq' }
          ]
        }
      ],
      '/admin/': [
        {
          text: 'Primeiros Passos',
          items: [
            { text: 'Visão Geral', link: '/admin/visao-geral' },
            { text: 'Acesso e Perfis', link: '/admin/primeiros-passos' },
            { text: 'WordPress Básico', link: '/admin/wordpress-basico' },
            { text: 'Segurança e LGPD', link: '/admin/seguranca-e-lgpd' },
            { text: 'Checklists Rápidos', link: '/admin/checklists' },
            { text: 'FAQ Administrativo', link: '/admin/faq' }
          ]
        },
        {
          text: 'VikBooking – Configuração',
          items: [
            { text: 'Conceitos e Estrutura', link: '/admin/vikbooking/estrutura' },
            { text: 'Configuração Inicial', link: '/admin/vikbooking/configuracao-inicial' },
            { text: 'Quartos e Tipos', link: '/admin/vikbooking/quartos-e-tipos' },
            { text: 'Tarifas e Preços', link: '/admin/vikbooking/tarifas-e-precos' },
            { text: 'Disponibilidade e Restrições', link: '/admin/vikbooking/disponibilidade-e-restricoes' },
            { text: 'Pagamentos', link: '/admin/vikbooking/pagamentos' }
          ]
        },
        {
          text: 'VikBooking – Operação',
          items: [
            { text: 'Reservas (gestão completa)', link: '/admin/vikbooking/reservas' },
            { text: 'E-mails e Modelos', link: '/admin/vikbooking/emails-e-templates' },
            { text: 'Cupons e Descontos', link: '/admin/vikbooking/cupons-descontos' },
            { text: 'Relatórios e Faturas', link: '/admin/vikbooking/relatorios-e-faturas' },
            { text: 'Shortcodes e Widgets', link: '/admin/vikbooking/shortcodes-widgets' },
            { text: 'Cronjobs e Webhooks', link: '/admin/vikbooking/cronjobs-webhooks' },
            { text: 'Backup e Manutenção', link: '/admin/vikbooking/backup-e-manutencao' }
          ]
        }
      ],
      '/referencia/': [
        {
          text: 'Referência',
          items: [
            { text: 'Recursos do VikBooking', link: '/referencia/recursos-vikbooking' },
            { text: 'Glossário', link: '/referencia/glossario' },
            { text: 'Status de Reserva', link: '/referencia/status-de-reserva' },
            { text: 'Shortcodes', link: '/referencia/shortcodes' },
            { text: 'Fluxos Operacionais', link: '/referencia/fluxos' },
            { text: 'Solução de Problemas', link: '/referencia/solucao-de-problemas' }
          ]
        }
      ],
      '/': [
        {
          text: 'Guia Inicial',
          items: [
            { text: 'Guia Rápido', link: '/guia-rapida' }
          ]
        }
      ]
    },
    outline: 'deep',
    editLink: {
      pattern: 'https://github.com/Park-dos-Lagos/website/edit/bk/docs/:path',
      text: 'Sugerir uma edição nesta página'
    },
    footer: {
      message: 'Conteúdo interno — uso exclusivo Park dos Lagos',
      copyright: '© 2025 Park dos Lagos'
    }
  }
}
