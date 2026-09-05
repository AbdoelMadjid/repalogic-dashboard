/**
 * Profil Pengguna - Messages & Chat Module JavaScript
 * Path: public/assets/js/admin/profil-pengguna/messages.js
 */

document.addEventListener('DOMContentLoaded', function() {
    'use strict';

    // Global Config from Blade Bridge
    const config = window.MessagesConfig || {};
    const currentUserId = config.currentUserId || null;
    let currentUserAvatar = config.currentUserAvatar || '';
    const defaultAvatar = config.defaultAvatar || '/assets/images/users/default-avatar.svg';

    function getCsrfToken() {
        return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    }

    const chatContainer = document.getElementById('chat-container');
    const chatForm = document.getElementById('form-send-chat');
    const chatInput = document.getElementById('chat-message-input');
    const activeReceiverInput = document.getElementById('active-receiver-id');
    const activeChatName = document.getElementById('active-chat-name');
    const activeChatRole = document.getElementById('active-chat-role');
    const activeChatAvatar = document.getElementById('active-chat-avatar');
    const btnViewUserDetail = document.getElementById('btn-view-user-detail');
    const btnClearChat = document.getElementById('btn-clear-chat');
    const contactSearchInput = document.getElementById('chat-contact-search');

    // In-Chat Search Elements
    const btnToggleSearch = document.getElementById('btn-toggle-search');
    const inChatSearchBar = document.getElementById('in-chat-search-bar');
    const inputSearchInChat = document.getElementById('input-search-in-chat');
    const btnClearInChatSearch = document.getElementById('btn-clear-in-chat-search');
    const searchMatchCount = document.getElementById('search-match-count');
    const btnSearchPrev = document.getElementById('btn-search-prev');
    const btnSearchNext = document.getElementById('btn-search-next');
    const btnCloseSearch = document.getElementById('btn-close-search');

    // Pinned Message Elements
    const pinnedMessageBanner = document.getElementById('pinned-message-banner');
    const pinnedTextPreview = document.getElementById('pinned-text-preview');
    const btnJumpToPinned = document.getElementById('btn-jump-to-pinned');
    const btnUnpinBanner = document.getElementById('btn-unpin-banner');
    let currentPinnedMessageId = config.initialPinnedMessageId || null;

    // Quick Reaction Elements
    const quickReactionPopover = document.getElementById('quick-reaction-popover');
    let activeReactMessageId = null;

    // Forward Modal Elements
    const forwardModalEl = document.getElementById('forward-message-modal');
    const forwardContactSearch = document.getElementById('forward-contact-search');
    const forwardContactList = document.getElementById('forward-contact-list');
    let activeForwardMessageId = null;

    // Voice Note Recorder Elements
    const btnRecordVoice = document.getElementById('btn-record-voice');
    const voiceRecordingContainer = document.getElementById('voice-recording-container');
    const voiceRecordingTimer = document.getElementById('voice-recording-timer');
    const btnCancelVoice = document.getElementById('btn-cancel-voice');
    const btnSendVoice = document.getElementById('btn-send-voice');
    const chatInputRow = document.getElementById('chat-input-row');

    let activeUserId = activeReceiverInput ? activeReceiverInput.value : '';
    let lastMessageCount = config.initialMessageCount || 0;
    let lastMessageId = config.initialLastMessageId || null;
    let userHasScrolledUp = false;

    // Voice Note MediaRecorder state
    let mediaRecorder = null;
    let audioChunks = [];
    let recordingTimerInterval = null;
    let recordingSeconds = 0;
    let activeAudioPlayer = null;
    let activeAudioBtn = null;
    let activeAudioProgress = null;
    let activeAudioTimeEl = null;

    // In-Chat Search state
    let searchMatches = [];
    let currentSearchIndex = -1;

    // ==========================================
    // HELPER FUNCTIONS (UTILITIES & DOM)
    // ==========================================
    function renderReactionsHtml(msgId, reactions, isSender) {
        if (!reactions || typeof reactions !== 'object') return '';
        let html = '';
        Object.keys(reactions).forEach(function(emoji) {
            const users = reactions[emoji];
            if (Array.isArray(users) && users.length > 0) {
                const hasReacted = users.includes(currentUserId);
                html += `<button type="button" class="btn btn-link p-0 text-decoration-none btn-reaction-pill fs-11 d-inline-flex align-items-center gap-0.5 ${hasReacted ? 'text-primary fw-semibold' : 'text-muted'}" data-msg-id="${msgId}" data-emoji="${emoji}" title="${users.length} orang bereaksi ${emoji}" style="line-height: 1;">
                    <span class="fs-12">${emoji}</span>
                    <span class="fs-11 ${hasReacted ? 'fw-bold text-primary' : 'text-muted opacity-85'}">${users.length}</span>
                </button>`;
            }
        });
        return html;
    }

    function updatePinnedBanner(pinnedMsg) {
        if (!pinnedMessageBanner || !pinnedTextPreview) return;
        if (pinnedMsg) {
            currentPinnedMessageId = pinnedMsg.id;
            const previewText = pinnedMsg.body || (pinnedMsg.attachment_name || (pinnedMsg.attachment_type === 'voice' ? 'Pesan Suara' : 'Lampiran berkas'));
            pinnedTextPreview.textContent = previewText.length > 60 ? previewText.substring(0, 60) + '...' : previewText;
            pinnedMessageBanner.classList.remove('d-none');
        } else {
            currentPinnedMessageId = null;
            pinnedMessageBanner.classList.add('d-none');
        }
    }

    function escapeHtml(text) {
        if (text === null || typeof text === 'undefined') return '';
        return String(text)
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }

    function formatBytes(bytes) {
        if (!bytes || bytes === 0) return '0 B';
        const b = parseInt(bytes, 10);
        if (b >= 1048576) {
            return (b / 1048576).toFixed(1) + ' MB';
        } else if (b >= 1024) {
            return (b / 1024).toFixed(1) + ' KB';
        }
        return b + ' B';
    }

    function setChatContainerHtml(html) {
        if (!chatContainer) return;
        const sbContent = chatContainer.querySelector('.simplebar-content');
        if (sbContent) {
            sbContent.innerHTML = html;
        } else {
            chatContainer.innerHTML = html;
        }
    }

    function appendChatContainerHtml(html) {
        if (!chatContainer) return;
        const sbContent = chatContainer.querySelector('.simplebar-content');
        if (sbContent) {
            sbContent.insertAdjacentHTML('beforeend', html);
        } else {
            chatContainer.insertAdjacentHTML('beforeend', html);
        }
    }

    function getChatScrollElement() {
        if (!chatContainer) return null;
        const sbWrapper = chatContainer.querySelector('.simplebar-content-wrapper');
        if (sbWrapper) return sbWrapper;
        return chatContainer;
    }

    function isUserNearBottom() {
        const scrollEl = getChatScrollElement();
        if (!scrollEl) return true;
        const distanceToBottom = scrollEl.scrollHeight - scrollEl.scrollTop - scrollEl.clientHeight;
        return distanceToBottom < 120;
    }

    function attachScrollListener() {
        const scrollEl = getChatScrollElement();
        if (scrollEl) {
            scrollEl.addEventListener('scroll', function() {
                const distanceToBottom = scrollEl.scrollHeight - scrollEl.scrollTop - scrollEl.clientHeight;
                userHasScrolledUp = distanceToBottom > 120;
            }, { passive: true });
        }
    }
    setTimeout(attachScrollListener, 200);

    function scrollToBottom(force = false) {
        if (!chatContainer) return;
        setTimeout(function() {
            const scrollElement = getChatScrollElement();
            if (scrollElement) {
                scrollElement.scrollTop = scrollElement.scrollHeight;
                userHasScrolledUp = false;
            }
        }, 50);
    }

    scrollToBottom(true);

    function renderAttachmentHtml(msg) {
        if (!msg.attachment_url) return '';
        const isVoice = msg.attachment_type === 'voice' || (msg.attachment_url && /\.(mp3|wav|ogg|webm|m4a|aac|flac)$/i.test(msg.attachment_url));
        const isImg = !isVoice && (msg.attachment_type === 'image' || (msg.attachment_url && /\.(jpg|jpeg|png|webp|gif)$/i.test(msg.attachment_url)));
        const name = escapeHtml(msg.attachment_name || 'Lampiran Berkas');
        const sizeStr = msg.attachment_size_formatted || (msg.attachment_size ? formatBytes(msg.attachment_size) : '');

        if (isVoice) {
            return `<div class="voice-player-card my-2 p-2 rounded-3 bg-white bg-opacity-75 border d-flex align-items-center gap-2 shadow-sm" style="min-width: 220px; max-width: 280px;">
                <button type="button" class="btn btn-sm btn-primary rounded-circle p-0 d-flex align-items-center justify-content-center btn-play-voice flex-shrink-0" style="width: 32px; height: 32px;" data-audio-src="${msg.attachment_url}" title="Putar Pesan Suara">
                    <i class="ti ti-player-play fs-14"></i>
                </button>
                <div class="flex-grow-1 overflow-hidden">
                    <div class="d-flex justify-content-between align-items-center fs-xxs text-muted mb-1">
                        <span class="voice-current-time">0:00</span>
                        <span class="voice-duration">🎙️ Pesan Suara</span>
                    </div>
                    <div class="progress voice-progress rounded-pill bg-secondary-subtle" style="height: 5px; cursor: pointer;">
                        <div class="progress-bar bg-primary rounded-pill" role="progressbar" style="width: 0%"></div>
                    </div>
                </div>
            </div>`;
        } else if (isImg) {
            return `<div class="chat-attachment-image my-2">
                <a href="${msg.attachment_url}" class="d-inline-block position-relative rounded-3 overflow-hidden shadow-sm border btn-preview-img-modal" data-img-url="${msg.attachment_url}" data-img-name="${name}">
                    <img src="${msg.attachment_url}" alt="${name}" class="rounded-3" style="width: 240px; max-width: 100%; height: 160px; object-fit: cover; cursor: pointer; display: block; transition: transform 0.2s ease;" onmouseover="this.style.transform='scale(1.02)'" onmouseout="this.style.transform='scale(1)'">
                    <div class="position-absolute bottom-0 start-0 end-0 py-1 px-2 bg-dark bg-opacity-50 text-white d-flex align-items-center justify-content-between fs-11">
                        <span class="text-truncate me-2"><i class="ti ti-photo me-1"></i>${name}</span>
                        <i class="ti ti-zoom-in fs-13"></i>
                    </div>
                </a>
            </div>`;
        } else {
            return `<div class="mt-1 mb-2 p-2 bg-white bg-opacity-75 rounded border d-flex align-items-center justify-content-between gap-2 shadow-sm fs-12">
                <div class="d-flex align-items-center gap-2 overflow-hidden">
                    <i class="ti ti-file-text fs-24 text-primary flex-shrink-0"></i>
                    <div class="overflow-hidden text-start">
                        <span class="d-block fw-semibold text-dark text-truncate" title="${name}">${name}</span>
                        ${sizeStr ? `<span class="d-block text-muted fs-11">${sizeStr}</span>` : ''}
                    </div>
                </div>
                <a href="${msg.attachment_url}" download="${name}" target="_blank" class="btn btn-sm btn-outline-primary px-2 py-1 flex-shrink-0" title="Unduh Berkas">
                    <i class="ti ti-download"></i>
                </a>
            </div>`;
        }
    }

    // Pindahkan kontak ke bagian "Percakapan Aktif" secara teratur & urutkan ke posisi teratas
    function promoteContactToRecent(userId, messageText, timeText = 'Baru saja') {
        const contactEl = document.querySelector(`.btn-select-chat[data-user-id="${userId}"]`);
        if (!contactEl) return;

        const lastMsgEl = contactEl.querySelector('.contact-last-msg');
        const lastTimeEl = contactEl.querySelector('.contact-last-time');
        if (lastMsgEl && messageText) lastMsgEl.textContent = messageText;
        if (lastTimeEl && timeText) lastTimeEl.textContent = timeText;

        const listRecent = document.getElementById('list-recent-contacts');
        const listOther = document.getElementById('list-other-contacts');
        const secRecent = document.getElementById('section-recent-contacts');
        const secOther = document.getElementById('section-other-contacts');
        const badgeRecent = document.getElementById('badge-recent-count');
        const badgeOther = document.getElementById('badge-other-count');

        if (!listRecent || !listOther) return;

        const isCurrentlyOther = listOther.contains(contactEl);

        if (isCurrentlyOther) {
            listRecent.prepend(contactEl);

            if (badgeRecent) {
                const currentRecent = parseInt(badgeRecent.textContent.trim() || '0', 10);
                badgeRecent.textContent = currentRecent + 1;
            }
            if (badgeOther) {
                const currentOther = parseInt(badgeOther.textContent.trim() || '0', 10);
                badgeOther.textContent = Math.max(0, currentOther - 1);
            }

            if (secRecent) secRecent.classList.remove('d-none');
            if (secOther) {
                if (listOther.children.length === 0) {
                    secOther.classList.add('d-none');
                } else {
                    secOther.classList.add('mt-2');
                }
            }
        } else {
            listRecent.prepend(contactEl);
        }
    }

    // Pindahkan kontak kembali ke bagian "Pengguna Lainnya" secara instan saat obrolan kosong/dibersihkan
    function demoteContactToOther(userId) {
        const contactEl = document.querySelector(`.btn-select-chat[data-user-id="${userId}"]`);
        if (!contactEl) return;

        const lastMsgEl = contactEl.querySelector('.contact-last-msg');
        const lastTimeEl = contactEl.querySelector('.contact-last-time');
        const unreadBadge = contactEl.querySelector('.contact-unread-badge');

        if (lastMsgEl) lastMsgEl.textContent = 'Belum ada obrolan.';
        if (lastTimeEl) lastTimeEl.textContent = '';
        if (unreadBadge) {
            unreadBadge.classList.add('d-none');
            unreadBadge.textContent = '0';
        }

        const listRecent = document.getElementById('list-recent-contacts');
        const listOther = document.getElementById('list-other-contacts');
        const secRecent = document.getElementById('section-recent-contacts');
        const secOther = document.getElementById('section-other-contacts');
        const badgeRecent = document.getElementById('badge-recent-count');
        const badgeOther = document.getElementById('badge-other-count');

        if (!listRecent || !listOther) return;

        if (listRecent.contains(contactEl)) {
            listOther.prepend(contactEl);

            const currentRecent = listRecent.children.length;
            const currentOther = listOther.children.length;

            if (badgeRecent) badgeRecent.textContent = currentRecent;
            if (badgeOther) badgeOther.textContent = currentOther;

            if (secRecent) {
                if (currentRecent > 0) secRecent.classList.remove('d-none');
                else secRecent.classList.add('d-none');
            }

            if (secOther) {
                if (currentOther > 0) {
                    secOther.classList.remove('d-none');
                    if (currentRecent > 0) secOther.classList.add('mt-2');
                    else secOther.classList.remove('mt-2');
                } else {
                    secOther.classList.add('d-none');
                }
            }
        }
    }

    // Search Filter Kontak Sidebar
    if (contactSearchInput) {
        contactSearchInput.addEventListener('keyup', function(e) {
            const query = e.target.value.toLowerCase().trim();
            document.querySelectorAll('#chat-contacts-list .btn-select-chat').forEach(function(item) {
                const name = item.getAttribute('data-user-name') ? item.getAttribute('data-user-name').toLowerCase() : '';
                if (query === '' || name.includes(query)) {
                    item.style.setProperty('display', '', 'important');
                } else {
                    item.style.setProperty('display', 'none', 'important');
                }
            });
        });
    }

    // Event Delegation Pilih Kontak dari Sidebar
    document.addEventListener('click', function(e) {
        const btnSelect = e.target.closest('.btn-select-chat');
        if (!btnSelect) return;
        e.preventDefault();

        const userId = btnSelect.getAttribute('data-user-id');
        const userName = btnSelect.getAttribute('data-user-name');
        const userAvatar = btnSelect.getAttribute('data-user-avatar');
        const userRole = btnSelect.getAttribute('data-user-role');

        if (!userId || userId === activeUserId) return;

        // Mark active contact item instantly
        document.querySelectorAll('#chat-contacts-list .btn-select-chat').forEach(function(el) {
            el.classList.remove('active');
        });
        btnSelect.classList.add('active');

        // Sembunyikan badge unread pada kontak ini
        const unreadBadge = btnSelect.querySelector('.contact-unread-badge');
        if (unreadBadge) unreadBadge.classList.add('d-none');

        activeUserId = userId;
        lastMessageCount = 0;
        lastMessageId = null;
        userHasScrolledUp = false;

        cancelReplyState();
        cancelEditState();
        cancelAttachmentState();

        // Update Header seketika (Instant 0ms Feedback)
        if (activeReceiverInput) activeReceiverInput.value = userId;
        if (activeChatName) activeChatName.textContent = userName;
        if (activeChatRole) activeChatRole.textContent = userRole;
        if (activeChatAvatar) {
            activeChatAvatar.src = userAvatar || defaultAvatar;
            activeChatAvatar.classList.remove('d-none');
        }

        // Update Status Kehadiran Header Seketika
        const isOnline = btnSelect.getAttribute('data-user-online') === '1';
        const lastSeenHuman = btnSelect.getAttribute('data-user-last-seen') || 'Offline';
        const userCover = btnSelect.getAttribute('data-user-cover');
        const userCoverPos = btnSelect.getAttribute('data-user-cover-pos') || '0';
        const userMotto = btnSelect.getAttribute('data-user-motto') || '';
        const activeChatOnlineDot = document.getElementById('active-chat-online-dot');
        const activeChatStatus = document.getElementById('active-chat-status');

        // Update Modal Detail Akun Seketika (Instant 0ms Feedback)
        const modalUserCover = document.getElementById('modal-user-cover');
        if (modalUserCover && userCover) {
            modalUserCover.style.backgroundImage = `url('${userCover}')`;
            modalUserCover.style.backgroundPosition = `center ${userCoverPos}%`;
        }
        const modalUserAvatar = document.getElementById('modal-user-avatar');
        if (modalUserAvatar && userAvatar) {
            modalUserAvatar.src = userAvatar;
        }
        const modalUserName = document.getElementById('modal-user-name');
        if (modalUserName) modalUserName.textContent = userName;
        const modalUserRole = document.getElementById('modal-user-role');
        if (modalUserRole) modalUserRole.innerHTML = `<i class="ti ti-shield-check me-1"></i>${userRole}`;
        const modalUserMotto = document.getElementById('modal-user-motto');
        if (modalUserMotto) {
            modalUserMotto.textContent = `"${userMotto || 'Setiap hari adalah kesempatan baru untuk belajar dan berkarya.'}"`;
            modalUserMotto.setAttribute('title', userMotto);
        }

        if (activeChatOnlineDot) {
            activeChatOnlineDot.classList.remove('d-none');
            activeChatOnlineDot.className = `position-absolute bottom-0 end-0 border border-2 border-white rounded-circle ${isOnline ? 'bg-success' : 'bg-secondary opacity-50'}`;
        }
        if (activeChatStatus) {
            activeChatStatus.textContent = isOnline ? 'Online Sekarang' : lastSeenHuman;
        }

        // Aktifkan input chat langsung tanpa jeda
        if (chatInput) {
            chatInput.disabled = false;
            chatInput.focus();
        }
        if (document.getElementById('btn-send-message')) document.getElementById('btn-send-message').disabled = false;
        if (document.getElementById('btn-toggle-emoji')) document.getElementById('btn-toggle-emoji').disabled = false;
        if (document.getElementById('btn-attach-file')) document.getElementById('btn-attach-file').disabled = false;
        if (btnRecordVoice) btnRecordVoice.disabled = false;
        if (btnToggleSearch) btnToggleSearch.disabled = false;
        if (btnViewUserDetail) btnViewUserDetail.disabled = false;
        if (btnClearChat) btnClearChat.disabled = true;

        // Tampilkan placeholder transisi cepat di chat container
        setChatContainerHtml(`
            <div class="text-center py-5 text-muted chat-placeholder-box" id="chat-loading-placeholder">
                <div class="spinner-border spinner-border-sm text-primary mb-2" role="status"></div>
                <div class="fs-12 fw-medium">Memuat percakapan dengan ${escapeHtml(userName)}...</div>
            </div>
        `);

        // Reset state balasan & lampiran saat ganti kontak
        cancelReplyState();
        cancelAttachmentState();

        // Load percakapan via AJAX
        loadConversation(userId, false);
    });

    const btnAttachFile = document.getElementById('btn-attach-file');
    const chatFileInput = document.getElementById('chat-file-input');
    const attachmentPreviewContainer = document.getElementById('attachment-preview-container');
    const attachmentPreviewImg = document.getElementById('attachment-preview-img');
    const attachmentPreviewIcon = document.getElementById('attachment-preview-icon');
    const attachmentPreviewName = document.getElementById('attachment-preview-name');
    const attachmentPreviewSize = document.getElementById('attachment-preview-size');
    const btnCancelAttachment = document.getElementById('btn-cancel-attachment');

    let selectedChatFile = null;

    function cancelAttachmentState() {
        selectedChatFile = null;
        if (chatFileInput) chatFileInput.value = '';
        if (attachmentPreviewContainer) attachmentPreviewContainer.classList.add('d-none');
        if (attachmentPreviewImg) {
            attachmentPreviewImg.src = '';
            attachmentPreviewImg.classList.add('d-none');
        }
        if (attachmentPreviewIcon) attachmentPreviewIcon.classList.remove('d-none');
    }

    if (btnAttachFile && chatFileInput) {
        btnAttachFile.addEventListener('click', function(e) {
            e.preventDefault();
            chatFileInput.click();
        });

        chatFileInput.addEventListener('change', function(e) {
            const files = e.target.files;
            if (!files || files.length === 0) return;

            const file = files[0];

            // Validasi ukuran berkas maksimal 10 MB
            if (file.size > 10 * 1024 * 1024) {
                if (typeof window.showWarning === 'function') {
                    window.showWarning('Ukuran berkas melebihi batas maksimal 10 MB.');
                } else {
                    alert('Ukuran berkas melebihi batas maksimal 10 MB.');
                }
                chatFileInput.value = '';
                return;
            }

            selectedChatFile = file;

            if (attachmentPreviewContainer) {
                attachmentPreviewContainer.classList.remove('d-none');
                if (attachmentPreviewName) attachmentPreviewName.textContent = file.name;
                if (attachmentPreviewSize) attachmentPreviewSize.textContent = formatBytes(file.size);

                const isImage = file.type.startsWith('image/');
                if (isImage && attachmentPreviewImg) {
                    const reader = new FileReader();
                    reader.onload = function(evt) {
                        attachmentPreviewImg.src = evt.target.result;
                        attachmentPreviewImg.classList.remove('d-none');
                        if (attachmentPreviewIcon) attachmentPreviewIcon.classList.add('d-none');
                    };
                    reader.readAsDataURL(file);
                } else {
                    if (attachmentPreviewImg) attachmentPreviewImg.classList.add('d-none');
                    if (attachmentPreviewIcon) {
                        attachmentPreviewIcon.classList.remove('d-none');
                        if (file.name.endsWith('.pdf')) attachmentPreviewIcon.className = 'ti ti-file-type-pdf fs-22 text-danger';
                        else if (file.name.endsWith('.doc') || file.name.endsWith('.docx')) attachmentPreviewIcon.className = 'ti ti-file-type-doc fs-22 text-primary';
                        else if (file.name.endsWith('.xls') || file.name.endsWith('.xlsx')) attachmentPreviewIcon.className = 'ti ti-file-type-xls fs-22 text-success';
                        else if (file.name.endsWith('.zip') || file.name.endsWith('.rar')) attachmentPreviewIcon.className = 'ti ti-file-type-zip fs-22 text-warning';
                        else attachmentPreviewIcon.className = 'ti ti-file-text fs-22 text-info';
                    }
                }
            }
        });
    }

    if (btnCancelAttachment) {
        btnCancelAttachment.addEventListener('click', function(e) {
            e.preventDefault();
            cancelAttachmentState();
        });
    }

    // Event Delegation Buka Modal Lightbox Gambar (Rule 2 Compliance)
    document.addEventListener('click', function(e) {
        const imgBtn = e.target.closest('.btn-preview-img-modal');
        if (!imgBtn) return;
        e.preventDefault();

        const imgUrl = imgBtn.getAttribute('data-img-url');
        const imgName = imgBtn.getAttribute('data-img-name') || 'Pratinjau Gambar';

        const modalImg = document.getElementById('modal-preview-full-img');
        const modalLabel = document.getElementById('chatImageModalLabel');
        const downloadLink = document.getElementById('modal-download-image');

        if (modalImg) modalImg.src = imgUrl;
        if (modalLabel) modalLabel.textContent = imgName;
        if (downloadLink) {
            downloadLink.href = imgUrl;
            downloadLink.setAttribute('download', imgName);
        }

        const modalEl = document.getElementById('chat-image-modal');
        if (modalEl && window.bootstrap) {
            const bsModal = bootstrap.Modal.getOrCreateInstance(modalEl);
            bsModal.show();
        }
    });

    // Event Delegation Klik Reply Quote Box untuk Scroll ke Pesan Asal (Rule 2 Compliance)
    document.addEventListener('click', function(e) {
        const replyBox = e.target.closest('.reply-quote-box');
        if (!replyBox) return;

        const parentId = replyBox.getAttribute('data-parent-id');
        if (!parentId) return;

        const targetMsgEl = document.getElementById(`chat-msg-${parentId}`);
        if (targetMsgEl) {
            targetMsgEl.scrollIntoView({ behavior: 'smooth', block: 'center' });

            const msgBubble = targetMsgEl.querySelector('.chat-message') || targetMsgEl;
            msgBubble.classList.remove('chat-message-highlight');
            void msgBubble.offsetWidth; // Trigger DOM reflow to restart animation
            msgBubble.classList.add('chat-message-highlight');

            setTimeout(function() {
                msgBubble.classList.remove('chat-message-highlight');
            }, 1800);
        } else {
            if (typeof window.showToast === 'function') {
                window.showToast('Pesan asal berada di luar riwayat saat ini.', 'info');
            }
        }
    });

    // Event Delegation Tombol Balas Pesan (Rule 2 Compliance)
    document.addEventListener('click', function(e) {
        const btnReply = e.target.closest('.btn-reply-msg');
        if (!btnReply) return;
        e.preventDefault();

        const msgId = btnReply.getAttribute('data-msg-id');
        const senderName = btnReply.getAttribute('data-sender-name');
        const msgBody = btnReply.getAttribute('data-msg-body');

        const replyContainer = document.getElementById('reply-preview-container');
        const replyName = document.getElementById('reply-preview-name');
        const replyBody = document.getElementById('reply-preview-body');
        const replyParentInput = document.getElementById('reply-parent-id');

        if (replyContainer && replyParentInput) {
            replyParentInput.value = msgId;
            if (replyName) replyName.textContent = senderName;
            if (replyBody) replyBody.textContent = msgBody;
            replyContainer.classList.remove('d-none');
            if (chatInput) chatInput.focus();
        }
    });

    const btnCancelReply = document.getElementById('btn-cancel-reply');
    if (btnCancelReply) {
        btnCancelReply.addEventListener('click', function(e) {
            e.preventDefault();
            cancelReplyState();
        });
    }

    function cancelReplyState() {
        const replyContainer = document.getElementById('reply-preview-container');
        const replyParentInput = document.getElementById('reply-parent-id');
        if (replyParentInput) replyParentInput.value = '';
        if (replyContainer) replyContainer.classList.add('d-none');
    }

    // ==========================================
    // FITUR EDIT PESAN (BATAS 10 MENIT)
    // ==========================================
    document.addEventListener('click', function(e) {
        const btnEdit = e.target.closest('.btn-edit-msg');
        if (!btnEdit) return;
        e.preventDefault();

        const msgId = btnEdit.getAttribute('data-msg-id');
        const msgBody = btnEdit.getAttribute('data-msg-body') || '';
        const createdAt = parseInt(btnEdit.getAttribute('data-created-at') || '0', 10);

        if (!msgId || String(msgId).startsWith('temp_')) return;

        // Validasi batas waktu 10 menit di sisi UI
        if (createdAt > 0) {
            const nowSeconds = Math.floor(Date.now() / 1000);
            const elapsedMinutes = (nowSeconds - createdAt) / 60;
            if (elapsedMinutes > 10) {
                if (typeof window.showWarning === 'function') {
                    window.showWarning('Pesan tidak dapat diedit karena telah melewati batas waktu 10 menit.', 'Batas Waktu Habis');
                }
                return;
            }
        }

        // Buka mode edit
        cancelReplyState();
        cancelAttachmentState();

        const editContainer = document.getElementById('edit-preview-container');
        const editBody = document.getElementById('edit-preview-body');
        const editMessageInput = document.getElementById('edit-message-id');
        const submitBtn = document.getElementById('btn-send-message');

        if (editMessageInput) editMessageInput.value = msgId;
        if (editBody) editBody.textContent = msgBody;
        if (editContainer) editContainer.classList.remove('d-none');
        if (submitBtn) submitBtn.innerHTML = 'Simpan <i class="ti ti-check ms-1 fs-14"></i>';

        if (chatInput) {
            chatInput.value = msgBody;
            chatInput.focus();
            chatInput.setSelectionRange(msgBody.length, msgBody.length);
        }
    });

    const btnCancelEdit = document.getElementById('btn-cancel-edit');
    if (btnCancelEdit) {
        btnCancelEdit.addEventListener('click', function(e) {
            e.preventDefault();
            cancelEditState();
        });
    }

    function cancelEditState() {
        const editContainer = document.getElementById('edit-preview-container');
        const editMessageInput = document.getElementById('edit-message-id');
        const submitBtn = document.getElementById('btn-send-message');

        if (editMessageInput) editMessageInput.value = '';
        if (editContainer) editContainer.classList.add('d-none');
        if (submitBtn) submitBtn.innerHTML = 'Kirim <i class="ti ti-send ms-1 fs-14"></i>';
    }

    // Batalkan mode edit saat tombol ESC ditekan
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const editMessageInput = document.getElementById('edit-message-id');
            if (editMessageInput && editMessageInput.value) {
                cancelEditState();
                if (chatInput) chatInput.value = '';
            }
        }
    });

    // Load Percakapan via AJAX
    function loadConversation(userId, isPolling = false) {
        if (!userId) return;

        fetch(`/admin/profil-pengguna/messages/conversation/${userId}`, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(function(res) {
            if (!res.ok) return null;
            return res.json();
        })
        .then(function(data) {
            if (data && data.success && chatContainer) {
                if (data.target_user) {
                    const tu = data.target_user;
                    if (document.getElementById('modal-user-avatar')) document.getElementById('modal-user-avatar').src = tu.avatar;
                    if (document.getElementById('modal-user-cover')) {
                        const coverUrl = tu.cover_bg_url || window.MessagesConfig?.defaultCover || '/assets/images/profile-bg.jpg';
                        const coverPosY = (tu.cover_position_y !== undefined && tu.cover_position_y !== null) ? tu.cover_position_y : 0;
                        document.getElementById('modal-user-cover').style.backgroundImage = `url('${coverUrl}')`;
                        document.getElementById('modal-user-cover').style.backgroundPosition = `center ${coverPosY}%`;
                    }
                    if (document.getElementById('modal-user-motto')) {
                        document.getElementById('modal-user-motto').textContent = `"${tu.motto || 'Setiap hari adalah kesempatan baru untuk belajar dan berkarya.'}"`;
                        document.getElementById('modal-user-motto').setAttribute('title', tu.motto || '');
                    }
                    if (document.getElementById('modal-user-name')) document.getElementById('modal-user-name').textContent = tu.name;
                    if (document.getElementById('modal-user-email')) document.getElementById('modal-user-email').textContent = tu.email;
                    if (document.getElementById('modal-user-role')) document.getElementById('modal-user-role').innerHTML = `<i class="ti ti-shield-check me-1"></i>${tu.role_name}`;
                    if (document.getElementById('modal-user-status')) document.getElementById('modal-user-status').innerHTML = `<i class="ti ti-circle-check me-1"></i>${tu.status}`;
                    if (document.getElementById('modal-info-email')) document.getElementById('modal-info-email').textContent = tu.email;
                    if (document.getElementById('modal-info-telepon')) {
                        if (tu.telepon) {
                            const waUrl = tu.telepon_wa_url || `https://wa.me/${tu.telepon.replace(/\D/g, '')}`;
                            document.getElementById('modal-info-telepon').innerHTML = `<a href="${waUrl}" target="_blank" class="text-success text-decoration-none fw-semibold d-inline-flex align-items-center">${tu.telepon} <i class="ti ti-external-link fs-11 ms-1"></i></a>`;
                        } else {
                            document.getElementById('modal-info-telepon').innerHTML = `<span class="text-muted fst-italic fw-normal">-</span>`;
                        }
                    }
                    if (document.getElementById('modal-info-role')) document.getElementById('modal-info-role').textContent = tu.role_name;
                    if (document.getElementById('modal-info-joined')) document.getElementById('modal-info-joined').textContent = tu.joined_at;

                    // Sinkronkan avatar header aktif & kontak sidebar jika berubah
                    if (activeChatAvatar && tu.avatar) {
                        activeChatAvatar.src = tu.avatar;
                        activeChatAvatar.classList.remove('d-none');
                    }
                    const contactEl = document.querySelector(`.btn-select-chat[data-user-id="${userId}"]`);
                    if (contactEl && tu.avatar) {
                        contactEl.setAttribute('data-user-avatar', tu.avatar);
                        const contactImg = contactEl.querySelector('img');
                        if (contactImg && contactImg.src !== tu.avatar) {
                            contactImg.src = tu.avatar;
                        }
                    }
                }

                const messages = data.messages || [];
                const newCount = messages.length;
                const newLastMsg = newCount > 0 ? messages[newCount - 1] : null;
                const newLastId = newLastMsg ? newLastMsg.id : null;

                // Jika sedang polling dan tidak ada perubahan total/id pesan terakhir, lakukan sinkronisasi in-place (reaksi emoji & sematan pin) secara presisi tanpa re-render keseluruhan DOM
                if (isPolling && newCount === lastMessageCount && newLastId === lastMessageId) {
                    let polledPinnedMsg = null;
                    messages.forEach(function(msg) {
                        if (msg.is_pinned) {
                            polledPinnedMsg = msg;
                        }
                        const msgEl = document.getElementById(`chat-msg-${msg.id}`);
                        if (msgEl) {
                            // 0. Sinkronisasi Teks Pesan & Indikator Edited Real-Time
                            const bodyEl = msgEl.querySelector('.message-body-text');
                            if (bodyEl && msg.body) {
                                const currentRaw = bodyEl.getAttribute('data-raw-body');
                                if (currentRaw !== msg.body && bodyEl.textContent.trim() !== msg.body.trim()) {
                                    bodyEl.innerHTML = escapeHtml(msg.body).replace(/\n/g, '<br>');
                                    bodyEl.removeAttribute('data-raw-body');
                                }
                            }
                            if (msg.is_edited) {
                                const statusTimeEl = msgEl.querySelector('.chat-status-time');
                                if (statusTimeEl && !statusTimeEl.querySelector('.edited-indicator')) {
                                    statusTimeEl.insertAdjacentHTML('beforeend', `<span class="edited-indicator ms-1 fs-10 text-muted fst-italic" title="Diedit pada ${msg.edited_at_formatted || ''}">(diedit)</span>`);
                                }
                            }

                            // 1. Sinkronisasi Reaksi Emoji Real-Time
                            const reactionsContainer = document.getElementById(`chat-reactions-${msg.id}`);
                            if (reactionsContainer) {
                                const newReactionsHtml = renderReactionsHtml(msg.id, msg.reactions, msg.is_sender);
                                if (reactionsContainer.innerHTML.trim() !== newReactionsHtml.trim()) {
                                    reactionsContainer.innerHTML = newReactionsHtml;
                                }
                            }

                            // 2. Sinkronisasi Status Pin Real-Time (Tombol Dropdown & Badge Indikator)
                            const isPinned = msg.is_pinned === true;
                            const btnPin = msgEl.querySelector('.btn-pin-msg');
                            if (btnPin) {
                                const currentPinnedState = btnPin.getAttribute('data-is-pinned') === '1';
                                if (currentPinnedState !== isPinned) {
                                    btnPin.setAttribute('data-is-pinned', isPinned ? '1' : '0');
                                    btnPin.innerHTML = `<i class="ti ${isPinned ? 'ti-pinned-off text-warning' : 'ti-pin text-warning'} fs-14"></i> ${isPinned ? 'Lepas Pin' : 'Pin'}`;
                                }
                            }

                            const pinIndicator = msgEl.querySelector('.pinned-indicator');
                            if (isPinned && !pinIndicator) {
                                const statusTimeEl = msgEl.querySelector('.chat-status-time');
                                if (statusTimeEl && statusTimeEl.parentElement) {
                                    const badgeHtml = '<span class="badge bg-success-subtle text-success border border-success-subtle fs-xxs py-0.5 px-1 pinned-indicator" title="Pesan Disematkan"><i class="ti ti-pin-filled me-0.5"></i> Sematan</span>';
                                    if (msg.is_sender) {
                                        statusTimeEl.insertAdjacentHTML('beforebegin', badgeHtml);
                                    } else {
                                        statusTimeEl.insertAdjacentHTML('afterend', badgeHtml);
                                    }
                                }
                            } else if (!isPinned && pinIndicator) {
                                pinIndicator.remove();
                            }
                        }
                    });

                    // 3. Sinkronisasi Banner Pesan Tersemat di Bagian Atas
                    updatePinnedBanner(polledPinnedMsg);
                    return;
                }

                const wasNearBottom = isUserNearBottom();

                let html = '';
                let pinnedMsg = null;
                if (newCount > 0) {
                    const summaryText = newLastMsg.body || (newLastMsg.attachment_type === 'image' ? '📷 [Foto / Gambar]' : (newLastMsg.attachment_type === 'voice' ? '🎙️ [Pesan Suara]' : ('📎 [' + (newLastMsg.attachment_name || 'Berkas') + ']')));
                    promoteContactToRecent(userId, summaryText, newLastMsg.time_formatted);

                    messages.forEach(function(msg) {
                        if (msg.is_pinned) {
                            pinnedMsg = msg;
                        }
                        const isSender = msg.is_sender;
                        const avatar = isSender ? currentUserAvatar : (msg.sender_avatar || currentUserAvatar);
                        const senderName = isSender ? 'Anda' : (msg.sender_name || 'Pengguna');
                        const replyText = msg.body || (msg.attachment_name || (msg.attachment_type === 'voice' ? 'Pesan Suara' : 'Lampiran'));
                        const isPinned = msg.is_pinned === true;
                        const isForwarded = msg.is_forwarded === true;
                        const reactions = msg.reactions || [];

                        html += `<div class="d-flex align-items-start gap-2 my-3 chat-item ${isSender ? 'text-end justify-content-end' : ''}" id="chat-msg-${msg.id}" data-msg-id="${msg.id}">`;
                        if (!isSender) {
                            html += `<img src="${avatar}" class="rounded-circle object-fit-cover shadow-sm flex-shrink-0 chat-avatar-opponent" style="width: 36px; height: 36px; object-fit: cover; object-position: top;" alt="Avatar" />`;
                        }
                        html += `<div style="max-width: 75%; min-width: 140px;">
                            <div class="chat-message py-2 px-3 ${isSender ? 'pe-4 bg-primary-subtle text-dark' : 'ps-4 bg-light text-dark border'} rounded shadow-sm text-start position-relative">
                                <div class="dropdown position-absolute top-0 ${isSender ? 'end-0 me-1' : 'start-0 ms-1'} mt-1 chat-msg-dropdown">
                                    <button class="btn btn-sm btn-link p-0 text-decoration-none dropdown-toggle-no-caret d-flex align-items-center justify-content-center chat-msg-more-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false" title="Opsi Pesan">
                                        <i class="ti ti-dots-vertical fs-14"></i>
                                    </button>
                                    <ul class="dropdown-menu ${isSender ? 'dropdown-menu-end' : 'dropdown-menu-start'} shadow-sm fs-12 py-1 border-0" style="z-index: 1050; min-width: 140px;">
                                        <li>
                                            <a class="dropdown-item d-flex align-items-center gap-2 py-1.5 btn-reply-msg" href="javascript:void(0);" data-msg-id="${msg.id}" data-sender-name="${escapeHtml(senderName)}" data-msg-body="${escapeHtml(replyText)}">
                                                <i class="ti ti-corner-up-left text-primary fs-14"></i> Balas
                                            </a>
                                        </li>
                                        ${(isSender && msg.body) ? `
                                        <li>
                                            <a class="dropdown-item d-flex align-items-center gap-2 py-1.5 btn-edit-msg" href="javascript:void(0);" data-msg-id="${msg.id}" data-msg-body="${escapeHtml(msg.body)}" data-created-at="${msg.created_at_timestamp || 0}">
                                                <i class="ti ti-edit text-success fs-14"></i> Edit
                                            </a>
                                        </li>
                                        ` : ''}
                                        <li>
                                            <a class="dropdown-item d-flex align-items-center gap-2 py-1.5 btn-forward-msg" href="javascript:void(0);" data-msg-id="${msg.id}">
                                                <i class="ti ti-arrow-forward-up text-info fs-14"></i> Teruskan
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item d-flex align-items-center gap-2 py-1.5 btn-pin-msg" href="javascript:void(0);" data-msg-id="${msg.id}" data-is-pinned="${isPinned ? '1' : '0'}">
                                                <i class="ti ${isPinned ? 'ti-pinned-off text-warning' : 'ti-pin text-warning'} fs-14"></i> ${isPinned ? 'Lepas Pin' : 'Pin'}
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider my-1"></li>
                                        <li>
                                            <a class="dropdown-item d-flex align-items-center gap-2 py-1.5 text-danger btn-delete-msg" href="javascript:void(0);" data-msg-id="${msg.id}" data-is-sender="${isSender ? '1' : '0'}">
                                                <i class="ti ti-trash fs-14"></i> Hapus
                                            </a>
                                        </li>
                                    </ul>
                                </div>`;
                        
                        if (isForwarded) {
                            html += `<div class="fs-11 text-muted fst-italic mb-1 d-flex align-items-center gap-1">
                                <i class="ti ti-arrow-forward-up fs-12 text-primary"></i> Diteruskan
                            </div>`;
                        }

                        if (msg.parent) {
                            const parentId = msg.parent_id || (msg.parent ? msg.parent.id : '');
                            html += `<div class="p-2 mb-2 bg-white bg-opacity-75 rounded border-start border-3 border-primary text-start fs-12 shadow-sm reply-quote-box" data-parent-id="${parentId}" role="button" title="Klik untuk menuju pesan yang dibalas">
                                <strong class="d-block text-primary fs-11 mb-0.5"><i class="ti ti-corner-up-left me-1"></i>${escapeHtml(msg.parent.sender_name || 'Pesan')}</strong>
                                <div class="text-muted text-truncate fs-12">${escapeHtml(msg.parent.body || '')}</div>
                            </div>`;
                        }

                        if (msg.subject && msg.subject !== 'Pesan Masuk') {
                            html += `<strong class="d-block text-primary fs-12 mb-1"><i class="ti ti-bell me-1"></i>${escapeHtml(msg.subject)}</strong>`;
                        }

                        if (msg.attachment_url) {
                            html += renderAttachmentHtml(msg);
                        }

                        if (msg.body) {
                            html += `<div class="fs-13 lh-base text-wrap message-body-text" style="word-break: break-word;">${escapeHtml(msg.body).replace(/\n/g, '<br>')}</div>`;
                        }

                        if (msg.reason) {
                            html += `<div class="mt-2 p-2 bg-white rounded border border-danger-subtle fs-12 text-danger">
                                <strong><i class="ti ti-notes me-1"></i>Alasan dari Admin:</strong> ${escapeHtml(msg.reason)}
                            </div>`;
                        }
                        html += `</div>

                        <!-- ACTION ROW & REACTIONS -->
                        <div class="d-flex align-items-center justify-content-between gap-2 text-muted fs-xs mt-1 w-100 px-0.5">
                            ${isSender ? `
                                <div class="d-flex align-items-center gap-1.5">
                                    <button type="button" class="btn btn-link p-0 text-muted btn-react-msg text-decoration-none fs-xs d-inline-flex align-items-center gap-0.5 opacity-75 opacity-100-hover" data-msg-id="${msg.id}" title="Beri Reaksi Emoji">
                                        <i class="ti ti-mood-smile"></i>
                                    </button>
                                    <div class="chat-reactions-container d-inline-flex align-items-center gap-1.5" id="chat-reactions-${msg.id}">
                                        ${renderReactionsHtml(msg.id, reactions, isSender)}
                                    </div>
                                </div>
                                <div class="d-flex align-items-center gap-1.5 ms-auto">
                                    ${isPinned ? '<span class="badge bg-success-subtle text-success border border-success-subtle fs-xxs py-0.5 px-1 pinned-indicator" title="Pesan Disematkan"><i class="ti ti-pin-filled me-0.5"></i> Sematan</span>' : ''}
                                    <span class="chat-status-time"><i class="ti ti-clock me-0.5"></i> ${msg.time_formatted}${msg.is_edited ? `<span class="edited-indicator ms-1 fs-10 text-muted fst-italic" title="Diedit pada ${msg.edited_at_formatted || ''}">(diedit)</span>` : ''}</span>
                                </div>
                            ` : `
                                <div class="d-flex align-items-center gap-1.5 me-auto">
                                    <span class="chat-status-time"><i class="ti ti-clock me-0.5"></i> ${msg.time_formatted}${msg.is_edited ? `<span class="edited-indicator ms-1 fs-10 text-muted fst-italic" title="Diedit pada ${msg.edited_at_formatted || ''}">(diedit)</span>` : ''}</span>
                                    ${isPinned ? '<span class="badge bg-success-subtle text-success border border-success-subtle fs-xxs py-0.5 px-1 pinned-indicator" title="Pesan Disematkan"><i class="ti ti-pin-filled me-0.5"></i> Sematan</span>' : ''}
                                </div>
                                <div class="d-flex align-items-center gap-1.5 ms-auto">
                                    <div class="chat-reactions-container d-inline-flex align-items-center gap-1.5" id="chat-reactions-${msg.id}">
                                        ${renderReactionsHtml(msg.id, reactions, isSender)}
                                    </div>
                                    <button type="button" class="btn btn-link p-0 text-muted btn-react-msg text-decoration-none fs-xs d-inline-flex align-items-center gap-0.5 opacity-75 opacity-100-hover" data-msg-id="${msg.id}" title="Beri Reaksi Emoji">
                                        <i class="ti ti-mood-smile"></i>
                                    </button>
                                </div>
                            `}
                        </div>
                    </div>`;
                    if (isSender) {
                        html += `<img src="${avatar}" class="rounded-circle object-fit-cover shadow-sm flex-shrink-0 chat-avatar-sender" style="width: 36px; height: 36px; object-fit: cover; object-position: top;" alt="Avatar" />`;
                    }
                    html += `</div>`;
                });
            } else {
                html = `<div class="text-center py-5 text-muted chat-placeholder-box" id="empty-chat-placeholder">
                    <div class="avatar-md mx-auto mb-2">
                        <span class="avatar-title text-bg-light text-primary rounded-circle fs-24">
                            <i class="ti ti-messages"></i>
                        </span>
                    </div>
                    <h6 class="fs-14 fw-semibold text-dark mb-1">Belum Ada Riwayat Obrolan</h6>
                    <p class="fs-12 mb-0">Mulai percakapan dengan mengetikkan pesan di bawah ini.</p>
                </div>`;
            }

            // Update isi kontainer obrolan secara presisi
            setChatContainerHtml(html);
            updatePinnedBanner(pinnedMsg);

            if (btnClearChat) {
                btnClearChat.disabled = newCount === 0;
            }

            if (newCount === 0 && activeUserId) {
                demoteContactToOther(activeUserId);
            }

            lastMessageCount = newCount;
            lastMessageId = newLastId;

            // Sinkronkan badge dropdown pesan di topbar
            if (typeof window.fetchMessagesSilently === 'function') {
                window.fetchMessagesSilently(false);
            }

            // Pasang ulang scroll listener jika elemen di-recreate
            attachScrollListener();

            // Hanya scroll ke paling bawah jika bukan polling biasa ATAU jika user tidak sedang scroll ke atas & berada di bawah
            if (!isPolling || (!userHasScrolledUp && wasNearBottom)) {
                scrollToBottom(true);
            }
        }
    })
    .catch(function(err) {
        console.error('Error loading conversation:', err);
    });
}

    // Kirim Pesan via AJAX (Mendukung Teks, Reply Quote, dan Lampiran Berkas/Foto)
    if (chatForm) {
        chatForm.addEventListener('submit', function(e) {
            e.preventDefault();
            if (!chatInput) return;

            const messageText = chatInput.value.trim();
            const receiverId = activeReceiverInput ? activeReceiverInput.value : '';
            const replyParentInput = document.getElementById('reply-parent-id');
            const parentId = (replyParentInput && replyParentInput.value.trim() !== '') ? parseInt(replyParentInput.value.trim(), 10) : null;
            const replyNameEl = document.getElementById('reply-preview-name');
            const replyBodyEl = document.getElementById('reply-preview-body');

            const editMessageInput = document.getElementById('edit-message-id');
            const editMsgId = editMessageInput ? editMessageInput.value.trim() : '';

            // JIKA DALAM MODE EDIT PESAN
            if (editMsgId) {
                if (!messageText) {
                    if (typeof window.showWarning === 'function') {
                        window.showWarning('Pesan teks tidak boleh kosong.', 'Peringatan');
                    }
                    return;
                }

                const submitBtn = document.getElementById('btn-send-message');
                if (submitBtn) submitBtn.disabled = true;

                fetch(`/admin/profil-pengguna/messages/${editMsgId}`, {
                    method: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': getCsrfToken(),
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ body: messageText })
                })
                .then(function(res) { return res.json(); })
                .then(function(data) {
                    if (submitBtn) submitBtn.disabled = false;
                    if (data && data.success) {
                        const updatedData = data.data || {};
                        const msgEl = document.getElementById(`chat-msg-${editMsgId}`);
                        if (msgEl) {
                            const bodyEl = msgEl.querySelector('.message-body-text');
                            if (bodyEl) {
                                bodyEl.innerHTML = escapeHtml(updatedData.body || messageText).replace(/\n/g, '<br>');
                                bodyEl.removeAttribute('data-raw-body');
                            }
                            const btnReply = msgEl.querySelector('.btn-reply-msg');
                            if (btnReply) {
                                btnReply.setAttribute('data-msg-body', updatedData.body || messageText);
                            }
                            const btnEdit = msgEl.querySelector('.btn-edit-msg');
                            if (btnEdit) {
                                btnEdit.setAttribute('data-msg-body', updatedData.body || messageText);
                            }
                            const statusTimeEl = msgEl.querySelector('.chat-status-time');
                            if (statusTimeEl && !statusTimeEl.querySelector('.edited-indicator')) {
                                statusTimeEl.insertAdjacentHTML('beforeend', `<span class="edited-indicator ms-1 fs-10 text-muted fst-italic" title="Diedit pada ${updatedData.edited_at || ''}">(diedit)</span>`);
                            }
                        }

                        cancelEditState();
                        if (chatInput) chatInput.value = '';

                        if (typeof window.showToast === 'function') {
                            window.showToast(data.message || 'Pesan berhasil diperbarui.', 'success');
                        }

                        // Update ringkasan percakapan sidebar
                        promoteContactToRecent(activeUserId, updatedData.body || messageText, 'Baru saja');
                    } else {
                        if (typeof window.showError === 'function') {
                            window.showError(data && data.message ? data.message : 'Gagal memperbarui pesan.');
                        }
                    }
                })
                .catch(function(err) {
                    if (submitBtn) submitBtn.disabled = false;
                    if (typeof window.showError === 'function') {
                        window.showError('Terjadi kesalahan saat memperbarui pesan.');
                    }
                });

                return;
            }

            if ((!messageText && !selectedChatFile) || !receiverId) return;

            // Siapkan snapshot data optimistik sebelum form di-clear
            const tempMsgId = 'temp_' + Date.now();
            const capturedFile = selectedChatFile;
            let capturedFileUrl = null;
            if (capturedFile && capturedFile.type.startsWith('image/')) {
                capturedFileUrl = (attachmentPreviewImg && attachmentPreviewImg.src) ? attachmentPreviewImg.src : URL.createObjectURL(capturedFile);
            }
            const capturedFileName = capturedFile ? capturedFile.name : null;
            const capturedFileType = capturedFile ? (capturedFile.type.startsWith('image/') ? 'image' : 'file') : null;
            const capturedFileSize = capturedFile ? capturedFile.size : null;
            const capturedParent = parentId ? {
                id: parentId,
                sender_name: replyNameEl ? replyNameEl.textContent : 'Pesan',
                body: replyBodyEl ? replyBodyEl.textContent : ''
            } : null;

            // Siapkan form data untuk background request
            const formData = new FormData();
            formData.append('receiver_id', receiverId);
            if (parentId) formData.append('parent_id', parentId);
            if (messageText) formData.append('body', messageText);
            if (capturedFile) formData.append('attachment', capturedFile);

            // 1. OPTIMISTIC UI: Langsung bersihkan input & render balon pesan seketika (0ms delay)
            chatInput.value = '';
            cancelReplyState();
            cancelAttachmentState();
            chatInput.focus();

            const now = new Date();
            const timeFormatted = String(now.getHours()).padStart(2, '0') + ':' + String(now.getMinutes()).padStart(2, '0');
            const optimisticMsg = {
                id: tempMsgId,
                temp_id: tempMsgId,
                is_sender: true,
                body: messageText,
                attachment_url: capturedFileUrl,
                attachment_name: capturedFileName,
                attachment_type: capturedFileType,
                attachment_size: capturedFileSize,
                attachment_size_formatted: capturedFileSize ? formatBytes(capturedFileSize) : null,
                parent_id: parentId,
                parent: capturedParent,
                time_formatted: timeFormatted,
                is_pending: true
            };

            appendSingleMessage(optimisticMsg);
            scrollToBottom(true);

            // Update ringkasan percakapan kontak aktif langsung di sidebar
            const summaryText = messageText || (capturedFileType === 'image' ? '📷 [Foto / Gambar]' : ('📎 [' + (capturedFileName || 'Berkas') + ']'));
            promoteContactToRecent(receiverId, summaryText, 'Baru saja');

            // 2. Kirim ke server di latar belakang
            fetch('/admin/profil-pengguna/messages/send', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': getCsrfToken(),
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(function(res) { return res.json(); })
            .then(function(data) {
                if (data && data.success) {
                    // Update status & ID pesan dari server
                    const tempEl = document.getElementById(`chat-msg-${tempMsgId}`);
                    if (tempEl) {
                        tempEl.id = `chat-msg-${data.message.id}`;
                        tempEl.setAttribute('data-msg-id', data.message.id);

                        const statusTimeEl = tempEl.querySelector('.chat-status-time');
                        if (statusTimeEl) {
                            statusTimeEl.innerHTML = `<i class="ti ti-check text-primary me-0.5" title="Terkirim"></i> ${data.message.time_formatted || timeFormatted}`;
                        }

                        const dropdownEl = tempEl.querySelector('.chat-msg-dropdown');
                        if (dropdownEl) dropdownEl.classList.remove('d-none');

                        const btnReact = tempEl.querySelector('.btn-react-msg');
                        if (btnReact) {
                            btnReact.setAttribute('data-msg-id', data.message.id);
                            btnReact.classList.remove('d-none');
                        }

                        const btnReply = tempEl.querySelector('.btn-reply-msg');
                        if (btnReply) {
                            btnReply.setAttribute('data-msg-id', data.message.id);
                            btnReply.classList.remove('d-none');
                        }

                        const btnForward = tempEl.querySelector('.btn-forward-msg');
                        if (btnForward) {
                            btnForward.setAttribute('data-msg-id', data.message.id);
                            btnForward.classList.remove('d-none');
                        }

                        const btnPin = tempEl.querySelector('.btn-pin-msg');
                        if (btnPin) {
                            btnPin.setAttribute('data-msg-id', data.message.id);
                            btnPin.classList.remove('d-none');
                        }

                        const btnDelete = tempEl.querySelector('.btn-delete-msg');
                        if (btnDelete) {
                            btnDelete.setAttribute('data-msg-id', data.message.id);
                            btnDelete.classList.remove('d-none');
                        }

                        const btnEdit = tempEl.querySelector('.btn-edit-msg');
                        if (btnEdit) {
                            btnEdit.setAttribute('data-msg-id', data.message.id);
                            btnEdit.classList.remove('d-none');
                        }

                        if (data.message.attachment_url) {
                            const previewLink = tempEl.querySelector('.btn-preview-img-modal');
                            if (previewLink) {
                                previewLink.setAttribute('data-img-url', data.message.attachment_url);
                                previewLink.href = data.message.attachment_url;
                            }
                            const downloadBtn = tempEl.querySelector('a[download]');
                            if (downloadBtn) {
                                downloadBtn.href = data.message.attachment_url;
                            }
                        }
                    }

                    // Sinkronkan unread counts & topbar secara background
                    pollSidebarContacts();
                    if (typeof window.fetchMessagesSilently === 'function') {
                        window.fetchMessagesSilently(false);
                    }
                } else {
                    markMessageFailed(tempMsgId, data && data.message ? data.message : 'Gagal mengirim pesan.');
                }
            })
            .catch(function(err) {
                markMessageFailed(tempMsgId, 'Koneksi terputus saat mengirim.');
            });
        });
    }

    function markMessageFailed(tempId, errorText) {
        const tempEl = document.getElementById(`chat-msg-${tempId}`);
        if (tempEl) {
            const statusTimeEl = tempEl.querySelector('.chat-status-time');
            if (statusTimeEl) {
                statusTimeEl.innerHTML = `<span class="badge bg-danger-subtle text-danger fs-xxs py-0.5 px-1"><i class="ti ti-alert-circle me-1"></i>${escapeHtml(errorText)}</span>`;
            }
        }
    }

    function appendSingleMessage(msg) {
        if (!chatContainer) return;

        // Hapus semua elemen placeholder (Belum Ada Riwayat Obrolan / Loading / Pilih Kontak) seketika detik itu juga
        const placeholders = chatContainer.querySelectorAll('#empty-chat-placeholder, #chat-loading-placeholder, #empty-select-contact-placeholder, .chat-placeholder-box');
        placeholders.forEach(function(el) {
            el.remove();
        });

        const isSender = msg.is_sender !== false;
        const isPending = msg.is_pending === true;
        const avatar = isSender ? currentUserAvatar : (msg.sender_avatar || currentUserAvatar);
        const senderName = isSender ? 'Anda' : (msg.sender_name || 'Pengguna');
        const replyText = msg.body || (msg.attachment_name || (msg.attachment_type === 'voice' ? 'Pesan Suara' : 'Lampiran'));
        const timeIndicator = isPending ? `<i class="ti ti-clock text-muted opacity-75 me-0.5" title="Mengirim..."></i> ${msg.time_formatted}` : `<i class="ti ti-check text-primary me-0.5" title="Terkirim"></i> ${msg.time_formatted}`;
        const isPinned = msg.is_pinned === true;
        const isForwarded = msg.is_forwarded === true;
        const reactions = msg.reactions || [];

        let html = `<div class="d-flex align-items-start gap-2 my-3 chat-item ${isSender ? 'text-end justify-content-end' : ''}" id="chat-msg-${msg.id}" data-msg-id="${msg.id}">`;
        if (!isSender) {
            html += `<img src="${avatar}" class="rounded-circle object-fit-cover shadow-sm flex-shrink-0 chat-avatar-opponent" style="width: 36px; height: 36px; object-fit: cover; object-position: top;" alt="Avatar" />`;
        }
        html += `<div style="max-width: 75%; min-width: 140px;">
            <div class="chat-message py-2 px-3 ${isSender ? 'pe-4 bg-primary-subtle text-dark' : 'ps-4 bg-light text-dark border'} rounded shadow-sm text-start position-relative">
                <div class="dropdown position-absolute top-0 ${isSender ? 'end-0 me-1' : 'start-0 ms-1'} mt-1 chat-msg-dropdown ${isPending ? 'd-none' : ''}">
                    <button class="btn btn-sm btn-link p-0 text-decoration-none dropdown-toggle-no-caret d-flex align-items-center justify-content-center chat-msg-more-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false" title="Opsi Pesan">
                        <i class="ti ti-dots-vertical fs-14"></i>
                    </button>
                    <ul class="dropdown-menu ${isSender ? 'dropdown-menu-end' : 'dropdown-menu-start'} shadow-sm fs-12 py-1 border-0" style="z-index: 1050; min-width: 140px;">
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2 py-1.5 btn-reply-msg" href="javascript:void(0);" data-msg-id="${msg.id}" data-sender-name="${escapeHtml(senderName)}" data-msg-body="${escapeHtml(replyText)}">
                                <i class="ti ti-corner-up-left text-primary fs-14"></i> Balas
                            </a>
                        </li>
                        ${(isSender && msg.body) ? `
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2 py-1.5 btn-edit-msg" href="javascript:void(0);" data-msg-id="${msg.id}" data-msg-body="${escapeHtml(msg.body)}" data-created-at="${msg.created_at_timestamp || Math.floor(Date.now() / 1000)}">
                                <i class="ti ti-edit text-success fs-14"></i> Edit
                            </a>
                        </li>
                        ` : ''}
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2 py-1.5 btn-forward-msg" href="javascript:void(0);" data-msg-id="${msg.id}">
                                <i class="ti ti-arrow-forward-up text-info fs-14"></i> Teruskan
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2 py-1.5 btn-pin-msg" href="javascript:void(0);" data-msg-id="${msg.id}" data-is-pinned="${isPinned ? '1' : '0'}">
                                <i class="ti ${isPinned ? 'ti-pinned-off text-warning' : 'ti-pin text-warning'} fs-14"></i> ${isPinned ? 'Lepas Pin' : 'Pin'}
                            </a>
                        </li>
                        <li><hr class="dropdown-divider my-1"></li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2 py-1.5 text-danger btn-delete-msg" href="javascript:void(0);" data-msg-id="${msg.id}" data-is-sender="${isSender ? '1' : '0'}">
                                <i class="ti ti-trash fs-14"></i> Hapus
                            </a>
                        </li>
                    </ul>
                </div>`;
        
        if (isForwarded) {
            html += `<div class="fs-11 text-muted fst-italic mb-1 d-flex align-items-center gap-1">
                <i class="ti ti-arrow-forward-up fs-12 text-primary"></i> Diteruskan
            </div>`;
        }

        if (msg.parent) {
            const parentId = msg.parent_id || (msg.parent ? msg.parent.id : '');
            html += `<div class="p-2 mb-2 bg-white bg-opacity-75 rounded border-start border-3 border-primary text-start fs-12 shadow-sm reply-quote-box" data-parent-id="${parentId}" role="button" title="Klik untuk menuju pesan yang dibalas">
                <strong class="d-block text-primary fs-11 mb-0.5"><i class="ti ti-corner-up-left me-1"></i>${escapeHtml(msg.parent.sender_name || 'Pesan')}</strong>
                <div class="text-muted text-truncate fs-12">${escapeHtml(msg.parent.body || '')}</div>
            </div>`;
        }

        if (msg.attachment_url) {
            html += renderAttachmentHtml(msg);
        }

        if (msg.body) {
            html += `<div class="fs-13 lh-base text-wrap message-body-text" style="word-break: break-word;">${escapeHtml(msg.body).replace(/\n/g, '<br>')}</div>`;
        }

        html += `</div>

        <!-- ACTION ROW & REACTIONS -->
        <div class="d-flex align-items-center justify-content-between gap-2 text-muted fs-xs mt-1 w-100 px-0.5">
            ${isSender ? `
                <div class="d-flex align-items-center gap-1.5">
                    <button type="button" class="btn btn-link p-0 text-muted btn-react-msg text-decoration-none fs-xs d-inline-flex align-items-center gap-0.5 opacity-75 opacity-100-hover ${isPending ? 'd-none' : ''}" data-msg-id="${msg.id}" title="Beri Reaksi Emoji">
                        <i class="ti ti-mood-smile"></i>
                    </button>
                    <div class="chat-reactions-container d-inline-flex align-items-center gap-1.5" id="chat-reactions-${msg.id}">
                        ${renderReactionsHtml(msg.id, reactions, isSender)}
                    </div>
                </div>
                <div class="d-flex align-items-center gap-1.5 ms-auto">
                    ${isPinned ? '<span class="badge bg-success-subtle text-success border border-success-subtle fs-xxs py-0.5 px-1 pinned-indicator" title="Pesan Disematkan"><i class="ti ti-pin-filled me-0.5"></i> Sematan</span>' : ''}
                    <span class="chat-status-time">${timeIndicator}</span>
                </div>
            ` : `
                <div class="d-flex align-items-center gap-1.5 me-auto">
                    <span class="chat-status-time">${timeIndicator}</span>
                    ${isPinned ? '<span class="badge bg-success-subtle text-success border border-success-subtle fs-xxs py-0.5 px-1 pinned-indicator" title="Pesan Disematkan"><i class="ti ti-pin-filled me-0.5"></i> Sematan</span>' : ''}
                </div>
                <div class="d-flex align-items-center gap-1.5 ms-auto">
                    <div class="chat-reactions-container d-inline-flex align-items-center gap-1.5" id="chat-reactions-${msg.id}">
                        ${renderReactionsHtml(msg.id, reactions, isSender)}
                    </div>
                    <button type="button" class="btn btn-link p-0 text-muted btn-react-msg text-decoration-none fs-xs d-inline-flex align-items-center gap-0.5 opacity-75 opacity-100-hover ${isPending ? 'd-none' : ''}" data-msg-id="${msg.id}" title="Beri Reaksi Emoji">
                        <i class="ti ti-mood-smile"></i>
                    </button>
                </div>
            `}
        </div>
    </div>`;
        if (isSender) {
            html += `<img src="${avatar}" class="rounded-circle object-fit-cover shadow-sm flex-shrink-0 chat-avatar-sender" style="width: 36px; height: 36px; object-fit: cover; object-position: top;" alt="Avatar" />`;
        }
        html += `</div>`;

        appendChatContainerHtml(html);

        if (btnClearChat) {
            btnClearChat.disabled = false;
        }
    }

    // Polling daftar kontak, pesan terakhir, badge unread, dan avatar terbaru secara real-time
    function pollSidebarContacts() {
        if (document.hidden) return;

        fetch('/admin/profil-pengguna/messages/poll-contacts', {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(function(res) {
            if (!res.ok) return null;
            return res.json();
        })
        .then(function(data) {
            if (!data || !data.success || !Array.isArray(data.contacts)) return;

            // Real-time update avatar user aktif jika berubah
            if (data.current_user_avatar && data.current_user_avatar !== currentUserAvatar) {
                currentUserAvatar = data.current_user_avatar;
                document.querySelectorAll('#chat-container .chat-avatar-sender').forEach(function(img) {
                    if (img.src !== data.current_user_avatar) {
                        img.src = data.current_user_avatar;
                    }
                });
            }

            const listRecent = document.getElementById('list-recent-contacts');
            const listOther = document.getElementById('list-other-contacts');
            const secRecent = document.getElementById('section-recent-contacts');
            const secOther = document.getElementById('section-other-contacts');
            const badgeRecent = document.getElementById('badge-recent-count');
            const badgeOther = document.getElementById('badge-other-count');

            data.contacts.forEach(function(c) {
                const contactEl = document.querySelector(`.btn-select-chat[data-user-id="${c.id}"]`);
                if (!contactEl) return;

                // Real-time update avatar & presence kontak di sidebar
                if (c.avatar) {
                    contactEl.setAttribute('data-user-avatar', c.avatar);
                    const contactImg = contactEl.querySelector('img');
                    if (contactImg && contactImg.src !== c.avatar) {
                        contactImg.src = c.avatar;
                    }
                }

                contactEl.setAttribute('data-user-online', c.is_online ? '1' : '0');
                contactEl.setAttribute('data-user-last-seen', c.last_seen_human || 'Offline');

                const contactDot = contactEl.querySelector('.contact-online-dot');
                if (contactDot) {
                    if (c.is_online) {
                        contactDot.className = 'position-absolute bottom-0 end-0 border border-2 border-white rounded-circle contact-online-dot bg-success';
                        contactDot.title = 'Online Sekarang';
                    } else {
                        contactDot.className = 'position-absolute bottom-0 end-0 border border-2 border-white rounded-circle contact-online-dot bg-secondary opacity-50';
                        contactDot.title = c.last_seen_human || 'Offline';
                    }
                }

                const lastMsgEl = contactEl.querySelector('.contact-last-msg');
                const lastTimeEl = contactEl.querySelector('.contact-last-time');
                const unreadBadge = contactEl.querySelector('.contact-unread-badge');

                if (lastMsgEl && c.last_message) lastMsgEl.textContent = c.last_message;
                if (lastTimeEl && c.last_message_time) lastTimeEl.textContent = c.last_message_time;

                const isContactActive = String(activeUserId) === String(c.id);

                // Real-time update avatar & status kehadiran header aktif
                if (isContactActive) {
                    if (c.avatar) {
                        const activeHeaderAvatar = document.getElementById('active-chat-avatar');
                        if (activeHeaderAvatar && activeHeaderAvatar.src !== c.avatar) {
                            activeHeaderAvatar.src = c.avatar;
                            activeHeaderAvatar.classList.remove('d-none');
                        }
                        const modalAvatar = document.getElementById('modal-user-avatar');
                        if (modalAvatar && modalAvatar.src !== c.avatar) {
                            modalAvatar.src = c.avatar;
                        }
                        document.querySelectorAll('#chat-container .chat-avatar-opponent').forEach(function(img) {
                            if (img.src !== c.avatar) {
                                img.src = c.avatar;
                            }
                        });
                    }

                    const activeChatOnlineDot = document.getElementById('active-chat-online-dot');
                    const activeChatStatus = document.getElementById('active-chat-status');

                    if (activeChatOnlineDot) {
                        activeChatOnlineDot.classList.remove('d-none');
                        activeChatOnlineDot.className = `position-absolute bottom-0 end-0 border border-2 border-white rounded-circle ${c.is_online ? 'bg-success' : 'bg-secondary opacity-50'}`;
                    }
                    if (activeChatStatus) {
                        activeChatStatus.textContent = c.is_online ? 'Online Sekarang' : (c.last_seen_human || 'Offline');
                    }
                }

                if (unreadBadge) {
                    if (isContactActive) {
                        unreadBadge.classList.add('d-none');
                        unreadBadge.textContent = '0';
                    } else if (c.unread_count > 0) {
                        unreadBadge.textContent = c.unread_count > 99 ? '99+' : c.unread_count;
                        unreadBadge.classList.remove('d-none');
                    } else {
                        unreadBadge.classList.add('d-none');
                        unreadBadge.textContent = '0';
                    }
                }

                // Jika kontak memiliki percakapan dan sebelumnya di 'other', pindahkan ke 'recent'
                if (c.has_conversation && listOther && listRecent && listOther.contains(contactEl)) {
                    listRecent.prepend(contactEl);
                }

                // Jika kontak TIDAK memiliki percakapan lagi dan sebelumnya di 'recent', pindahkan ke 'other'
                if (!c.has_conversation && listOther && listRecent && listRecent.contains(contactEl)) {
                    listOther.prepend(contactEl);
                }

                // Jika ada pesan baru masuk (unread > 0), tempatkan di urutan teratas list recent
                if (c.unread_count > 0 && listRecent && listRecent.contains(contactEl)) {
                    if (listRecent.firstElementChild !== contactEl) {
                        listRecent.prepend(contactEl);
                    }
                }
            });

            if (badgeRecent && typeof data.recent_count !== 'undefined') badgeRecent.textContent = data.recent_count;
            if (badgeOther && typeof data.other_count !== 'undefined') badgeOther.textContent = data.other_count;

            if (secRecent) {
                if (data.recent_count > 0) secRecent.classList.remove('d-none');
                else secRecent.classList.add('d-none');
            }

            if (secOther) {
                if (data.other_count > 0) {
                    secOther.classList.remove('d-none');
                    if (data.recent_count > 0) secOther.classList.add('mt-2');
                    else secOther.classList.remove('mt-2');
                } else {
                    secOther.classList.add('d-none');
                }
            }
        })
        .catch(function(err) {});
    }

    // 1. Polling daftar kontak & badge unread sidebar setiap 3.5 detik
    setInterval(pollSidebarContacts, 3500);

    // 2. Polling obrolan aktif setiap 3.5 detik jika ada kontak yang sedang dibuka
    setInterval(function() {
        if (activeUserId && !document.hidden) {
            loadConversation(activeUserId, true);
        }
    }, 3500);

    // ==========================================
    // EMOJI / EMOTION PICKER & INSERTION ENGINE
    // ==========================================
    const emojiPickerContainer = document.getElementById('emoji-picker-container');
    const btnToggleEmoji = document.getElementById('btn-toggle-emoji');
    const btnCloseEmoji = document.getElementById('btn-close-emoji');
    const emojiSearchInput = document.getElementById('emoji-search-input');
    const emojiGridContainer = document.getElementById('emoji-grid-container');

    const EMOJI_DATABASE = {
        smileys: [
            { char: '😀', tags: 'senyum lebar gembira grinning happy smile' },
            { char: '😃', tags: 'senyum ceria bahagia smiley joy' },
            { char: '😄', tags: 'tertawa senang smile haha lol' },
            { char: '😁', tags: 'nyengir gembira grin teeth' },
            { char: '😆', tags: 'tertawa terbahak laughing ngakak' },
            { char: '😅', tags: 'senyum keringat lega sweat smile whew' },
            { char: '🤣', tags: 'tertawa guling rofl ngakak parah' },
            { char: '😂', tags: 'menangis tertawa joy ngakak nangis' },
            { char: '🙂', tags: 'senyum tipis ramah slightly smiling' },
            { char: '🙃', tags: 'senyum terbalik sarkas upside down' },
            { char: '😉', tags: 'kedip mata genit wink flirty' },
            { char: '😊', tags: 'tersipu malu manis blush warm' },
            { char: '😇', tags: 'malaikat suci baik angel innocent' },
            { char: '🥰', tags: 'penuh cinta sayang hearts lovely' },
            { char: '😍', tags: 'kagum suka cinta heart eyes love' },
            { char: '🤩', tags: 'terpukau bintang star struck amazing' },
            { char: '😘', tags: 'cium cinta blow kiss love' },
            { char: '😗', tags: 'cium biasa kissing cute' },
            { char: '😚', tags: 'cium mesra kissing closed eyes' },
            { char: '😋', tags: 'lezat enak sedap yum delicious' },
            { char: '😛', tags: 'melet lidah bercanda tongue' },
            { char: '😜', tags: 'melet kedip konyol wink tongue crazy' },
            { char: '🤪', tags: 'gila seru konyol zany goofy' },
            { char: '😝', tags: 'melet tertawa squint tongue funny' },
            { char: '🤗', tags: 'peluk hangat hugging friendly' },
            { char: '🤭', tags: 'menutup mulut kaget hand over mouth oops' },
            { char: '🤫', tags: 'diam rahasia sst shushing quiet secret' },
            { char: '🤔', tags: 'mikir berpikir ide thinking question' },
            { char: '🤐', tags: 'tutup mulut kunci zipper secret' },
            { char: '🤨', tags: 'curiga heran raised eyebrow skeptic' },
            { char: '😐', tags: 'netral datar neutral poker face' },
            { char: '😑', tags: 'tanpa ekspresi jengkel expressionless' },
            { char: '😶', tags: 'diam hening no mouth silent' },
            { char: '😏', tags: 'senyum sinis nakal smirk sly' },
            { char: '😒', tags: 'kesal tidak puas unamused annoyed' },
            { char: '🙄', tags: 'memutar mata bosan rolling eyes whatever' },
            { char: '😬', tags: 'meringis canggung grimace awkward' },
            { char: '🤥', tags: 'bohong pinokio lying liar' },
            { char: '😌', tags: 'lega tenang damai relieved peaceful' },
            { char: '😔', tags: 'sedih murung lesu pensive sad' },
            { char: '😪', tags: 'mengantuk lelah sleepy tired' },
            { char: '🤤', tags: 'ngiler mau sedap drooling want' },
            { char: '😴', tags: 'tidur zzz sleeping bed' },
            { char: '😷', tags: 'masker sakit flu mask hospital' },
            { char: '🤒', tags: 'demam panas sakit thermometer sick' },
            { char: '🤕', tags: 'terluka perban head bandage hurt' },
            { char: '🤢', tags: 'mual ingin muntah nauseated sick' },
            { char: '🤮', tags: 'muntah vomiting sick gross' },
            { char: '🤧', tags: 'bersin pilek sneezing cold flu' },
            { char: '🥵', tags: 'kepanasan gerah hot face summer' },
            { char: '🥶', tags: 'kedinginan beku cold face freezing' },
            { char: '🥴', tags: 'pusing teler woozy tipsy' },
            { char: '😵', tags: 'pusing pingsan dizzy knockout' },
            { char: '🤯', tags: 'pikiran meledak kaget exploding mindblown' },
            { char: '🤠', tags: 'koboi cowboy hat cool' },
            { char: '🥳', tags: 'pesta perayaan selamat partying celebrate' },
            { char: '😎', tags: 'keren kacamata gaya cool swag' },
            { char: '🤓', tags: 'kutu buku pintar kacamata nerd smart geek' },
            { char: '🧐', tags: 'mengamati teliti cek periksa monocle inspect' },
            { char: '😕', tags: 'bingung ragu confused puzzled' },
            { char: '😟', tags: 'cemas khawatir worried anxious' },
            { char: '🙁', tags: 'cemberut sedikit sedih frowning sad' },
            { char: '😮', tags: 'mulut terbuka kaget open mouth wow' },
            { char: '😯', tags: 'terperangah hushed surprised' },
            { char: '😲', tags: 'terkejut kaget astonished shocked' },
            { char: '😳', tags: 'malu kaget merah flushed shy' },
            { char: '🥺', tags: 'memohon sedih puppy eyes pleading please' },
            { char: '😦', tags: 'kaget kecewa frowning open mouth' },
            { char: '😧', tags: 'terpukul cemas anguished hurt' },
            { char: '😨', tags: 'takut kaget fearful scared' },
            { char: '😰', tags: 'keringat dingin anxious sweat panic' },
            { char: '😥', tags: 'sedih lega sad relieved whew' },
            { char: '😢', tags: 'menangis sedih air mata crying tear' },
            { char: '😭', tags: 'menangis tersedu kejer sob weeping loud' },
            { char: '😱', tags: 'berteriak takut jerit scream horror panic' },
            { char: '😖', tags: 'jengkel tersiksa confounded frustrated' },
            { char: '😣', tags: 'menahan sakit lelah persevering struggle' },
            { char: '😞', tags: 'kecewa pupus sedih disappointed sad' },
            { char: '😓', tags: 'putus asa letih downcast sweat' },
            { char: '😩', tags: 'lelah letih pasrah weary exhausted' },
            { char: '😫', tags: 'capek lelah sangat tired drained' },
            { char: '🥱', tags: 'menguap mengantuk yawning sleepy' },
            { char: '😤', tags: 'mendengus bertekad triumph steam furious' },
            { char: '😡', tags: 'marah murka merah pouting enraged angry' },
            { char: '😠', tags: 'marah kesal angry mad' },
            { char: '🤬', tags: 'memaki sensor marah cursing mad swearing' },
            { char: '😈', tags: 'iblis tersenyum jahat devil evil smile' },
            { char: '👿', tags: 'iblis marah devil angry evil' },
            { char: '💀', tags: 'tengkorak mati ngakak skull dead' },
            { char: '💩', tags: 'kotoran lucu poop crap funny' },
            { char: '🤡', tags: 'badut lelucon clown joke silly' },
            { char: '👻', tags: 'hantu bayangan ghost spooky boo' },
            { char: '👽', tags: 'alien luar angkasa ufo extraterrestrial' },
            { char: '🤖', tags: 'robot bot mesin ai artificial' }
        ],
        gestures: [
            { char: '👍', tags: 'jempol mantap setuju oke sip thumbs up ok' },
            { char: '👎', tags: 'jempol bawah tidak setuju jelek thumbs down bad' },
            { char: '👌', tags: 'oke sempurna pas mantap ok hand perfect' },
            { char: '🤌', tags: 'pinched fingers maksud apa gesture' },
            { char: '🤏', tags: 'sedikit kecil tipis pinching little bit' },
            { char: '✌️', tags: 'damai peace salam dua jari victory' },
            { char: '🤞', tags: 'semoga beruntung doa crossed fingers luck' },
            { char: '🫰', tags: 'saranghae love jari korea finger heart' },
            { char: '🤟', tags: 'aku cinta kamu metal gaul love you gesture' },
            { char: '🤘', tags: 'musik rock metal keren rock on horns' },
            { char: '🤙', tags: 'hubungi saya telepon santai call me hang loose' },
            { char: '👈', tags: 'tunjuk kiri pointing left direction' },
            { char: '👉', tags: 'tunjuk kanan ini pointing right here' },
            { char: '👆', tags: 'tunjuk atas perhatikan pointing up look' },
            { char: '👇', tags: 'tunjuk bawah cek ini pointing down check' },
            { char: '☝️', tags: 'nomor satu satu telunjuk index pointing up one' },
            { char: '🖐️', tags: 'lima tangan buka splayed fingers five' },
            { char: '✋', tags: 'angkat tangan berhenti stop raised hand wait' },
            { char: '🖖', tags: 'salam spock vulcan salute live long' },
            { char: '🤝', tags: 'jabat tangan salaman deal sepakat handshake partner' },
            { char: '👏', tags: 'tepuk tangan applause salut hebat clapping bravo' },
            { char: '🙌', tags: 'angkat tangan syukur hore raising hands celebrate' },
            { char: '🫶', tags: 'bentuk hati tangan cinta heart hands love' },
            { char: '🤲', tags: 'berdoa memohon syukur palms up together pray' },
            { char: '🙏', tags: 'terima kasih mohon maaf please thanks pray' },
            { char: '🤜', tags: 'kepalan tos fist bump right' },
            { char: '🤛', tags: 'kepalan tos bro fist bump left' },
            { char: '✊', tags: 'kepalan tangan semangat juang raised fist power' },
            { char: '👊', tags: 'tinju pukulan tos punch oncoming fist' },
            { char: '👋', tags: 'lambaian tangan halo dadah waving hand bye hi' },
            { char: '🫂', tags: 'pelukan erat hangat teman people hugging hug' },
            { char: '💋', tags: 'bekas ciuman bibir kiss mark lips' },
            { char: '💯', tags: 'seratus persen sempurna juara hundred points perfect' },
            { char: '🔥', tags: 'api semangat panas gacor jos fire lit hot' },
            { char: '✨', tags: 'kilauan bersinar baru estetik sparkles shine magic' },
            { char: '🌟', tags: 'bintang bersinar terang glowing star shining' },
            { char: '💥', tags: 'ledakan tabrakan boom collision blast' }
        ],
        hearts: [
            { char: '❤️', tags: 'hati merah cinta sayang love red heart' },
            { char: '🧡', tags: 'hati oranye hangat orange heart care' },
            { char: '💛', tags: 'hati kuning sahabat yellow heart friend' },
            { char: '💚', tags: 'hati hijau damai alam green heart nature' },
            { char: '💙', tags: 'hati biru tenang setia blue heart trust' },
            { char: '💜', tags: 'hati ungu elegan purple heart royal' },
            { char: '🖤', tags: 'hati hitam keren misteri black heart cool' },
            { char: '🤍', tags: 'hati putih suci tulus white heart pure' },
            { char: '🤎', tags: 'hati cokelat brown heart warm' },
            { char: '💔', tags: 'patah hati sedih putus broken heart sad' },
            { char: '❤️‍🔥', tags: 'hati membara gelora rindu heart on fire passion' },
            { char: '❤️‍🩹', tags: 'hati sembuh pulih mending heart healing' },
            { char: '❣️', tags: 'tanda seru hati heart exclamation love' },
            { char: '💕', tags: 'dua hati manis two hearts lovely' },
            { char: '💞', tags: 'hati berputar harmonis revolving hearts' },
            { char: '💓', tags: 'detak jantung berdebar beating heart heartbeat' },
            { char: '💗', tags: 'hati membesar kasih growing heart expand' },
            { char: '💖', tags: 'hati berkilau sparkling heart sparkle' },
            { char: '💘', tags: 'panah asmara cupid cinta heart with arrow' },
            { char: '💝', tags: 'kado cinta hadiah ribbon gift heart' },
            { char: '💟', tags: 'dekorasi hati heart decoration ornament' }
        ],
        objects: [
            { char: '🎉', tags: 'terompet pesta selamat perayaan party popper celebrate' },
            { char: '🎊', tags: 'konfeti bola pesta kemeriahan confetti ball' },
            { char: '🎁', tags: 'hadiah kado bingkisan kejutan gift wrapped present' },
            { char: '🏆', tags: 'piala juara pemenang nomor satu trophy champion winner' },
            { char: '🥇', tags: 'medali emas juara satu medal first place gold' },
            { char: '🎯', tags: 'sasaran target fokus tepat bullseye direct hit goal' },
            { char: '🚀', tags: 'roket meluncur cepat gas launch rocket fast' },
            { char: '💡', tags: 'lampu bohlam ide terang cemerlang light bulb idea smart' },
            { char: '📌', tags: 'pin paku semat penting tandai pushpin pin memo' },
            { char: '📍', tags: 'lokasi titik pin koordinat map marker pin location' },
            { char: '📝', tags: 'catatan tulis memo tugas agenda memo write note' },
            { char: '📅', tags: 'kalender tanggal jadwal rapat calendar date schedule' },
            { char: '🕒', tags: 'jam waktu pukul pengingat clock time watch' },
            { char: '💼', tags: 'tas kerja koper kantor bisnis briefcase work business' },
            { char: '💻', tags: 'laptop komputer kerja ngoding laptop computer tech' },
            { char: '📱', tags: 'handphone telepon seluler hp smartphone mobile phone' },
            { char: '🔒', tags: 'terkunci aman privasi rahasia locked secure privacy' },
            { char: '🔑', tags: 'kunci akses kata sandi solusi key password unlock' },
            { char: '✅', tags: 'centang hijau benar sukses selesai check mark ok done' },
            { char: '❌', tags: 'silang merah salah batal tolak cross mark error cancel' },
            { char: '⚠️', tags: 'peringatan awas hati-hati bahaya warning alert caution' },
            { char: '❓', tags: 'tanda tanya kenapa ada apa question mark why' },
            { char: '❗', tags: 'tanda seru penting perhatian exclamation mark important' },
            { char: '💬', tags: 'balon obrolan chat pesan bicara speech balloon chat message' },
            { char: '💭', tags: 'balon pikiran mikir impian thought balloon thinking' }
        ],
        activities: [
            { char: '☕', tags: 'kopi teh hangat istirahat santai coffee tea break relax' },
            { char: '🍕', tags: 'pizza makanan enak makan siang pizza food slice' },
            { char: '🍔', tags: 'hamburger burger fastfood makan hamburger food' },
            { char: '🍻', tags: 'bersulang cheers minum bersama beer toast drink' },
            { char: '🥂', tags: 'gelas anggur perayaan selamat cheers champagne toast' },
            { char: '🎂', tags: 'kue ulang tahun ultah selamat birthday cake sweet' },
            { char: '🍰', tags: 'kue manis dessert lezat shortcake cake pastry' },
            { char: '🍦', tags: 'es krim segar manis ice cream sweet cold' },
            { char: '🍿', tags: 'popcorn nonton bioskop film movie snack' },
            { char: '🚗', tags: 'mobil jalan perjalanan otw car auto drive travel' },
            { char: '✈️', tags: 'pesawat terbang liburan perjalanan tugas airplane flight holiday' },
            { char: '🏖️', tags: 'pantai liburan santai holiday healing beach summer vacation' },
            { char: '🎵', tags: 'musik lagu nada santai music note song melody' },
            { char: '🎮', tags: 'video game main permainan seru gamepad gaming play' },
            { char: '⚽', tags: 'sepak bola olahraga tanding bola soccer football ball' },
            { char: '🏀', tags: 'basket olahraga tim basketball ball sports' }
        ]
    };

    let currentEmojiCategory = 'smileys';

    function renderEmojiGrid(category = 'smileys', filterQuery = '') {
        if (!emojiGridContainer) return;

        let list = [];
        const query = filterQuery.toLowerCase().trim();

        if (query !== '') {
            // Filter pencarian di semua kategori emoji
            Object.keys(EMOJI_DATABASE).forEach(function(cat) {
                EMOJI_DATABASE[cat].forEach(function(item) {
                    if (item.tags.includes(query) || item.char.includes(query)) {
                        if (!list.some(function(i) { return i.char === item.char; })) {
                            list.push(item);
                        }
                    }
                });
            });
        } else {
            list = EMOJI_DATABASE[category] || [];
        }

        if (list.length === 0) {
            emojiGridContainer.innerHTML = `<div class="col-12 text-center py-3 text-muted fs-12" style="grid-column: 1 / -1;">
                <i class="ti ti-mood-empty fs-18 d-block mb-1"></i>Emoji tidak ditemukan
            </div>`;
            return;
        }

        let html = '';
        list.forEach(function(item) {
            html += `<button type="button" class="emoji-btn btn-insert-emoji" data-emoji="${item.char}" title="${item.char}">${item.char}</button>`;
        });

        emojiGridContainer.innerHTML = html;
    }

    // Inisialisasi awal render grid emoji
    renderEmojiGrid(currentEmojiCategory);

    // Toggle Popup Emoji Picker
    if (btnToggleEmoji && emojiPickerContainer) {
        btnToggleEmoji.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const isHidden = emojiPickerContainer.classList.contains('d-none');
            if (isHidden) {
                emojiPickerContainer.classList.remove('d-none');
                if (emojiSearchInput) {
                    emojiSearchInput.value = '';
                    setTimeout(function() { emojiSearchInput.focus(); }, 100);
                }
                renderEmojiGrid(currentEmojiCategory);
            } else {
                emojiPickerContainer.classList.add('d-none');
            }
        });
    }

    // Close Popup Emoji
    if (btnCloseEmoji && emojiPickerContainer) {
        btnCloseEmoji.addEventListener('click', function(e) {
            e.preventDefault();
            emojiPickerContainer.classList.add('d-none');
        });
    }

    // Tab Kategori Emoji
    document.querySelectorAll('#emoji-category-tabs .btn-emoji-cat').forEach(function(tabBtn) {
        tabBtn.addEventListener('click', function(e) {
            e.preventDefault();
            document.querySelectorAll('#emoji-category-tabs .btn-emoji-cat').forEach(function(b) { b.classList.remove('active'); });
            tabBtn.classList.add('active');

            const category = tabBtn.getAttribute('data-category');
            currentEmojiCategory = category;
            if (emojiSearchInput) emojiSearchInput.value = '';
            renderEmojiGrid(category);
        });
    });

    // Pencarian Emoji Real-Time
    if (emojiSearchInput) {
        emojiSearchInput.addEventListener('keyup', function(e) {
            const q = e.target.value;
            renderEmojiGrid(currentEmojiCategory, q);
        });
    }

    // Event Delegation Sisipkan Emoji ke Kolom Input
    document.addEventListener('click', function(e) {
        const btnEmoji = e.target.closest('.btn-insert-emoji');
        if (!btnEmoji) return;
        e.preventDefault();

        const emoji = btnEmoji.getAttribute('data-emoji');
        if (!emoji || !chatInput) return;

        // Sisipkan emoji pada posisi kursor saat ini
        const startPos = chatInput.selectionStart || 0;
        const endPos = chatInput.selectionEnd || 0;
        const textBefore = chatInput.value.substring(0, startPos);
        const textAfter = chatInput.value.substring(endPos, chatInput.value.length);

        chatInput.value = textBefore + emoji + textAfter;
        const newPos = startPos + emoji.length;
        chatInput.setSelectionRange(newPos, newPos);
        chatInput.focus();
    });

    // Tutup Emoji Picker jika mengklik di luar area
    document.addEventListener('click', function(e) {
        if (!emojiPickerContainer || emojiPickerContainer.classList.contains('d-none')) return;
        if (!emojiPickerContainer.contains(e.target) && !btnToggleEmoji.contains(e.target)) {
            emojiPickerContainer.classList.add('d-none');
        }
    });

    // Tutup Emoji Picker saat tombol ESC ditekan
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && emojiPickerContainer && !emojiPickerContainer.classList.contains('d-none')) {
            emojiPickerContainer.classList.add('d-none');
        }
    });

    // Event Delegation Hapus Pesan Chat
    document.addEventListener('click', function(e) {
        const btnDelete = e.target.closest('.btn-delete-msg');
        if (!btnDelete) return;
        e.preventDefault();

        const msgId = btnDelete.getAttribute('data-msg-id');
        const isSender = btnDelete.getAttribute('data-is-sender') === '1' || btnDelete.getAttribute('data-is-sender') === 'true';

        if (!msgId || String(msgId).startsWith('temp_')) return;

        const confirmTitle = isSender ? 'Tarik & Hapus Pesan?' : 'Hapus Pesan untuk Saya?';
        const confirmText = isSender 
            ? 'Pesan yang Anda kirim akan ditarik dan dihapus permanen untuk semua orang (tidak terlihat lagi oleh lawan chat maupun Anda).' 
            : 'Pesan ini hanya akan dihapus dari tampilan obrolan Anda. Pengirim / lawan chat tetap dapat melihat pesan ini.';

        const doDelete = function() {
            fetch(`/admin/profil-pengguna/messages/${msgId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': getCsrfToken(),
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(function(res) { return res.json(); })
            .then(function(data) {
                if (data && data.success) {
                    // Jika pesan yang sedang dibalas adalah pesan ini, batalkan preview balasan
                    const replyParentInput = document.getElementById('reply-parent-id');
                    if (replyParentInput && replyParentInput.value === String(msgId)) {
                        cancelReplyState();
                    }

                    // Hapus elemen pesan dari DOM dengan animasi halus
                    const msgEl = document.getElementById(`chat-msg-${msgId}`);
                    if (msgEl) {
                        msgEl.style.transition = 'all 0.25s ease-out';
                        msgEl.style.opacity = '0';
                        msgEl.style.transform = 'scale(0.95)';
                        setTimeout(function() {
                            msgEl.remove();

                            // Periksa apakah masih ada pesan tersisa di kontainer
                            const remainingItems = chatContainer.querySelectorAll('.chat-item');
                            if (remainingItems.length === 0) {
                                if (btnClearChat) btnClearChat.disabled = true;
                                if (activeUserId) demoteContactToOther(activeUserId);
                                setChatContainerHtml(`
                                    <div class="text-center py-5 text-muted chat-placeholder-box" id="empty-chat-placeholder">
                                        <div class="avatar-md mx-auto mb-2">
                                            <span class="avatar-title text-bg-light text-primary rounded-circle fs-24">
                                                <i class="ti ti-messages"></i>
                                            </span>
                                        </div>
                                        <h6 class="fs-14 fw-semibold text-dark mb-1">Belum Ada Riwayat Obrolan</h6>
                                        <p class="fs-12 mb-0">Mulai percakapan dengan mengetikkan pesan di bawah ini.</p>
                                    </div>
                                `);
                            }
                        }, 250);
                    }

                    if (typeof window.showToast === 'function') {
                        window.showToast(data.message, 'success');
                    }

                    // Sinkronkan sidebar kontak & badge unread
                    pollSidebarContacts();
                    if (typeof window.fetchMessagesSilently === 'function') {
                        window.fetchMessagesSilently(false);
                    }
                } else {
                    if (typeof window.showError === 'function') {
                        window.showError(data && data.message ? data.message : 'Gagal menghapus pesan.');
                    }
                }
            })
            .catch(function(err) {
                if (typeof window.showError === 'function') {
                    window.showError('Terjadi kesalahan koneksi saat menghapus pesan.');
                }
            });
        };

        if (typeof window.showConfirm === 'function') {
            window.showConfirm({
                title: confirmTitle,
                text: confirmText,
                isDanger: true,
                onConfirm: doDelete
            });
        } else {
            if (confirm(confirmText)) {
                doDelete();
            }
        }
    });

    // Event Listener Bersihkan Seluruh Riwayat Obrolan
    if (btnClearChat) {
        btnClearChat.addEventListener('click', function(e) {
            e.preventDefault();
            if (!activeUserId) return;

            const activeName = activeChatName ? activeChatName.textContent.trim() : 'pengguna ini';

            const confirmClear = function() {
                fetch(`/admin/profil-pengguna/messages/conversation/${activeUserId}/clear`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': getCsrfToken(),
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(function(res) { return res.json(); })
                .then(function(data) {
                    if (data && data.success) {
                        cancelReplyState();
                        lastMessageCount = 0;
                        lastMessageId = null;

                        setChatContainerHtml(`
                            <div class="text-center py-5 text-muted chat-placeholder-box" id="empty-chat-placeholder">
                                <div class="avatar-md mx-auto mb-2">
                                    <span class="avatar-title text-bg-light text-primary rounded-circle fs-24">
                                        <i class="ti ti-messages"></i>
                                    </span>
                                </div>
                                <h6 class="fs-14 fw-semibold text-dark mb-1">Belum Ada Riwayat Obrolan</h6>
                                <p class="fs-12 mb-0">Mulai percakapan dengan mengetikkan pesan di bawah ini.</p>
                            </div>
                        `);

                        if (btnClearChat) btnClearChat.disabled = true;

                        // Pindahkan kontak langsung ke "Pengguna Lainnya" seketika tanpa perlu refresh
                        if (activeUserId) {
                            demoteContactToOther(activeUserId);
                        }

                        if (typeof window.showToast === 'function') {
                            window.showToast(data.message, 'success');
                        }

                        pollSidebarContacts();
                        if (typeof window.fetchMessagesSilently === 'function') {
                            window.fetchMessagesSilently(false);
                        }
                    } else {
                        if (typeof window.showError === 'function') {
                            window.showError(data && data.message ? data.message : 'Gagal membersihkan riwayat obrolan.');
                        }
                    }
                })
                .catch(function(err) {
                    if (typeof window.showError === 'function') {
                        window.showError('Terjadi kesalahan jaringan saat membersihkan obrolan.');
                    }
                });
            };

            if (typeof window.showConfirm === 'function') {
                window.showConfirm({
                    title: 'Bersihkan Seluruh Riwayat Obrolan?',
                    text: `Semua riwayat percakapan dengan ${activeName} akan dihapus dari tampilan Anda. Lawan obrolan Anda tetap dapat melihat seluruh riwayat percakapan tersebut.`,
                    isDanger: true,
                    onConfirm: confirmClear
                });
            } else {
                if (confirm(`Bersihkan riwayat obrolan dengan ${activeName}? Lawan obrolan tetap dapat melihatnya.`)) {
                    confirmClear();
                }
            }
        });
    }

    // ==========================================
    // 1. IN-CHAT SEARCH BAR LOGIC
    // ==========================================
    document.addEventListener('click', function(e) {
        const btnSearch = e.target.closest('#btn-toggle-search');
        if (btnSearch) {
            e.preventDefault();
            if (btnSearch.disabled) return;

            const searchBar = document.getElementById('in-chat-search-bar');
            if (searchBar) {
                const isHidden = searchBar.classList.contains('d-none');
                if (isHidden) {
                    searchBar.classList.remove('d-none');
                    const searchInput = document.getElementById('input-search-in-chat');
                    if (searchInput) {
                        setTimeout(function() { searchInput.focus(); }, 50);
                        if (searchInput.value.trim() !== '') {
                            performInChatSearch(searchInput.value.trim());
                        }
                    }
                } else {
                    closeInChatSearch();
                }
            }
            return;
        }

        const btnClose = e.target.closest('#btn-close-search');
        if (btnClose) {
            e.preventDefault();
            closeInChatSearch();
            return;
        }

        const btnClear = e.target.closest('#btn-clear-in-chat-search');
        if (btnClear) {
            e.preventDefault();
            const searchInput = document.getElementById('input-search-in-chat');
            if (searchInput) {
                searchInput.value = '';
                performInChatSearch('');
                searchInput.focus();
            }
            return;
        }

        const btnNext = e.target.closest('#btn-search-next');
        if (btnNext) {
            e.preventDefault();
            if (searchMatches.length > 0) {
                currentSearchIndex = (currentSearchIndex + 1) % searchMatches.length;
                highlightCurrentMatch();
            }
            return;
        }

        const btnPrev = e.target.closest('#btn-search-prev');
        if (btnPrev) {
            e.preventDefault();
            if (searchMatches.length > 0) {
                currentSearchIndex = (currentSearchIndex - 1 + searchMatches.length) % searchMatches.length;
                highlightCurrentMatch();
            }
            return;
        }
    });

    function closeInChatSearch() {
        const searchBar = document.getElementById('in-chat-search-bar');
        const searchInput = document.getElementById('input-search-in-chat');
        const countBadge = document.getElementById('search-match-count');
        const btnPrev = document.getElementById('btn-search-prev');
        const btnNext = document.getElementById('btn-search-next');
        const btnClear = document.getElementById('btn-clear-in-chat-search');

        if (searchBar) searchBar.classList.add('d-none');
        if (searchInput) searchInput.value = '';
        if (btnClear) btnClear.style.display = 'none';
        if (btnPrev) btnPrev.disabled = true;
        if (btnNext) btnNext.disabled = true;

        clearSearchHighlights();
        searchMatches = [];
        currentSearchIndex = -1;
        if (countBadge) {
            countBadge.textContent = '0 dari 0';
            countBadge.classList.add('d-none');
        }
    }

    function clearSearchHighlights() {
        document.querySelectorAll('#chat-container .message-body-text').forEach(function(el) {
            if (el.hasAttribute('data-raw-body')) {
                el.innerHTML = escapeHtml(el.getAttribute('data-raw-body')).replace(/\n/g, '<br>');
                el.removeAttribute('data-raw-body');
            }
        });
    }

    function performInChatSearch(query) {
        clearSearchHighlights();
        searchMatches = [];
        currentSearchIndex = -1;

        const countBadge = document.getElementById('search-match-count');
        const btnPrev = document.getElementById('btn-search-prev');
        const btnNext = document.getElementById('btn-search-next');
        const btnClear = document.getElementById('btn-clear-in-chat-search');

        if (btnClear) {
            btnClear.style.display = query ? 'inline-block' : 'none';
        }

        if (!query) {
            if (countBadge) {
                countBadge.textContent = '0 dari 0';
                countBadge.classList.add('d-none');
            }
            if (btnPrev) btnPrev.disabled = true;
            if (btnNext) btnNext.disabled = true;
            return;
        }

        const bodyEls = document.querySelectorAll('#chat-container .message-body-text');
        const escapedQuery = query.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
        const regex = new RegExp(`(${escapedQuery})`, 'gi');

        bodyEls.forEach(function(el) {
            const rawText = el.getAttribute('data-raw-body') || el.textContent || '';
            if (regex.test(rawText)) {
                el.setAttribute('data-raw-body', rawText);
                const safeHtml = escapeHtml(rawText).replace(/\n/g, '<br>');
                el.innerHTML = safeHtml.replace(regex, '<mark class="search-match bg-warning text-dark px-0.5 rounded fw-semibold">$1</mark>');
            }
        });

        searchMatches = Array.from(document.querySelectorAll('#chat-container mark.search-match'));
        if (searchMatches.length > 0) {
            currentSearchIndex = 0;
            if (btnPrev) btnPrev.disabled = false;
            if (btnNext) btnNext.disabled = false;
            highlightCurrentMatch();
        } else {
            if (countBadge) {
                countBadge.textContent = '0 dari 0';
                countBadge.classList.remove('d-none');
            }
            if (btnPrev) btnPrev.disabled = true;
            if (btnNext) btnNext.disabled = true;
        }
    }

    function highlightCurrentMatch() {
        if (searchMatches.length === 0) return;
        searchMatches.forEach(function(m) {
            m.classList.remove('bg-danger', 'text-white');
            m.classList.add('bg-warning', 'text-dark');
        });

        const current = searchMatches[currentSearchIndex];
        if (current) {
            current.classList.remove('bg-warning', 'text-dark');
            current.classList.add('bg-danger', 'text-white');
            current.scrollIntoView({ behavior: 'smooth', block: 'center' });

            const bubble = current.closest('.chat-message');
            if (bubble) {
                bubble.classList.remove('chat-message-highlight');
                void bubble.offsetWidth;
                bubble.classList.add('chat-message-highlight');
            }
        }

        const countBadge = document.getElementById('search-match-count');
        if (countBadge) {
            countBadge.textContent = `${currentSearchIndex + 1} dari ${searchMatches.length}`;
            countBadge.classList.remove('d-none');
        }
    }

    document.addEventListener('input', function(e) {
        if (e.target && e.target.id === 'input-search-in-chat') {
            performInChatSearch(e.target.value.trim());
        }
    });

    document.addEventListener('keydown', function(e) {
        if (e.target && e.target.id === 'input-search-in-chat') {
            if (e.key === 'Enter') {
                e.preventDefault();
                if (searchMatches.length > 0) {
                    if (e.shiftKey) {
                        currentSearchIndex = (currentSearchIndex - 1 + searchMatches.length) % searchMatches.length;
                    } else {
                        currentSearchIndex = (currentSearchIndex + 1) % searchMatches.length;
                    }
                    highlightCurrentMatch();
                }
            } else if (e.key === 'Escape') {
                closeInChatSearch();
            }
        }
    });

    // ==========================================
    // 2. PINNED MESSAGES LOGIC
    // ==========================================
    if (btnJumpToPinned) {
        btnJumpToPinned.addEventListener('click', function(e) {
            e.preventDefault();
            if (!currentPinnedMessageId) return;
            const targetEl = document.getElementById(`chat-msg-${currentPinnedMessageId}`);
            if (targetEl) {
                targetEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
                const bubble = targetEl.querySelector('.chat-message') || targetEl;
                bubble.classList.remove('chat-message-highlight');
                void bubble.offsetWidth;
                bubble.classList.add('chat-message-highlight');
            } else {
                if (typeof window.showToast === 'function') {
                    window.showToast('Pesan sematan berada di luar riwayat saat ini.', 'info');
                }
            }
        });
    }

    if (btnUnpinBanner) {
        btnUnpinBanner.addEventListener('click', function(e) {
            e.preventDefault();
            if (!currentPinnedMessageId) return;
            togglePinMessage(currentPinnedMessageId);
        });
    }

    document.addEventListener('click', function(e) {
        const btnPin = e.target.closest('.btn-pin-msg');
        if (!btnPin) return;
        e.preventDefault();
        const msgId = btnPin.getAttribute('data-msg-id');
        if (!msgId) return;
        togglePinMessage(msgId);
    });

    function togglePinMessage(msgId) {
        fetch(`/admin/profil-pengguna/messages/${msgId}/toggle-pin`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': getCsrfToken(),
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(function(res) { return res.json(); })
        .then(function(data) {
            if (data && data.success) {
                if (typeof window.showToast === 'function') {
                    window.showToast(data.message, 'success');
                }
                if (activeUserId) {
                    loadConversation(activeUserId, false);
                }
            } else {
                if (typeof window.showError === 'function') {
                    window.showError(data && data.message ? data.message : 'Gagal mengubah sematan pesan.');
                }
            }
        })
        .catch(function(err) {
            if (typeof window.showError === 'function') {
                window.showError('Terjadi kesalahan jaringan.');
            }
        });
    }

    // ==========================================
    // 3. MESSAGE REACTIONS LOGIC
    // ==========================================
    document.addEventListener('click', function(e) {
        const btnReact = e.target.closest('.btn-react-msg');
        if (btnReact) {
            e.preventDefault();
            e.stopPropagation();
            const msgId = btnReact.getAttribute('data-msg-id');
            activeReactMessageId = msgId;

            if (quickReactionPopover) {
                if (quickReactionPopover.parentNode !== document.body) {
                    document.body.appendChild(quickReactionPopover);
                }

                const rect = btnReact.getBoundingClientRect();
                const popoverWidth = 240;
                let leftPos = rect.left - 80;
                if (leftPos + popoverWidth > window.innerWidth - 10) {
                    leftPos = window.innerWidth - popoverWidth - 10;
                }
                if (leftPos < 10) leftPos = 10;

                let topPos = rect.top - 46;
                if (topPos < 10) {
                    topPos = rect.bottom + 8;
                }

                quickReactionPopover.style.position = 'fixed';
                quickReactionPopover.style.zIndex = '99999';
                quickReactionPopover.style.top = `${topPos}px`;
                quickReactionPopover.style.left = `${leftPos}px`;
                quickReactionPopover.classList.remove('d-none');
            }
            return;
        }

        const btnQuickEmoji = e.target.closest('.btn-quick-react');
        if (btnQuickEmoji) {
            e.preventDefault();
            e.stopPropagation();
            const emoji = btnQuickEmoji.getAttribute('data-emoji');
            if (activeReactMessageId && emoji) {
                submitReaction(activeReactMessageId, emoji);
            }
            if (quickReactionPopover) quickReactionPopover.classList.add('d-none');
            return;
        }

        const btnReactionPill = e.target.closest('.btn-reaction-pill');
        if (btnReactionPill) {
            e.preventDefault();
            e.stopPropagation();
            const msgId = btnReactionPill.getAttribute('data-msg-id');
            const emoji = btnReactionPill.getAttribute('data-emoji');
            if (msgId && emoji) {
                submitReaction(msgId, emoji);
            }
            return;
        }

        // Klik di luar popover menutup popover
        if (quickReactionPopover && !quickReactionPopover.contains(e.target)) {
            quickReactionPopover.classList.add('d-none');
        }
    });

    function submitReaction(msgId, emoji) {
        if (!msgId || !emoji) return;

        // 1. Optimistic UI: Update DOM instantly without any delay (0ms)
        const reactionsContainer = document.getElementById(`chat-reactions-${msgId}`);
        const msgItem = document.getElementById(`chat-msg-${msgId}`);
        const isSender = msgItem ? (msgItem.classList.contains('justify-content-end') || msgItem.classList.contains('text-end')) : false;

        if (reactionsContainer) {
            let currentPill = reactionsContainer.querySelector(`.btn-reaction-pill[data-emoji="${emoji}"]`);
            if (currentPill) {
                const countSpan = currentPill.querySelector('span:last-child');
                let currentCount = countSpan ? parseInt(countSpan.textContent.trim() || '0', 10) : 0;
                const hasReacted = currentPill.classList.contains('text-primary');
                if (hasReacted) {
                    currentCount = Math.max(0, currentCount - 1);
                    if (currentCount === 0) {
                        currentPill.remove();
                    } else {
                        if (countSpan) {
                            countSpan.textContent = currentCount;
                            countSpan.className = 'fs-11 text-muted opacity-85';
                        }
                        currentPill.className = 'btn btn-link p-0 text-decoration-none btn-reaction-pill fs-11 d-inline-flex align-items-center gap-0.5 text-muted';
                    }
                } else {
                    currentCount++;
                    if (countSpan) {
                        countSpan.textContent = currentCount;
                        countSpan.className = 'fs-11 fw-bold text-primary';
                    }
                    currentPill.className = 'btn btn-link p-0 text-decoration-none btn-reaction-pill fs-11 d-inline-flex align-items-center gap-0.5 text-primary fw-semibold';
                }
            } else {
                const newPillHtml = `<button type="button" class="btn btn-link p-0 text-decoration-none btn-reaction-pill fs-11 d-inline-flex align-items-center gap-0.5 text-primary fw-semibold" data-msg-id="${msgId}" data-emoji="${emoji}" title="1 orang bereaksi ${emoji}" style="line-height: 1;">
                    <span class="fs-12">${emoji}</span>
                    <span class="fs-11 fw-bold text-primary">1</span>
                </button>`;
                reactionsContainer.insertAdjacentHTML('beforeend', newPillHtml);
            }
        }

        // 2. Background AJAX synchronization
        fetch(`/admin/profil-pengguna/messages/${msgId}/toggle-reaction`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': getCsrfToken(),
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ emoji: emoji })
        })
        .then(function(res) { return res.json(); })
        .then(function(data) {
            if (data && data.success && reactionsContainer) {
                reactionsContainer.innerHTML = renderReactionsHtml(msgId, data.reactions, isSender);
            }
        })
        .catch(function(err) {
            console.error('Error submitting reaction:', err);
        });
    }

    // ==========================================
    // 4. FORWARD MESSAGE LOGIC
    // ==========================================
    document.addEventListener('click', function(e) {
        const btnForward = e.target.closest('.btn-forward-msg');
        if (!btnForward) return;
        e.preventDefault();

        const msgId = btnForward.getAttribute('data-msg-id');
        activeForwardMessageId = msgId;

        populateForwardContactList();

        if (forwardModalEl && window.bootstrap) {
            const bsModal = bootstrap.Modal.getOrCreateInstance(forwardModalEl);
            bsModal.show();
        }
    });

    function populateForwardContactList(filterQuery = '') {
        if (!forwardContactList) return;
        const contactEls = document.querySelectorAll('#chat-contacts-list .btn-select-chat');
        let html = '';
        const query = filterQuery.toLowerCase().trim();

        contactEls.forEach(function(el) {
            const uid = el.getAttribute('data-user-id');
            const uname = el.getAttribute('data-user-name') || '';
            const uavatar = el.getAttribute('data-user-avatar') || '';
            const urole = el.getAttribute('data-user-role') || '';

            if (query === '' || uname.toLowerCase().includes(query)) {
                html += `<div class="list-group-item list-group-item-action d-flex align-items-center justify-content-between py-2 px-2.5 border-0 border-bottom">
                    <div class="d-flex align-items-center gap-2 overflow-hidden me-2">
                        <img src="${uavatar}" class="rounded-circle object-fit-cover flex-shrink-0" style="width: 32px; height: 32px;" alt="Avatar">
                        <div class="overflow-hidden">
                            <div class="fw-semibold text-dark fs-12 text-truncate">${escapeHtml(uname)}</div>
                            <div class="text-muted fs-11 text-truncate">${escapeHtml(urole)}</div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary btn-sm px-2.5 py-1 fs-11 btn-send-forward flex-shrink-0" data-target-uid="${uid}" data-target-uname="${escapeHtml(uname)}">
                        <i class="ti ti-arrow-forward-up me-0.5"></i> Teruskan
                    </button>
                </div>`;
            }
        });

        if (html === '') {
            html = `<div class="p-3 text-center text-muted fs-12">Kontak tidak ditemukan.</div>`;
        }

        forwardContactList.innerHTML = html;
    }

    if (forwardContactSearch) {
        forwardContactSearch.addEventListener('input', function(e) {
            populateForwardContactList(e.target.value);
        });
    }

    document.addEventListener('click', function(e) {
        const btnSendFwd = e.target.closest('.btn-send-forward');
        if (!btnSendFwd) return;
        e.preventDefault();

        const targetUid = btnSendFwd.getAttribute('data-target-uid');
        const targetUname = btnSendFwd.getAttribute('data-target-uname') || 'pengguna';
        if (!activeForwardMessageId || !targetUid) return;

        btnSendFwd.disabled = true;
        btnSendFwd.innerHTML = `<span class="spinner-border spinner-border-sm" role="status"></span>`;

        fetch(`/admin/profil-pengguna/messages/${activeForwardMessageId}/forward`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': getCsrfToken(),
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ target_user_id: targetUid })
        })
        .then(function(res) { return res.json(); })
        .then(function(data) {
            if (data && data.success) {
                if (forwardModalEl && window.bootstrap) {
                    const bsModal = bootstrap.Modal.getInstance(forwardModalEl);
                    if (bsModal) bsModal.hide();
                }
                if (typeof window.showToast === 'function') {
                    window.showToast(`Pesan berhasil diteruskan ke ${targetUname}`, 'success');
                }
                pollSidebarContacts();
                if (activeUserId === targetUid) {
                    loadConversation(targetUid, false);
                }
            } else {
                if (typeof window.showError === 'function') {
                    window.showError(data && data.message ? data.message : 'Gagal meneruskan pesan.');
                }
                btnSendFwd.disabled = false;
                btnSendFwd.innerHTML = `<i class="ti ti-arrow-forward-up me-0.5"></i> Teruskan`;
            }
        })
        .catch(function(err) {
            if (typeof window.showError === 'function') {
                window.showError('Terjadi kesalahan koneksi.');
            }
            btnSendFwd.disabled = false;
            btnSendFwd.innerHTML = `<i class="ti ti-arrow-forward-up me-0.5"></i> Teruskan`;
        });
    });

    // ==========================================
    // 5. VOICE NOTE RECORDER & AUDIO PLAYER
    // ==========================================
    if (btnRecordVoice) {
        btnRecordVoice.addEventListener('click', async function(e) {
            e.preventDefault();
            if (!activeUserId) return;

            if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                if (typeof window.showWarning === 'function') {
                    window.showWarning('Browser Anda tidak mendukung rekaman audio.');
                } else {
                    alert('Browser Anda tidak mendukung rekaman audio.');
                }
                return;
            }

            try {
                const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
                audioChunks = [];
                mediaRecorder = new MediaRecorder(stream);

                mediaRecorder.ondataavailable = function(evt) {
                    if (evt.data && evt.data.size > 0) {
                        audioChunks.push(evt.data);
                    }
                };

                mediaRecorder.start();
                recordingSeconds = 0;

                if (voiceRecordingContainer) {
                    voiceRecordingContainer.classList.remove('d-none');
                    voiceRecordingContainer.classList.add('d-flex');
                }
                if (chatInputRow) chatInputRow.classList.add('d-none');

                if (voiceRecordingTimer) voiceRecordingTimer.textContent = '00:00';
                recordingTimerInterval = setInterval(function() {
                    recordingSeconds++;
                    const mins = String(Math.floor(recordingSeconds / 60)).padStart(2, '0');
                    const secs = String(recordingSeconds % 60).padStart(2, '0');
                    if (voiceRecordingTimer) voiceRecordingTimer.textContent = `${mins}:${secs}`;
                }, 1000);

            } catch (err) {
                console.error('Mic access error:', err);
                if (typeof window.showWarning === 'function') {
                    window.showWarning('Izin mikrofon ditolak atau tidak tersedia.');
                } else {
                    alert('Izin mikrofon ditolak.');
                }
            }
        });
    }

    function stopRecordingCleanup() {
        if (recordingTimerInterval) {
            clearInterval(recordingTimerInterval);
            recordingTimerInterval = null;
        }
        if (mediaRecorder && mediaRecorder.state !== 'inactive') {
            mediaRecorder.stop();
            mediaRecorder.stream.getTracks().forEach(function(track) { track.stop(); });
        }
        if (voiceRecordingContainer) {
            voiceRecordingContainer.classList.add('d-none');
            voiceRecordingContainer.classList.remove('d-flex');
        }
        if (chatInputRow) chatInputRow.classList.remove('d-none');
    }

    if (btnCancelVoice) {
        btnCancelVoice.addEventListener('click', function(e) {
            e.preventDefault();
            stopRecordingCleanup();
            audioChunks = [];
        });
    }

    if (btnSendVoice) {
        btnSendVoice.addEventListener('click', function(e) {
            e.preventDefault();
            if (!mediaRecorder || !activeUserId) return;

            mediaRecorder.onstop = function() {
                const audioBlob = new Blob(audioChunks, { type: 'audio/webm' });
                if (audioBlob.size === 0) return;

                const audioFile = new File([audioBlob], `voice_note_${Date.now()}.webm`, { type: 'audio/webm' });
                const formData = new FormData();
                formData.append('receiver_id', activeUserId);
                formData.append('attachment', audioFile);

                const replyParentInput = document.getElementById('reply-parent-id');
                const parentId = (replyParentInput && replyParentInput.value.trim() !== '') ? parseInt(replyParentInput.value.trim(), 10) : null;
                if (parentId) formData.append('parent_id', parentId);

                const tempMsgId = 'temp_' + Date.now();
                const blobUrl = URL.createObjectURL(audioBlob);
                const now = new Date();
                const timeFormatted = String(now.getHours()).padStart(2, '0') + ':' + String(now.getMinutes()).padStart(2, '0');

                const optimisticMsg = {
                    id: tempMsgId,
                    temp_id: tempMsgId,
                    is_sender: true,
                    body: '',
                    attachment_url: blobUrl,
                    attachment_name: 'Pesan Suara',
                    attachment_type: 'voice',
                    attachment_size: audioBlob.size,
                    parent_id: parentId,
                    time_formatted: timeFormatted,
                    is_pending: true
                };

                appendSingleMessage(optimisticMsg);
                scrollToBottom(true);
                promoteContactToRecent(activeUserId, '🎙️ [Pesan Suara]', 'Baru saja');

                fetch('/admin/profil-pengguna/messages/send', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': getCsrfToken(),
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    body: formData
                })
                .then(function(res) { return res.json(); })
                .then(function(data) {
                    if (data && data.success) {
                        const tempEl = document.getElementById(`chat-msg-${tempMsgId}`);
                        if (tempEl) {
                            tempEl.id = `chat-msg-${data.message.id}`;
                            tempEl.setAttribute('data-msg-id', data.message.id);
                            const statusTimeEl = tempEl.querySelector('.chat-status-time');
                            if (statusTimeEl) {
                                statusTimeEl.innerHTML = `<i class="ti ti-check text-primary me-0.5" title="Terkirim"></i> ${data.message.time_formatted || timeFormatted}`;
                            }

                            const dropdownEl = tempEl.querySelector('.chat-msg-dropdown');
                            if (dropdownEl) dropdownEl.classList.remove('d-none');

                            const btnReact = tempEl.querySelector('.btn-react-msg');
                            if (btnReact) {
                                btnReact.setAttribute('data-msg-id', data.message.id);
                                btnReact.classList.remove('d-none');
                            }

                            const btnReply = tempEl.querySelector('.btn-reply-msg');
                            if (btnReply) {
                                btnReply.setAttribute('data-msg-id', data.message.id);
                                btnReply.classList.remove('d-none');
                            }

                            const btnForward = tempEl.querySelector('.btn-forward-msg');
                            if (btnForward) {
                                btnForward.setAttribute('data-msg-id', data.message.id);
                                btnForward.classList.remove('d-none');
                            }

                            const btnPin = tempEl.querySelector('.btn-pin-msg');
                            if (btnPin) {
                                btnPin.setAttribute('data-msg-id', data.message.id);
                                btnPin.classList.remove('d-none');
                            }

                            const btnDelete = tempEl.querySelector('.btn-delete-msg');
                            if (btnDelete) {
                                btnDelete.setAttribute('data-msg-id', data.message.id);
                                btnDelete.classList.remove('d-none');
                            }
                        }
                        pollSidebarContacts();
                    }
                })
                .catch(function(err) {
                    console.error('Error sending voice note:', err);
                });
            };

            stopRecordingCleanup();
        });
    }

    // In-Bubble Audio Player Logic
    document.addEventListener('click', function(e) {
        const btnPlay = e.target.closest('.btn-play-voice');
        if (!btnPlay) return;
        e.preventDefault();

        const audioSrc = btnPlay.getAttribute('data-audio-src');
        if (!audioSrc) return;

        const card = btnPlay.closest('.voice-player-card');
        const progressBar = card ? card.querySelector('.progress-bar') : null;
        const timeEl = card ? card.querySelector('.voice-current-time') : null;
        const icon = btnPlay.querySelector('i');

        // Jika sedang memainkan audio yang sama -> pause
        if (activeAudioPlayer && activeAudioBtn === btnPlay) {
            if (activeAudioPlayer.paused) {
                activeAudioPlayer.play();
                if (icon) icon.className = 'ti ti-player-pause fs-14';
            } else {
                activeAudioPlayer.pause();
                if (icon) icon.className = 'ti ti-player-play fs-14';
            }
            return;
        }

        // Stop active previous player
        if (activeAudioPlayer) {
            activeAudioPlayer.pause();
            if (activeAudioBtn) {
                const prevIcon = activeAudioBtn.querySelector('i');
                if (prevIcon) prevIcon.className = 'ti ti-player-play fs-14';
            }
            if (activeAudioProgress) activeAudioProgress.style.width = '0%';
        }

        activeAudioPlayer = new Audio(audioSrc);
        activeAudioBtn = btnPlay;
        activeAudioProgress = progressBar;
        activeAudioTimeEl = timeEl;

        if (icon) icon.className = 'ti ti-player-pause fs-14';

        activeAudioPlayer.addEventListener('timeupdate', function() {
            if (activeAudioPlayer.duration) {
                const progress = (activeAudioPlayer.currentTime / activeAudioPlayer.duration) * 100;
                if (progressBar) progressBar.style.width = `${progress}%`;

                const curMins = Math.floor(activeAudioPlayer.currentTime / 60);
                const curSecs = String(Math.floor(activeAudioPlayer.currentTime % 60)).padStart(2, '0');
                if (timeEl) timeEl.textContent = `${curMins}:${curSecs}`;
            }
        });

        activeAudioPlayer.addEventListener('ended', function() {
            if (icon) icon.className = 'ti ti-player-play fs-14';
            if (progressBar) progressBar.style.width = '0%';
            if (timeEl) timeEl.textContent = '0:00';
            activeAudioPlayer = null;
        });

        activeAudioPlayer.play();
    });

    // Seek audio saat progress bar diklik
    document.addEventListener('click', function(e) {
        const progressContainer = e.target.closest('.voice-progress');
        if (!progressContainer || !activeAudioPlayer) return;

        const rect = progressContainer.getBoundingClientRect();
        const clickX = e.clientX - rect.left;
        const percent = Math.max(0, Math.min(1, clickX / rect.width));

        if (activeAudioPlayer.duration) {
            activeAudioPlayer.currentTime = percent * activeAudioPlayer.duration;
        }
    });
});
