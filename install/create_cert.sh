#
# This script will create a server certificate/private key pair for use with AWS
#
# usage : ./create_cert.sh foundation-number  (ex. 20)
#
if [ -z $1 ]; then
  echo "Usage : ./create_cert.sh foundation-number (ex. 20)"
  exit 1
fi

FN=$1
echo "Creating certs for foundation $FN"

TEMP_PRIVATE_KEY=temp-private-key.pem
TEMP_CSR=temp-csr.pem
DNS_WILDCARD=*.foundation-$FN.edu.pcfdemo.com
CERT_FILE=certs/foundation-$FN-certificate.pem
KEY_FILE=certs/foundation-$FN-private.key

openssl genrsa -out $TEMP_PRIVATE_KEY 2048
openssl req -sha256 -new -key $TEMP_PRIVATE_KEY -out $TEMP_CSR<<EOF
US
Missouri
Saint Louis
Pivotal
Training
$DNS_WILDCARD
mjeffries@pivotal.io


EOF
openssl x509 -req -days 365 -in $TEMP_CSR -signkey $TEMP_PRIVATE_KEY -out ./$CERT_FILE
openssl rsa -in $TEMP_PRIVATE_KEY -outform PEM>./$KEY_FILE

rm $TEMP_PRIVATE_KEY
rm $TEMP_CSR

echo "Uploading"

aws iam upload-server-certificate --server-certificate-name foundation-$FN --certificate-body file://$CERT_FILE --private-key file://$KEY_FILE


echo "Completed"




