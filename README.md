# Forms

Forms, a simple WWW form handler as-a-service

## What's this ?

I often find myself in a situation where I need a contact form on a static website
(Hi, [Jekyll](http://jekyllrb.com/) !).
Installing a CMS just to get a form plugin is way too resource-hungry,
and I don't want to code a crappy PHP script that will be copied from site to site
and end up in a bunch of unmaintainable different versions.

So I created Form, a Laravel app that can be set up on a dedicated host,
where you can create as many form handlers as you need.

You configure the field names and validation rules, email notification and redirects
in Form, and then you're ready to implement your custom form on your website.

You will usually point the `action` attribute of your HTML form to Forms.
If you setup a redirect, your users will not even see this application.

## How to use

### Installation

This is a PHP application built with the Laravel Framework.

The app was tested under a PHP/Apache/MySQL setup but any configuration supported by Laravel should work out of the box.

The better option is to install the app on its own subdomain, e.g. `forms.yourdomain.com`.
If your forms are hosted under an HTTPS-enabled server you should make sure they are submitted through HTTPS too.

```bash
# Clone the project
git clone https://github.com/clarkwinkelmann/forms.git
cd forms
# Install dependencies
composer install
# Copy/rename the configuration file .env.example to .env
cp .env.example .env
# Generate a key for your application (will be placed in .env)
php artisan key:generate
# Edit .env to fit your environment
nano .env
# Run the migrations to create the tables
php artisan migrate
```

The app is ready. Have a look at the users section below to get started.

### Users

There is no fancy UI to manage users and the login is done through a basic HTTP auth method.
All users are administrators and have access to the same data.
You can use only one account or create more for convenience.

The `php artisan forms:user` can be used to create and edit users.
You will be prompted to choose an email address and password.
To change a password, run the same command again.

You can access the admin area at `https://formhandlerdomain.com/admin` (of course replacing formhandlerdomain.com with the host where you installed Forms).

### Setting up a form

Use the admin area to create new forms and fields.
All fields are well described so it should be easy.
The `slug` attributes are the ones you will reuse in your HTML.

The `rules` attribute accept any [Laravel-compatible rule string](https://laravel.com/docs/5.2/validation#available-validation-rules).

Then configure your HTML form in the following fashion:

```html
<form action="https://formhandlerdomain.com/forms/YOUR_FORM_SLUG" method="post">
	<input type="text" name="YOUR_FIELD_SLUG">
	<input type="submit">
</form>
```

The handler URL only accepts `post` requests.
There is no route protection whatsoever (e.g. CSRF is disabled).

For optimal user experience, you should validate all the fields **before** sending the form.
HTML5 validation like `required`, `min`, `max`, etc should be enough.
If errors occur, the user will get a page with the field names and linked
Laravel Validator errors as well as a message asking them to go back and retry.

### Getting submissions

Every submission is stored into the database and can be accessed through the admin interface.

You can define a list of emails that will get a notification for each submission in the form attributes.

### After submitting

You can configure Forms to send a confirmation email with a message of your choice to your users (if you have an email field in the form).

You can also configure a redirect that will take the user back to your site (e.g. your own confirmation page) if everything went right.

## Contributing

You are welcome to report bugs in the Issues section or even submit Pull Requests, I'll have a look !

## License

Forms is released under the [MIT license](http://opensource.org/licenses/MIT).
