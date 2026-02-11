/**
 * Student Portal JavaScript
 * Handles all functionality for the integrated student portal
 */

// Global variables
let currentNIS = '';  // Variable untuk menyimpan NIS siswa saat ini

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    initializeTabs();      // Inisialisasi fungsi tab navigation
    initializeForm();      // Inisialisasi fungsi form handling
    initializeNISSync();   // Inisialisasi sinkronisasi NIS antar tab
});

// Tab functionality
function initializeTabs() {
    // Ambil semua tombol tab dan tambahkan event listener
    document.querySelectorAll('.tab-button').forEach(button => {
        button.addEventListener('click', () => {
            const tabId = button.getAttribute('data-tab');  // Ambil ID tab dari attribute
            switchTab(tabId);  // Panggil fungsi untuk switch tab
        });
    });
}

function switchTab(tabId) {
    // Hapus class active dari semua tab dan pane
    document.querySelectorAll('.tab-button').forEach(b => b.classList.remove('active'));
    document.querySelectorAll('.tab-pane').forEach(p => p.classList.remove('active'));
    
    // Tambahkan class active ke tab dan pane yang dipilih
    document.querySelector(`[data-tab="${tabId}"]`).classList.add('active');
    document.getElementById(tabId).classList.add('active');
}

// Form functionality
function initializeForm() {
    const form = document.getElementById('aspirationForm');    // Ambil element form aspirasi
    const ketTextarea = document.getElementById('ket');        // Ambil textarea keterangan
    const ketCounter = document.getElementById('ket-counter'); // Ambil element counter karakter
    
    // Character counter - hitung karakter yang diketik
    if (ketTextarea && ketCounter) {
        ketTextarea.addEventListener('input', function() {
            const length = this.value.length;  // Hitung panjang teks
            ketCounter.textContent = length;   // Update counter display
            
            // Ubah warna jika mendekati batas maksimal (50 karakter)
            if (length >= 50) {
                ketCounter.parentElement.style.color = '#ef4444';  // Merah jika >= 50
            } else {
                ketCounter.parentElement.style.color = '#64748b';  // Abu-abu jika < 50
            }
        });
    }

    // Form submission - handle submit form
    if (form) {
        form.addEventListener('submit', handleFormSubmit);  // Tambahkan event listener submit
    }
}

async function handleFormSubmit(e) {
    e.preventDefault();
    
    console.log('Form submitted');
    
    // Clear previous errors
    clearErrors();
    
    // Get form data
    const formData = new FormData(e.target);
    const data = Object.fromEntries(formData);
    
    console.log('Form data:', data);
    
    // Validate
    if (!validateForm(data)) {
        console.log('Form validation failed');
        return;
    }
    
    // Show loading
    const submitBtn = e.target.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '⏳ Mengirim...';
    submitBtn.disabled = true;
    
    try {
        console.log('Sending request to /student/submit');
        
        const response = await fetch('/student/submit', {
            method: 'POST',
            body: formData
        });
        
        console.log('Response status:', response.status);
        console.log('Response headers:', response.headers);
        
        if (response.ok) {
            // Try to get response text
            const responseText = await response.text();
            console.log('Response text:', responseText);
            
            // Check if it's a redirect or contains success message
            if (responseText.includes('berhasil') || responseText.includes('success') || response.redirected) {
                showMessage('success', '✅ Aspirasi berhasil dikirim!');
                
                // Reset form on success
                e.target.reset();
                if (document.getElementById('ket-counter')) {
                    document.getElementById('ket-counter').textContent = '0';
                }
                
                // Store NIS for other tabs
                currentNIS = data.nis;
                syncNISFields();
            } else {
                showMessage('error', '❌ Gagal mengirim aspirasi. Silakan coba lagi.');
            }
        } else {
            const errorText = await response.text();
            console.error('Server error:', errorText);
            showMessage('error', '❌ Server error: ' + response.status);
        }
    } catch (error) {
        console.error('Network error:', error);
        showMessage('error', '❌ Terjadi kesalahan jaringan: ' + error.message);
    } finally {
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    }
}

function validateForm(data) {
    let isValid = true;
    
    if (!data.nis || parseInt(data.nis) <= 0) {
        showFieldError('nis', 'NIS harus diisi dengan angka yang valid');
        isValid = false;
    }
    
    if (!data.kelas || !data.kelas.trim()) {
        showFieldError('kelas', 'Kelas harus diisi');
        isValid = false;
    }
    
    if (!data.id_kategori) {
        showFieldError('kategori', 'Kategori harus dipilih');
        isValid = false;
    }
    
    if (!data.lokasi || !data.lokasi.trim()) {
        showFieldError('lokasi', 'Lokasi harus diisi');
        isValid = false;
    }
    
    if (!data.ket || !data.ket.trim()) {
        showFieldError('ket', 'Keterangan harus diisi');
        isValid = false;
    }
    
    return isValid;
}

// NIS synchronization
function initializeNISSync() {
    const nisInput = document.getElementById('nis');
    if (nisInput) {
        nisInput.addEventListener('blur', function() {
            currentNIS = this.value;
            syncNISFields();
        });
    }
}

function syncNISFields() {
    if (currentNIS) {
        const feedbackNIS = document.getElementById('feedback-nis');
        const historyNIS = document.getElementById('history-nis');
        
        if (feedbackNIS) feedbackNIS.value = currentNIS;
        if (historyNIS) historyNIS.value = currentNIS;
    }
}

// Load feedback data
async function loadFeedback() {
    const nis = document.getElementById('feedback-nis').value;
    if (!nis) {
        Swal.fire({
            title: 'NIS Diperlukan',
            text: 'Masukkan NIS terlebih dahulu',
            icon: 'warning',
            confirmButtonColor: '#2E5AA7'
        });
        return;
    }
    
    const resultsDiv = document.getElementById('feedback-results');
    showLoading(resultsDiv);
    
    try {
        const response = await fetch(`/api/student/feedback?nis=${nis}`);
        const data = await response.json();
        
        if (data.error) {
            showEmptyState(resultsDiv, '📭', 'Tidak Ada Data', data.error);
        } else {
            renderFeedbackData(resultsDiv, data.data);
        }
    } catch (error) {
        showErrorMessage(resultsDiv, '❌ Gagal memuat feedback');
    }
}

function renderFeedbackData(container, aspirations) {
    let html = `
        <div style="margin-bottom: 20px;">
            <h3 style="color: #0f172a;">Ditemukan ${aspirations.length} aspirasi</h3>
        </div>
    `;
    
    aspirations.forEach(aspiration => {
        const statusClass = getStatusClass(aspiration.status);
        const statusIcon = getStatusIcon(aspiration.status);
        
        html += `
            <div class="card">
                <div class="card-header">
                    <div>
                        <h3 class="card-title">ID: ${aspiration.id_pelaporan}</h3>
                        <p style="margin: 0; color: #64748b; font-size: 14px;">
                            ${aspiration.ket_kategori || 'Kategori tidak diketahui'}
                        </p>
                    </div>
                    <span class="status-badge ${statusClass}">
                        ${statusIcon} ${aspiration.status || 'Belum Diproses'}
                    </span>
                </div>
                <div class="card-body">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 16px;">
                        <div>
                            <p style="font-weight: 600; margin-bottom: 4px; color: #0f172a;">📍 Lokasi</p>
                            <p style="margin: 0; color: #1e293b;">${aspiration.lokasi}</p>
                        </div>
                        <div>
                            <p style="font-weight: 600; margin-bottom: 4px; color: #0f172a;">📅 Tanggal</p>
                            <p style="margin: 0; color: #1e293b;">
                                ${formatDate(aspiration.created_at || aspiration.submitted_at)}
                            </p>
                        </div>
                    </div>
                    
                    <div style="background: #f0f9ff; border-left: 4px solid #3b82f6; padding: 16px; border-radius: 8px; margin-bottom: 16px;">
                        <p style="font-weight: 600; margin-bottom: 8px; color: #0f172a;">📝 Keterangan</p>
                        <p style="margin: 0; color: #1e293b;">${aspiration.ket}</p>
                    </div>
                    
                    ${aspiration.feedback ? `
                        <div style="background: #ecfdf5; border-left: 4px solid #059669; padding: 16px; border-radius: 8px; margin-bottom: 16px;">
                            <p style="font-weight: 600; margin-bottom: 8px; color: #065f46;">💬 Feedback Admin</p>
                            <p style="margin: 0; color: #1e293b;">${aspiration.feedback}</p>
                        </div>
                    ` : `
                        <div class="alert alert-info" style="margin-bottom: 16px;">
                            <strong>ℹ️ Info:</strong> Belum ada feedback dari admin untuk aspirasi ini.
                        </div>
                    `}
                    
                    <!-- Progress Timeline -->
                    ${aspiration.audit_trail && aspiration.audit_trail.length > 0 ? `
                        <div style="background: #fafafa; border-radius: 8px; padding: 16px;">
                            <h4 style="margin-bottom: 12px; color: #0f172a;">📊 Timeline Progress</h4>
                            <div class="timeline">
                                ${aspiration.audit_trail.map(audit => `
                                    <div class="timeline-item">
                                        <div class="timeline-dot"></div>
                                        <div style="background: white; border: 1px solid #e2e8f0; border-radius: 6px; padding: 12px;">
                                            <p style="font-weight: 600; margin-bottom: 4px; color: #0f172a; font-size: 14px;">
                                                ${getAuditIcon(audit.action_type)} ${getAuditTitle(audit.action_type)}
                                            </p>
                                            <p style="margin: 0; color: #64748b; font-size: 12px;">
                                                ${formatDate(audit.created_at)} ${audit.admin_username ? `oleh ${audit.admin_username}` : ''}
                                            </p>
                                            ${audit.new_value ? `<p style="margin: 6px 0 0 0; color: #1e293b; font-size: 13px;">${audit.new_value}</p>` : ''}
                                        </div>
                                    </div>
                                `).join('')}
                            </div>
                        </div>
                    ` : ''}
                </div>
            </div>
        `;
    });
    
    container.innerHTML = html;
}

// Load history data
async function loadHistory() {
    const nis = document.getElementById('history-nis').value;
    if (!nis) {
        Swal.fire({
            title: 'NIS Diperlukan',
            text: 'Masukkan NIS terlebih dahulu',
            icon: 'warning',
            confirmButtonColor: '#2E5AA7'
        });
        return;
    }
    
    const resultsDiv = document.getElementById('history-results');
    showLoading(resultsDiv);
    
    try {
        const response = await fetch(`/api/student/history?nis=${nis}`);
        const data = await response.json();
        
        if (data.error) {
            showEmptyState(resultsDiv, '📭', 'Tidak Ada Data', data.error);
        } else {
            renderHistoryData(resultsDiv, data.data);
        }
    } catch (error) {
        showErrorMessage(resultsDiv, '❌ Gagal memuat riwayat');
    }
}

function renderHistoryData(container, aspirations) {
    // Statistics
    const totalCount = aspirations.length;
    const menungguCount = aspirations.filter(a => a.status === 'Menunggu').length;
    const prosesCount = aspirations.filter(a => a.status === 'Proses').length;
    const selesaiCount = aspirations.filter(a => a.status === 'Selesai').length;
    
    let html = `
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px;">
            <div style="background: white; border: 2px solid #e2e8f0; border-radius: 12px; padding: 24px; text-align: center;">
                <div style="font-size: 2rem; margin-bottom: 8px;">📊</div>
                <h3 style="font-size: 24px; font-weight: 700; margin: 0; color: #1e40af;">${totalCount}</h3>
                <p style="margin: 0; color: #64748b; font-size: 14px;">Total Aspirasi</p>
            </div>
            <div style="background: white; border: 2px solid #e2e8f0; border-radius: 12px; padding: 24px; text-align: center;">
                <div style="font-size: 2rem; margin-bottom: 8px;">🔄</div>
                <h3 style="font-size: 24px; font-weight: 700; margin: 0; color: #2563eb;">${prosesCount}</h3>
                <p style="margin: 0; color: #64748b; font-size: 14px;">Dalam Proses</p>
            </div>
            <div style="background: white; border: 2px solid #e2e8f0; border-radius: 12px; padding: 24px; text-align: center;">
                <div style="font-size: 2rem; margin-bottom: 8px;">✅</div>
                <h3 style="font-size: 24px; font-weight: 700; margin: 0; color: #059669;">${selesaiCount}</h3>
                <p style="margin: 0; color: #64748b; font-size: 14px;">Selesai</p>
            </div>
        </div>
        
        <h3 style="margin-bottom: 20px; color: #0f172a;">Timeline Aspirasi</h3>
        <div class="timeline">
    `;
    
    aspirations.forEach((aspiration, index) => {
        const statusClass = getStatusClass(aspiration.status);
        const statusIcon = getStatusIcon(aspiration.status);
        
        html += `
            <div class="timeline-item">
                <div class="timeline-dot"></div>
                <div class="card">
                    <div class="card-header">
                        <div>
                            <h3 class="card-title">${aspiration.ket_kategori || 'Kategori tidak diketahui'}</h3>
                            <p style="margin: 0; color: #64748b; font-size: 12px;">
                                ID: ${aspiration.id_pelaporan} • ${formatDate(aspiration.created_at || aspiration.submitted_at)}
                            </p>
                        </div>
                        <span class="status-badge ${statusClass}">
                            ${statusIcon} ${aspiration.status || 'Belum Diproses'}
                        </span>
                    </div>
                    <div class="card-body">
                        <p style="font-weight: 600; margin-bottom: 4px; color: #0f172a;">📍 Lokasi: ${aspiration.lokasi}</p>
                        <p style="font-weight: 600; margin-bottom: 4px; color: #0f172a;">📝 Keterangan: ${aspiration.ket}</p>
                        
                        ${aspiration.feedback ? `
                            <div style="background: #ecfdf5; border-left: 4px solid #059669; padding: 12px; border-radius: 8px; margin-top: 12px;">
                                <p style="font-weight: 600; margin-bottom: 4px; color: #065f46;">💬 Feedback Admin</p>
                                <p style="margin: 0; color: #1e293b;">${aspiration.feedback}</p>
                            </div>
                        ` : ''}
                    </div>
                </div>
            </div>
        `;
    });
    
    html += '</div>';
    container.innerHTML = html;
}

// Helper functions
function getStatusClass(status) {
    switch (status) {
        case 'Menunggu': return 'status-menunggu';
        case 'Proses': return 'status-proses';
        case 'Selesai': return 'status-selesai';
        default: return 'status-menunggu';
    }
}

function getStatusIcon(status) {
    switch (status) {
        case 'Menunggu': return '⏳';
        case 'Proses': return '🔄';
        case 'Selesai': return '✅';
        default: return '❓';
    }
}

function getAuditIcon(actionType) {
    switch (actionType) {
        case 'created': return '📝';
        case 'status_change': return '🔄';
        case 'feedback_added': return '💬';
        default: return '📋';
    }
}

function getAuditTitle(actionType) {
    switch (actionType) {
        case 'created': return 'Aspirasi Dibuat';
        case 'status_change': return 'Status Diubah';
        case 'feedback_added': return 'Feedback Ditambahkan';
        default: return 'Aktivitas';
    }
}

function formatDate(dateString) {
    if (!dateString) return '-';
    
    const date = new Date(dateString);
    const options = { 
        year: 'numeric', 
        month: 'long', 
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    };
    
    return date.toLocaleDateString('id-ID', options);
}

function showLoading(container) {
    container.innerHTML = `
        <div class="loading show">
            <div class="spinner"></div>
            Memuat data...
        </div>
    `;
}

function showEmptyState(container, icon, title, message) {
    container.innerHTML = `
        <div class="empty-state">
            <div class="icon">${icon}</div>
            <h3>${title}</h3>
            <p>${message}</p>
        </div>
    `;
}

function showErrorMessage(container, message) {
    container.innerHTML = `<div class="alert alert-error">${message}</div>`;
}

function showMessage(type, message) {
    const messagesDiv = document.getElementById('form-messages');
    if (messagesDiv) {
        messagesDiv.innerHTML = `<div class="alert alert-${type}">${message}</div>`;
        
        // Auto hide after 5 seconds
        setTimeout(() => {
            messagesDiv.innerHTML = '';
        }, 5000);
    }
}

function showFieldError(fieldId, message) {
    const errorElement = document.getElementById(fieldId + '-error');
    if (errorElement) {
        errorElement.textContent = message;
        errorElement.style.color = '#ef4444';
        errorElement.style.fontSize = '13px';
        errorElement.style.marginTop = '6px';
        errorElement.style.display = 'block';
    }
}

function clearErrors() {
    document.querySelectorAll('.form-error').forEach(el => el.textContent = '');
}

function clearForm() {
    const form = document.getElementById('aspirationForm');
    if (form) {
        form.reset();
    }
    
    const counter = document.getElementById('ket-counter');
    if (counter) {
        counter.textContent = '0';
    }
    
    clearErrors();
    
    const messages = document.getElementById('form-messages');
    if (messages) {
        messages.innerHTML = '';
    }
}