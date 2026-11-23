import CryptoJS from 'crypto-js';

const SECRET_KEY =
  process.env.NEXT_PUBLIC_CRYPTO_SECRET || 'dental_clinic_saas_default_aes_key_2026';

/**
 * Crypto Security Helper
 * Encrypts payloads before transmission and decrypts received sensitive responses.
 */
export const CryptoHelper = {
  /**
   * Encrypt arbitrary data payload (Object, Array, or String) using AES-256
   */
  encrypt: (data: unknown): string => {
    try {
      const jsonString = typeof data === 'string' ? data : JSON.stringify(data);
      return CryptoJS.AES.encrypt(jsonString, SECRET_KEY).toString();
    } catch (error) {
      console.error('[CryptoHelper] Encryption failed:', error);
      return typeof data === 'string' ? data : JSON.stringify(data);
    }
  },

  /**
   * Decrypt AES ciphertext back to typed object or string
   */
  decrypt: <T = unknown>(ciphertext: string): T | null => {
    try {
      const bytes = CryptoJS.AES.decrypt(ciphertext, SECRET_KEY);
      const decryptedString = bytes.toString(CryptoJS.enc.Utf8);
      if (!decryptedString) return null;

      try {
        return JSON.parse(decryptedString) as T;
      } catch {
        return decryptedString as unknown as T;
      }
    } catch (error) {
      console.error('[CryptoHelper] Decryption failed:', error);
      return null;
    }
  },

  /**
   * Generate SHA-256 checksum for tamper-proof form payloads
   */
  hash: (message: string): string => {
    return CryptoJS.SHA256(message).toString(CryptoJS.enc.Hex);
  },

  /**
   * Safe base64 token encoder
   */
  encodeToken: (token: string): string => {
    return CryptoJS.enc.Base64.stringify(CryptoJS.enc.Utf8.parse(token));
  },

  /**
   * Safe base64 token decoder
   */
  decodeToken: (encoded: string): string => {
    return CryptoJS.enc.Utf8.stringify(CryptoJS.enc.Base64.parse(encoded));
  },
};
