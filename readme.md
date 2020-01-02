npn instal -g yarn
yarn install ...

npm run dev | prod

php artisan make:mail Auth\Register\VerifyMail --markdown=mails.auth.register.confirm

php artisan make:migration add_user_verificaton --table=users

php artisan tinker
>>> $user = factory(\App\Entity\User::class, 200)->create();
