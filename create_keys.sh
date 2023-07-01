mkdir ./auth_server/key
mkdir ./resource_server/key
openssl genrsa -aes128 -passout pass:passphrase -out "./auth_server/key/private.key" 2048
openssl rsa -in "./auth_server/key/private.key" -passin pass:passphrase -pubout -out "./resource_server/key/public.pem"
