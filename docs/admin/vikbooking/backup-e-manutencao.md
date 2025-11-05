---
title: Backup e Manutenção
---

# Backup e Manutenção
Este documento traz procedimentos detalhados e passo-a-passo para backups, verificação e manutenção do site e do plugin VikBooking.

1. Objetivos
- Garantir recuperação rápida do site em caso de falha.
- Minimizar perda de dados de reservas e transações.

2. O que fazer backup (essencial)
- Arquivos do WordPress: todo o diretório do site (tema, plugins, uploads em `wp-content/uploads`).
- Banco de dados: tabelas do WordPress e tabelas específicas do VikBooking.
- Configurações e certificados (quando possível): arquivos de configuração, chaves e certificados SSL.

3. Estratégia e frequência recomendada
- Backups diários: banco de dados (mínimo) — assegura retenção de reservas/alterações.
- Backups semanais: arquivos do site completos.
- Antes de atualizações: criar backup completo (arquivos + banco) imediatamente antes de atualizar WordPress, plugins ou o tema.
- Retenção: manter pelo menos 4 semanas de backups diários e 6 meses de snapshots semanais (ajustar conforme política da organização).

4. Métodos de backup
- Plugin WordPress (recomendado para administradores sem shell):
	- UpdraftPlus, BackWPup, Duplicator, All-in-One WP Migration.
	- Configurar armazenamentos remotos: S3, Google Drive, FTP, ou um servidor de backup.
- Linha de comando / acesso ao servidor (para times técnicos):
	- Backup do banco com mysqldump:

```bash
# Exemplo: exportar banco
mysqldump -u USUARIO -pNOMEDOBANCO > /backups/wwwparkdoslagos_db_$(date +%F).sql
```

	- Compactar arquivos do site:

```bash
tar -czf /backups/wwwparkdoslagos_files_$(date +%F).tar.gz /var/www/html/path-to-site
```

5. Backups de fornecedores (hospedagem/CDN)
- Se o provedor oferece snapshots (p.ex. painel do host), combine snapshots de disco com backups lógicos do banco.

6. Teste de restauração (passo-a-passo)
1) Em ambiente de staging, preparar um host vazio.
2) Restaurar arquivos (untar ou restaurar plugin).
3) Importar SQL para o banco de staging:

```bash
mysql -u USUARIO -pNOMEDOBANCO_STAGING < wwwparkdoslagos_db_YYYY-MM-DD.sql
```

4) Ajustar configurações (URLs, credenciais) se necessário.
5) Verificar operações críticas: formulário de busca/reserva, criação de reserva, envio de e-mail, painéis administrativos.

7. Manutenção programada (janela de manutenção)
- Planejamento: comunicar usuários com antecedência (banner no site e e-mail se necessário).
- Atividades comuns: atualizações de WordPress, plugins (VikBooking, gateways), atualização de tema, aplicação de correções de segurança.
- Pré-checklist:
	- Criar backup completo.
	- Desativar tarefas cron que possam interferir (temporariamente).
	- Notificar equipe de suporte/financeiro.

8. Pós-atualização — checklist de verificação
- Confirmar que o site carrega normalmente (home, páginas principais).
- Testar fluxo de reserva: pesquisa > seleção de quarto > checkout (em ambiente de teste, não cobrar). 
- Verificar envio de e-mails transacionais.
- Conferir logs de erro do PHP/servidor e dos plugins.

9. Logs e monitoramento
- Habilitar logs (servidor e PHP) e rotacioná-los.
- Monitorar alertas de disponibilidade (uptime) e falhas de jobs cron.

10. Políticas de segurança e retenção
- Rotacionar chaves/credenciais de integração (pagamento/webhook) conforme política.
- Controlar acessos administrativos e registrar auditoria.

11. Procedimento de emergência (recuperação rápida)
1) Identificar o último backup íntegro (arquivos + DB).
2) Restaurar banco em host alternativo ou staging.
3) Redirecionar tráfego (modo de manutenção) até validação.
4) Comunicar stakeholders (financeiro, gestão, suporte) com status e ETA.

12. Ferramentas e recomendações
- Plugins: UpdraftPlus (backup agendado e armazenamento remoto), WP-CLI para administração via terminal, strumenti de monitoramento (UptimeRobot, NewRelic).
- Scripts: automatizar mysqldump + upload para storage remoto (S3/FTP) via agendador.

13. Anexos: exemplo de crontab para backup diário (Linux)

```bash
# Backup DB diário às 02:00
0 2 * * * mysqldump -u USUARIO -pSENHA NOME_DB | gzip > /backups/wwwparkdoslagos_db_$(date +\%F).sql.gz

# Backup de arquivos semanais aos domingos às 03:00
0 3 * * 0 tar -czf /backups/wwwparkdoslagos_files_$(date +\%F).tar.gz /var/www/html/path-to-site
```

Observação: adapte caminhos e credenciais ao seu ambiente. Nunca deixe senhas em texto puro em scripts; use variáveis de ambiente ou arquivos de credenciais com permissões restritas.
