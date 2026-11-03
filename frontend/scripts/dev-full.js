const { spawn } = require('child_process');
const path = require('path');
const fs = require('fs');

const rootDir = path.resolve(__dirname, '../../');
const backendPublic = path.resolve(rootDir, 'backend/public');

// Candidate PHP binary paths on Windows / Unix
const candidates = [
  'C:\\xampp\\php\\php.exe',
  'php',
  'C:\\laragon\\bin\\php\\php-8.2.12-Win32-vs16-x64\\php.exe',
  'C:\\php\\php.exe'
];

let phpBinary = 'php';
for (const candidate of candidates) {
  if (fs.existsSync(candidate)) {
    phpBinary = candidate;
    break;
  }
}

console.log('================================================================');
console.log(' [DentaFlow Full-Stack Local Development Environment]');
console.log(' 1. Patient Website: http://localhost:3000/advanced-dental-clinic/');
console.log(' 2. Admin EMR Portal: http://localhost:3000/advanced-dental-clinic/admin/');
console.log(' 3. Backend PHP API: http://127.0.0.1:8000/api/v1/ping');
console.log('================================================================');

// 1. Start PHP backend on port 8000
const phpServer = spawn(phpBinary, ['-S', '127.0.0.1:8000', '-t', `"${backendPublic}"`], {
  stdio: 'inherit',
  shell: true
});

// 2. Start Next.js dev server on port 3000
const nextServer = spawn('npm', ['run', 'dev', '--', '-p', '3000'], {
  cwd: path.resolve(__dirname, '../'),
  stdio: 'inherit',
  shell: true
});

const cleanup = () => {
  try { phpServer.kill(); } catch {}
  try { nextServer.kill(); } catch {}
  process.exit();
};

process.on('SIGINT', cleanup);
process.on('SIGTERM', cleanup);
