import fs from 'fs';
import path from 'path';
import less from 'less';
import { fileURLToPath } from 'url';

const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);
const srcDir = path.resolve(__dirname, '../src');

function findLessFiles(dir) {
  let results = [];
  const list = fs.readdirSync(dir);
  for (const file of list) {
    const fullPath = path.join(dir, file);
    const stat = fs.statSync(fullPath);
    if (stat.isDirectory()) {
      results = results.concat(findLessFiles(fullPath));
    } else if (file.endsWith('.less') && !file.startsWith('_') && file !== 'variables.less' && file !== 'mixins.less') {
      results.push(fullPath);
    }
  }
  return results;
}

async function compileLess() {
  const lessFiles = findLessFiles(srcDir);
  console.log(`[compile-less] Compiling ${lessFiles.length} LESS file(s)...`);

  const stylesDirNormalized = path.resolve(srcDir, 'styles').replace(/\\/g, '/');

  for (const filePath of lessFiles) {
    let content = fs.readFileSync(filePath, 'utf8');
    // Replace '@/styles/' with absolute path for clean lessc resolution
    content = content.replace(/@\/styles\//g, `${stylesDirNormalized}/`);

    const outPath = filePath.replace(/\.less$/, '.css');

    try {
      const output = await less.render(content, {
        filename: filePath,
        paths: [path.resolve(srcDir, 'styles'), srcDir],
        javascriptEnabled: true,
      });

      fs.writeFileSync(outPath, output.css, 'utf8');
      console.log(`  ✓ Compiled ${path.relative(srcDir, filePath)} -> ${path.basename(outPath)}`);
    } catch (err) {
      console.error(`  ✗ Error compiling ${filePath}:`, err.message);
    }
  }
  console.log('[compile-less] Done!');
}

compileLess();
