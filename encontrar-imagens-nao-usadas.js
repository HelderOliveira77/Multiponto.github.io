const fs = require('fs');
const path = require('path');

// Defina os diretórios
const imagensDir = path.join(__dirname, 'wp-content'); // ajuste para sua pasta de imagens
const projetoDir = __dirname;

// Extensões de imagem a verificar
const extensoesImagem = ['.png', '.jpg', '.jpeg', '.gif', '.webp', '.svg'];

// Arquivos de código a verificar
const arquivosParaVerificar = ['.html', '.css', '.js'];

// Coleta todas as imagens na pasta
function listarImagens(dir) {
  const imagens = [];
  const arquivos = fs.readdirSync(dir);
  arquivos.forEach(arquivo => {
    const caminho = path.join(dir, arquivo);
    const stat = fs.statSync(caminho);
    if (stat.isDirectory()) {
      imagens.push(...listarImagens(caminho));
    } else if (extensoesImagem.includes(path.extname(arquivo).toLowerCase())) {
      imagens.push(path.relative(imagensDir, caminho));
    }
  });
  return imagens;
}

// Lê todos os arquivos do projeto e concatena o conteúdo
function lerConteudoProjeto(dir) {
  let conteudo = '';
  const arquivos = fs.readdirSync(dir);
  arquivos.forEach(arquivo => {
    const caminho = path.join(dir, arquivo);
    const stat = fs.statSync(caminho);
    if (stat.isDirectory() && !arquivo.startsWith('.')) {
      conteudo += lerConteudoProjeto(caminho);
    } else if (arquivosParaVerificar.includes(path.extname(arquivo).toLowerCase())) {
      conteudo += fs.readFileSync(caminho, 'utf8');
    }
  });
  return conteudo;
}

// Executa o script
function verificarImagensNaoUsadas() {
  const imagens = listarImagens(imagensDir);
  const conteudo = lerConteudoProjeto(projetoDir);

  const imagensNaoUsadas = imagens.filter(imagem => {
    return !conteudo.includes(imagem) && !conteudo.includes(path.basename(imagem));
  });

  if (imagensNaoUsadas.length === 0) {
    console.log('✅ Todas as imagens estão a ser usadas!');
  } else {
    console.log('🚫 Imagens não utilizadas encontradas:');
    imagensNaoUsadas.forEach(img => console.log(' -', img));
  }
}

verificarImagensNaoUsadas();
