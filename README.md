<picture>
    <source srcset="public/images/logo.png"  
            media="(prefers-color-scheme: dark)">
    <img src="public/images/logo-dark.png" alt="App Logo">
</picture>

> **Important Note:** This Project is ready for Production. But use code from main branch only. If you find any bug or have any suggestion please create an Issue.

# Local Installation

-   run `git clone URL`
-   run `composer install `
-   run `npm install`
-   run `npm run dev`
-   copy .env.example to .env
-   run `php artisan key:generate`
-   set up your database in the .env
-   run `php artisan migrate --seed`
-   run `php artisan storage:link`
-   run `php artisan serve`
-   then visit `http://localhost:8000 or http://127.0.0.1:8000`.

> **Important Note:** Apps uses Laravel Snappy Package for PDFs. If you are using Linux then no configuration is needed. But in other Operating Systems please refer to [Laravel Snappy Documentation](https://github.com/barryvdh/laravel-snappy).

# Admin Credentials

## Demo

![Apps](public/images/screenshot.jpg)
**Live Demo:** will update soon

# License

**[Creative Commons Attribution 4.0 cc-by-4.0](https://creativecommons.org/licenses/by/4.0/)**
