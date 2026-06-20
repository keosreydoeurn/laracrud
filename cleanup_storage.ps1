Write-Host "Cleaning up storage files from Git..." -ForegroundColor Green

cd C:\Users\SREYDOEURN.KEO\Desktop\simple-blog-system

# Remove cached storage files
Write-Host "Removing cached storage files..." -ForegroundColor Yellow
git rm -r --cached backend/storage/framework/cache/ -ErrorAction SilentlyContinue
git rm -r --cached backend/storage/framework/sessions/ -ErrorAction SilentlyContinue
git rm -r --cached backend/storage/framework/views/ -ErrorAction SilentlyContinue
git rm -r --cached backend/storage/logs/ -ErrorAction SilentlyContinue
git rm -r --cached backend/storage/app/public/ -ErrorAction SilentlyContinue
git rm -r --cached frontend/dist/ -ErrorAction SilentlyContinue
git rm -r --cached frontend/.vite/ -ErrorAction SilentlyContinue

# Update .gitignore
Write-Host "Updating .gitignore..." -ForegroundColor Yellow
@"
# Storage cache files
backend/storage/*.db
backend/storage/*.sqlite
backend/storage/*.sqlite-journal
backend/storage/debugbar/
backend/storage/framework/cache/
backend/storage/framework/sessions/
backend/storage/framework/views/
backend/storage/logs/
backend/storage/app/public/

# Frontend build files
frontend/dist/
frontend/.vite/
frontend/node_modules/

# Composer and NPM
backend/vendor/
frontend/node_modules/
composer.lock
package-lock.json
"@ | Add-Content .gitignore

# Re-add everything
Write-Host "Re-adding files..." -ForegroundColor Yellow
git add .

# Commit
Write-Host "Committing..." -ForegroundColor Yellow
git commit -m "Clean up storage cache and build files"

# Push
Write-Host "Pushing to GitHub..." -ForegroundColor Yellow
git push

Write-Host "✅ Cleanup complete!" -ForegroundColor Green
