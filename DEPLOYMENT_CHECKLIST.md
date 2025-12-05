# 🚀 Deployment Checklist - Upload Migration

## Pre-Deployment Verification ✅

### Local Testing (Complete Before Deployment)
- [ ] Test slider upload - verify file goes to `public/assets/slider/`
- [ ] Test karya seni upload - verify file goes to `public/assets/karya_seni/{user_id}/`
- [ ] Test thumbnail upload - verify file goes to `public/assets/thumbnails/{user_id}/`
- [ ] Test delete karya seni - verify both media and thumbnail files deleted
- [ ] Test delete slider - verify file deleted
- [ ] Test sambutan image upload - verify file goes to `public/assets/sambutan/`
- [ ] Test all views display images correctly
- [ ] Test with different media types: image, video, youtube link

### Database Verification
- [ ] Run `php artisan migrate:upload-paths --dry-run` and review changes
- [ ] Run `php artisan migrate:upload-paths` to apply database migrations

---

## Files to Deploy

### Core Files (Must Deploy)
1. `app/Http/Controllers/SliderController.php` - ✅ Updated
2. `app/Http/Controllers/SenimanDashboardController.php` - ✅ Updated
3. `app/Http/Controllers/SambutanController.php` - ✅ Updated
4. `app/Console/Commands/MigrateUploadPaths.php` - ✅ New
5. `resources/views/sambutan.blade.php` - ✅ Updated
6. `resources/views/admin/kata-sambutan.blade.php` - ✅ Updated

### Folder Structure (Must Create)
1. `public/assets/slider/` - ✅ Exists
2. `public/assets/karya_seni/` - ✅ Exists
3. `public/assets/thumbnails/` - ✅ Exists
4. `public/assets/sambutan/` - ✅ Exists
5. `public/assets/.htaccess` - ✅ Created

### Documentation (Optional but Recommended)
1. `UPLOAD_MIGRATION_GUIDE.md` - ✅ Created
2. `MIGRATION_COMPLETE.md` - ✅ Created

---

## Hostinger Deployment Steps

### Step 1: Upload Files via FTP/File Manager
```
Upload these files to: /public_html/

app/Http/Controllers/SliderController.php
app/Http/Controllers/SenimanDashboardController.php
app/Http/Controllers/SambutanController.php
app/Console/Commands/MigrateUploadPaths.php
resources/views/sambutan.blade.php
resources/views/admin/kata-sambutan.blade.php
```

### Step 2: Create Folder Structure via FTP/File Manager
```
Create these directories in /public_html/public/assets/:

public/assets/slider/
public/assets/karya_seni/
public/assets/thumbnails/
public/assets/sambutan/
```

### Step 3: Upload .htaccess File
```
Upload to: /public_html/public/assets/.htaccess

Content should already be in the file:
- Allow media files
- Disable PHP execution
```

### Step 4: Update Environment File
Edit `.env` on Hostinger:
```
APP_URL=https://yourdomain.com
APP_ENV=production
APP_DEBUG=false
```

### Step 5: Run Database Migration (Via SSH/Terminal)
```bash
cd public_html
php artisan migrate:upload-paths
```

### Step 6: Clear Application Cache
```bash
php artisan cache:clear
php artisan config:clear
```

### Step 7: Verify Deployment
- [ ] Visit admin panel - no errors
- [ ] Check /assets/images folder loads
- [ ] Test upload a slider image - verify it shows on homepage
- [ ] Check browser console for any 404 errors
- [ ] Test download a uploaded file

---

## Troubleshooting Guide

### Issue: Images still show 404
**Solution:**
1. Check `.env` has correct `APP_URL=https://yourdomain.com`
2. Run `php artisan config:clear`
3. Verify files actually exist in `public/assets/` folder on hosting

### Issue: Upload fails with permission error
**Solution:**
1. Check folder permissions: should be `755` or `775`
2. Ensure web server user can write to folder
3. Contact Hostinger support if permission issue persists

### Issue: Sambutan images not loading
**Solution:**
1. Run `php artisan migrate:upload-paths` if not done yet
2. Check database paths were updated: should start with `assets/` not `storage/`
3. Verify `.env` APP_URL is correct

### Issue: Old storage/assets paths still referenced
**Solution:**
1. Verify all controller files were uploaded
2. Verify all view files were updated
3. Run database migration: `php artisan migrate:upload-paths`

### Issue: "No such file or directory" when uploading
**Solution:**
1. Ensure folder structure exists: `public/assets/slider/` etc
2. Ensure folders are writable by web server
3. Check disk space is available on hosting

---

## Rollback Plan (If Needed)

### Quick Rollback
If migration fails and you need to revert:

1. **Restore old controller files** from git:
   ```bash
   git checkout app/Http/Controllers/SliderController.php
   git checkout app/Http/Controllers/SenimanDashboardController.php
   git checkout app/Http/Controllers/SambutanController.php
   ```

2. **Restore old views:**
   ```bash
   git checkout resources/views/sambutan.blade.php
   git checkout resources/views/admin/kata-sambutan.blade.php
   ```

3. **Revert database paths** (if migration was applied):
   - Connect to database
   - Run SQL:
     ```sql
     UPDATE karya_seni 
     SET media_path = CONCAT('storage/', media_path) 
     WHERE media_path LIKE 'karya_seni%';
     
     UPDATE karya_seni 
     SET thumbnail = CONCAT('storage/', thumbnail) 
     WHERE thumbnail LIKE 'thumbnails%';
     
     UPDATE slider_images 
     SET file_path = CONCAT('storage/', file_path) 
     WHERE file_path LIKE 'assets/slider%';
     ```

4. **Clear cache:**
   ```bash
   php artisan cache:clear
   php artisan config:clear
   ```

---

## Success Indicators ✅

After deployment, verify:

- [ ] Admin panel loads without errors
- [ ] Slider images display on homepage
- [ ] Can upload new slider images successfully
- [ ] Can upload new karya seni successfully
- [ ] Can upload thumbnails successfully
- [ ] Can upload sambutan images successfully
- [ ] Browser network tab shows no 404 errors for assets
- [ ] Sambutan page displays all images correctly
- [ ] Admin sambutan editor loads images correctly
- [ ] Deleting items removes associated files

---

## Important Notes

⚠️ **Do NOT delete `storage/app/public/` folder** - May contain existing backups

⚠️ **Backup database before migration** - Always backup before running database commands

⚠️ **Test on localhost first** - Thoroughly test all uploads/downloads before going live

⚠️ **Update APP_URL correctly** - Asset paths depend on correct APP_URL setting

---

## Support Contact Information

For deployment issues on Hostinger:
- **Hostinger Support:** [https://hpanel.hostinger.com/](https://hpanel.hostinger.com/)
- **SSH Access:** Usually available in hPanel
- **File Manager:** Available in hPanel for direct folder/file uploads

---

## Post-Deployment Monitoring

After deployment, monitor for:
- [ ] Any PHP errors in `/home/youruser/logs/` folder
- [ ] Storage/disk usage growth
- [ ] Upload success rates
- [ ] Image loading performance

---

## Version Information

- **Migration Type:** Storage → Public Assets
- **Deployed Date:** _______________
- **Deployed By:** _______________
- **Status:** ⏳ Pending / ✅ Complete / ❌ Rolled Back
- **Notes:** _______________

---

**Last Updated:** December 5, 2025
