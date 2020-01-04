npn instal -g yarn
yarn install ...

npm run dev | prod

php artisan make:mail Auth\Register\VerifyMail --markdown=mails.auth.register.confirm

php artisan make:migration add_user_verificaton --table=users

php artisan tinker
>>> $user = factory(\App\Entity\User::class, 30)->create();
>>> $vpngroups = factory(\App\Entity\VpnGroups::class, 30)->create();
>>> $vpnusers = factory(\App\Entity\VpnUsers::class, 150)->create();
