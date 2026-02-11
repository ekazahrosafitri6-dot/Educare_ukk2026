<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - EduCare</title>
    <link rel="stylesheet" href="/css/style.css">
    <style>
        body {
            background: var( --primary-500);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }
        
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><defs><pattern id="grid" width="50" height="50" patternUnits="userSpaceOnUse"><path d="M 50 0 L 0 0 0 50" fill="none" stroke="rgba(255,255,255,0.05)" stroke-width="1"/></pattern></defs><rect width="100%" height="100%" fill="url(%23grid)"/></svg>');
            opacity: 0.3;
        }
        
        .login-container {
            position: relative;
            z-index: 2;
            width: 100%;
            max-width: 400px;
            padding: var(--spacing-6);
        }
        
        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: var(--radius-2xl);
            padding: var(--spacing-10);
            box-shadow: var(--shadow-xl);
        }
        
        .login-header {
            text-align: center;
            margin-bottom: var(--spacing-8);
        }
        
        .logo {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 80px;
            height: 80px;
            background: var( --primary-500);
            border-radius: var(--radius-2xl);
            margin-bottom: var(--spacing-4);
            font-size: 36px;
            color: white;
        }
        
        .login-title {
            font-size: var(--font-size-2xl);
            font-weight: 700;
            color: var(--primary-500);
            margin-bottom: var(--spacing-2);
        }
        
        .login-subtitle {
            color: var(--primary-800);
            font-size: var(--font-size-sm);
        }
        
        .form-group {
            margin-bottom: var(--spacing-5);
        }
        
        .form-label {
            display: flex;
            align-items: center;
            gap: var(--spacing-2);
            margin-bottom: var(--spacing-2);
            font-weight: 500;
            color: var(--primary-900);
        }
        
        .form-input {
            padding: var(--spacing-4);
            font-size: var(--font-size-base);
            border-radius: var(--radius-xl);
            border: 2px solid var(--secondary-600);
            transition: all var(--transition-fast);
        }
        
        .form-input:focus {
            border-color: var(--primary-500);
            box-shadow: 0 0 0 4px rgba(0, 56, 188, 0.1);
        }
        
        .btn-login {
            width: 100%;
            padding: var(--spacing-4);
            font-size: var(--font-size-base);
            font-weight: 600;
            border-radius: var(--radius-xl);
            margin-bottom: var(--spacing-6);
        }
        
        .error-message {
            background: var(--error-50);
            color: var(--error-600);
            padding: var(--spacing-4);
            border-radius: var(--radius-lg);
            border: 2px solid var(--error-500);
            margin-bottom: var(--spacing-6);
            display: flex;
            align-items: center;
            gap: var(--spacing-2);
            font-size: var(--font-size-sm);
        }
        
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: var(--spacing-2);
            color: var(--primary-800);
            text-decoration: none;
            font-size: var(--font-size-sm);
            transition: color var(--transition-fast);
        }
        
        .back-link:hover {
            color: var(--primary-900);
        }
        
        .login-footer {
            text-align: center;
            margin-top: var(--spacing-6);
            padding-top: var(--spacing-6);
            border-top: 1px solid var(--secondary-600);
        }
        
        .footer-text {
            color: var(--primary-800);
            font-size: var(--font-size-xs);
            margin: 0;
        }
        
        .demo-info {
            background: linear-gradient(135deg, var(--neutral-50), var(--neutral-100));
            border: 2px solid var(--warning-600);
            border-radius: var(--radius-lg);
            padding: var(--spacing-4);
            margin-top: var(--spacing-6);
        }
        
        .demo-title {
            font-weight: 600;
            color: var(--primary-900);
            margin-bottom: var(--spacing-2);
            font-size: var(--font-size-sm);
        }
        
        .demo-credentials {
            font-size: var(--font-size-xs);
            color: var(--primary-800);
            line-height: 1.4;
        }
        
        /* Loading Animation */
        .btn-loading {
            position: relative;
            color: transparent;
        }
        
        .btn-loading::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 20px;
            height: 20px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-top: 2px solid white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            0% { transform: translate(-50%, -50%) rotate(0deg); }
            100% { transform: translate(-50%, -50%) rotate(360deg); }
        }
        
        /* Responsive */
        @media (max-width: 640px) {
            .login-container {
                padding: var(--spacing-4);
            }
            
            .login-card {
                padding: var(--spacing-6);
            }
            
            .logo {
                width: 60px;
                height: 60px;
                font-size: 28px;
            }
            
            .login-title {
                font-size: var(--font-size-xl);
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div class="logo">
                    <div class="icon icon-school icon-2xl"></div>
                </div>
                <h1 class="login-title">Admin Login</h1>
                <p class="login-subtitle">Masuk ke panel administrasi EduCare</p>
            </div>
            
            <?php if (isset($error)): ?>
                <div class="error-message">
                    <div class="icon icon-exclamation icon-sm"></div>
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="/admin/authenticate" id="loginForm">
                <div class="form-group">
                    <label for="username" class="form-label">
                        <div class="icon icon-user icon-sm"></div>
                        Username
                    </label>
                    <input 
                        type="text" 
                        id="username" 
                        name="username" 
                        class="form-input" 
                        placeholder="Masukkan username Anda"
                        required
                        autocomplete="username"
                        value="<?= htmlspecialchars($_POST['username'] ?? '') ?>"
                    >
                </div>
                
                <div class="form-group">
                    <label for="password" class="form-label">
                        <div class="icon icon-lock icon-sm"></div>
                        Password
                    </label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        class="form-input" 
                        placeholder="Masukkan password Anda"
                        required
                        autocomplete="current-password"
                    >
                </div>
                
                <button type="submit" class="btn btn-primary btn-login" id="loginBtn">
                    <span id="loginText">Masuk ke Dashboard</span>
                </button>
            </form>
            
            <div class="text-center">
                <a href="/" class="back-link">
                    <div class="icon icon-arrow-left icon-sm"></div>
                    Kembali ke Beranda
                </a>
            </div>
            
            <div class="login-footer">
                <p class="footer-text">
                    EduCare - Sistem Pengaduan Sarana Sekolah<br>
                    © 2024 Semua hak dilindungi
                </p>
            </div>
        </div>
    </div>
    
    <script>
        // Form submission with loading state
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const btn = document.getElementById('loginBtn');
            const btnText = document.getElementById('loginText');
            
            // Add loading state
            btn.classList.add('btn-loading');
            btn.disabled = true;
            btnText.textContent = 'Memproses...';
            
            // Remove loading state after 3 seconds if form hasn't submitted
            setTimeout(() => {
                if (btn.classList.contains('btn-loading')) {
                    btn.classList.remove('btn-loading');
                    btn.disabled = false;
                    btnText.textContent = 'Masuk ke Dashboard';
                }
            }, 3000);
        });
        
        // Auto-focus on first input
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('username').focus();
        });
        
        // Enter key navigation
        document.getElementById('username').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                document.getElementById('password').focus();
            }
        });
    </script>
</body>
</html>