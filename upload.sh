echo "Entrando em modo de UPLOAD"

HOST="ftp.salvamais.saude.ws"
USER="salvamaissaude1"

echo $HOST
PASS=$1

LCD="$PWD/$2/"
RCD="public_html/$2"

EXCLUDE_DEFAULT=" -x \.*.md$ \
        -x conexao.php \
        -x \.*.log$ -x \.*.ts$ -x \.*.scss$ \
        -x \.*.lock$ \
        -x /\..+/$ \
        -X enyalius \
        -X *.yml -X LICENSE -X vendor/ \
        -X CHANGELOG \
        -X package.json \
        -X doc/ \
        -X .git/ \
        -X testes/ \
        -X build/ \
        -X offline \
        -X *.dist \
        -X *.yml \
        -X .gitmodules \
        -X .project \
        -X .vscode/ \
        -X tools/.git\
        -X Profile \
        -X gulpfile.js \
        -X phpunit/ \
        -X nbproject/ \
        -X package.json \
        -X .htaccess \
        -X public_html/css/src/ \
        -X public_html/media/ \
        -X node_modules/ \
        -X composer.json \
        -X doc/ \
        -X z_data/ \
        -X procfile \
        -X .gitignore \
        -X testes/ \
        -X pg_dump "

echo "PWD $PWD \n\n"
FTPURL="ftp://$USER:$PASS@$HOST"

COMAND="set ftp:list-options -a;  
    set ssl:verify-certificate no; 
    set ftp:ssl-allow true; 
    set ftp:ssl-force false;  
    set ftp:ssl-protect-data false; 
    set ftp:ssl-protect-list false; 
    open '$FTPURL';
    lcd $LCD;
    mkdir -f -p $RCD;
    cd $RCD;
    mirror --reverse --verbose --no-symlinks --parallel=10 -x \.*.sh$ $EXCLUDE_DEFAULT "

#Execução
lftp -c "$COMAND"
