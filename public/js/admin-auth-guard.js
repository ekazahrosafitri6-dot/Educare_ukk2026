/**
 * Admin Authentication Guard
 * Prevents access to admin pages after logout via browser back button
 */
(function() {
    'use strict';
    
    // Check if user is logged in by verifying session
    function checkAuthStatus() {
        fetch('/admin/check-auth', {
            method: 'GET',
            credentials: 'same-origin',
            cache: 'no-cache'
        })
        .then(response => response.json())
        .then(data => {
            if (!data.authenticated) {
                // User is not authenticated, show popup and redirect
                showLoginRequiredPopup();
            }
        })
        .catch(error => {
            console.error('Auth check failed:', error);
            // On error, assume not authenticated
            showLoginRequiredPopup();
        });
    }
    
    // Show popup when user needs to login
    function showLoginRequiredPopup() {
        // Prevent multiple popups
        if (document.getElementById('authGuardOverlay')) {
            return;
        }
        
        // Create popup overlay
        const overlay = document.createElement('div');
        overlay.id = 'authGuardOverlay';
        overlay.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            z-index: 10000;
            display: flex;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(5px);
        `;
        
        // Create popup content
        const popup = document.createElement('div');
        popup.style.cssText = `
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            text-align: center;
            max-width: 400px;
            width: 90%;
            animation: popupSlideIn 0.3s ease-out;
            position: relative;
        `;
        
        popup.innerHTML = `
            <div style="color: #dc2626; font-size: 48px; margin-bottom: 20px;">
                🔒
            </div>
            <h2 style="color: #1f2937; margin-bottom: 15px; font-size: 24px; font-weight: 600;">
                Akses Ditolak
            </h2>
            <p style="color: #6b7280; margin-bottom: 25px; line-height: 1.5; font-size: 16px;">
                Anda harus login terlebih dahulu untuk mengakses dashboard admin.
            </p>
            <button id="loginRedirectBtn" style="
                background: #2563eb;
                color: white;
                border: none;
                padding: 12px 24px;
                border-radius: 8px;
                font-size: 16px;
                font-weight: 600;
                cursor: pointer;
                transition: all 0.2s;
                box-shadow: 0 2px 4px rgba(37, 99, 235, 0.2);
            " onmouseover="this.style.background='#1d4ed8'; this.style.transform='translateY(-1px)'" 
               onmouseout="this.style.background='#2563eb'; this.style.transform='translateY(0)'">
                Login Sekarang
            </button>
        `;
        
        // Add animation keyframes if not already added
        if (!document.getElementById('authGuardStyles')) {
            const style = document.createElement('style');
            style.id = 'authGuardStyles';
            style.textContent = `
                @keyframes popupSlideIn {
                    from {
                        opacity: 0;
                        transform: scale(0.8) translateY(-20px);
                    }
                    to {
                        opacity: 1;
                        transform: scale(1) translateY(0);
                    }
                }
                @keyframes shake {
                    0%, 100% { transform: translateX(0); }
                    25% { transform: translateX(-5px); }
                    75% { transform: translateX(5px); }
                }
            `;
            document.head.appendChild(style);
        }
        
        overlay.appendChild(popup);
        document.body.appendChild(overlay);
        
        // Handle login button click
        document.getElementById('loginRedirectBtn').addEventListener('click', function() {
            window.location.href = '/admin/login';
        });
        
        // Prevent closing popup by clicking outside
        overlay.addEventListener('click', function(e) {
            if (e.target === overlay) {
                e.preventDefault();
                // Shake animation to indicate popup can't be closed
                popup.style.animation = 'shake 0.5s ease-in-out';
                setTimeout(() => {
                    popup.style.animation = 'popupSlideIn 0.3s ease-out';
                }, 500);
            }
        });
        
        // Prevent ESC key from closing popup
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && document.getElementById('authGuardOverlay')) {
                e.preventDefault();
                // Shake animation
                popup.style.animation = 'shake 0.5s ease-in-out';
                setTimeout(() => {
                    popup.style.animation = 'popupSlideIn 0.3s ease-out';
                }, 500);
            }
        });
    }
    
    // Handle browser back button and page navigation
    function initAuthGuard() {
        // Handle browser back button (pageshow event)
        window.addEventListener('pageshow', function(event) {
            if (event.persisted) {
                // Page was loaded from cache (back button used)
                setTimeout(checkAuthStatus, 100);
            }
        });
        
        // Handle popstate (back/forward button)
        window.addEventListener('popstate', function(event) {
            setTimeout(checkAuthStatus, 100);
        });
        
        // Handle page visibility change (when user returns to tab)
        document.addEventListener('visibilitychange', function() {
            if (!document.hidden) {
                setTimeout(checkAuthStatus, 100);
            }
        });
        
        // Initial check when page loads
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(checkAuthStatus, 100);
        });
        
        // Periodic check every 30 seconds
        setInterval(checkAuthStatus, 30000);
    }
    
    // Initialize auth guard
    initAuthGuard();
    
    // Expose function globally for manual checks
    window.AdminAuthGuard = {
        checkAuth: checkAuthStatus,
        showLoginPopup: showLoginRequiredPopup
    };
})();