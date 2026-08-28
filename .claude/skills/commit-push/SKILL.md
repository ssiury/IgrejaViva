---
name: commit-push
description: Commita as mudanças pendentes e dá push para o origin deste repositório (IgrejaViva). Use quando o usuário disser "commita e sobe", "commite e push", "salva isso no git", "sobe pro github" ou rodar /commit-push.
---

Fluxo padrão deste projeto para salvar trabalho: aqui não se abre PR, o
time comita direto na branch atual (normalmente `main`) e dá push. Não
pare para pedir confirmação antes do commit/push em si — o usuário
pedir esta skill já é a confirmação; só pare se algo abaixo pedir
explicitamente.

## 1. Levantar o estado

Rode em paralelo:
- `git status` (nunca `-uall`)
- `git diff` (unstaged) e `git diff --staged`
- `git log -5 --oneline` para manter o estilo de mensagem do repo
  (mensagens curtas, em português, no imperativo — "Adiciona X",
  "Remove Y", "Corrige Z")

Se não houver nenhuma mudança (staged, unstaged ou untracked
relevante), avise o usuário e pare — não crie commit vazio.

## 2. Selecionar o que entra no commit

- Adicione os arquivos relevantes **por nome** — nunca `git add -A`
  nem `git add .`.
- Depois de dar `git add`, rode `git status` de novo e confira que não
  entrou nada estranho (`.env`, credenciais, `vendor/`, `node_modules/`,
  arquivos de build). Se um arquivo suspeito aparecer, olhe o conteúdo
  antes de prosseguir e avise o usuário se parecer segredo.
- Se houver mudanças claramente não relacionadas ao pedido atual (ex.:
  edição manual do usuário em outro arquivo que ele deixou aberto no
  IDE), pode incluir no mesmo commit se fizer sentido temático com a
  mudança em questão — senão pergunte antes de misturar.

## 3. Escrever a mensagem de commit

- Curta (uma linha, às vezes um corpo de 1-2 frases explicando o
  "porquê" quando não for óbvio), em português, imperativo, seguindo o
  estilo do `git log` deste repo.
- Sempre via heredoc (nunca `-m` com `\n` escapado), terminando com:

  ```
  Co-Authored-By: Claude Sonnet 5 <noreply@anthropic.com>
  Claude-Session: <URL da sessão atual>
  ```

## 4. Commitar e dar push

- `git commit -m "$(cat <<'EOF' ... EOF)"`.
- `git push`. O remote já está configurado via SSH
  (`git@github.com:ssiury/IgrejaViva.git`, chave
  `~/.ssh/id_ed25519_github`), então o push deve funcionar sem prompt
  de credencial. Se pedir usuário/senha ou falhar por autenticação,
  pare e avise o usuário em vez de tentar contornar.
- Se o push for rejeitado por estar desatualizado (`rejected` /
  `non-fast-forward`), rode `git fetch` + `git log` para entender o que
  mudou no remoto e avise o usuário — não force push sem autorização
  explícita.

## 5. Ao final

Confirme em 1-2 frases o que foi commitado/pushado (arquivos +
resumo), sem repetir o diff inteiro.
