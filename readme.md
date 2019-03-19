<p align="center"><img src="https://laravel.com/assets/img/components/logo-laravel.svg"></p>

<p align="center">
Laravel Version: 5.8 | Php Version: 7.2.8
</p>
<h2 align="center"> Laravel Notification System</h2>

A laravel notification system help to send notifications (events & scheduled based) to **landlord** and **tenant**.

**Notification Types:**
- Email (*used mailtrap, so you need to have a mailtrap account.*)
 - Push (*used pusher . make sure to create account* )
- Database
- SMS (*used nexmo, you should have nexmo account.*)

Before installation make sure you have following accounts in order to get notifications and make changes in `.env`.

 - Nexmo (SMS)
 - Pusher (Push Notifications)
 - MailTrap (Mail Server)

Please follow the following guide for installation.

 - `git clone`
 - copy `.env.example` and create `.env`
 - update the `.env` file.
 - `composer install && composer update`
 - `php artisan migrate`
 - `php artisan db:seed`

**Setting Up `.env` File**
Set `.env` accordingly (e.g). Don't forget to change database settings as well.
````
APP_NAME=Notify
APP_URL=http://localhost:8000

BROADCAST_DRIVER=pusher

#create and use mailtrap username and password
MAIL_HOST=smtp.mailtrap.io  
MAIL_PORT=2525  
MAIL_USERNAME=xxxxx
MAIL_PASSWORD=xxxxx
MAIL_ENCRYPTION=tls

#create and use pusher detail
PUSHER_APP_ID=xxxx  
PUSHER_APP_KEY=xxxx  
PUSHER_APP_SECRET=xxxx  
PUSHER_APP_CLUSTER=xxx

#make sure to put your number before migration
PHONE_NUMBER_NEXMO = xxxx

#create & use nexmo key and secret
NEXMO_KEY=xxxx  
NEXMO_SECRET=xxxx
````

**Run Server**
Run php server (e.g)
````
php artisan serve
````
 
<h4 align="center">API Requests</h4>

**Notifications:**

````
GET /api/notifications							list of all notifications.
GET /api/notifications/{userid}/				list of notifications by user id.
GET /api/notifications/{userid}/scheduled		list of scheduled notifications by user id. 
````

**Invoices**
````
GET /api/invoices/								list of all invoices.

/* This post api is only created to generate notifications to landlord */
POST /api/invoices/{invoiceid}/status			update invoice status and set paid also generate notifications for landlord.
````



**(Q#3) How to track email and SMS in case 3rd party doesn't provide the data?**

The most easy way to track **Email** is to set an image tag in that email `<img href="{tracking_url}"/>` and set the `href` to our **tracking url**. That tracking url will have a unique identifier for every email in order to set that email as read.
Tracking url will act like a **webhook** in our application.
Even with that tracking url we can get more customer data like IP, Location etc.

For **SMS** currently i don't see any other option except relying on 3rd party response or sending a link in sms when a customer click on that it will track from that url.
Because sms is a plain text service and there is no run time requests.
