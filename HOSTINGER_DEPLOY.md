# Hostinger Deployment Guide — Pathoflix (Laravel)

## Server Requirements (Hostinger Premium/Business Plan)
- PHP 8.2+
- MySQL 8.x
- Composer (via SSH)
- mod_rewrite enabled

---

## Step 1: Hostinger hPanel mein MySQL Database Banao

1. hPanel > Databases > MySQL Databases
2. **Database Name** banao: e.g., `u123456_patholabx`
3. **Database User** banao password ke saath
4. User ko database se assign karo (All Privileges)
5. Credentials note karo — `.env` mein lagenge

---

## Step 2: Files Server pe Upload Karo (FTP / File Manager)

### Folder Structure on Server:
```
/home/u123456789/          ← account root
├── public_html/           ← website ka root (domain yahan point karta hai)
│   ├── index.php          ← hostinger_deploy/public_html/index.php
│   └── .htaccess          ← hostinger_deploy/public_html/.htaccess
└── pathoflix/             ← Laravel project yahan upload karo (SABA kuch)
    ├── app/
    ├── bootstrap/
    ├── config/
    ├── database/
    ├── public/            ← Laravel ka public folder (domain directly nahi milega)
    ├── resources/
    ├── routes/
    ├── storage/
    ├── vendor/            ← composer install ke baad banega
    ├── .env               ← manually create karo server pe
    └── artisan
```

### Upload Steps:
1. **FTP/FileManager se** `pathoflix/` folder upload karo account root mein
   - `vendor/` aur `node_modules/` SKIP karo (bade hote hain)
2. `hostinger_deploy/public_html/index.php` → `public_html/index.php` upload karo
3. `hostinger_deploy/public_html/.htaccess` → `public_html/.htaccess` upload karo
4. Laravel ke `public/` folder ka content bhi `public_html/` mein copy karo:
   - `public/build/` → `public_html/build/`
   - `public/vendor/` → `public_html/vendor/`
   - `public/favicon.ico` → `public_html/favicon.ico`

---

## Step 3: SSH Terminal se Commands Chalao

```bash
# pathoflix directory mein jao
cd ~/pathoflix

# Composer install karo (vendor/ generate hoga)
composer install --no-dev --optimize-autoloader

# App Key generate karo
php artisan key:generate

# Database migrate karo
php artisan migrate --force

# Seeders chalao (fresh start)
php artisan db:seed

# Caches optimize karo
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache
```

---

## Step 4: `.env` Server pe Configure Karo

SSH ya File Manager se `~/pathoflix/.env` file create/edit karo:

```env
APP_NAME="Pathoflix"
APP_ENV=production
APP_KEY=         ← key:generate se auto fill hoga
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=u123456_patholabx    ← hPanel se copy karo
DB_USERNAME=u123456_dbuser       ← hPanel se copy karo
DB_PASSWORD=your_db_password

SESSION_DRIVER=file
QUEUE_CONNECTION=database
CACHE_STORE=file

MAIL_MAILER=smtp
MAIL_HOST=smtp.hostinger.com
MAIL_PORT=587
MAIL_USERNAME=noreply@yourdomain.com
MAIL_PASSWORD=your_email_password
MAIL_FROM_ADDRESS="noreply@yourdomain.com"
MAIL_FROM_NAME="Pathoflix"

# Cloudflare R2 Storage
FILESYSTEM_DISK=r2
R2_URL=
R2_ACCESS_KEY_ID=your_r2_key
R2_SECRET_ACCESS_KEY=your_r2_secret
R2_ENDPOINT=https://ACCOUNT_ID.r2.cloudflarestorage.com
R2_BUCKET=pathonixlab
R2_REGION=us-east-1
R2_USE_PATH_STYLE_ENDPOINT=true

# Feature Toggles
FEATURE_IMPERSONATION=false
FEATURE_PARTNER_LOGINS=false
FEATURE_INVENTORY=false
FEATURE_SUPPORT=false
```

---

## Step 5: Permissions Set Karo

```bash
chmod -R 755 ~/pathoflix/storage
chmod -R 755 ~/pathoflix/bootstrap/cache
```

---

## Step 6: Queue Jobs ke liye Cron Job (Hostinger hPanel)

hPanel > Advanced > Cron Jobs mein yeh add karo:

```
* * * * * /usr/local/bin/php /home/u123456789/pathoflix/artisan queue:work --stop-when-empty >> /dev/null 2>&1
```

Ya agar queue heavy nahi hai, toh `.env` mein `QUEUE_CONNECTION=sync` karo — 
queue directly process hoga background job ke bina.

---

## Step 7: Verification

- [ ] https://yourdomain.com khule (500 error nahi)
- [ ] Login kaam kare
- [ ] Invoice create kare
- [ ] PDF generate ho
- [ ] Image upload (R2) kaam kare
- [ ] `storage/logs/laravel.log` mein errors check karo

---

## ⚠️ Common Issues & Fixes

| Issue | Fix |
|-------|-----|
| 500 Error | `APP_DEBUG=true` karo temporarily, error dekho |
| Permission denied | `chmod 777 storage bootstrap/cache` |
| Class not found | `composer dump-autoload` |
| Migration failed | Check DB credentials in `.env` |
| Images not loading | R2 credentials check karo |
| Session/Auth issue | `php artisan config:clear && php artisan cache:clear` |

---

## 📁 Files in `hostinger_deploy/` folder

| File | Upload To |
|------|-----------|
| `public_html/index.php` | `~/public_html/index.php` |
| `public_html/.htaccess` | `~/public_html/.htaccess` |
