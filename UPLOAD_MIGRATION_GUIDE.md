# File Upload Migration Guide

## Overview
This document explains the migration from Laravel's `storage/app/public` uploads to direct `public/assets` storage.

## Why This Change?

**Original Approach (Storage Facade):**
- Files stored in: `storage/app/public/`
- Accessed via symlink: `public/storage/` → `storage/app/public/`
- Issues on shared hosting:
  - Symlinks may not work (permission restrictions)
  - `storage/app/public` not web-accessible by default
  - File access returns 404 on Hostinger

**New Approach (Direct Public Assets):**
- Files stored directly in: `public/assets/`
- Accessed directly: `/assets/filename`
- Advantages:
  - No symlink needed
  - Works immediately on any hosting
  - Files always accessible
  - Simpler path management

## New Folder Structure

```
public/
├── assets/
│   ├── slider/           # Photo slider images
│   ├── karya_seni/       # Artwork uploads (organized by user_id)
│   ├── thumbnails/       # Artwork thumbnails (organized by user_id)
│   ├── sambutan/         # Sambutan page images
│   └── images/           # Static placeholder images
```

## File Path Format Changes

### Before (Storage Facade)
```
storage/karya_seni/1/karya-1701234567-abc12345.jpg
storage/assets/slider/slider-1701234567-abc12345.jpg
```

### After (Direct Public Assets)
```
assets/karya_seni/1/karya-1701234567-abc12345.jpg
assets/slider/slider-1701234567-abc12345.jpg
```

## Database Updates Needed

To migrate existing file paths in database from `storage/` to `assets/` format, run:

```bash
php artisan migrate:upload-paths --dry-run
```

To actually apply changes:

```bash
php artisan migrate:upload-paths
```

This command will:
1. Update all KaryaSeni `media_path` fields (removes `storage/` prefix)
2. Update all KaryaSeni `thumbnail` fields (removes `storage/` prefix)
3. Update all SliderImage `file_path` fields (removes `storage/` prefix)
4. Update all SambutanContent image fields (removes `storage/` prefix)

## Updated Controllers

### SliderController
- **Location:** `app/Http/Controllers/SliderController.php`
- **Changes:**
  - Removed `use Illuminate\Support\Facades\Storage;`
  - Updated `store()`: Moved files directly to `public_path('assets/slider')`
  - Updated `destroy()`: Deleted files using native `unlink()`
  - Database stores relative paths: `assets/slider/filename.jpg`

### SenimanDashboardController
- **Location:** `app/Http/Controllers/SenimanDashboardController.php`
- **Changes:**
  - Removed Storage facade dependency
  - Updated karya media uploads to `public_path('assets/karya_seni/{user_id}')`
  - Updated thumbnail uploads to `public_path('assets/thumbnails/{user_id}')`
  - Updated `deleteKarya()`: Properly deletes files and handles both file uploads and URL links
  - Database stores relative paths: `assets/karya_seni/{user_id}/filename`

### SambutanController
- **Location:** `app/Http/Controllers/SambutanController.php`
- **Changes:**
  - Removed `use Illuminate\Support\Facades\Storage;`
  - Updated `update()`: Moved sambutan images to `public_path('assets/sambutan')`
  - File deletion now uses native `unlink()` instead of Storage facade
  - Database stores relative paths: `assets/sambutan/filename.jpg`

## Blade Template Adjustments

When displaying files in Blade, use the `asset()` helper which works with relative paths:

```blade
<!-- Karya seni media -->
<img src="{{ asset($karyaSeni->media_path) }}" alt="{{ $karyaSeni->judul }}">

<!-- Thumbnail -->
<img src="{{ asset($karyaSeni->thumbnail) }}" alt="Thumbnail">

<!-- Slider image -->
<img src="{{ asset($slider->file_path) }}" alt="Slider">

<!-- Sambutan image -->
<img src="{{ asset($sambutan->hero_image) }}" alt="Hero">
```

## Security Configuration

**.htaccess in `public/assets/`:**
```apache
# Allow access to asset files
<FilesMatch "\.(jpg|jpeg|png|gif|webp|mp4|webm|pdf)$">
    Order allow,deny
    Allow from all
</FilesMatch>

# Disable PHP execution in uploads (security)
php_flag engine off
```

This ensures:
- Only media files can be accessed
- No PHP code execution in upload folder
- Protection against malicious script uploads

## Manual File Migration (If Needed)

If you have existing files in `storage/app/public/`, manually copy them:

```powershell
# From public/storage/karya_seni to public/assets/karya_seni
Copy-Item -Path "public/storage/karya_seni/*" -Destination "public/assets/karya_seni/" -Recurse

# From public/storage/assets/slider to public/assets/slider
Copy-Item -Path "public/storage/assets/slider/*" -Destination "public/assets/slider/" -Recurse

# From public/storage/assets/sambutan to public/assets/sambutan
Copy-Item -Path "public/storage/assets/sambutan/*" -Destination "public/assets/sambutan/" -Recurse

# From public/storage/thumbnails to public/assets/thumbnails
Copy-Item -Path "public/storage/thumbnails/*" -Destination "public/assets/thumbnails/" -Recurse
```

Then run the migration command to update database paths.

## Deployment on Hostinger

1. **Upload new public/assets folder structure** to hosting
2. **Set .env APP_URL** to your Hostinger domain:
   ```
   APP_URL=https://yourdomain.com
   ```
3. **Run database migration** (if existing files):
   ```bash
   php artisan migrate:upload-paths
   ```
4. **Clear application cache:**
   ```bash
   php artisan cache:clear
   php artisan config:clear
   ```
5. **Verify uploads work:**
   - Upload a photo slider image
   - Check if accessible at `https://yourdomain.com/assets/slider/filename.jpg`

## URL Generation Examples

When you upload a file using `$file->move($dir, $filename)`, the relative path is stored in database:
- `assets/slider/slider-1701234567-abc12345.jpg`

In Blade template, use:
```blade
<!-- This generates: /assets/slider/slider-1701234567-abc12345.jpg -->
{{ asset($slider->file_path) }}

<!-- Full URL with domain: -->
{{ asset($slider->file_path) }}
```

Laravel's `asset()` helper automatically prepends APP_URL when necessary.

## Rollback Instructions

If you need to revert to Storage approach:

1. Update `.env` to re-enable storage symlink
2. Run: `php artisan storage:link`
3. Restore original controller code using git:
   ```bash
   git checkout app/Http/Controllers/SliderController.php
   git checkout app/Http/Controllers/SenimanDashboardController.php
   git checkout app/Http/Controllers/SambutanController.php
   ```
4. Run migration command to revert database paths:
   ```bash
   # Create custom rollback command if needed
   ```

## File Upload Limit Configuration

For large file uploads (video), ensure `.htaccess` allows large files:

```apache
# In public/assets/.htaccess
php_value upload_max_filesize 100M
php_value post_max_size 100M
```

Or configure in PHP settings directly.

## Troubleshooting

### Files not accessible (404)
- Check `.htaccess` in `public/assets/`
- Verify APP_URL is correct in `.env`
- Check file permissions: Should be readable by web server

### Files show in database but not on display
- Run `php artisan migrate:upload-paths` to update paths
- Check Blade templates use `asset()` helper
- Verify file actually exists in `public/assets/` folder

### Upload fails
- Check `public/assets/` subdirectory exists
- Verify web server has write permissions
- Check PHP `upload_max_filesize` setting

### URLs are broken after migration
- Confirm `.env` APP_URL matches your domain
- Run `php artisan config:clear`
- Check database paths use correct format (should start with `assets/`)
