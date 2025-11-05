---
title: Shortcodes e Widgets
---

# Shortcodes e Widgets
Este documento descreve os shortcodes e widgets disponíveis, parâmetros comuns e exemplos de uso em páginas e temas.

1) Shortcodes principais
- [vikbooking_search] — formulário de busca. Parâmetros comuns: `layout=horizontal|vertical`, `default_checkin=YYYY-MM-DD`.
- [vikbooking_rooms] — listagem de quartos. Parâmetros: `type_id`, `show_images=true|false`, `limit=10`.
- [vikbooking_checkout] — formulário de checkout integrado.

2) Exemplos de uso
- Página de busca simples:

```html
[vikbooking_search layout="horizontal"]
```

- Página com listagem filtrada:

```html
[vikbooking_rooms type_id="3" show_images="true" limit="6"]
```

3) Widgets
- O VikBooking disponibiliza widgets para áreas de sidebar/footer do tema: formulário de busca compacto, calendário e promoções.
- Adicione em Aparência → Widgets e configure os parâmetros no painel.

4) Integração com tema e templates
- Para desenvolvedores, use as funções/shortcodes do plugin dentro de templates PHP: `echo do_shortcode('[vikbooking_rooms]');`.

5) Boas práticas
- Testar shortcodes em páginas de staging antes de publicar.
- Evitar múltiplos shortcodes pesados na mesma página para reduzir latência.

6) Troubleshooting
- Shortcode não renderiza: verificar se o plugin está ativo e se o shortcode está escrito corretamente.
- Imagens não carregam: checar permissões em `wp-content/uploads`.
