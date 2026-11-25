'use client';

import React, { useEffect, useRef, useState } from 'react';
import { apiClient } from '@/api/client';
import { useTheme } from '@/context/ThemeContext';
import { BookingModal } from '@/components/common/BookingModal/BookingModal';

interface ChatMessage {
  id: string;
  sender: 'user' | 'assistant';
  text: string;
  timestamp?: string;
}

interface DoctorOption {
  id: number;
  name: string;
  role: string;
}

interface SlotOption {
  time?: string;
  time_24?: string;
  display?: string;
  available: boolean;
}

interface ServiceOption {
  id: number;
  title: string;
}

function renderFormattedText(text: string) {
  const parts = text.split(/(\*\*[^*]+\*\*)/g);
  return parts.map((part, idx) => {
    if (part.startsWith('**') && part.endsWith('**')) {
      return <strong key={idx}>{part.slice(2, -2)}</strong>;
    }
    return <React.Fragment key={idx}>{part}</React.Fragment>;
  });
}

export const FloatingWhatsAppMenu: React.FC = () => {
  const { theme } = useTheme();
  const [menuOpen, setMenuOpen] = useState(false);
  const [bookingOpen, setBookingOpen] = useState(false);
  const [chatOpen, setChatOpen] = useState(false);

  // Lead Capture State
  const [sessionId, setSessionId] = useState<string>('');
  const [started, setStarted] = useState(false);
  const [visitorName, setVisitorName] = useState('');
  const [visitorPhone, setVisitorPhone] = useState('');
  const [serviceInterest, setServiceInterest] = useState('Routine Dental Examinations');
  const [servicesList, setServicesList] = useState<ServiceOption[]>([]);

  // Chat State
  const [messages, setMessages] = useState<ChatMessage[]>([]);
  const [quickReplies, setQuickReplies] = useState<string[]>([]);
  const [inputMsg, setInputMsg] = useState('');
  const [sending, setSending] = useState(false);

  // Live Slot Picker State inside Chat
  const [showSlotPicker, setShowSlotPicker] = useState(false);
  const [doctors, setDoctors] = useState<DoctorOption[]>([]);
  const [selectedDoctorId, setSelectedDoctorId] = useState<number>(1);
  const [selectedDate, setSelectedDate] = useState<string>(() => {
    const d = new Date();
    d.setDate(d.getDate() + 1);
    return d.toISOString().split('T')[0];
  });
  const [availableSlots, setAvailableSlots] = useState<SlotOption[]>([]);
  const [loadingSlots, setLoadingSlots] = useState(false);

  const messagesEndRef = useRef<HTMLDivElement | null>(null);

  useEffect(() => {
    async function loadServices() {
      try {
        const res = await apiClient.get<ServiceOption[]>('/services');
        const raw = res as unknown as { success?: boolean; data?: ServiceOption[] };
        if (raw?.success && Array.isArray(raw.data) && raw.data.length > 0) {
          setServicesList(raw.data);
          setServiceInterest(raw.data[0].title);
        }
      } catch {
        // Fallback options handled in JSX
      }
    }
    loadServices();
  }, []);

  useEffect(() => {
    messagesEndRef.current?.scrollIntoView({ behavior: 'smooth' });
  }, [messages, showSlotPicker]);

  const rawWa = (theme?.branding?.whatsapp || '+441217652870').replace(/[^0-9]/g, '');
  const waHref = `https://wa.me/${rawWa}?text=${encodeURIComponent('Hello Acocks Green Dental Practice, I would like to enquire about an appointment.')}`;

  const handleStartChat = async (e: React.FormEvent) => {
    e.preventDefault();
    if (!visitorName.trim() || !visitorPhone.trim()) return;
    setSending(true);
    const sid = sessionId || `chat_${Date.now()}_${Math.floor(Math.random() * 1000)}`;
    setSessionId(sid);
    try {
      const res = await apiClient.add<{
        session_id: string;
        messages: ChatMessage[];
        quick_replies?: string[];
      }>('/assistant/chat', {
        action: 'start',
        session_id: sid,
        visitor_name: visitorName.trim(),
        phone: visitorPhone.trim(),
        service_interest: serviceInterest,
      });
      const raw = res as unknown as {
        success?: boolean;
        messages?: ChatMessage[];
        quick_replies?: string[];
      };
      if (raw?.success) {
        setStarted(true);
        setMessages(raw.messages || []);
        setQuickReplies(raw.quick_replies || []);
      }
    } finally {
      setSending(false);
    }
  };

  const loadDoctorSlots = async (docId: number, dateStr: string) => {
    setLoadingSlots(true);
    try {
      const res = await apiClient.add<{
        doctors?: DoctorOption[];
        slots?: SlotOption[];
      }>('/assistant/chat', {
        action: 'slots',
        session_id: sessionId,
        doctor_id: docId,
        date: dateStr,
      });
      const raw = res as unknown as {
        success?: boolean;
        doctors?: DoctorOption[];
        slots?: SlotOption[];
      };
      if (raw?.success) {
        if (raw.doctors) setDoctors(raw.doctors);
        setAvailableSlots(raw.slots || []);
      }
    } finally {
      setLoadingSlots(false);
    }
  };

  const sendMessage = async (textToSend: string) => {
    const clean = textToSend.trim();
    if (!clean || sending) return;
    setSending(true);
    setInputMsg('');
    try {
      const res = await apiClient.add<{
        messages?: ChatMessage[];
        quick_replies?: string[];
        show_booking_picker?: boolean;
        doctors?: DoctorOption[];
      }>('/assistant/chat', {
        action: 'message',
        session_id: sessionId,
        visitor_name: visitorName,
        phone: visitorPhone,
        service_interest: serviceInterest,
        message: clean,
      });
      const raw = res as unknown as {
        success?: boolean;
        messages?: ChatMessage[];
        quick_replies?: string[];
        show_booking_picker?: boolean;
        doctors?: DoctorOption[];
      };
      if (raw?.success) {
        setMessages(raw.messages || []);
        setQuickReplies(raw.quick_replies || []);
        if (raw.show_booking_picker) {
          setShowSlotPicker(true);
          if (raw.doctors) setDoctors(raw.doctors);
          loadDoctorSlots(selectedDoctorId, selectedDate);
        }
      }
    } finally {
      setSending(false);
    }
  };

  const handleBookSlot = async (timeSlot: string) => {
    setSending(true);
    try {
      const res = await apiClient.add<{
        messages?: ChatMessage[];
        quick_replies?: string[];
      }>('/assistant/chat', {
        action: 'book',
        session_id: sessionId,
        visitor_name: visitorName,
        phone: visitorPhone,
        service_interest: serviceInterest,
        treatment: serviceInterest,
        doctor_id: selectedDoctorId,
        date: selectedDate,
        time_slot: timeSlot,
      });
      const raw = res as unknown as {
        success?: boolean;
        messages?: ChatMessage[];
        quick_replies?: string[];
      };
      if (raw?.success) {
        setShowSlotPicker(false);
        setMessages(raw.messages || []);
        setQuickReplies(raw.quick_replies || []);
      }
    } finally {
      setSending(false);
    }
  };

  return (
    <>
      <style>{`
        .wa-float-wrap {
          position: fixed;
          right: 24px;
          bottom: 24px;
          z-index: 1040;
          display: flex;
          flex-direction: column;
          align-items: flex-end;
          gap: 12px;
        }
        @media (max-width: 991px) {
          .wa-float-wrap {
            right: 16px;
            bottom: 84px;
          }
        }
      `}</style>

      <div className="wa-float-wrap">
        {/* 3-OPTION POPOVER MENU */}
        {menuOpen && !chatOpen && (
          <div
            style={{
              width: 268,
              background: '#ffffff',
              borderRadius: 18,
              border: '1px solid #dbe5de',
              boxShadow: '0 18px 42px rgba(13, 46, 26, 0.22)',
              padding: 12,
              display: 'flex',
              flexDirection: 'column',
              gap: 8,
            }}
          >
            <div style={{ padding: '4px 8px 6px', borderBottom: '1px solid #f1f5f9', display: 'flex', justifyContent: 'space-between', alignItems: 'center' }}>
              <span style={{ fontSize: 12, fontWeight: 800, color: '#0d631b', textTransform: 'uppercase', letterSpacing: '0.05em' }}>
                How can we help?
              </span>
              <button type="button" onClick={() => setMenuOpen(false)} style={{ border: 'none', background: 'transparent', cursor: 'pointer', fontSize: 16, color: '#64748b' }}>
                ✕
              </button>
            </div>

            <button
              type="button"
              onClick={() => {
                setMenuOpen(false);
                setBookingOpen(true);
              }}
              style={{
                display: 'flex',
                alignItems: 'center',
                gap: 10,
                padding: '10px 12px',
                borderRadius: 12,
                border: '1px solid #e2e8f0',
                background: '#f8fafc',
                color: '#0f172a',
                fontWeight: 700,
                fontSize: 14,
                cursor: 'pointer',
                textAlign: 'left',
              }}
            >
              <span className="material-symbols-outlined" style={{ color: '#0d631b', fontSize: 20 }}>calendar_month</span>
              <span>Make a Booking</span>
            </button>

            <a
              href={waHref}
              target="_blank"
              rel="noopener noreferrer"
              onClick={() => setMenuOpen(false)}
              style={{
                display: 'flex',
                alignItems: 'center',
                gap: 10,
                padding: '10px 12px',
                borderRadius: 12,
                border: '1px solid #bbf7d0',
                background: '#f0fdf4',
                color: '#166534',
                fontWeight: 700,
                fontSize: 14,
                textDecoration: 'none',
              }}
            >
              <span className="material-symbols-outlined" style={{ color: '#16a34a', fontSize: 20 }}>chat</span>
              <span>Contact us on WhatsApp</span>
            </a>

            <button
              type="button"
              onClick={() => {
                setMenuOpen(false);
                setChatOpen(true);
              }}
              style={{
                display: 'flex',
                alignItems: 'center',
                gap: 10,
                padding: '10px 12px',
                borderRadius: 12,
                border: 'none',
                background: '#0d631b',
                color: '#ffffff',
                fontWeight: 700,
                fontSize: 14,
                cursor: 'pointer',
                textAlign: 'left',
              }}
            >
              <span className="material-symbols-outlined" style={{ color: '#ffffff', fontSize: 20 }}>smart_toy</span>
              <span>Smart Dental Assistant</span>
            </button>
          </div>
        )}

        {/* SMART DENTAL ASSISTANT CHAT DRAWER */}
        {chatOpen && (
          <div
            style={{
              width: 'min(390px, calc(100vw - 32px))',
              height: 'min(560px, calc(100vh - 130px))',
              background: '#ffffff',
              borderRadius: 20,
              border: '1px solid #dbe5de',
              boxShadow: '0 24px 54px rgba(13, 46, 26, 0.25)',
              display: 'flex',
              flexDirection: 'column',
              overflow: 'hidden',
            }}
          >
            {/* Header */}
            <div style={{ background: '#0d631b', color: '#ffffff', padding: '14px 16px', display: 'flex', justifyContent: 'space-between', alignItems: 'center' }}>
              <div style={{ display: 'flex', alignItems: 'center', gap: 10 }}>
                <span className="material-symbols-outlined" style={{ fontSize: 24 }}>smart_toy</span>
                <div>
                  <div style={{ fontWeight: 800, fontSize: 15 }}>Smart Dental Assistant</div>
                  <div style={{ fontSize: 11, opacity: 0.9 }}>Live Clinic Info &amp; Instant Booking</div>
                </div>
              </div>
              <button
                type="button"
                aria-label="Close Smart Dental Assistant"
                onClick={() => setChatOpen(false)}
                style={{ border: 'none', background: 'rgba(255,255,255,0.18)', color: '#fff', width: 28, height: 28, borderRadius: '50%', cursor: 'pointer', fontWeight: 700 }}
              >
                ✕
              </button>
            </div>

            {/* Body */}
            {!started ? (
              <form onSubmit={handleStartChat} style={{ padding: 20, display: 'flex', flexDirection: 'column', gap: 14, flex: 1, overflowY: 'auto' }}>
                <div style={{ fontSize: 14, color: '#334155', lineHeight: 1.5 }}>
                  Welcome! Please share your details so our <strong>Smart Dental Assistant</strong> can assist you or book an appointment:
                </div>
                <div>
                  <label style={{ display: 'block', fontSize: 12.5, fontWeight: 700, marginBottom: 4 }}>Full Name *</label>
                  <input
                    required
                    value={visitorName}
                    onChange={(e) => setVisitorName(e.target.value)}
                    placeholder="e.g. Sarah Jenkins"
                    style={{ width: '100%', padding: '10px 12px', borderRadius: 10, border: '1px solid #cbd5e1', fontSize: 14 }}
                  />
                </div>
                <div>
                  <label style={{ display: 'block', fontSize: 12.5, fontWeight: 700, marginBottom: 4 }}>Contact / WhatsApp Number *</label>
                  <input
                    required
                    type="tel"
                    value={visitorPhone}
                    onChange={(e) => setVisitorPhone(e.target.value)}
                    placeholder="e.g. 07700 900123"
                    style={{ width: '100%', padding: '10px 12px', borderRadius: 10, border: '1px solid #cbd5e1', fontSize: 14 }}
                  />
                </div>
                <div>
                  <label style={{ display: 'block', fontSize: 12.5, fontWeight: 700, marginBottom: 4 }}>Service / Treatment Looking For *</label>
                  <select
                    value={serviceInterest}
                    onChange={(e) => setServiceInterest(e.target.value)}
                    style={{ width: '100%', padding: '10px 12px', borderRadius: 10, border: '1px solid #cbd5e1', fontSize: 14, background: '#fff' }}
                  >
                    {servicesList.length > 0 ? (
                      servicesList.map((s) => (
                        <option key={s.id} value={s.title}>{s.title}</option>
                      ))
                    ) : (
                      <>
                        <option value="Routine Dental Examinations">Routine Dental Examinations</option>
                        <option value="Dental Hygiene & Airflow Polish">Dental Hygiene &amp; Airflow Polish</option>
                        <option value="Invisalign Clear Aligners">Invisalign Clear Aligners</option>
                        <option value="Same-Day Emergency Relief">Same-Day Emergency Relief</option>
                      </>
                    )}
                    <option value="General Enquiry">General Enquiry</option>
                  </select>
                </div>
                <button
                  type="submit"
                  disabled={sending}
                  style={{
                    marginTop: 'auto',
                    padding: '12px 16px',
                    borderRadius: 12,
                    border: 'none',
                    background: '#0d631b',
                    color: '#ffffff',
                    fontWeight: 800,
                    fontSize: 14.5,
                    cursor: 'pointer',
                  }}
                >
                  {sending ? 'Starting Chat...' : 'Start Chat →'}
                </button>
              </form>
            ) : (
              <>
                <div style={{ flex: 1, padding: 14, overflowY: 'auto', background: '#f2fcf5', display: 'flex', flexDirection: 'column', gap: 10 }}>
                  {messages.map((m) => {
                    const isUser = m.sender === 'user';
                    return (
                      <div key={m.id} style={{ display: 'flex', justifyContent: isUser ? 'flex-end' : 'flex-start' }}>
                        <div
                          style={{
                            maxWidth: '84%',
                            padding: '10px 13px',
                            borderRadius: 14,
                            background: isUser ? '#0d631b' : '#ffffff',
                            color: isUser ? '#ffffff' : '#151d1a',
                            border: isUser ? 'none' : '1px solid #dbe5de',
                            fontSize: 13.5,
                            lineHeight: 1.5,
                            whiteSpace: 'pre-line',
                          }}
                        >
                          {renderFormattedText(m.text)}
                        </div>
                      </div>
                    );
                  })}

                  {/* Inline Live Slot Picker */}
                  {showSlotPicker && (
                    <div style={{ background: '#ffffff', border: '1px solid #bbf7d0', borderRadius: 14, padding: 12 }}>
                      <div style={{ fontSize: 12, fontWeight: 800, color: '#0d631b', marginBottom: 8 }}>
                        Select Clinician &amp; Date
                      </div>
                      <div style={{ display: 'flex', gap: 6, marginBottom: 8 }}>
                        <select
                          value={selectedDoctorId}
                          onChange={(e) => {
                            const id = Number(e.target.value);
                            setSelectedDoctorId(id);
                            loadDoctorSlots(id, selectedDate);
                          }}
                          style={{ flex: 1, padding: '6px 8px', borderRadius: 8, border: '1px solid #cbd5e1', fontSize: 12 }}
                        >
                          {doctors.map((d) => (
                            <option key={d.id} value={d.id}>{d.name}</option>
                          ))}
                        </select>
                        <input
                          type="date"
                          value={selectedDate}
                          onChange={(e) => {
                            setSelectedDate(e.target.value);
                            loadDoctorSlots(selectedDoctorId, e.target.value);
                          }}
                          style={{ padding: '6px 8px', borderRadius: 8, border: '1px solid #cbd5e1', fontSize: 12 }}
                        />
                      </div>
                      {loadingSlots ? (
                        <div style={{ fontSize: 12, color: '#64748b' }}>Checking live slots...</div>
                      ) : availableSlots.length === 0 ? (
                        <div style={{ fontSize: 12, color: '#ba1a1a' }}>No available slots on this date. Try another day.</div>
                      ) : (
                        <div style={{ display: 'flex', flexWrap: 'wrap', gap: 6 }}>
                          {availableSlots.map((sl, sIdx) => {
                            const slotVal = sl.time_24 || sl.time || sl.display || '';
                            const slotLabel = sl.display || sl.time_24 || sl.time || '';
                            return (
                              <button
                                key={`${slotVal}-${sIdx}`}
                                type="button"
                                disabled={sending}
                                onClick={() => handleBookSlot(slotVal)}
                                style={{
                                  padding: '5px 10px',
                                  borderRadius: 8,
                                  border: '1px solid #0d631b',
                                  background: '#f0fdf4',
                                  color: '#0d631b',
                                  fontWeight: 700,
                                  fontSize: 12,
                                  cursor: 'pointer',
                                }}
                              >
                                {slotLabel}
                              </button>
                            );
                          })}
                        </div>
                      )}
                    </div>
                  )}

                  {/* Quick Replies */}
                  {quickReplies.length > 0 && (
                    <div style={{ display: 'flex', flexWrap: 'wrap', gap: 6, marginTop: 4 }}>
                      {quickReplies.map((qr) => (
                        <button
                          key={qr}
                          type="button"
                          onClick={() => sendMessage(qr)}
                          style={{
                            padding: '5px 11px',
                            borderRadius: 999,
                            border: '1px solid #0d631b',
                            background: '#ffffff',
                            color: '#0d631b',
                            fontWeight: 600,
                            fontSize: 12,
                            cursor: 'pointer',
                          }}
                        >
                          {qr}
                        </button>
                      ))}
                    </div>
                  )}
                  <div ref={messagesEndRef} />
                </div>

                {/* Chat Input */}
                <form
                  onSubmit={(e) => {
                    e.preventDefault();
                    sendMessage(inputMsg);
                  }}
                  style={{ padding: 10, borderTop: '1px solid #e2e8f0', display: 'flex', gap: 8, background: '#ffffff' }}
                >
                  <input
                    value={inputMsg}
                    onChange={(e) => setInputMsg(e.target.value)}
                    placeholder="Ask about prices, hours, or booking..."
                    style={{ flex: 1, padding: '9px 12px', borderRadius: 10, border: '1px solid #cbd5e1', fontSize: 13.5 }}
                  />
                  <button
                    type="submit"
                    disabled={sending || !inputMsg.trim()}
                    style={{
                      padding: '0 14px',
                      borderRadius: 10,
                      border: 'none',
                      background: '#0d631b',
                      color: '#ffffff',
                      fontWeight: 700,
                      fontSize: 13.5,
                      cursor: 'pointer',
                    }}
                  >
                    Send
                  </button>
                </form>
              </>
            )}
          </div>
        )}

        {/* FIXED FLOATING WHATSAPP ICON BUTTON */}
        <button
          type="button"
          aria-label="Open WhatsApp & Smart Dental Assistant Menu"
          onClick={() => {
            if (chatOpen) {
              setChatOpen(false);
            } else {
              setMenuOpen((prev) => !prev);
            }
          }}
          style={{
            width: 58,
            height: 58,
            borderRadius: '50%',
            border: 'none',
            background: '#25D366',
            color: '#ffffff',
            boxShadow: '0 8px 24px rgba(37, 211, 102, 0.42)',
            display: 'flex',
            alignItems: 'center',
            justifyContent: 'center',
            cursor: 'pointer',
          }}
        >
          <svg width="30" height="30" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
            <path d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91C21.95 6.45 17.5 2 12.04 2zm5.8 14.11c-.24.68-1.41 1.3-1.95 1.38-.5.07-1.13.1-1.83-.12-.42-.13-.96-.31-1.65-.61-2.91-1.26-4.81-4.2-4.96-4.39-.14-.19-1.18-1.57-1.18-3 0-1.43.75-2.13 1.02-2.42.27-.29.59-.36.79-.36h.57c.18 0 .43-.07.67.51.24.59.82 2.02.89 2.17.07.15.12.33.02.52-.1.19-.15.31-.3.48-.15.17-.31.38-.44.51-.15.15-.3.31-.13.61.17.3.76 1.25 1.63 2.02 1.12 1 2.07 1.31 2.37 1.46.3.15.47.12.64-.07.17-.2.74-.86.94-1.16.2-.3.4-.25.67-.15.27.1 1.72.81 2.02.96.3.15.49.22.56.34.07.12.07.7-.17 1.38z" />
          </svg>
        </button>
      </div>

      <BookingModal isOpen={bookingOpen} onClose={() => setBookingOpen(false)} />
    </>
  );
};
