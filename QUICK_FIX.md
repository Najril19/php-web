# Quick Fix Guide - "Target class [view] does not exist"

## 🚨 Emergency Fix (1 minute)

If your Laravel app on Railway is showing "Target class [view] does not exist":

```bash
# Run this in your Railway container/terminal:
mkdir -p bootstrap/cache storage/framework/sessions storage/framework/views storage/framework/cache/data && \
chmod -R 775 storage bootstrap/cache && \
php artisan config:clear && \
php artisan cache:clear && \
php artisan view:clear
```

Then restart your Railway deployment.

## 📋 Proper Deployment (5 minutes)

### Step 1: Use the deployment script
```bash
chmod +x deploy.sh
./deploy.sh
```

### Step 2: Restart Railway
Go to Railway dashboard → Your service → Restart

### Step 3: Verify
Visit your app URL - error should be gone!

## 🔍 Still Not Working?

### Check 1: Environment Variables
Ensure these are set in Railway:
- `APP_KEY` (generate with `php artisan key:generate --show`)
- `DATABASE_URL` (your PostgreSQL connection string)
- `APP_ENV=production`

### Check 2: Directories Exist
```bash
ls -la bootstrap/cache
ls -la storage/framework/views
```

### Check 3: Permissions
```bash
chmod -R 775 storage bootstrap/cache
```

### Check 4: Clear Everything
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
rm -f bootstrap/cache/*.php
```

## 📚 More Help?

- Detailed guide: See `FIX_VIEW_ERROR.md`
- Deployment notes: See `DEPLOYMENT_FIX.md`
- FrankenPHP specifics: See `FRANKENPHP_NOTES.md`
- All changes: See `CHANGES_SUMMARY.md`

## ✅ Success Indicators

You'll know it's fixed when:
- No "Target class [view] does not exist" error
- Application loads in browser
- Login/register pages are accessible
- No errors in logs

## 🆘 Last Resort

If nothing works:
1. Delete `bootstrap/cache/*` and `storage/framework/cache/*`
2. Run `composer install --optimize-autoloader --no-dev`
3. Run `php artisan config:clear`
4. Restart Railway deployment
5. Check Railway logs for other errors
