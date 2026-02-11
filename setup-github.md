# 🚀 PANDUAN SETUP GITHUB UNTUK EDUCARE

## 📋 Langkah-langkah Deploy ke GitHub

### **1. Install Git (Jika Belum Ada)**

1. **Download Git**: 
   - Kunjungi: https://git-scm.com/download/win
   - Download versi terbaru untuk Windows

2. **Install Git**:
   - Jalankan installer yang sudah didownload
   - Ikuti wizard instalasi (gunakan setting default)
   - Pastikan "Git Bash" dan "Git GUI" tercentang

3. **Verifikasi Instalasi**:
   ```bash
   git --version
   ```

### **2. Konfigurasi Git (Pertama Kali)**

Buka Command Prompt atau PowerShell, lalu jalankan:

```bash
# Set username Git Anda
git config --global user.name "Nama Anda"

# Set email Git Anda  
git config --global user.email "email@anda.com"

# Verifikasi konfigurasi
git config --list
```

### **3. Deploy Otomatis (Mudah)**

Jalankan script yang sudah disediakan:

```bash
# Double-click file: deploy-to-github.bat
# Atau jalankan di Command Prompt:
deploy-to-github.bat
```

Script ini akan otomatis:
- ✅ Initialize Git repository
- ✅ Add remote origin ke GitHub
- ✅ Add semua file project
- ✅ Commit dengan pesan yang sesuai
- ✅ Push ke GitHub repository

### **4. Deploy Manual (Jika Diperlukan)**

Jika ingin melakukan secara manual:

```bash
# 1. Initialize Git repository
git init

# 2. Add remote repository
git remote add origin https://github.com/ekazahrosafitri6-dot/Educare_ukk2026.git

# 3. Add semua file
git add .

# 4. Commit pertama
git commit -m "Initial commit: EduCare System"

# 5. Set branch utama
git branch -M main

# 6. Push ke GitHub
git push -u origin main
```

### **5. Verifikasi Deploy**

Setelah berhasil push:

1. **Buka Repository**: https://github.com/ekazahrosafitri6-dot/Educare_ukk2026
2. **Cek File**: Pastikan semua file sudah terupload
3. **Cek README**: Pastikan README.md tampil dengan baik

### **6. Setup GitHub Pages (Hosting Gratis)**

Untuk hosting aplikasi di GitHub Pages:

1. **Masuk ke Repository Settings**
2. **Scroll ke bagian "Pages"**
3. **Source**: Pilih "Deploy from a branch"
4. **Branch**: Pilih "main" dan folder "/ (root)"
5. **Save**

URL hosting akan menjadi: `https://ekazahrosafitri6-dot.github.io/Educare_ukk2026/`

### **7. Update Project (Untuk Perubahan Selanjutnya)**

Jika ada perubahan pada project:

```bash
# Add perubahan
git add .

# Commit dengan pesan yang jelas
git commit -m "Update: Deskripsi perubahan"

# Push ke GitHub
git push origin main
```

## 🔧 Troubleshooting

### **Error: Git tidak ditemukan**
- Install Git dari https://git-scm.com/download/win
- Restart Command Prompt setelah instalasi

### **Error: Permission denied**
- Pastikan Anda memiliki akses ke repository
- Cek apakah repository URL benar

### **Error: Repository tidak ditemukan**
- Pastikan repository sudah dibuat di GitHub
- Cek URL repository: https://github.com/ekazahrosafitri6-dot/Educare_ukk2026.git

### **Error: Merge conflict**
```bash
# Pull perubahan terbaru dulu
git pull origin main

# Resolve conflict, lalu:
git add .
git commit -m "Resolve merge conflict"
git push origin main
```

## 📱 Akses Repository

Setelah berhasil deploy:

- **Repository URL**: https://github.com/ekazahrosafitri6-dot/Educare_ukk2026
- **Clone URL**: `git clone https://github.com/ekazahrosafitri6-dot/Educare_ukk2026.git`
- **Download ZIP**: Tersedia di halaman repository

## 🎯 Tips

1. **Commit Sering**: Lakukan commit untuk setiap perubahan penting
2. **Pesan Commit Jelas**: Gunakan pesan yang menjelaskan perubahan
3. **Backup**: GitHub berfungsi sebagai backup project Anda
4. **Dokumentasi**: Update README.md jika ada perubahan fitur
5. **Branching**: Gunakan branch untuk fitur baru (git checkout -b feature-name)

---

**Selamat! Project EduCare Anda sekarang sudah tersedia di GitHub! 🎉**