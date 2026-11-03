const { spawn } = require('child_process');
const path = require('path');
const fs = require('fs');

const rootDir = path.resolve(__dirname, '../../');
const backendPublic = path.resolve(rootDir, 'backend/public');

// Candidate PHP binary paths on Windows / Unix
const candidates = [
  'php',
  'C:\\xampp\\php\\php.exe',
  'C:\\laragon\\bin\\php\\php-8.2.12-Win32-vs16-x64\\php.exe',
  'C:\\php\\php.exe'
];

let phpBinary = 'php';
for (const candidate of candidates) {
  if (candidate === 'php') {
    try {
      const check = spawn('php', ['-v'], { shell: true });
      phpBinary = 'php';
      break;
    } catch {
      continue;
    }
  } else if (fs.existsSync(candidate)) {
    phpBinary = candidate;
    break;
  }
}

console.log(`[DentaFlow] Starting PHP Backend on http://127.0.0.1:8000 using: ${phpBinary}`);
console.log(`[DentaFlow] Document root: ${backendPublic}`);

const server = spawn(phpBinary, ['-S', '127.0.0.1:8000', '-t', backendPublic], {
  stdio: 'inherit',
  shell: true
});

server.on('error', (err) => {
  console.error('[DentaFlow] Failed to start PHP server:', err);
});

server.on('exit', (code) => {
  console.log(`[DentaFlow] PHP server exited with code ${code}`);
});

process.on('SIGINT', () => {
  server.kill('SIGINT');
  process.exit();
});
