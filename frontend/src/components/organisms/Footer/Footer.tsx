import React from 'react';
import Link from 'next/link';
import styles from './Footer.module.scss';
import {
  Sparkles,
  Phone,
  MapPin,
  Clock,
  ShieldCheck,
  Award,
  HeartHandshake
} from 'lucide-react';

export const Footer: React.FC = () => {
  return (
    <footer className={styles.footer}>
      {/* Emergency & Quick Help Banner */}
      <div className={styles.emergencyStrip}>
        <div className={styles.emergencyContainer}>
          <div className={styles.emergencyText}>
            <span className={styles.emergencyDot} />
            <h4>Immediate Dental Emergency? Severe Toothache or Trauma?</h4>
            <p>Our emergency clinical team is on standby 24/7 across all 3 metro branches.</p>
          </div>
          <div className={styles.emergencyActions}>
            <a href="https://wa.me/919904379260?text=Hello%20Advanced%20Dental%20Clinic!%20I%20have%20an%20urgent%20dental%20inquiry." target="_blank" rel="noopener noreferrer" className={styles.emergencyCallBtn}>
              <Phone size={18} />
              <span>Emergency Line & WhatsApp: +91 99043 79260</span>
            </a>
          </div>
        </div>
      </div>

      {/* Main Footer Content */}
      <div className={styles.mainFooter}>
        <div className={styles.footerContainer}>
          {/* Column 1: Brand & Clinical Accreditation */}
          <div className={styles.brandCol}>
            <Link href="/" className={styles.brand}>
              <div className={styles.logoMark}>
                <Sparkles size={20} />
              </div>
              <div>
                <span className={styles.brandTitle}>Advanced Dental Clinic</span>
                <span className={styles.brandSubtitle}>Comprehensive Dental Care & Specialists</span>
              </div>
            </Link>
            <p className={styles.brandDescription}>
              Delivering high-precision restorative, cosmetic, and emergency dentistry with digital 3D imaging, pain-free sedation, and compassionate patient care.
            </p>

            <div className={styles.accreditationGroup}>
              <div className={styles.accreditationItem}>
                <ShieldCheck size={16} />
                <span>ADA Accredited Practice</span>
              </div>
              <div className={styles.accreditationItem}>
                <Award size={16} />
                <span>Board Certified Prosthodontists</span>
              </div>
              <div className={styles.accreditationItem}>
                <HeartHandshake size={16} />
                <span>HIPAA & OSHA Compliant</span>
              </div>
            </div>
          </div>

          {/* Column 2: Clinical Treatments */}
          <div className={styles.linksCol}>
            <h5 className={styles.colTitle}>Treatments & Procedures</h5>
            <ul className={styles.linksList}>
              <li><Link href="#services">Digital Dental Implants (All-on-4)</Link></li>
              <li><Link href="#services">Clear Aligners & Orthodontics</Link></li>
              <li><Link href="#services">Porcelain Veneers & Smile Makeovers</Link></li>
              <li><Link href="#services">Microscopic Root Canal Therapy</Link></li>
              <li><Link href="#services">Laser Periodontal Gum Treatment</Link></li>
              <li><Link href="#services">Pediatric Gentle Dentistry</Link></li>
              <li><Link href="#services">Professional In-Office Teeth Whitening</Link></li>
            </ul>
          </div>

          {/* Column 3: Patient Care & Plans */}
          <div className={styles.linksCol}>
            <h5 className={styles.colTitle}>Patient Care & Plans</h5>
            <ul className={styles.linksList}>
              <li><Link href="#booking">Book Online (Real-Time Slots)</Link></li>
              <li><Link href="#pricing">Dental Membership Plan ($39/mo)</Link></li>
              <li><Link href="#pricing">Zero-Interest Financing (CareCredit)</Link></li>
              <li><Link href="#makeover">Before & After Smile Transformation</Link></li>
              <li><Link href="#reviews">Verified Patient Testimonials</Link></li>
              <li><Link href="#faq">Pre & Post Treatment Guidelines</Link></li>
              <li><a href="https://wa.me/919904379260?text=Hello%20Advanced%20Dental%20Clinic!" target="_blank" rel="noopener noreferrer">WhatsApp Direct Clinical Hub (+919904379260)</a></li>
            </ul>
          </div>

          {/* Column 4: Clinic Locations & Hours */}
          <div className={styles.locationsCol}>
            <h5 className={styles.colTitle}>Clinic Locations</h5>
            <div className={styles.branchItem}>
              <strong>Central Practice (Headquarters)</strong>
              <p><MapPin size={12} /> 100 Healthcare Boulevard, Suite 400, Austin, TX 78701</p>
              <p><Clock size={12} /> Mon-Sat: 8:00 AM - 7:00 PM</p>
            </div>

            <div className={styles.branchItem}>
              <strong>Westside Cosmetic Studio</strong>
              <p><MapPin size={12} /> 500 Medical Center Parkway, Suite 250, Denver, CO 80202</p>
              <p><Clock size={12} /> Mon-Fri: 9:00 AM - 6:00 PM</p>
            </div>

            <div className={styles.branchItem}>
              <strong>Northside Family Center</strong>
              <p><MapPin size={12} /> 750 Wellness Way, Building B, Charlotte, NC 28202</p>
              <p><Clock size={12} /> Tue-Sat: 8:30 AM - 5:30 PM</p>
            </div>
          </div>
        </div>
      </div>

      {/* Bottom Bar: Copyright & Compliance */}
      <div className={styles.bottomBar}>
        <div className={styles.bottomContainer}>
          <p className={styles.copyright}>
            &copy; {new Date().getFullYear()} Advanced Dental Clinic Network. All rights reserved. Demonstration and portfolio release.
          </p>
          <div className={styles.legalLinks}>
            <span>HIPAA Compliant</span>
            <span>Privacy Policy</span>
            <span>Terms of Clinical Service</span>
            <span>Non-Discrimination Notice</span>
          </div>
          <div className={styles.authorCredit}>
            Website by{' '}
            <a
              href="https://ratneshsharma.com/"
              target="_blank"
              rel="noopener noreferrer"
            >
              Ratnesh Sharma
            </a>
          </div>
        </div>
      </div>
    </footer>
  );
};
