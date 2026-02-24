# Panduan Deployment ke cPanel dengan Git

## Workflow Deployment

### 1. Di PC Lokal (Terminal)
```bash
# Tambahkan semua perubahan ke staging
git add .

# Commit perubahan dengan pesan
git commit -m "Update TourController dan welcome view"

# Push ke repository (GitHub/GitLab/Bitbucket)
git push
```

### 2. Di cPanel (Terminal/SSH)
```bash
# Masuk ke folder project
cd ~/public_html
# atau
cd ~/northsumateratrip

# Pull perubahan terbaru dari repository
git pull origin main
# atau jika branch master
git pull origin master

# Jalankan perintah Laravel untuk update
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Jika ada perubahan database/migration
php artisan migrate --force

# Jika perlu seed data (seperti translations)
php artisan db:seed --class=TranslationSeeder --force

# Optimize untuk production
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Setup Git di cPanel (Pertama Kali)

### A. Clone Repository ke cPanel

1. **Login SSH ke cPanel**
   - Buka Terminal di cPanel atau gunakan SSH client (PuTTY)
   
2. **Clone repository**
   ```bash
   cd ~
   git clone https://github.com/username/northsumateratrip.git
   # atau
   git clone https://gitlab.com/username/northsumateratrip.git
   ```

3. **Setup .env**
   ```bash
   cd northsumateratrip
   cp .env.example .env
   nano .env  # Edit dengan kredensial cPanel
   ```

4. **Install dependencies**
   ```bash
   composer install --optimize-autoloader --no-dev
   ```

5. **Setup permissions**
   ```bash
   chmod -R 775 storage bootstrap/cache
   ```

6. **Run migrations**
   ```bash
   php artisan migrate --force
   php artisan db:seed --force
   ```

### B. Setup Git Credentials (Jika Private Repo)

```bash
# Konfigurasi Git
git config --global user.name "Your Name"
git config --global user.email "your@email.com"

# Untuk HTTPS (akan diminta password setiap pull)
# Atau gunakan Personal Access Token

# Untuk SSH (lebih aman, tidak perlu password)
ssh-keygen -t rsa -b 4096 -C "your@email.com"
cat ~/.ssh/id_rsa.pub
# Copy output dan tambahkan ke GitHub/GitLab SSH Keys
```

## Perintah Git Berguna

```bash
# Cek status perubahan
git status

# Cek branch saat ini
git branch

# Pindah branch
git checkout main

# Lihat log commit
git log --oneline

# Discard perubahan lokal (hati-hati!)
git reset --hard origin/main

# Pull dengan rebase (lebih bersih)
git pull --rebase origin main
```

## Troubleshooting

### Error: "Permission denied (publickey)"
```bash
# Generate SSH key baru
ssh-keygen -t rsa -b 4096
cat ~/.ssh/id_rsa.pub
# Tambahkan ke GitHub/GitLab
```

### Error: "Your local changes would be overwritten"
```bash
# Simpan perubahan lokal
git stash

# Pull perubahan
git pull origin main

# Restore perubahan lokal (jika perlu)
git stash pop
```

### Error: "fatal: not a git repository"
```bash
# Inisialisasi git
git init
git remote add origin https://github.com/username/repo.git
git pull origin main
```

## Automation dengan Git Hooks (Advanced)

Buat file `.git/hooks/post-receive` di server:
```bash
#!/bin/bash
cd /home/username/northsumateratrip
git pull origin main
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

Buat executable:
```bash
chmod +x .git/hooks/post-receive
```

## Best Practices

1. **Jangan commit file .env** - Sudah ada di .gitignore
2. **Jangan commit folder vendor/** - Install via composer
3. **Jangan commit folder node_modules/** - Install via npm
4. **Selalu test di local** sebelum push
5. **Gunakan branch** untuk fitur baru
6. **Backup database** sebelum migrate
7. **Clear cache** setelah pull perubahan

## Quick Commands Cheat Sheet

### Di PC Lokal
```bash
git add .
git commit -m "pesan commit"
git push
```

### Di cPanel
```bash
cd ~/public_html
git pull
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

## Struktur Folder Recommended di cPanel

```
/home/username/
├── public_html/              # Symlink atau copy dari project/public
│   ├── index.php
│   ├── css/
│   └── js/
├── northsumateratrip/        # Git repository
│   ├── app/
│   ├── config/
│   ├── public/              # ← Symlink ke public_html
│   ├── storage/
│   └── .git/
```

### Setup Symlink (Recommended)
```bash
# Backup public_html lama
mv ~/public_html ~/public_html.bak

# Buat symlink
ln -s ~/northsumateratrip/public ~/public_html

# Atau copy isi folder public
cp -r ~/northsumateratrip/public/* ~/public_html/
```
