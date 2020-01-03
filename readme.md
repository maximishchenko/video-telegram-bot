npn instal -g yarn
yarn install ...

npm run dev | prod

php artisan make:mail Auth\Register\VerifyMail --markdown=mails.auth.register.confirm

php artisan make:migration add_user_verificaton --table=users

php artisan tinker
>>> $user = factory(\App\Entity\User::class, 200)->create();
>>> $vpngroups = factory(\App\Entity\VpnGroups::class, 30)->create();
>>> $vpnusers = factory(\App\Entity\VpnUsers::class, 150)->create();





mkdir -p /root/ca/ssl.key

mkdir -p /root/ca/ssl.crt

mkdir -p /root/ca/ssl.csr/


openssl req -x509 -newkey rsa:1024 -keyout /root/ca/ssl.key/ca.key -out /root/ca/ssl.crt/ca.crt -days 9999 -nodes  -subj "/C=RU/ST=KMV/L=KMV/O=ALFAGROUP/CN=CA"

openssl req -new -newkey rsa:1024 -nodes -keyout /root/ca/ssl.key/ovpn.key -subj /CN=agvpn.gorodavto.lan -out /root/ca/ssl.csr/ovpn.csropenssl ca -config ca.conf -in /root/ssl.csr/ovpn.csr -out /root/ssl.crt/ovpn.crt -batch
openssl ca -config ca.conf -in /root/ssl.csr/ovpn.csr -out /root/ssl.crt/ovpn.crt -batch
