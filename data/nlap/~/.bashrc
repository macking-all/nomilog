export PS1="[\u@\[\e[0;37m\]nlap \W]$"
# lsの結果を色付きで表示してくれる
alias ls="ls --color=auto"
# ○○するときに、本当に○○していいか聞いてくれる系のエイリアス
alias rm='rm -i'
alias mv='mv -i'
alias cp='cp -i'

# laで隠しファイルも含めて全部表示してくれる
alias ll="ls -la"