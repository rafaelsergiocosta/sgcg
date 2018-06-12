# SGCG

  

## Sistema de Gestão do Conhecimento Gamificado

  

Para executar a aplicação com Docker execute os passos a seguir.

  

Primeiramente adicione o host da aplicação e o host do banco no seu arquivo hosts:

    sudo sed -i "$ a 127.0.0.1    sgcg.rasersoft.com.br" /etc/hosts
    
    sudo sed -i "$ a 127.0.0.1    docker.db" /etc/hosts

  

Posteriormente execute o comando a seguir para rodar a aplicação:

    docker-compose up
